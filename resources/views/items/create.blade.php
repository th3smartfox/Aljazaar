@extends('layouts.vertical', ['title' => 'Create Item'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Item Management</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Items</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Create New Item</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                                                    id="name" value="{{ old('name') }}" placeholder="e.g., Cheeseburger" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <label for="description" class="form-label">Description (Optional)</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4"
                                                    placeholder="Enter a brief description...">{{ old('description') }}</textarea>
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
                                            <!-- JS is container mein inputs add karega -->
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
                                                    id="base_price" value="{{ old('base_price') }}" placeholder="e.g., 500.00" step="0.01" required>
                                                @error('base_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="discount_percent" class="form-label">Discount (%) (Optional)</label>
                                                <input type="number" name="discount_percent" class="form-control @error('discount_percent') is-invalid @enderror"
                                                    id="discount_percent" value="{{ old('discount_percent', 0) }}" placeholder="e.g., 10" step="0.01">
                                                @error('discount_percent')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id" required>
                                                    <option value="" disabled selected>Select a category...</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
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
                                        <label for="image" class="form-label">Item Image (Optional)</label>
                                        <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <img id="imagePreview" src="#" alt="Image Preview" class="rounded mt-3" style="display: none; width: 100%; height: auto; object-fit: cover;" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-12 text-end">
                                <button class="btn btn-primary" type="submit">Submit Item</button>
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
            let addonIndex = 0;
            const container = document.getElementById('add-ons-container');
            
            // --- FIX: SVG icon ko ek variable mein rakhein ---
            const trashIconSVG = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            `;
            
            document.getElementById('add-addon-btn').addEventListener('click', function() {
                // Create new elements
                const row = document.createElement('div');
                row.classList.add('row', 'g-2', 'mb-2', 'align-items-center');
                
                // Name input
                const nameCol = document.createElement('div');
                nameCol.classList.add('col');
                nameCol.innerHTML = `
                    <label class="form-label-sm">Name</label>
                    <input type="text" name="add_ons[${addonIndex}][name]" class="form-control form-control-sm" placeholder="e.g., Fries">
                `;
                
                // Price input
                const priceCol = document.createElement('div');
                priceCol.classList.add('col');
                priceCol.innerHTML = `
                    <label class="form-label-sm">Price (Rs.)</label>
                    <input type="number" name="add_ons[${addonIndex}][price]" class="form-control form-control-sm" placeholder="e.g., 150" step="0.01">
                `;

                // Remove button
                const removeCol = document.createElement('div');
                removeCol.classList.add('col-auto');
                
                // --- FIX: <i> tag ke bajaye seedha SVG istemaal karein ---
                removeCol.innerHTML = `
                    <label class="form-label-sm d-block">&nbsp;</label>
                    <button type="button" class="btn btn-sm btn-danger remove-addon-btn">
                        ${trashIconSVG}
                    </button>
                `;

                // Append columns to row
                row.appendChild(nameCol);
                row.appendChild(priceCol);
                row.appendChild(removeCol);
                
                // Append row to container
                container.appendChild(row);
                
                // Add event listener to the new remove button
                removeCol.querySelector('.remove-addon-btn').addEventListener('click', function() {
                    row.remove();
                });
                
                addonIndex++;
            });
        });
    </script>
@endsection