<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reward\UserRewardResource;
use App\Models\Reward;
use App\Models\UserReward;
use App\Models\RedeemRewardsPage;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    /**
     * Get redeem rewards page content with user's rewards.
     */
    public function getRedeemRewardsPage(Request $request)
    {
        $page = RedeemRewardsPage::where('status', true)->latest()->first();

        $pageContent = [
            'app_bar_title' => $page->app_bar_title ?? 'Redeem Rewards',
            'empty_title' => $page->empty_title ?? 'No Rewards Available',
            'empty_subtitle' => $page->empty_subtitle ?? 'Check back later for exciting rewards!',
            'copy_button_text' => $page->copy_button_text ?? 'Copy Code',
            'copied_message' => $page->copied_message ?? 'Code copied to clipboard!',
            'min_order_label' => $page->min_order_label ?? 'Min Order',
            'max_discount_label' => $page->max_discount_label ?? 'Max Discount',
            'expired_label' => $page->expired_label ?? 'Expired',
            'redeemed_label' => $page->redeemed_label ?? 'Redeemed',
        ];

        $rewards = [];

        if ($request->user()) {
            $userRewards = $request->user()->userRewards()
                ->with('reward')
                ->whereHas('reward', function ($q) {
                    $q->where('is_active', true);
                })
                ->orderByDesc('created_at')
                ->get();

            $rewards = UserRewardResource::collection($userRewards);
        }

        return response()->json([
            'page_content' => $pageContent,
            'rewards' => $rewards,
        ]);
    }

    /**
     * Get all available rewards (active and not expired).
     */
    public function index(Request $request)
    {
        $rewards = Reward::valid()
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'rewards' => $rewards->map(function ($reward) {
                return [
                    'id' => $reward->id,
                    'code' => $reward->code,
                    'discount_type' => $reward->discount_type,
                    'discount_value' => (float) $reward->discount_value,
                    'min_order_amount' => (float) $reward->min_order_amount,
                    'max_discount' => $reward->max_discount ? (float) $reward->max_discount : null,
                    'description' => $reward->description,
                    'expiry_date' => $reward->expiry_date->toIso8601String(),
                    'is_redeemed' => false,
                    'redeemed_at' => null,
                ];
            }),
        ]);
    }

    /**
     * Get user-specific rewards.
     */
    public function userRewards(Request $request)
    {
        $user = $request->user();

        $userRewards = $user->userRewards()
            ->with('reward')
            ->whereHas('reward', function ($q) {
                $q->where('is_active', true);
            })
            ->get();

        $availableCount = $userRewards->where('is_redeemed', false)
            ->filter(fn($ur) => !$ur->reward->isExpired())
            ->count();

        $redeemedCount = $userRewards->where('is_redeemed', true)->count();

        return response()->json([
            'available_rewards' => $availableCount,
            'redeemed_rewards' => $redeemedCount,
            'rewards' => UserRewardResource::collection($userRewards),
        ]);
    }

    /**
     * Redeem a specific reward.
     */
    public function redeem(Request $request, $id)
    {
        $user = $request->user();

        $userReward = UserReward::where('id', $id)
            ->where('user_id', $user->id)
            ->with('reward')
            ->first();

        if (!$userReward) {
            return response()->json([
                'success' => false,
                'message' => 'Reward not found',
            ], 404);
        }

        // Check if already redeemed
        if ($userReward->is_redeemed) {
            return response()->json([
                'success' => false,
                'message' => 'This reward has already been redeemed',
            ], 400);
        }

        // Check if expired
        if ($userReward->reward->isExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'This reward has expired',
            ], 400);
        }

        // Check if reward is still active
        if (!$userReward->reward->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This reward is no longer available',
            ], 400);
        }

        // Mark as redeemed
        $userReward->markAsRedeemed();
        $userReward->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Reward redeemed successfully',
            'reward' => [
                'id' => $userReward->id,
                'code' => $userReward->reward->code,
                'is_redeemed' => true,
                'redeemed_at' => $userReward->redeemed_at->toIso8601String(),
            ],
        ]);
    }

    /**
     * Validate a reward code for checkout.
     */
    public function validateCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'order_amount' => 'required|numeric|min:0',
        ]);

        $user = $request->user();
        $code = strtoupper($request->code);
        $orderAmount = (float) $request->order_amount;

        // Find the reward by code
        $reward = Reward::where('code', $code)->first();

        if (!$reward) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reward code',
            ], 400);
        }

        // Check if reward is active
        if (!$reward->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This reward is no longer available',
            ], 400);
        }

        // Check if expired
        if ($reward->isExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'This reward has expired',
            ], 400);
        }

        // Check if user has this reward
        $userReward = UserReward::where('user_id', $user->id)
            ->where('reward_id', $reward->id)
            ->first();

        if (!$userReward) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this reward',
            ], 400);
        }

        // Check if already redeemed
        if ($userReward->is_redeemed) {
            return response()->json([
                'success' => false,
                'message' => 'This reward has already been redeemed',
            ], 400);
        }

        // Check minimum order amount
        if ($orderAmount < $reward->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order amount of $' . number_format($reward->min_order_amount, 2) . ' required',
            ], 400);
        }

        // Calculate discount
        $discount = $reward->calculateDiscount($orderAmount);

        return response()->json([
            'success' => true,
            'message' => 'Reward code is valid',
            'reward' => [
                'id' => $userReward->id,
                'code' => $reward->code,
                'discount_type' => $reward->discount_type,
                'discount_value' => (float) $reward->discount_value,
                'calculated_discount' => $discount,
                'description' => $reward->description,
            ],
        ]);
    }
}
