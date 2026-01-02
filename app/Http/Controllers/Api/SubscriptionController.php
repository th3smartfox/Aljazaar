<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\AccountTierPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Subscription\SubscriptionPlanResource;
use App\Http\Resources\Subscription\UserSubscriptionResource;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    /**
     * GET /api/content/account-tier-page
     * Fetch account tier page content, plans, and user's subscription status
     */
    public function getAccountTierPage()
    {
        $user = Auth::user();

        // Get page content (first record or create default)
        $pageContent = AccountTierPage::first();
        if (!$pageContent) {
            $pageContent = AccountTierPage::create([
                'app_bar_title' => 'Get Subscription',
                'subtitle' => 'Upgrade your food journey with a taste of premium comfort.',
                'button_text' => 'Start 7-day free trial',
                'terms_text' => 'By placing this order, you agree to the ',
                'terms_of_service_text' => 'Terms of Service ',
                'privacy_policy_text' => 'Privacy Policy. ',
                'renewal_notice' => 'Subscription automatically renews unless auto-renew is turned off at least 24-hours before the end of the current period.',
            ]);
        }

        // Get all active subscription plans
        $plans = SubscriptionPlan::active()->get();

        // Get user's active subscription
        $userSubscription = $user->activeSubscription;

        return response()->json([
            'page_content' => [
                'app_bar_title' => $pageContent->app_bar_title,
                'header_image' => $pageContent->header_image,
                'subtitle' => $pageContent->subtitle,
                'button_text' => $pageContent->button_text,
                'terms_text' => $pageContent->terms_text,
                'terms_of_service_text' => $pageContent->terms_of_service_text,
                'privacy_policy_text' => $pageContent->privacy_policy_text,
                'renewal_notice' => $pageContent->renewal_notice,
            ],
            'plans' => SubscriptionPlanResource::collection($plans),
            'user_subscription' => $userSubscription ? new UserSubscriptionResource($userSubscription) : null,
        ]);
    }

    /**
     * GET /api/subscriptions/plans
     * Fetch available subscription plans only
     */
    public function getPlans()
    {
        $plans = SubscriptionPlan::active()->get();

        return response()->json([
            'plans' => SubscriptionPlanResource::collection($plans),
        ]);
    }

    /**
     * POST /api/subscriptions/subscribe
     * Subscribe to a plan (starts free trial if available)
     */
    public function subscribe(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        // Check if user already has an active subscription
        $existingSubscription = UserSubscription::where('user_id', $user->id)
            ->active()
            ->first();

        if ($existingSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active subscription',
            ], 409);
        }

        // Get the plan
        $plan = SubscriptionPlan::find($request->plan_id);

        if (!$plan || !$plan->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid plan selected',
            ], 400);
        }

        // Calculate dates
        $startDate = now();
        $trialEndDate = null;
        $status = 'active';

        if ($plan->trial_days > 0) {
            $trialEndDate = now()->addDays($plan->trial_days);
            $status = 'trial';
        }

        $endDate = now()->addDays($plan->duration_days);

        // Create subscription
        $subscription = UserSubscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => $status,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'trial_end_date' => $trialEndDate,
            'auto_renew' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully subscribed to {$plan->name}",
            'subscription' => new UserSubscriptionResource($subscription->load('plan')),
        ], 201);
    }

    /**
     * GET /api/subscriptions/user-status
     * Get the current user's subscription status only
     */
    public function getUserStatus()
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;

        return response()->json([
            'has_subscription' => $subscription ? true : false,
            'subscription' => $subscription ? new UserSubscriptionResource($subscription) : null,
        ]);
    }

    /**
     * POST /api/subscriptions/cancel
     * Cancel the current subscription
     */
    public function cancel()
    {
        $user = Auth::user();
        $subscription = UserSubscription::where('user_id', $user->id)
            ->active()
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'No active subscription found',
            ], 404);
        }

        $subscription->cancel();

        return response()->json([
            'success' => true,
            'message' => "Subscription cancelled successfully. Access continues until {$subscription->end_date->format('Y-m-d')}.",
        ]);
    }
}
