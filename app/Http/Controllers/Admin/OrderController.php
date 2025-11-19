<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.item', 'user', 'address', 'payment');
        return view('orders.show', compact('order'));
    }

    /**
     * Admin Order Status update function
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,preparing,out_for_delivery,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        // Payment status update based on order status
        if ($request->status === 'delivered' && $order->payment_method === 'cod') {
            $order->update(['payment_status' => 'completed']);
            if ($order->payment) {
                $order->payment->update(['status' => 'completed']);
            }
        }
        
        if ($request->status === 'cancelled') {
             $order->update(['payment_status' => 'cancelled']);
             if ($order->payment) {
                 $order->payment->update(['status' => 'cancelled']);
             }
        }

        return redirect()->route('orders.show', $order)
                         ->with('success', 'Order status updated successfully.');
    }
}