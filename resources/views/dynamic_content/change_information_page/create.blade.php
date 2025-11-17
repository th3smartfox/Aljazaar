@extends('layouts.vertical', ['title' => 'Create Change Info Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Change Information Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('change-information-pages.index') }}">Change Information Page</a></li>
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
                    <form class="row g-3" action="{{ route('change-information-pages.store') }}" method="POST">
                        @csrf
                        
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Bar Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', 'Account Settings') }}" required>
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
                        <h6 class="text-primary">Account Section</h6>
                        
                        <div class="col-md-6">
                            <label for="label_account" class="form-label">"Account" Label</label>
                            <input type="text" name="label_account" class="form-control @error('label_account') is-invalid @enderror"
                                id="label_account" value="{{ old('label_account', 'Account') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="label_personal_information" class="form-label">"Personal Information" Label</label>
                            <input type="text" name="label_personal_information" class="form-control @error('label_personal_information') is-invalid @enderror"
                                id="label_personal_information" value="{{ old('label_personal_information', 'Personal Information') }}" required>
                        </div>

                        <hr class="my-2">
                        <h6 class="text-primary">Payment Section</h6>

                        <div class="col-md-6">
                            <label for="label_payment_method" class="form-label">"Payment Method" Label</label>
                            <input type="text" name="label_payment_method" class="form-control @error('label_payment_method') is-invalid @enderror"
                                id="label_payment_method" value="{{ old('label_payment_method', 'Payment Method') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="label_card_information" class="form-label">"Card Information" Label</label>
                            <input type="text" name="label_card_information" class="form-control @error('label_card_information') is-invalid @enderror"
                                id="label_card_information" value="{{ old('label_card_information', 'Card Information') }}" required>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="col-12 mt-3">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                            <a href="{{ route('change-information-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection