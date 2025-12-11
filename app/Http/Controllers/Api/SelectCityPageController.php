<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SelectCityPage;
use App\Http\Resources\Content\SelectCityPageResource;
use Illuminate\Http\Request;

class SelectCityPageController extends Controller
{
    public function getCityPageContent(Request $request)
    {
        $page = SelectCityPage::with([
            'selectedCities' => function ($query) {
                $query->with('city')->orderBy('id');
            }
        ])
            ->where('status', true)
            ->latest()
            ->first();

        if (!$page) {
            $pageContent = [
                'main_heading' => 'Select Your City',
                'sub_heading' => 'Choose your city to start exploring nearby restaurants and cuisines.',
                'button_text' => 'Next',
            ];
        } else {
            $pageContent = (new SelectCityPageResource($page))->toArray($request);
        }

        $cities = $page
            ? $page->selectedCities
                ->map(function ($selectedCity) {
                    if (!$selectedCity->city) {
                        return null;
                    }

                    return [
                        'id' => (int) $selectedCity->city_id,
                        'name' => $selectedCity->city->name,
                        'image' => $selectedCity->image_url,
                    ];
                })
                ->filter()
                ->values()
            : collect();

        if ($request->has('search')) {
            $term = strtolower($request->query('search'));
            $cities = $cities->filter(function ($city) use ($term) {
                return str_contains(strtolower($city['name']), $term);
            })->values();
        }

        return response()->json([
            'page_content' => $pageContent,
            'cities' => $cities,
        ]);
    }
}