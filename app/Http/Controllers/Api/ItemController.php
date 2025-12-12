<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Items\ItemResource;
use App\Http\Resources\Items\ItemSummaryResource;
use App\Models\Item;
use App\Models\OrderCustomizationPage;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * API 1: Fetch items based on type
     * Query Params: type = hot-discount | top-picks | order-again
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        $query = Item::with('category:id,name')->where('status', true);

        if ($type === 'hot-discount') {
            // Items with highest discount first
            $query->where('discount_percent', '>', 0)
                ->orderBy('discount_percent', 'DESC');
        } elseif ($type === 'top-picks') {
            // Most ordered items (Future logic)
            // Currently just returning latest items
            $query->latest();
        } elseif ($type === 'order-again') {
            // User's previous order items
            $user = $request->user('sanctum');

            if ($user) {
                // Get item IDs from user's orders
                $itemIds = \App\Models\OrderItem::whereHas('order', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->pluck('item_id')->unique();

                $query->whereIn('id', $itemIds);
            } else {
                // If not authenticated or no orders, maybe return empty or popular?
                // For now, let's return empty to be safe/strict about "order again"
                // Or we can just return latest if we want to show something.
                // User said "user k previous order items", so strictly previous items.
                if (!$user) {
                    return response()->json(['data' => [], 'meta' => ['total' => 0]], 200);
                }
            }
        } else {
            // Default: Latest items
            $query->latest();
        }

        $items = $query->paginate(15);

        return ItemSummaryResource::collection($items);
    }

    /**
     * API 3: Get details for a single item
     */
    public function show(Item $item)
    {
        if (!$item->status) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->load('category:id,name');

        // Fetch order customization page content
        $pageContent = OrderCustomizationPage::where('status', true)->latest()->first();

        $pageContentData = [
            'title' => 'Order Customization',
            'text_add_ons' => 'Add-Ons',
            'text_portion' => 'Portion',
            'button_add_to_cart' => 'Add to cart',
            'text_total' => 'Total',
        ];

        if ($pageContent) {
            $pageContentData = [
                'title' => $pageContent->title ?? 'Order Customization',
                'text_add_ons' => $pageContent->text_add_ons ?? 'Add-Ons',
                'text_portion' => $pageContent->text_portion ?? 'Portion',
                'button_add_to_cart' => $pageContent->button_add_to_cart ?? 'Add to cart',
                'text_total' => $pageContent->text_total ?? 'Total',
            ];
        }

        return new ItemResource($item, $pageContentData);
    }
    /**
     * API 5: Search items by name or description
     */
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return response()->json(['message' => 'Search parameter is required'], 400);
        }

        $items = Item::with('category:id,name')
            ->where('status', true)
            ->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        return ItemSummaryResource::collection($items);
    }
}