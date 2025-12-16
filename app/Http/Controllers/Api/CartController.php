<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartPageContent;
use App\Models\Item;
use App\Models\AddOn;
use App\Models\CartItemAddOn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Cart\CartResource;

class CartController extends Controller
{
    private function getCartSummary($userId)
    {
        $cartItems = Cart::with([
            'item:id,name,image,base_price,discount_percent,status',
            'cartItemAddOns'
        ])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $totalPrice = 0;
        $totalItems = 0;

        foreach ($cartItems as $cartItem) {
            if ($cartItem->item) {
                $itemPrice = $cartItem->item->discounted_price;
                $addOnsPrice = $cartItem->cartItemAddOns->sum('add_on_price');

                $totalPrice += ($itemPrice + $addOnsPrice) * $cartItem->quantity;
                $totalItems += $cartItem->quantity;
            } else {
                // If item deleted, remove from cart
                $cartItem->delete();
            }
        }

        return [
            'items' => $cartItems, // Raw collection
            'summary' => [
                'total_items' => $totalItems,
                'total_price' => round($totalPrice, 2),
            ]
        ];
    }

    /**
     * Method 1: Get the current user's cart
     * Endpoint: GET /api/cart
     */
    public function getCart()
    {
        $cartData = $this->getCartSummary(Auth::id());

        // Fetch cart page content
        $pageContent = CartPageContent::where('status', true)->latest()->first();

        $pageContentData = [
            'title' => 'Order Details',
            'text_rewards_progress' => 'Your Rewards Progress',
            'text_rewards_status' => "You're {amount} from your coupon code",
            'total_spending' => '0.00',
            'placeholder_coupon' => 'Enter Coupon Code',
            'button_apply' => 'Apply',
            'text_total' => 'Total',
            'button_checkout' => 'Checkout',
        ];

        if ($pageContent) {
            $pageContentData = [
                'title' => $pageContent->title ?? 'Order Details',
                'text_rewards_progress' => $pageContent->text_rewards_progress ?? 'Your Rewards Progress',
                'text_rewards_status' => $pageContent->text_rewards_status ?? "You're {amount} away from your coupon code",
                'total_spending' => $pageContent->total_spending ?? '0.00',
                'placeholder_coupon' => $pageContent->placeholder_coupon ?? 'Enter Coupon Code',
                'button_apply' => $pageContent->button_apply ?? 'Apply',
                'text_total' => $pageContent->text_total ?? 'Total',
                'button_checkout' => $pageContent->button_checkout ?? 'Checkout',
            ];
        }

        return response()->json([
            'items' => CartResource::collection($cartData['items']),
            'summary' => $cartData['summary'],
            'page_content' => $pageContentData
        ]);
    }

    /**
     * Method 2: Add an item to the cart
     * Endpoint: POST /api/cart/add
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'add_ons' => 'nullable|array',
            'add_ons.*' => 'integer|exists:add_ons,id',
        ]);

        $userId = Auth::id();
        $itemId = $request->item_id;
        $quantity = $request->quantity;
        $addOnIds = $request->add_ons ?? [];
        sort($addOnIds);

        $item = Item::find($itemId);
        if (!$item || !$item->status) {
            return response()->json(['message' => 'Item is not available'], 404);
        }

        // Validate Add-ons belong to Item
        if (!empty($addOnIds)) {
            $validAddOnsCount = AddOn::whereIn('id', $addOnIds)->where('item_id', $itemId)->count();
            if ($validAddOnsCount !== count($addOnIds)) {
                return response()->json(['message' => 'Invalid add-ons for this item'], 400);
            }
        }

        // Find existing cart item with exact add-ons
        $existingCartItem = null;
        $cartItems = Cart::where('user_id', $userId)->where('item_id', $itemId)->with('cartItemAddOns')->get();

        foreach ($cartItems as $cartItem) {
            $currentAddOnIds = $cartItem->cartItemAddOns->pluck('add_on_id')->sort()->values()->toArray();
            if ($currentAddOnIds === $addOnIds) {
                $existingCartItem = $cartItem;
                break;
            }
        }

        if ($existingCartItem) {
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            $newCartItem = Cart::create([
                'user_id' => $userId,
                'item_id' => $itemId,
                'quantity' => $quantity,
            ]);

            if (!empty($addOnIds)) {
                $addOns = AddOn::whereIn('id', $addOnIds)->get();
                foreach ($addOns as $addOn) {
                    CartItemAddOn::create([
                        'cart_id' => $newCartItem->id,
                        'add_on_id' => $addOn->id,
                        'add_on_name' => $addOn->name,
                        'add_on_price' => $addOn->price,
                    ]);
                }
            }
        }

        $cartData = $this->getCartSummary($userId);
        return response()->json([
            'message' => 'Item added to cart successfully',
            'items' => CartResource::collection($cartData['items']),
            'summary' => $cartData['summary']
        ], 200);
    }

    /**
     * Method 3: Update item quantity
     * Endpoint: PUT /api/cart/update
     */
    public function updateCartItem(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $cartItem = Cart::where('id', $request->cart_item_id)
            ->where('user_id', $userId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            $cartData = $this->getCartSummary($userId);
            return response()->json([
                'items' => CartResource::collection($cartData['items']),
                'summary' => $cartData['summary']
            ], 200);
        }

        return response()->json(['message' => 'Cart item not found or unauthorized'], 404);
    }

    /**
     * Method 4: Remove an item from the cart
     * Endpoint: DELETE /api/cart/remove
     */
    /**
     * Method 4: Remove an item from the cart
     * Endpoint: DELETE /api/cart/remove
     */
    public function removeCartItem(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:carts,id',
        ]);

        $userId = Auth::id();
        $cartItem = Cart::where('id', $request->cart_item_id)
            ->where('user_id', $userId)
            ->first();

        if ($cartItem) {
            $cartItem->delete();

            $cartData = $this->getCartSummary($userId);
            return response()->json([
                'items' => CartResource::collection($cartData['items']),
                'summary' => $cartData['summary']
            ], 200);
        }

        return response()->json(['message' => 'Cart item not found or unauthorized'], 404);
    }
}