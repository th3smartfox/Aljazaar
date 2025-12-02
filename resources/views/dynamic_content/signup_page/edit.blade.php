@extends('layouts.vertical', ['title' => 'Edit Signup Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Signup Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('signup-pages.index') }}">Signup Page</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Edit Signup Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('signup-pages.update', $signupPage->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', $signupPage->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sub Title Field -->
                        <div class="col-md-6">
                            <label for="sub_title" class="form-label">Sub Title</label>
                            <input type="text" name="sub_title" class="form-control @error('sub_title') is-invalid @enderror"
                                id="sub_title" value="{{ old('sub_title', $signupPage->sub_title) }}" required>
                            @error('sub_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Full Name Label -->
                        <div class="col-md-6">
                            <label for="full_name_label" class="form-label">Full Name Label</label>
                            <input type="text" name="full_name_label" class="form-control @error('full_name_label') is-invalid @enderror"
                                id="full_name_label" value="{{ old('full_name_label', $signupPage->full_name_label) }}" required>
                            @error('full_name_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Full Name Hint -->
                        <div class="col-md-6">
                            <label for="full_name_hint" class="form-label">Full Name Hint</label>
                            <input type="text" name="full_name_hint" class="form-control @error('full_name_hint') is-invalid @enderror"
                                id="full_name_hint" value="{{ old('full_name_hint', $signupPage->full_name_hint) }}">
                            @error('full_name_hint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number Label -->
                        <div class="col-md-6">
                            <label for="phone_number_label" class="form-label">Phone Number Label</label>
                            <input type="text" name="phone_number_label" class="form-control @error('phone_number_label') is-invalid @enderror"
                                id="phone_number_label" value="{{ old('phone_number_label', $signupPage->phone_number_label) }}" required>
                            @error('phone_number_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number Hint -->
                        <div class="col-md-6">
                            <label for="phone_number_hint" class="form-label">Phone Number Hint</label>
                            <input type="text" name="phone_number_hint" class="form-control @error('phone_number_hint') is-invalid @enderror"
                                id="phone_number_hint" value="{{ old('phone_number_hint', $signupPage->phone_number_hint) }}">
                            @error('phone_number_hint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Label -->
                        <div class="col-md-6">
                            <label for="password_label" class="form-label">Password Label</label>
                            <input type="text" name="password_label" class="form-control @error('password_label') is-invalid @enderror"
                                id="password_label" value="{{ old('password_label', $signupPage->password_label) }}" required>
                            @error('password_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Hint -->
                        <div class="col-md-6">
                            <label for="password_hint" class="form-label">Password Hint</label>
                            <input type="text" name="password_hint" class="form-control @error('password_hint') is-invalid @enderror"
                                id="password_hint" value="{{ old('password_hint', $signupPage->password_hint) }}">
                            @error('password_hint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sign Up Button Text -->
                        <div class="col-md-6">
                            <label for="sign_up_button_text" class="form-label">Sign Up Button Text</label>
                            <input type="text" name="sign_up_button_text" class="form-control @error('sign_up_button_text') is-invalid @enderror"
                                id="sign_up_button_text" value="{{ old('sign_up_button_text', $signupPage->sign_up_button_text) }}" required>
                            @error('sign_up_button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Already Have Account Text -->
                        <div class="col-md-6">
                            <label for="already_have_account_text" class="form-label">"Already have an account?" Text</label>
                            <input type="text" name="already_have_account_text" class="form-control @error('already_have_account_text') is-invalid @enderror"
                                id="already_have_account_text" value="{{ old('already_have_account_text', $signupPage->already_have_account_text) }}" required>
                            @error('already_have_account_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Login Button Text -->
                        <div class="col-md-6">
                            <label for="login_button_text" class="form-label">Login Button Text</label>
                            <input type="text" name="login_button_text" class="form-control @error('login_button_text') is-invalid @enderror"
                                id="login_button_text" value="{{ old('login_button_text', $signupPage->login_button_text) }}" required>
                            @error('login_button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Field -->
                        <div class="col-md-12">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" required>
                                <option value="1" {{ old('status', $signupPage->status) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $signupPage->status) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('signup-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection
