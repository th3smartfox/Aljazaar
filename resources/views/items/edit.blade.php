@extends('layouts.vertical', ['title' => 'Edit Item'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Item Management</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Items</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Edit Item: {{ $item->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Basic Info Card -->
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label for="name" class="form-label">Item Name</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                                    id="name" value="{{ old('name', $item->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label for="description" class="form-label">Description (Optional)</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4">{{ old('description', $item->description) }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- NEW: Add-ons Card -->
                                <div class="card shadow-sm border-0 mt-3">
                                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                        <h6 class="card-title mb-0 fw-semibold">Add-ons (Optional)</h6>
                                        <button type="button" class="btn btn-sm btn-primary" id="add-addon-btn">Add Add-on</button>
                                    </div>
                                    <div class="card-body">
                                        <div id="add-ons-container">
                                            <!-- Load existing add-ons -->
                                            @if($item->customization_options)
                                                @foreach($item->customization_options as $index => $addon)
                                                <div class="row g-2 mb-2 align-items-center">
                                                    <div class="col">
                                                        <label class="form-label-sm">Name</label>
                                                        <input type="text" name="add_ons[{{ $index }}][name]" class="form-control form-control-sm" placeholder="e.g., Fries" value="{{ $addon['name'] ?? '' }}">
                                                    </div>
                                                    <div class="col">
                                                        <label class="form-label-sm">Price (Rs.)</label>
                                                        <input type="number" name="add_ons[{{ $index }}][price]" class="form-control form-control-sm" placeholder="e.g., 150" step="0.01" value="{{ $addon['price'] ?? 0 }}">
                                                    </div>
                                                    <div class="col-auto">
                                                        <label class="form-label-sm d-block">&nbsp;</label>
                                                        <button type="button" class="btn btn-sm btn-danger remove-addon-btn">
                                                            <i data-feather="trash-2" style="width:16px; height:16px;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-lg-4">
                                <!-- Price & Category Card -->
                                <div class="card shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="base_price" class="form-label">Base Price (Rs.)</label>
                                                <input type="number" name="base_price" class="form-control @error('base_price') is-invalid @enderror"
                                                    id="base_price" value="{{ old('base_price', $item->base_price) }}" step="0.01" required>
                                                @error('base_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="discount_percent" class="form-label">Discount (%) (Optional)</label>
                                                <input type="number" name="discount_percent" class="form-control @error('discount_percent') is-invalid @enderror"
                                                    id="discount_percent" value="{{ old('discount_percent', $item->discount_percent) }}" step="0.01">
                                                @error('discount_percent')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id" required>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" required>
                                                    <option value="1" {{ old('status', $item->status) == 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ old('status', $item->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Image Card -->
                                <div class="card shadow-sm border-0 mt-3">
                                    <div class="card-body">
                                        <label for="image" class="form-label">Update Item Image (Optional)</label>
                                        <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        
                                        @php
                                            $imageSrc = $item->image ? asset('storage/' . $item->image) : '#';
                                            $imageDisplay = $item->image ? 'block' : 'none';
                                        @endphp
                                        <img id="imagePreview" src="{{ $imageSrc }}" alt="Image Preview" class="rounded mt-3" style="display: {{ $imageDisplay }}; width: 100%; height: auto; object-fit: cover;" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-12 text-end">
                                <button class="btn btn-primary" type="submit">Update Item</button>
                                <a href="{{ route('items.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // JS for image preview
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('imagePreview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // --- UPDATED: JS for Add-ons (Fixed Icon) ---
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('add-ons-container');
            
            // Initial index based on loaded items
            let addonIndex = {{ $item->customization_options ? count($item->customization_options) : 0 }};

            // --- FIX: SVG icon ko ek variable mein rakhein ---
            const trashIconSVG = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            `;

            // "Add" button click
            document.getElementById('add-addon-btn').addEventListener('click', function() {
                addAddonRow('', '', addonIndex);
                addonIndex++;
            });

            // "Remove" button click (event delegation)
            container.addEventListener('click', function(e) {
                // Check if the click target or its parent is the remove button
                if (e.target && (e.target.classList.contains('remove-addon-btn') || e.target.closest('.remove-addon-btn'))) {
                    e.target.closest('.row.g-2.mb-2').remove(); // Target the specific row class
                }
            });

            // Function to add a new row
            function addAddonRow(name, price, index) {
                const row = document.createElement('div');
                row.classList.add('row', 'g-2', 'mb-2', 'align-items-center');
                
                // --- FIX: <i> tag ke bajaye seedha SVG istemaal karein ---
                row.innerHTML = `
                    <div class="col">
                        <label class="form-label-sm">Name</label>
                        <input type="text" name="add_ons[${index}][name]" class="form-control form-control-sm" placeholder="e.g., Fries" value="${name}">
                    </div>
                    <div class="col">
                        <label class="form-label-sm">Price (Rs.)</label>
                        <input type="number" name="add_ons[${index}][price]" class="form-control form-control-sm" placeholder="e.g., 150" step="0.01" value="${price}">
                    </div>
                    <div class="col-auto">
                        <label class="form-label-sm d-block">&nbsp;</label>
                        <button type="button" class="btn btn-sm btn-danger remove-addon-btn">
                            ${trashIconSVG}
                        </button>
                    </div>
                `;
                
                container.appendChild(row);
                // feather.replace() ki ab zaroorat nahi hai
            }
        });
    </script>
@endsection