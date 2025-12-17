<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Cart\CartResource;

class CheckoutController extends Controller
{
    public function init(Request $request)
    {
        $user = $request->user();
        $userId = $user->id;

        // 1. Fetch Cart
        $cartItems = Cart::with([
            'item:id,name,image,base_price,discount_percent,status',
            'cartItemAddOns'
        ])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $totalPrice = 0;
        $totalItems = 0;

        // Filter out items where the associated item has been deleted or is invalid
        $validCartItems = $cartItems->filter(function ($cartItem) {
            if ($cartItem->item) {
                return true;
            }
            $cartItem->delete();
            return false;
        });

        foreach ($validCartItems as $cartItem) {
            $itemPrice = $cartItem->item->discounted_price;
            $addOnsPrice = $cartItem->cartItemAddOns->sum('add_on_price');

            $totalPrice += ($itemPrice + $addOnsPrice) * $cartItem->quantity;
            $totalItems += $cartItem->quantity;
        }

        $cartData = [
            'items' => CartResource::collection($validCartItems),
            'summary' => [
                'total_items' => $totalItems,
                'total_price' => round($totalPrice, 2),
            ]
        ];

        // 2. Fetch Addresses
        $addresses = Address::with('city')->where('user_id', $userId)->get();
        $addressesData = AddressResource::collection($addresses);

        // 3. Saved Cards (Empty for now)
        $savedCards = [];

        // 4. Available Payment Methods
        $paymentMethods = [
            "credit_card",
            "google_pay",
            "apple_pay",
            "paypal",
            "cash_on_delivery"
        ];

        return response()->json([
            'cart' => $cartData,
            'addresses' => $addressesData,
            'saved_cards' => $savedCards,
            'available_payment_methods' => $paymentMethods,
        ]);
    }
}
