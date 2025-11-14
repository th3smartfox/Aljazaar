@extends('layouts.vertical', ['title' => 'Edit Home Page Content'])

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Home Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home-page-contents.index') }}">Home Page</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Edit Home Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('home-page-contents.update', $homePageContent->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h6 class="text-primary">Tab Texts</h6>
                        <div class="col-md-4">
                            <label for="tab_new_order" class="form-label">"New Order" Tab</label>
                            <input type="text" name="tab_new_order" class="form-control @error('tab_new_order') is-invalid @enderror"
                                id="tab_new_order" value="{{ old('tab_new_order', $homePageContent->tab_new_order) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="tab_newest" class="form-label">"Newest" Tab</label>
                            <input type="text" name="tab_newest" class="form-control @error('tab_newest') is-invalid @enderror"
                                id="tab_newest" value="{{ old('tab_newest', $homePageContent->tab_newest) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="tab_most_favorite" class="form-label">"Most Favorite" Tab</label>
                            <input type="text" name="tab_most_favorite" class="form-control @error('tab_most_favorite') is-invalid @enderror"
                                id="tab_most_favorite" value="{{ old('tab_most_favorite', $homePageContent->tab_most_favorite) }}" required>
                        </div>

                        <hr class="my-3">
                        <h6 class="text-primary">Section Titles</h6>

                        <div class="col-md-4">
                            <label for="title_hot_discounts" class="form-label">"Hot Discounts" Title</label>
                            <input type="text" name="title_hot_discounts" class="form-control @error('title_hot_discounts') is-invalid @enderror"
                                id="title_hot_discounts" value="{{ old('title_hot_discounts', $homePageContent->title_hot_discounts) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="title_top_picks" class="form-label">"Top Picks" Title</label>
                            <input type="text" name="title_top_picks" class="form-control @error('title_top_picks') is-invalid @enderror"
                                id="title_top_picks" value="{{ old('title_top_picks', $homePageContent->title_top_picks) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="title_for_you" class="form-label">"For You" Title</label>
                            <input type="text" name="title_for_you" class="form-control @error('title_for_you') is-invalid @enderror"
                                id="title_for_you" value="{{ old('title_for_you', $homePageContent->title_for_you) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="title_order_again" class="form-label">"Order Again" Title</label>
                            <input type="text" name="title_order_again" class="form-control @error('title_order_again') is-invalid @enderror"
                                id="title_order_again" value="{{ old('title_order_again', $homePageContent->title_order_again) }}" required>
                        </div>
                        
                        <hr class="my-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" required>
                                <option value="1" {{ old('status', $homePageContent->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $homePageContent->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <hr class="my-3">
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-primary mb-0">Carousels</h6>
                                <button type="button" class="btn btn-sm btn-primary" id="addCarousel">
                                    <i data-feather="plus" class="me-1" style="width: 14px;"></i> Add Carousel
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="carouselsContainer" class="row g-3">
                                @php
                                    $carousels = old('carousels', $homePageContent->carousels ?? []);
                                @endphp
                                @if(!empty($carousels))
                                    @foreach($carousels as $index => $carousel)
                                        <div class="col-12 mb-3 p-3 border rounded carousel-item" data-index="{{ $index }}">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Carousel {{ $index + 1 }}</h6>
                                                <button type="button" class="btn btn-sm btn-danger remove-carousel">
                                                    <i data-feather="trash-2" style="width: 14px;"></i> Remove
                                                </button>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Heading</label>
                                                    <input type="text" name="carousel_heading[]" class="form-control" 
                                                        value="{{ old("carousel_heading.$index", $carousel['heading'] ?? '') }}" placeholder="Enter heading">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Button Text</label>
                                                    <input type="text" name="carousel_button_text[]" class="form-control" 
                                                        value="{{ old("carousel_button_text.$index", $carousel['button_text'] ?? '') }}" placeholder="Enter button text">
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Body</label>
                                                    <textarea name="carousel_body[]" class="form-control" rows="2" placeholder="Enter body text">{{ old("carousel_body.$index", $carousel['body'] ?? '') }}</textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Image</label>
                                                    @if(isset($carousel['image']) && $carousel['image'])
                                                        <div class="mb-2">
                                                            <img src="{{ Storage::url($carousel['image']) }}" alt="Current image" style="max-height: 100px;" class="img-thumbnail">
                                                        </div>
                                                    @endif
                                                    <input type="file" name="carousel_images[{{ $index }}]" class="form-control" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <hr class="my-3">
                        <div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-primary mb-0">Tabs (Max 3)</h6>
                                <button type="button" class="btn btn-sm btn-primary" id="addTab" 
                                    {{ count(old('tabs', $homePageContent->tabs ?? [])) >= 3 ? 'disabled' : '' }}>
                                    <i data-feather="plus" class="me-1" style="width: 14px;"></i> Add Tab
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="tabsContainer" class="row g-3">
                                @php
                                    $tabs = old('tabs', $homePageContent->tabs ?? []);
                                @endphp
                                @if(!empty($tabs))
                                    @foreach($tabs as $index => $tab)
                                        <div class="col-12 mb-3 p-3 border rounded tab-item" data-index="{{ $index }}">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Tab {{ $index + 1 }}</h6>
                                                <button type="button" class="btn btn-sm btn-danger remove-tab">
                                                    <i data-feather="trash-2" style="width: 14px;"></i> Remove
                                                </button>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" name="tab_title[]" class="form-control" 
                                                        value="{{ old("tab_title.$index", $tab['title'] ?? '') }}" placeholder="Enter tab title" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Image</label>
                                                    @if(isset($tab['image']) && $tab['image'])
                                                        <div class="mb-2">
                                                            <img src="{{ Storage::url($tab['image']) }}" alt="Current image" style="max-height: 100px;" class="img-thumbnail">
                                                        </div>
                                                    @endif
                                                    <input type="file" name="tab_images[{{ $index }}]" class="form-control" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <hr class="my-3">
                        <h6 class="text-primary">Section Headings</h6>

                        @php
                            $hotDiscountHeading = old('hot_discount_heading', $homePageContent->hot_discount_heading ?? []);
                            $topPicksHeading = old('top_picks_heading', $homePageContent->top_picks_heading ?? []);
                            $orderAgainHeading = old('order_again_heading', $homePageContent->order_again_heading ?? []);
                        @endphp

                        <div class="col-md-4">
                            <label for="hot_discount_main_heading" class="form-label">Hot Discounts - Main Heading</label>
                            <input type="text" name="hot_discount_main_heading" class="form-control"
                                id="hot_discount_main_heading" value="{{ old('hot_discount_main_heading', $hotDiscountHeading['main_heading'] ?? $homePageContent->title_hot_discounts ?? 'Hot discounts') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="hot_discount_sub_heading" class="form-label">Hot Discounts - Sub Heading</label>
                            <input type="text" name="hot_discount_sub_heading" class="form-control"
                                id="hot_discount_sub_heading" value="{{ old('hot_discount_sub_heading', $hotDiscountHeading['sub_heading'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="hot_discount_side_text" class="form-label">Hot Discounts - Side Text</label>
                            <input type="text" name="hot_discount_side_text" class="form-control"
                                id="hot_discount_side_text" value="{{ old('hot_discount_side_text', $hotDiscountHeading['side_text'] ?? 'See All') }}">
                        </div>

                        <div class="col-md-4">
                            <label for="top_picks_main_heading" class="form-label">Top Picks - Main Heading</label>
                            <input type="text" name="top_picks_main_heading" class="form-control"
                                id="top_picks_main_heading" value="{{ old('top_picks_main_heading', $topPicksHeading['main_heading'] ?? $homePageContent->title_top_picks ?? 'Top picks') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="top_picks_sub_heading" class="form-label">Top Picks - Sub Heading</label>
                            <input type="text" name="top_picks_sub_heading" class="form-control"
                                id="top_picks_sub_heading" value="{{ old('top_picks_sub_heading', $topPicksHeading['sub_heading'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="top_picks_side_text" class="form-label">Top Picks - Side Text</label>
                            <input type="text" name="top_picks_side_text" class="form-control"
                                id="top_picks_side_text" value="{{ old('top_picks_side_text', $topPicksHeading['side_text'] ?? 'See All') }}">
                        </div>

                        <div class="col-md-4">
                            <label for="order_again_main_heading" class="form-label">Order Again - Main Heading</label>
                            <input type="text" name="order_again_main_heading" class="form-control"
                                id="order_again_main_heading" value="{{ old('order_again_main_heading', $orderAgainHeading['main_heading'] ?? $homePageContent->title_order_again ?? 'Order Again') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="order_again_sub_heading" class="form-label">Order Again - Sub Heading</label>
                            <input type="text" name="order_again_sub_heading" class="form-control"
                                id="order_again_sub_heading" value="{{ old('order_again_sub_heading', $orderAgainHeading['sub_heading'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="order_again_side_text" class="form-label">Order Again - Side Text</label>
                            <input type="text" name="order_again_side_text" class="form-control"
                                id="order_again_side_text" value="{{ old('order_again_side_text', $orderAgainHeading['side_text'] ?? 'See All') }}">
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Update form</button>
                            <a href="{{ route('home-page-contents.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection

@section('script')
    <style>
        #carouselsContainer, #tabsContainer {
            min-height: 20px;
            display: block !important;
            width: 100% !important;
            clear: both !important;
        }
        .carousel-item, .tab-item {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            width: 100% !important;
            float: none !important;
            clear: both !important;
            margin-bottom: 1rem !important;
            position: relative !important;
        }
        .carousel-item .row, .tab-item .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    </style>
    <script>
        (function() {
            let carouselCount = {{ count(old('carousels', $homePageContent->carousels ?? [])) }};
            let tabCount = {{ count(old('tabs', $homePageContent->tabs ?? [])) }};

            function initCarousels() {
                const addCarouselBtn = document.getElementById('addCarousel');
                if (!addCarouselBtn) {
                    console.log('Add Carousel button not found, retrying...');
                    setTimeout(initCarousels, 100);
                    return;
                }

                addCarouselBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Add Carousel clicked');
                    const container = document.getElementById('carouselsContainer');
                    if (!container) {
                        console.error('Carousels container not found');
                        return;
                    }
                    
                    const index = carouselCount++;
                    
                    const carouselHtml = '<div class="col-12 mb-3 p-3 border rounded carousel-item" data-index="' + index + '">' +
                        '<div class="d-flex justify-content-between align-items-center mb-2">' +
                        '<h6 class="mb-0">Carousel ' + (index + 1) + '</h6>' +
                        '<button type="button" class="btn btn-sm btn-danger remove-carousel">' +
                        '<i data-feather="trash-2" style="width: 14px;"></i> Remove' +
                        '</button>' +
                        '</div>' +
                        '<div class="row g-3">' +
                        '<div class="col-md-6">' +
                        '<label class="form-label">Heading</label>' +
                        '<input type="text" name="carousel_heading[]" class="form-control" placeholder="Enter heading">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label class="form-label">Button Text</label>' +
                        '<input type="text" name="carousel_button_text[]" class="form-control" placeholder="Enter button text">' +
                        '</div>' +
                        '<div class="col-md-12">' +
                        '<label class="form-label">Body</label>' +
                        '<textarea name="carousel_body[]" class="form-control" rows="2" placeholder="Enter body text"></textarea>' +
                        '</div>' +
                        '<div class="col-md-12">' +
                        '<label class="form-label">Image</label>' +
                        '<input type="file" name="carousel_images[' + index + ']" class="form-control" accept="image/*">' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    
                    // Force scroll to see the added carousel
                    container.insertAdjacentHTML('beforeend', carouselHtml);
                    const addedCarousel = container.lastElementChild;
                    if (addedCarousel) {
                        addedCarousel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        console.log('Carousel added successfully. Container children:', container.children.length);
                        console.log('Added carousel element:', addedCarousel);
                        console.log('Carousel display style:', window.getComputedStyle(addedCarousel).display);
                    }
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                });
            }

            function initTabs() {
                const addTabBtn = document.getElementById('addTab');
                if (!addTabBtn) {
                    console.log('Add Tab button not found, retrying...');
                    setTimeout(initTabs, 100);
                    return;
                }

                addTabBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (tabCount >= 3) {
                        alert('Maximum 3 tabs allowed');
                        return;
                    }
                    
                    const container = document.getElementById('tabsContainer');
                    if (!container) {
                        console.error('Tabs container not found');
                        return;
                    }
                    
                    const index = tabCount++;
                    
                    const tabHtml = '<div class="col-12 mb-3 p-3 border rounded tab-item" data-index="' + index + '">' +
                        '<div class="d-flex justify-content-between align-items-center mb-2">' +
                        '<h6 class="mb-0">Tab ' + (index + 1) + '</h6>' +
                        '<button type="button" class="btn btn-sm btn-danger remove-tab">' +
                        '<i data-feather="trash-2" style="width: 14px;"></i> Remove' +
                        '</button>' +
                        '</div>' +
                        '<div class="row g-3">' +
                        '<div class="col-md-6">' +
                        '<label class="form-label">Title</label>' +
                        '<input type="text" name="tab_title[]" class="form-control" placeholder="Enter tab title" required>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label class="form-label">Image</label>' +
                        '<input type="file" name="tab_images[' + index + ']" class="form-control" accept="image/*">' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    
                    container.insertAdjacentHTML('beforeend', tabHtml);
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                    
                    if (tabCount >= 3) {
                        document.getElementById('addTab').disabled = true;
                    }
                });
            }

            // Remove Carousel
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-carousel')) {
                    e.target.closest('.carousel-item').remove();
                }
            });

            // Remove Tab
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-tab')) {
                    e.target.closest('.tab-item').remove();
                    tabCount--;
                    const addTabBtn = document.getElementById('addTab');
                    if (addTabBtn) {
                        addTabBtn.disabled = false;
                    }
                }
            });

            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    initCarousels();
                    initTabs();
                });
            } else {
                initCarousels();
                initTabs();
            }
        })();
    </script>
@endsection