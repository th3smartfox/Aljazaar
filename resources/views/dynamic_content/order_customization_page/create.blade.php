@extends('layouts.vertical', ['title' => 'Create Order Customization Page'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Order Customization Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('order-customization-pages.index') }}">Order Customization Page</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Create New Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('order-customization-pages.store') }}" method="POST">
                        @csrf

                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Bar Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', 'Order Customization') }}" required>
                        </div>
                        
                        <!-- Button Text -->
                        <div class="col-md-6">
                            <label for="button_add_to_cart" class="form-label">Button Text ("Add to cart")</label>
                            <input type="text" name="button_add_to_cart" class="form-control @error('button_add_to_cart') is-invalid @enderror"
                                id="button_add_to_cart" value="{{ old('button_add_to_cart', 'Add to cart') }}" required>
                        </div>
                        
                        <hr class_alias="my-2">

                        <!-- Add-Ons Text -->
                        <div class="col-md-4">
                            <label for="text_add_ons" class="form-label">"Add-Ons" Text</label>
                            <input type="text" name="text_add_ons" class="form-control @error('text_add_ons') is-invalid @enderror"
                                id="text_add_ons" value="{{ old('text_add_ons', 'Add-Ons') }}" required>
                        </div>

                        <!-- Portion Text -->
                        <div class="col-md-4">
                            <label for="text_portion" class="form-label">"Portion" Text</label>
                            <input type="text" name="text_portion" class="form-control @error('text_portion') is-invalid @enderror"
                                id="text_portion" value="{{ old('text_portion', 'Portion') }}" required>
                        </div>

                        <!-- Total Text -->
                        <div class="col-md-4">
                            <label for="text_total" class="form-label">"Total" Text</label>
                            <input type="text" name="text_total" class="form-control @error('text_total') is-invalid @enderror"
                                id="text_total" value="{{ old('text_total', 'Total') }}" required>
                        </div>
                        
                        <!-- Status Field -->
                        <div class="col-md-12 mt-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" required>
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                            <a href="{{ route('order-customization-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection