<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\NewOrderPage;
use App\Models\Item;
use App\Http\Resources\Items\ItemSummaryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * API: Get New Order Page Data
     * Returns page content and categories with items count
     */
    public function newOrder()
    {
        // Fetch new order page content
        $page = NewOrderPage::where('status', true)->latest()->first();
        
        $pageContent = [
            'title' => 'New Order',
        ];

        if ($page) {
            $pageContent = [
                'title' => $page->title ?? 'New Order',
            ];
        }

        // Fetch categories with items count
        $categories = Category::where('status', true)
            ->withCount(['items' => function ($query) {
                $query->where('status', true);
            }])
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'items_count' => $category->items_count,
                    'image' => $category->image ? Storage::url($category->image) : null,
                ];
            });

        return response()->json([
            'page_content' => $pageContent,
            'categories' => $categories,
        ]);
    }

    /**
     * API: Get Items by Category
     * Returns all items for a specific category
     */
    public function itemsByCategory(Request $request, $categoryId)
    {
        $category = Category::where('status', true)->find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $items = Item::with('category:id,name')
            ->where('category_id', $categoryId)
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'image' => $category->image ? Storage::url($category->image) : null,
            ],
            'items' => ItemSummaryResource::collection($items),
        ]);
    }
}

