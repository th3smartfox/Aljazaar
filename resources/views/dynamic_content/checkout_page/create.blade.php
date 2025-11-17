@extends('layouts.vertical', ['title' => 'Create Checkout Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Checkout Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('checkout-page-contents.index') }}">Checkout Page</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Create New Checkout Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('checkout-page-contents.store') }}" method="POST">
                        @csrf
                        
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Bar Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', 'Checkout') }}" required>
                        </div>
                        
                        <!-- Proceed Button Text -->
                        <div class="col-md-6">
                            <label for="button_proceed" class="form-label">"Proceed" Button Text</label>
                            <input type="text" name="button_proceed" class="form-control @error('button_proceed') is-invalid @enderror"
                                id="button_proceed" value="{{ old('button_proceed', 'Proceed') }}" required>
                        </div>
                        
                        <hr class="my-2">
                        <h6 class="text-primary">Shipping Section</h6>

                        <div class="col-md-6">
                            <label for="text_shipping" class="form-label">"Shipping" Text</label>
                            <input type="text" name="text_shipping" class="form-control @error('text_shipping') is-invalid @enderror"
                                id="text_shipping" value="{{ old('text_shipping', 'Shipping') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="text_add_address" class="form-label">"Add Address" Text</label>
                            <input type="text" name="text_add_address" class="form-control @error('text_add_address') is-invalid @enderror"
                                id="text_add_address" value="{{ old('text_add_address', 'Add Address') }}" required>
                        </div>
                        
                        <hr class="my-2">
                        <h6 class="text-primary">Date & Time Section</h6>
                        
                        <div class="col-md-6">
                            <label for="text_date_time" class="form-label">"Date & Time" Text</label>
                            <input type="text" name="text_date_time" class="form-control @error('text_date_time') is-invalid @enderror"
                                id="text_date_time" value="{{ old('text_date_time', 'Date & Time') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="text_select_date_time" class="form-label">"Select Date & Time" Text</label>
                            <input type="text" name="text_select_date_time" class="form-control @error('text_select_date_time') is-invalid @enderror"
                                id="text_select_date_time" value="{{ old('text_select_date_time', 'Select Date & Time') }}" required>
                        </div>
                        
                        <hr class="my-2">
                        <h6 class="text-primary">Payment Section</h6>

                        <div class="col-md-6">
                            <label for="text_payment" class="form-label">"Payment" Text</label>
                            <input type="text" name="text_payment" class="form-control @error('text_payment') is-invalid @enderror"
                                id="text_payment" value="{{ old('text_payment', 'Payment') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="text_select_payment_method" class="form-label">"Select Payment Method" Text</label>
                            <input type="text" name="text_select_payment_method" class="form-control @error('text_select_payment_method') is-invalid @enderror"
                                id="text_select_payment_method" value="{{ old('text_select_payment_method', 'Select Payment Method') }}" required>
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
                        <div class="col-12 mt-3">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                            <a href="{{ route('checkout-page-contents.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection