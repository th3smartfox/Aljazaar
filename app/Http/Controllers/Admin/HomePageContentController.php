<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomePageContentController extends Controller
{
    // Authorization 'role:Admin' middleware ke zariye routes/web.php mein hai

    public function index()
    {
        $homePages = HomePageContent::latest()->get();
        return view('dynamic_content.home_page.index', compact('homePages'));
    }

    public function create()
    {
        return view('dynamic_content.home_page.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());
        
        $data = $request->except(['carousel_images', 'tab_images', 'status']);
        $data['status'] = $request->status == 1;

        // Handle carousels
        $carousels = [];
        if ($request->has('carousel_heading')) {
            foreach ($request->carousel_heading as $index => $heading) {
                $carousel = [
                    'heading' => $heading ?? '',
                    'body' => $request->carousel_body[$index] ?? '',
                    'button_text' => $request->carousel_button_text[$index] ?? '',
                    'image' => '',
                ];
                
                // Handle carousel image upload
                if ($request->hasFile("carousel_images.$index")) {
                    $image = $request->file("carousel_images.$index");
                    $path = $image->store('home_page/carousels', 'public');
                    $carousel['image'] = $path;
                }
                
                if (!empty($heading) || !empty($carousel['body'])) {
                    $carousels[] = $carousel;
                }
            }
        }
        $data['carousels'] = !empty($carousels) ? $carousels : null;

        // Handle tabs (max 3)
        $tabs = [];
        if ($request->has('tab_title')) {
            $tabCount = 0;
            foreach ($request->tab_title as $index => $title) {
                if ($tabCount >= 3) break; // Limit to 3 tabs
                
                $tab = [
                    'title' => $title ?? '',
                    'image' => '',
                ];
                
                // Handle tab image upload
                if ($request->hasFile("tab_images.$index")) {
                    $image = $request->file("tab_images.$index");
                    $path = $image->store('home_page/tabs', 'public');
                    $tab['image'] = $path;
                }
                
                if (!empty($title)) {
                    $tabs[] = $tab;
                    $tabCount++;
                }
            }
        }
        $data['tabs'] = !empty($tabs) ? $tabs : null;

        // Handle headings
        if ($request->has('hot_discount_main_heading')) {
            $data['hot_discount_heading'] = [
                'main_heading' => $request->hot_discount_main_heading ?? '',
                'sub_heading' => $request->hot_discount_sub_heading ?? '',
                'side_text' => $request->hot_discount_side_text ?? 'See All',
            ];
        }

        if ($request->has('top_picks_main_heading')) {
            $data['top_picks_heading'] = [
                'main_heading' => $request->top_picks_main_heading ?? '',
                'sub_heading' => $request->top_picks_sub_heading ?? '',
                'side_text' => $request->top_picks_side_text ?? 'See All',
            ];
        }

        if ($request->has('order_again_main_heading')) {
            $data['order_again_heading'] = [
                'main_heading' => $request->order_again_main_heading ?? '',
                'sub_heading' => $request->order_again_sub_heading ?? '',
                'side_text' => $request->order_again_side_text ?? 'See All',
            ];
        }

        HomePageContent::create($data);
        return redirect()->route('home-page-contents.index')
                         ->with('success', 'Home Page content created successfully.');
    }

    public function show(HomePageContent $homePageContent)
    {
        return redirect()->route('home-page-contents.edit', $homePageContent);
    }

    public function edit(HomePageContent $homePageContent)
    {
        return view('dynamic_content.home_page.edit', compact('homePageContent'));
    }

    public function update(Request $request, HomePageContent $homePageContent)
    {
        $request->validate($this->getValidationRules());
        
        $data = $request->except(['carousel_images', 'tab_images', 'status', '_method', '_token']);
        $data['status'] = $request->status == 1;

        // Handle carousels
        $carousels = [];
        if ($request->has('carousel_heading')) {
            foreach ($request->carousel_heading as $index => $heading) {
                $carousel = [
                    'heading' => $heading ?? '',
                    'body' => $request->carousel_body[$index] ?? '',
                    'button_text' => $request->carousel_button_text[$index] ?? '',
                    'image' => '',
                ];
                
                // Check if existing carousel has image
                $existingCarousels = $homePageContent->carousels ?? [];
                if (isset($existingCarousels[$index]) && isset($existingCarousels[$index]['image'])) {
                    $carousel['image'] = $existingCarousels[$index]['image'];
                }
                
                // Handle new carousel image upload
                if ($request->hasFile("carousel_images.$index")) {
                    // Delete old image if exists
                    if (isset($existingCarousels[$index]['image'])) {
                        Storage::disk('public')->delete($existingCarousels[$index]['image']);
                    }
                    $image = $request->file("carousel_images.$index");
                    $path = $image->store('home_page/carousels', 'public');
                    $carousel['image'] = $path;
                }
                
                if (!empty($heading) || !empty($carousel['body'])) {
                    $carousels[] = $carousel;
                }
            }
        }
        $data['carousels'] = !empty($carousels) ? $carousels : null;

        // Handle tabs (max 3)
        $tabs = [];
        if ($request->has('tab_title')) {
            $tabCount = 0;
            $existingTabs = $homePageContent->tabs ?? [];
            foreach ($request->tab_title as $index => $title) {
                if ($tabCount >= 3) break; // Limit to 3 tabs
                
                $tab = [
                    'title' => $title ?? '',
                    'image' => '',
                ];
                
                // Check if existing tab has image
                if (isset($existingTabs[$index]) && isset($existingTabs[$index]['image'])) {
                    $tab['image'] = $existingTabs[$index]['image'];
                }
                
                // Handle new tab image upload
                if ($request->hasFile("tab_images.$index")) {
                    // Delete old image if exists
                    if (isset($existingTabs[$index]['image'])) {
                        Storage::disk('public')->delete($existingTabs[$index]['image']);
                    }
                    $image = $request->file("tab_images.$index");
                    $path = $image->store('home_page/tabs', 'public');
                    $tab['image'] = $path;
                }
                
                if (!empty($title)) {
                    $tabs[] = $tab;
                    $tabCount++;
                }
            }
        }
        $data['tabs'] = !empty($tabs) ? $tabs : null;

        // Handle headings
        if ($request->has('hot_discount_main_heading')) {
            $data['hot_discount_heading'] = [
                'main_heading' => $request->hot_discount_main_heading ?? '',
                'sub_heading' => $request->hot_discount_sub_heading ?? '',
                'side_text' => $request->hot_discount_side_text ?? 'See All',
            ];
        }

        if ($request->has('top_picks_main_heading')) {
            $data['top_picks_heading'] = [
                'main_heading' => $request->top_picks_main_heading ?? '',
                'sub_heading' => $request->top_picks_sub_heading ?? '',
                'side_text' => $request->top_picks_side_text ?? 'See All',
            ];
        }

        if ($request->has('order_again_main_heading')) {
            $data['order_again_heading'] = [
                'main_heading' => $request->order_again_main_heading ?? '',
                'sub_heading' => $request->order_again_sub_heading ?? '',
                'side_text' => $request->order_again_side_text ?? 'See All',
            ];
        }

        $homePageContent->update($data);
        return redirect()->route('home-page-contents.index')
                         ->with('success', 'Home Page content updated successfully.');
    }

    public function destroy(HomePageContent $homePageContent)
    {
        // Delete associated images
        if ($homePageContent->carousels) {
            foreach ($homePageContent->carousels as $carousel) {
                if (isset($carousel['image'])) {
                    Storage::disk('public')->delete($carousel['image']);
                }
            }
        }
        
        if ($homePageContent->tabs) {
            foreach ($homePageContent->tabs as $tab) {
                if (isset($tab['image'])) {
                    Storage::disk('public')->delete($tab['image']);
                }
            }
        }
        
        $homePageContent->delete();
        return redirect()->route('home-page-contents.index')
                         ->with('success', 'Home Page content deleted successfully.');
    }

    // Helper function for validation rules
    private function getValidationRules()
    {
        return [
            'tab_new_order' => 'required|string|max:100',
            'tab_newest' => 'required|string|max:100',
            'tab_most_favorite' => 'required|string|max:100',
            'title_hot_discounts' => 'required|string|max:100',
            'title_top_picks' => 'required|string|max:100',
            'title_for_you' => 'required|string|max:100',
            'title_order_again' => 'required|string|max:100',
            'status' => 'required|boolean',
            // Carousels
            'carousel_heading.*' => 'nullable|string|max:255',
            'carousel_body.*' => 'nullable|string|max:500',
            'carousel_button_text.*' => 'nullable|string|max:100',
            'carousel_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            // Tabs
            'tab_title.*' => 'nullable|string|max:100',
            'tab_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            // Headings
            'hot_discount_main_heading' => 'nullable|string|max:100',
            'hot_discount_sub_heading' => 'nullable|string|max:100',
            'hot_discount_side_text' => 'nullable|string|max:100',
            'top_picks_main_heading' => 'nullable|string|max:100',
            'top_picks_sub_heading' => 'nullable|string|max:100',
            'top_picks_side_text' => 'nullable|string|max:100',
            'order_again_main_heading' => 'nullable|string|max:100',
            'order_again_sub_heading' => 'nullable|string|max:100',
            'order_again_side_text' => 'nullable|string|max:100',
        ];
    }
}