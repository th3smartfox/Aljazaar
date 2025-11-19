<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderDetailResource;

class OrderController extends Controller
{
    /**
     * API: Create a new order from the user's cart
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id,user_id,' . Auth::id(),
            'payment_method' => 'required|string|in:cod,credit_card,paypal', // Payment methods
            'delivery_notes' => 'nullable|string',
            // 'delivery_slot' => 'required|string', // if needed
        ]);

        $user = Auth::user();
        $cartItems = Cart::with('item')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty'], 400);
        }

        $subTotal = 0;
        $discountAmount = 0;
        $deliveryFee = 00.00; // Example: Fixed delivery fee

        DB::beginTransaction();
        try {
            // Create the main order
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $request->address_id,
                'order_number' => 'RBO-' . time() . '-' . $user->id, // Unique Order Number
                'sub_total' => 0, // Placeholder
                'discount_amount' => $discountAmount,
                'delivery_fee' => $deliveryFee,
                'total_amount' => 0, // Placeholder
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending', // Order status
                'delivery_notes' => $request->delivery_notes,
            ]);

            // Add items to the order
            foreach ($cartItems as $cartItem) {
                if (!$cartItem->item) continue; // Skip if item is deleted
                
                $itemPrice = $cartItem->item->discounted_price;
                $subTotal += $itemPrice * $cartItem->quantity;

                // Add-ons price
                $addOnsTotal = 0;
                $selectedAddOns = $cartItem->selected_add_ons ?? []; // Assuming cart has this
                if (is_array($selectedAddOns)) {
                    foreach($selectedAddOns as $addOn) {
                        $addOnsTotal += $addOn['price'] ?? 0;
                    }
                }
                $subTotal += $addOnsTotal * $cartItem->quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'item_id' => $cartItem->item_id,
                    'item_name' => $cartItem->item->name,
                    'quantity' => $cartItem->quantity,
                    'price_at_purchase' => $itemPrice,
                    'selected_add_ons' => $selectedAddOns,
                ]);
            }

            // Update final totals in the order
            $order->sub_total = $subTotal;
            $order->total_amount = ($subTotal - $discountAmount) + $deliveryFee;
            $order->save();

            // Clear the user's cart
            Cart::where('user_id', $user->id)->delete();
            
            DB::commit();

            return response()->json([
                'message' => 'Order placed successfully!',
                'order' => new OrderDetailResource($order->load('items.item', 'address', 'user'))
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to place order: ' . $e->getMessage()], 500);
        }
    }

    /**
     * API: Get Active Orders (CRD Requirement)
     */
    public function getActiveOrders()
    {
        $orders = Auth::user()->orders()
                    ->whereNotIn('status', ['delivered', 'cancelled'])
                    ->with('items.item')
                    ->latest()
                    ->get();
        return OrderResource::collection($orders);
    }

    /**
     * API: Get Closed Orders (CRD Requirement)
     */
    public function getClosedOrders()
    {
        $orders = Auth::user()->orders()
                    ->whereIn('status', ['delivered', 'cancelled'])
                    ->with('items.item')
                    ->latest()
                    ->get();
        return OrderResource::collection($orders);
    }

    /**
     * API: Get details of a single order (Track Order)
     */
    public function trackOrder(Order $order)
    {
        // Check if user owns this order
        if (Auth::id() !== $order->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return new OrderDetailResource($order->load('items.item', 'address', 'user'));
    }

    /**
     * API: Re-order (CRD Requirement)
     */
    public function reorder(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        foreach ($order->items as $item) {
            // Check if item still exists and is active
            $originalItem = Item::where('id', $item->item_id)->where('status', true)->first();
            if ($originalItem) {
                // Add item back to cart
                Cart::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'item_id' => $item->item_id,
                    ],
                    [
                        'quantity' => DB::raw('quantity + ' . $item->quantity),
                        'selected_add_ons' => $item->selected_add_ons
                    ]
                );
            }
        }

        return response()->json(['message' => 'Items added back to your cart!']);
    }
}