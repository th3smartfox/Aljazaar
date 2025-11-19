<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Payment\PaymentResource;

class PaymentController extends Controller
{
    /**
     * API: Step 2 of checkout - Initiate Payment
     */
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id,user_id,' . Auth::id(),
            'payment_method' => 'required|string|in:cod,credit_card,paypal,apple_pay,google_pay'
        ]);

        $order = Order::find($request->order_id);
        $user = Auth::user();

        // 1. if 'cod' (Cash on Delivery)
        if ($request->payment_method === 'cod') {
            // Order update 
            $order->update([
                'payment_method' => 'cod',
                'payment_status' => 'pending', // Payment status pending 
                'status' => 'confirmed' // Order confirmed
            ]);

            // Payment record create
            $payment = Payment::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'payment_method' => 'cod',
                'status' => 'pending',
                'transaction_id' => 'cod-' . $order->order_number
            ]);

            return response()->json([
                'message' => 'Order placed with COD',
                'payment_status' => 'pending',
                'order_status' => 'confirmed'
            ]);
        }

        // 2. If payment Credit Card / Digital

        // Payment record create
        $payment = Payment::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Payment initiated',
            'client_secret' => 'client_secret_for_' . $payment->id,
            'payment_id' => $payment->id
        ]);
    }

    /**
     * API: Step 3 of checkout - Confirm Payment
     * (This API Flutter app call will call when Stripe/Gateway success message got)
     */
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id,user_id,' . Auth::id(),
            'transaction_id' => 'required|string',
            'status' => 'required|string|in:completed,failed'
        ]);

        $payment = Payment::find($request->payment_id);

        // If payment already completed do not process again
        if ($payment->status === 'completed') {
            return response()->json(['message' => 'Payment already confirmed']);
        }

        if ($request->status === 'completed') {
            // Payment update
            $payment->update([
                'status' => 'completed',
                'transaction_id' => $request->transaction_id,
                'gateway_response' => $request->gateway_response ?? null
            ]);

            // Order update
            $payment->order()->update([
                'payment_status' => 'completed',
                'status' => 'confirmed' // Order confirmed
            ]);

            return response()->json([
                'message' => 'Payment confirmed successfully',
                'order_status' => 'confirmed'
            ]);
        } else {
            // If payment failed
            $payment->update([
                'status' => 'failed',
                'gateway_response' => $request->gateway_response ?? null
            ]);
            // Order payment status update
            $payment->order()->update(['payment_status' => 'failed']);

            return response()->json(['message' => 'Payment failed'], 400);
        }
    }
}
