<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\User;
use App\Models\UserReward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    /**
     * Display a listing of rewards.
     */
    public function index(Request $request)
    {
        $query = Reward::withCount(['userRewards', 'userRewards as redeemed_count' => function ($q) {
            $q->where('is_redeemed', true);
        }])->orderByDesc('created_at');

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)->where('expiry_date', '>', now());
            } elseif ($request->status === 'expired') {
                $query->where('expiry_date', '<=', now());
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by discount type
        if ($request->filled('discount_type')) {
            $query->where('discount_type', $request->discount_type);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $rewards = $query->paginate(15)->withQueryString();

        return view('admin.rewards.index', compact('rewards'));
    }

    /**
     * Show the form for creating a new reward.
     */
    public function create()
    {
        return view('admin.rewards.create');
    }

    /**
     * Store a newly created reward.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:rewards,code',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'expiry_date' => 'required|date|after:now',
            'is_active' => 'boolean',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->has('is_active');
        $validated['min_order_amount'] = $validated['min_order_amount'] ?? 0;

        Reward::create($validated);

        return redirect()->route('rewards.index')
            ->with('success', 'Reward created successfully.');
    }

    /**
     * Display the specified reward.
     */
    public function show(Reward $reward)
    {
        $reward->loadCount(['userRewards', 'userRewards as redeemed_count' => function ($q) {
            $q->where('is_redeemed', true);
        }]);

        $userRewards = $reward->userRewards()
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.rewards.show', compact('reward', 'userRewards'));
    }

    /**
     * Show the form for editing the specified reward.
     */
    public function edit(Reward $reward)
    {
        return view('admin.rewards.edit', compact('reward'));
    }

    /**
     * Update the specified reward.
     */
    public function update(Request $request, Reward $reward)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:rewards,code,' . $reward->id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'expiry_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->has('is_active');
        $validated['min_order_amount'] = $validated['min_order_amount'] ?? 0;

        $reward->update($validated);

        return redirect()->route('rewards.index')
            ->with('success', 'Reward updated successfully.');
    }

    /**
     * Remove the specified reward.
     */
    public function destroy(Reward $reward)
    {
        $reward->delete();

        return redirect()->route('rewards.index')
            ->with('success', 'Reward deleted successfully.');
    }

    /**
     * Assign reward to users.
     */
    public function assignForm(Reward $reward)
    {
        $users = User::whereDoesntHave('userRewards', function ($q) use ($reward) {
            $q->where('reward_id', $reward->id);
        })->orderBy('name')->get();

        return view('admin.rewards.assign', compact('reward', 'users'));
    }

    /**
     * Store assigned users.
     */
    public function assign(Request $request, Reward $reward)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        $assigned = 0;
        foreach ($validated['user_ids'] as $userId) {
            $exists = UserReward::where('user_id', $userId)
                ->where('reward_id', $reward->id)
                ->exists();

            if (!$exists) {
                UserReward::create([
                    'user_id' => $userId,
                    'reward_id' => $reward->id,
                    'is_redeemed' => false,
                ]);
                $assigned++;
            }
        }

        return redirect()->route('rewards.show', $reward)
            ->with('success', "Reward assigned to {$assigned} user(s).");
    }

    /**
     * Remove user from reward.
     */
    public function removeUser(Reward $reward, User $user)
    {
        UserReward::where('reward_id', $reward->id)
            ->where('user_id', $user->id)
            ->delete();

        return redirect()->back()
            ->with('success', 'User removed from this reward.');
    }

    /**
     * Assign reward to all users.
     */
    public function assignAll(Reward $reward)
    {
        $users = User::whereDoesntHave('userRewards', function ($q) use ($reward) {
            $q->where('reward_id', $reward->id);
        })->get();

        $assigned = 0;
        foreach ($users as $user) {
            UserReward::create([
                'user_id' => $user->id,
                'reward_id' => $reward->id,
                'is_redeemed' => false,
            ]);
            $assigned++;
        }

        return redirect()->route('rewards.show', $reward)
            ->with('success', "Reward assigned to {$assigned} user(s).");
    }
}
