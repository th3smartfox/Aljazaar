<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::latest()->get();
        return view('admin.subscriptions.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscriptions.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_per_order' => 'required|string',
            'duration_days' => 'required|integer|min:1',
            'trial_days' => 'required|integer|min:0',
            'badge' => 'nullable|string|max:100',
            'is_recommended' => 'boolean',
            'is_active' => 'boolean',
        ]);

        SubscriptionPlan::create($request->all());

        return redirect()->route('subscription-plans.index')
            ->with('success', 'Subscription plan created successfully.');
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscriptions.plans.edit', compact('subscriptionPlan'));
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_per_order' => 'required|string',
            'duration_days' => 'required|integer|min:1',
            'trial_days' => 'required|integer|min:0',
            'badge' => 'nullable|string|max:100',
            'is_recommended' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $subscriptionPlan->update($request->all());

        return redirect()->route('subscription-plans.index')
            ->with('success', 'Subscription plan updated successfully.');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return redirect()->route('subscription-plans.index')
            ->with('success', 'Subscription plan deleted successfully.');
    }
}
