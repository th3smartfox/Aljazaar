@extends('layouts.vertical', ['title' => 'Edit Signin Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Signin Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('signin-pages.index') }}">Signin Page</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Edit Signin Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('signin-pages.update', $signinPage->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', $signinPage->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sub Title Field -->
                        <div class="col-md-6">
                            <label for="sub_title" class="form-label">Sub Title</label>
                            <input type="text" name="sub_title"
                                class="form-control @error('sub_title') is-invalid @enderror" id="sub_title"
                                value="{{ old('sub_title', $signinPage->sub_title) }}" required>
                            @error('sub_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email or Phone Number Label -->
                        <div class="col-md-6">
                            <label for="email_or_phone_label" class="form-label">Email or Phone Number Label</label>
                            <input type="text" name="email_or_phone_label"
                                class="form-control @error('email_or_phone_label') is-invalid @enderror"
                                id="email_or_phone_label"
                                value="{{ old('email_or_phone_label', $signinPage->email_or_phone_label) }}" required>
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
                                value="{{ old('email_or_phone_hint', $signinPage->email_or_phone_hint) }}" required>
                            @error('email_or_phone_hint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Label -->
                        <div class="col-md-6">
                            <label for="password_label" class="form-label">Password Label</label>
                            <input type="text" name="password_label"
                                class="form-control @error('password_label') is-invalid @enderror" id="password_label"
                                value="{{ old('password_label', $signinPage->password_label) }}" required>
                            @error('password_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Hint -->
                        <div class="col-md-6">
                            <label for="password_hint" class="form-label">Password Hint</label>
                            <input type="text" name="password_hint"
                                class="form-control @error('password_hint') is-invalid @enderror" id="password_hint"
                                value="{{ old('password_hint', $signinPage->password_hint) }}" required>
                            @error('password_hint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Forgot Password Text -->
                        <div class="col-md-6">
                            <label for="forgot_password_text" class="form-label">Forgot Password Text</label>
                            <input type="text" name="forgot_password_text"
                                class="form-control @error('forgot_password_text') is-invalid @enderror"
                                id="forgot_password_text"
                                value="{{ old('forgot_password_text', $signinPage->forgot_password_text) }}" required>
                            @error('forgot_password_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Login Button Text -->
                        <div class="col-md-6">
                            <label for="login_button_text" class="form-label">Login Button Text</label>
                            <input type="text" name="login_button_text"
                                class="form-control @error('login_button_text') is-invalid @enderror" id="login_button_text"
                                value="{{ old('login_button_text', $signinPage->login_button_text) }}" required>
                            @error('login_button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Don't have an account Text -->
                        <div class="col-md-6">
                            <label for="dont_have_account_text" class="form-label">"Don't have an account?" Text</label>
                            <input type="text" name="dont_have_account_text"
                                class="form-control @error('dont_have_account_text') is-invalid @enderror"
                                id="dont_have_account_text"
                                value="{{ old('dont_have_account_text', $signinPage->dont_have_account_text) }}" required>
                            @error('dont_have_account_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sign Up Text -->
                        <div class="col-md-6">
                            <label for="sign_up_text" class="form-label">Sign Up Text</label>
                            <input type="text" name="sign_up_text"
                                class="form-control @error('sign_up_text') is-invalid @enderror" id="sign_up_text"
                                value="{{ old('sign_up_text', $signinPage->sign_up_text) }}" required>
                            @error('sign_up_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Field -->
                        <div class="col-md-12">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status"
                                required>
                                <option value="1" {{ old('status', $signinPage->status) == '1' ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ old('status', $signinPage->status) == '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('signin-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection