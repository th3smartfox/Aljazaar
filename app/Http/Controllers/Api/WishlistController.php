<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Items\ItemSummaryResource;
use App\Models\Item;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    /**
     * Toggle Wishlist
     * Add or remove item from wishlist
     */
    public function toggle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $itemId = $request->item_id;

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('item_id', $itemId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Item removed from wishlist';
            $isWishlisted = false;
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'item_id' => $itemId,
            ]);
            $message = 'Item added to wishlist';
            $isWishlisted = true;
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'is_wishlisted' => $isWishlisted,
        ]);
    }

    /**
     * Get User's Wishlist
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $items = Item::whereHas('wishlists', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->with('category:id,name')
            ->where('status', true)
            ->latest()
            ->paginate(15);

        return ItemSummaryResource::collection($items);
    }
}
