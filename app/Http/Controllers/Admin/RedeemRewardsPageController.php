<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RedeemRewardsPage;
use Illuminate\Http\Request;

class RedeemRewardsPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = RedeemRewardsPage::latest()->paginate(10);
        return view('admin.dynamic_content.redeem_rewards_page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dynamic_content.redeem_rewards_page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_bar_title' => 'required|string|max:255',
            'empty_title' => 'required|string|max:255',
            'empty_subtitle' => 'required|string|max:255',
            'copy_button_text' => 'required|string|max:255',
            'copied_message' => 'required|string|max:255',
            'min_order_label' => 'required|string|max:255',
            'max_discount_label' => 'required|string|max:255',
            'expired_label' => 'required|string|max:255',
            'redeemed_label' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status');

        RedeemRewardsPage::create($validated);

        return redirect()->route('redeem-rewards-pages.index')
            ->with('success', 'Redeem Rewards Page content created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RedeemRewardsPage $redeemRewardsPage)
    {
        return view('admin.dynamic_content.redeem_rewards_page.edit', compact('redeemRewardsPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RedeemRewardsPage $redeemRewardsPage)
    {
        $validated = $request->validate([
            'app_bar_title' => 'required|string|max:255',
            'empty_title' => 'required|string|max:255',
            'empty_subtitle' => 'required|string|max:255',
            'copy_button_text' => 'required|string|max:255',
            'copied_message' => 'required|string|max:255',
            'min_order_label' => 'required|string|max:255',
            'max_discount_label' => 'required|string|max:255',
            'expired_label' => 'required|string|max:255',
            'redeemed_label' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status');

        $redeemRewardsPage->update($validated);

        return redirect()->route('redeem-rewards-pages.index')
            ->with('success', 'Redeem Rewards Page content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RedeemRewardsPage $redeemRewardsPage)
    {
        $redeemRewardsPage->delete();

        return redirect()->route('redeem-rewards-pages.index')
            ->with('success', 'Redeem Rewards Page content deleted successfully.');
    }
}
