@extends('layouts.vertical', ['title' => 'Create Cart Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Cart Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart-page-contents.index') }}">Cart Page</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Create New Cart Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('cart-page-contents.store') }}" method="POST">
                        @csrf
                        
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Bar Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', 'Order Details') }}" required>
                        </div>

                        <!-- Status Field -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" required>
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <hr class="my-2">
                        <h6 class="text-primary">Rewards Section</h6>

                        <!-- Rewards Progress Text -->
                        <div class="col-md-6">
                            <label for="text_rewards_progress" class="form-label">"Rewards Progress" Text</label>
                            <input type="text" name="text_rewards_progress" class="form-control @error('text_rewards_progress') is-invalid @enderror"
                                id="text_rewards_progress" value="{{ old('text_rewards_progress', 'Your Rewards Progress') }}" required>
                        </div>
                        
                        <!-- Rewards Status Text -->
                        <div class="col-md-6">
                            <label for="text_rewards_status" class="form-label">"Rewards Status" Text</label>
                            <input type="text" name="text_rewards_status" class="form-control @error('text_rewards_status') is-invalid @enderror"
                                id="text_rewards_status" value="{{ old('text_rewards_status', "You're {amount} from your coupon code") }}" required>
                            <small class="form-text text-muted">Use {amount} as a placeholder for the dynamic value.</small>
                        </div>

                        <hr class="my-2">
                        <h6 class="text-primary">Coupon Section</h6>

                        <!-- Coupon Placeholder -->
                        <div class="col-md-6">
                            <label for="placeholder_coupon" class="form-label">Coupon Placeholder</label>
                            <input type="text" name="placeholder_coupon" class="form-control @error('placeholder_coupon') is-invalid @enderror"
                                id="placeholder_coupon" value="{{ old('placeholder_coupon', 'Enter Coupon Code') }}" required>
                        </div>

                        <!-- Apply Button -->
                        <div class="col-md-6">
                            <label for="button_apply" class="form-label">"Apply" Button Text</label>
                            <input type="text" name="button_apply" class="form-control @error('button_apply') is-invalid @enderror"
                                id="button_apply" value="{{ old('button_apply', 'Apply') }}" required>
                        </div>

                        <hr class="my-2">
                        <h6 class="text-primary">Checkout Section</h6>
                        
                        <!-- Total Text -->
                        <div class="col-md-6">
                            <label for="text_total" class="form-label">"Total" Text</label>
                            <input type="text" name="text_total" class="form-control @error('text_total') is-invalid @enderror"
                                id="text_total" value="{{ old('text_total', 'Total') }}" required>
                        </div>
                        
                        <!-- Checkout Button -->
                        <div class="col-md-6">
                            <label for="button_checkout" class="form-label">"Checkout" Button Text</label>
                            <input type="text" name="button_checkout" class="form-control @error('button_checkout') is-invalid @enderror"
                                id="button_checkout" value="{{ old('button_checkout', 'Checkout') }}" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                            <a href="{{ route('cart-page-contents.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection