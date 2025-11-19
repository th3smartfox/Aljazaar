@php
    $cityId = $row['city_id'] ?? null;
    $cityName = $row['city_name'] ?? null;
    $imageUrl = $row['image_url'] ?? null;
    $imagePath = $row['image_path'] ?? null;
@endphp

<div class="city-card" data-index="{{ $index }}">
    <div class="city-card__header">
        <div>
            <span class="badge bg-primary-subtle text-primary fw-semibold">City #<span
                    class="city-row-number">{{ $rowNumber ?? $index + 1 }}</span></span>
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm remove-city-row">
            Remove
        </button>
    </div>

    <input type="hidden" name="cities[{{ $index }}][city_id]" class="city-id-input"
        value="{{ old("cities.$index.city_id", $cityId) }}">
    <input type="hidden" name="cities[{{ $index }}][existing_image]" class="existing-image-input"
        value="{{ old("cities.$index.existing_image", $imagePath) }}">

    <div class="row g-3">
        <div class="col-lg-6">
            <label class="form-label">Selected City</label>
            <div class="city-selected-pill">
                <span class="city-selected-name">{{ $cityName ?? 'No city selected yet' }}</span>
                <span class="text-muted small ms-2">(read-only)</span>
            </div>
            @error("cities.$index.city_id")
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-lg-6">
            <label class="form-label">Search City</label>
            <div class="city-search-container">
                <div class="input-group shadow-sm">
                    <input type="text" class="form-control city-search-input" placeholder="Start typing to search..."
                        autocomplete="off">
                    <button class="btn btn-outline-primary city-search-button" type="button">Search</button>
                </div>
                <div class="city-search-results d-none"></div>
            </div>
        </div>
    </div>

    <div class="row g-3 align-items-center mt-1">
        <div class="col-lg-6">
            <label class="form-label">City Image <span class="text-danger">*</span></label>
            <input type="file" name="cities[{{ $index }}][image]"
                class="form-control city-image-input @error("cities.$index.image") is-invalid @enderror" accept="image/*"
                data-preview-target="city-preview-{{ $index }}" {{ $imagePath ? '' : 'required' }}>
            @error("cities.$index.image")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-lg-6">
            <label class="form-label">Preview</label>
            <div class="city-image-preview {{ $imageUrl ? '' : 'd-none' }}" id="city-preview-{{ $index }}">
                @if ($imageUrl)
                    <img src="{{ $imageUrl }}" alt="{{ $cityName ?? 'Selected city image' }}" class="img-fluid rounded-3 shadow-sm">
                @else
                    <span class="text-muted small">No image selected yet</span>
                @endif
            </div>
        </div>
    </div>
</div>

