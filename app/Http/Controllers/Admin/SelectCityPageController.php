<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SelectCityPage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Nnjeim\World\Models\City;

class SelectCityPageController extends Controller
{
    // Authorization 'role:Admin' middleware ke zariye routes/web.php mein hai

    public function index()
    {
        $cityPages = SelectCityPage::latest()->get();
        return view('dynamic_content.city_page.index', compact('cityPages'));
    }

    public function create(Request $request)
    {
        $cityRows = $this->resolveCityRows(
            $request->session()->getOldInput('cities', [])
        );

        if ($cityRows->isEmpty()) {
            $cityRows->push($this->blankCityRow());
        }

        return view('dynamic_content.city_page.create', [
            'cityRows' => $cityRows,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateForm($request);

        DB::transaction(function () use ($validated, $request) {
            /** @var SelectCityPage $page */
            $page = SelectCityPage::create(Arr::only($validated, [
                'main_heading',
                'sub_heading',
                'button_text',
                'status',
            ]));

            $this->syncSelectedCities($page, $request);
        });

        return redirect()
            ->route('select-city-pages.index')
                         ->with('success', 'Select City Page content created successfully.');
    }

    public function show(SelectCityPage $selectCityPage)
    {
        return redirect()->route('select-city-pages.edit', $selectCityPage);
    }

    public function edit(Request $request, SelectCityPage $selectCityPage)
    {
        $selectCityPage->load('selectedCities.city');

        $oldCities = $request->session()->getOldInput('cities', []);
        if (!empty($oldCities)) {
            $cityRows = $this->resolveCityRows($oldCities);
        } else {
            $cityRows = $selectCityPage->selectedCities->map(function ($entry) {
                return [
                    'city_id' => $entry->city_id,
                    'city_name' => optional($entry->city)->name,
                    'image_path' => $entry->image_path,
                    'image_url' => $entry->image_url,
                ];
            });
        }

        if ($cityRows->isEmpty()) {
            $cityRows->push($this->blankCityRow());
        }

        return view('dynamic_content.city_page.edit', [
            'selectCityPage' => $selectCityPage,
            'cityRows' => $cityRows,
        ]);
    }

    public function update(Request $request, SelectCityPage $selectCityPage)
    {
        $validated = $this->validateForm($request);

        DB::transaction(function () use ($selectCityPage, $validated, $request) {
            $selectCityPage->update(Arr::only($validated, [
                'main_heading',
                'sub_heading',
                'button_text',
                'status',
            ]));

            $this->syncSelectedCities($selectCityPage, $request);
        });

        return redirect()
            ->route('select-city-pages.index')
            ->with('success', 'Select City Page content updated successfully.');
    }

    public function destroy(SelectCityPage $selectCityPage)
    {
        $imagePaths = $selectCityPage->selectedCities()->pluck('image_path')->toArray();
        $selectCityPage->delete();

        foreach ($imagePaths as $path) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }

        return redirect()->route('select-city-pages.index')
                         ->with('success', 'Select City Page content deleted successfully.');
    }

    public function searchCities(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $cities = City::select(['id', 'name'])
            ->where('name', 'like', "{$request->query('query')}%")
            ->orderBy('name')
            ->limit(20)
            ->get();

        return response()->json($cities);
    }

    protected function validateForm(Request $request): array
    {
        return $request->validate([
            'main_heading' => 'required|string|max:255',
            'sub_heading' => 'required|string|max:255',
            'button_text' => 'required|string|max:50',
            'status' => 'required|boolean',
            'cities' => 'required|array|min:1',
            'cities.*.city_id' => 'required|distinct|exists:cities,id',
            'cities.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'cities.*.existing_image' => 'nullable|string',
        ], [
            'cities.required' => 'Please add at least one city.',
            'cities.*.city_id.required' => 'City selection is required.',
            'cities.*.city_id.distinct' => 'Duplicate cities are not allowed.',
            'cities.*.city_id.exists' => 'Selected city was not found.',
            'cities.*.image.image' => 'City image must be a valid image file.',
        ]);
    }

    protected function syncSelectedCities(SelectCityPage $page, Request $request): void
    {
        $citiesInput = $request->input('cities', []);
        $oldImages = $page->selectedCities()->pluck('image_path')->toArray();
        $page->selectedCities()->delete();

        $imagePathsToKeep = [];

        foreach ($citiesInput as $index => $cityData) {
            $imageFile = $request->file("cities.$index.image");
            $existingImage = Arr::get($cityData, 'existing_image');

            if (!$imageFile && !$existingImage) {
                throw ValidationException::withMessages([
                    "cities.$index.image" => 'City image is required.',
                ]);
            }

            if ($imageFile) {
                $imagePath = $imageFile->store('select-city-page/cities', 'public');
            } else {
                $imagePath = $existingImage;
            }

            $normalizedPath = $this->normalizeImagePath($imagePath);
            $imagePathsToKeep[] = $normalizedPath;

            $page->selectedCities()->create([
                'city_id' => $cityData['city_id'],
                'image_path' => $normalizedPath,
            ]);
        }

        $pathsToDelete = array_diff($oldImages, $imagePathsToKeep);
        foreach ($pathsToDelete as $path) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    protected function resolveCityRows(array $citiesInput): Collection
    {
        if (empty($citiesInput)) {
            return collect();
        }

        $cityIds = collect($citiesInput)
            ->pluck('city_id')
            ->filter()
            ->unique();

        $cityNames = $cityIds->isNotEmpty()
            ? City::whereIn('id', $cityIds)->pluck('name', 'id')
            : collect();

        return collect($citiesInput)->map(function ($row) use ($cityNames) {
            $cityId = Arr::get($row, 'city_id');
            $imagePath = Arr::get($row, 'existing_image');

            return [
                'city_id' => $cityId,
                'city_name' => $cityId ? ($cityNames[$cityId] ?? null) : null,
                'image_path' => $imagePath,
                'image_url' => $this->formatImageUrl($imagePath),
            ];
        });
    }

    protected function blankCityRow(): array
    {
        return [
            'city_id' => null,
            'city_name' => null,
            'image_path' => null,
            'image_url' => null,
        ];
    }

    protected function normalizeImagePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        if (Str::startsWith($normalized, 'storage/')) {
            return Str::after($normalized, 'storage/');
        }

        if (Str::startsWith($normalized, 'public/')) {
            return Str::after($normalized, 'public/');
        }

        return $normalized;
    }

    protected function formatImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $normalized = str_replace('\\', '/', $path);

        if (Str::startsWith($normalized, ['http://', 'https://'])) {
            return $normalized;
        }

        if (Str::startsWith($normalized, ['/storage/', 'storage/'])) {
            return asset(ltrim($normalized, '/'));
        }

        return Storage::disk('public')->url($normalized);
    }
}