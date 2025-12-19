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
     * API: Complete Payment (Called after frontend gateway success)
     */
    public function completePayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id,user_id,' . Auth::id(),
            'transaction_id' => 'required|string',
            'payment_method' => 'required|string|in:credit_card,paypal,apple_pay,google_pay',
            'amount' => 'required|numeric',
            'status' => 'required|string|in:completed,failed',
            'gateway_response' => 'nullable'
        ]);

        $order = Order::find($request->order_id);

        // Check if order is already paid
        if ($order->payment_status === 'completed') {
            return response()->json(['message' => 'Order is already paid.'], 200);
        }

        if ($request->status === 'completed') {
            // Create Payment Record
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'transaction_id' => $request->transaction_id,
                'gateway_response' => $request->gateway_response
            ]);

            // Update Order
            $order->update([
                'payment_status' => 'completed',
                'status' => 'confirmed',
                'payment_method' => $request->payment_method
            ]);

            return response()->json([
                'message' => 'Payment completed successfully',
                'order_status' => 'confirmed'
            ]);
        } else {
            // Log failed attempt if needed, or just return error
            return response()->json(['message' => 'Payment failed status received.'], 400);
        }
    }
}
