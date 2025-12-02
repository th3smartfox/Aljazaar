@extends('layouts.vertical', ['title' => 'Create Forgot Password Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Forgot Password Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('forgot-password-pages.index') }}">Forgot Password Page</a>
                </li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Create New Forgot Password Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('forgot-password-pages.store') }}" method="POST">
                        @csrf

                        <!-- Title Field -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', 'Forgot Password') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sub Title Field -->
                        <div class="col-md-6">
                            <label for="sub_title" class="form-label">Sub Title</label>
                            <input type="text" name="sub_title"
                                class="form-control @error('sub_title') is-invalid @enderror" id="sub_title"
                                value="{{ old('sub_title', 'Enter Your email or phone number to receive a verification code.') }}"
                                required>
                            @error('sub_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email or Phone Number Label -->
                        <div class="col-md-6">
                            <label for="email_or_phone_label" class="form-label">Email or Phone Number Label</label>
                            <input type="text" name="email_or_phone_label"
                                class="form-control @error('email_or_phone_label') is-invalid @enderror"
                                id="email_or_phone_label" value="{{ old('email_or_phone_label', 'Email or Phone Number') }}"
                                required>
                            @error('email_or_phone_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email or Phone Number Hint -->
                        <div class="col-md-6">
                            <label for="email_or_phone_hint" class="form-label">Email or Phone Number Hint</label>
                            <input type="text" name="email_or_phone_hint"
                                class="form-control @error('email_or_phone_hint') is-invalid @enderror"
                                id="email_or_phone_hint"
                                value="{{ old('email_or_phone_hint', 'Your Email Or Phone Number') }}" required>
                            @error('email_or_phone_hint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Continue Button Text -->
                        <div class="col-md-6">
                            <label for="continue_button_text" class="form-label">Continue Button Text</label>
                            <input type="text" name="continue_button_text"
                                class="form-control @error('continue_button_text') is-invalid @enderror"
                                id="continue_button_text" value="{{ old('continue_button_text', 'Continue') }}" required>
                            @error('continue_button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Field -->
                        <div class="col-md-12">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status"
                                required>
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
                            <a href="{{ route('forgot-password-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection