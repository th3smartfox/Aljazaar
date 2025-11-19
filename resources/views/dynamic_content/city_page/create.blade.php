@extends('layouts.vertical', ['title' => 'Create City Page Content'])

@section('css')
    @include('dynamic_content.city_page.partials.form-styles')
@endsection

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Select City Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('select-city-pages.index') }}">Select City Page</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Create New City Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-4" action="{{ route('select-city-pages.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Main Heading Field -->
                        <div class="col-md-6">
                            <label for="main_heading" class="form-label">Main Heading</label>
                            <input type="text" name="main_heading" class="form-control @error('main_heading') is-invalid @enderror"
                                id="main_heading" value="{{ old('main_heading', 'Select Your City') }}" required>
                            @error('main_heading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Button Text Field -->
                        <div class="col-md-6">
                            <label for="button_text" class="form-label">Button Text</label>
                            <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror"
                                id="button_text" value="{{ old('button_text', 'Next') }}" required>
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sub Heading Field -->
                        <div class="col-md-12">
                            <label for="sub_heading" class="form-label">Sub Heading</label>
                            <textarea name="sub_heading" class="form-control @error('sub_heading') is-invalid @enderror"
                                id="sub_heading" rows="3">{{ old('sub_heading', 'Choose your city to start exploring nearby restaurants and cuisines.') }}</textarea>
                            @error('sub_heading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- City Selection -->
                        <div class="col-12">
                            <div class="cities-section">
                                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                                    <div>
                                        <label class="form-label d-block mb-1">Cities</label>
                                        <small class="text-muted">Choose one or more cities and add a square image for each
                                            selection.</small>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="addCityRow">
                                        + Add City
                                    </button>
                                </div>

                                @php
                                    $maxKey = $cityRows->keys()->filter(fn($key) => is_numeric($key))->max();
                                    $nextIndex = is_null($maxKey) ? $cityRows->count() : ($maxKey + 1);
                                @endphp
                                <div id="cityRows" data-search-url="{{ route('select-city-pages.city-search') }}"
                                    data-next-index="{{ $nextIndex }}">
                                    @foreach ($cityRows as $index => $row)
                                        @include('dynamic_content.city_page.partials.city-row', [
                                            'index' => $index,
                                            'row' => $row,
                                            'rowNumber' => $loop->iteration,
                                        ])
                                    @endforeach
                                </div>
                                @error('cities')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Field -->
                        <div class="col-md-12">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" required>
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                            <a href="{{ route('select-city-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

    <template id="city-row-template">
        <div class="city-card" data-index="__INDEX__">
            <div class="city-card__header">
                <span class="badge bg-primary-subtle text-primary fw-semibold">City #<span
                        class="city-row-number">__ROW__</span></span>
                <button type="button" class="btn btn-outline-danger btn-sm remove-city-row">
                    Remove
                </button>
            </div>

            <input type="hidden" name="cities[__INDEX__][city_id]" class="city-id-input" value="">
            <input type="hidden" name="cities[__INDEX__][existing_image]" class="existing-image-input" value="">

            <div class="row g-3">
                <div class="col-lg-6">
                    <label class="form-label">Selected City</label>
                    <div class="city-selected-pill">
                        <span class="city-selected-name">No city selected yet</span>
                        <span class="text-muted small ms-2">(read-only)</span>
                    </div>
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
                    <input type="file" name="cities[__INDEX__][image]" class="form-control city-image-input" accept="image/*"
                        data-preview-target="city-preview-__INDEX__" required>
                </div>

                <div class="col-lg-6">
                    <label class="form-label">Preview</label>
                    <div class="city-image-preview d-none" id="city-preview-__INDEX__">
                        <span class="text-muted small">No image selected yet</span>
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection

@section('script')
    @include('dynamic_content.city_page.partials.form-scripts')
@endsection