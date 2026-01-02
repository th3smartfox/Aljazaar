<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = UserSubscription::with(['user', 'plan'])->latest()->get();
        return view('admin.subscriptions.user-subscriptions.index', compact('subscriptions'));
    }

    public function cancel($id)
    {
        $subscription = UserSubscription::findOrFail($id);
        $subscription->cancel();

        return redirect()->back()->with('success', 'Subscription cancelled successfully.');
    }
}
