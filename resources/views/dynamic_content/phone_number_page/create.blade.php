@extends('layouts.vertical', ['title' => 'Create Phone Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Phone Number Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('phone-number-pages.index') }}">Phone Number Page</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Create New Phone Number Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('phone-number-pages.store') }}" method="POST">
                        @csrf

                        <!-- Main Heading 1 Field -->
                        <div class="col-md-6">
                            <label for="main_heading1" class="form-label">Main Heading 1</label>
                            <input type="text" name="main_heading1" class="form-control @error('main_heading1') is-invalid @enderror"
                                id="main_heading1" value="{{ old('main_heading1', 'Get started with') }}" required>
                            @error('main_heading1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Main Heading 2 Field -->
                        <div class="col-md-6">
                            <label for="main_heading2" class="form-label">Main Heading 2</label>
                            <input type="text" name="main_heading2" class="form-control @error('main_heading2') is-invalid @enderror"
                                id="main_heading2" value="{{ old('main_heading2', 'Royal Butcher') }}" required>
                            @error('main_heading2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sub Heading Field -->
                        <div class="col-md-12">
                            <label for="sub_heading" class="form-label">Sub Heading</label>
                            <textarea name="sub_heading" class="form-control @error('sub_heading') is-invalid @enderror"
                                id="sub_heading" rows="2">{{ old('sub_heading', 'Enter your phone number to use Royal Butcher and enjoy!') }}</textarea>
                            @error('sub_heading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Hint Field -->
                        <div class="col-md-4">
                            <label for="hint" class="form-label">Hint Text</label>
                            <input type="text" name="hint" class="form-control @error('hint') is-invalid @enderror"
                                id="hint" value="{{ old('hint', 'Phone Number') }}" required>
                            @error('hint')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Placeholder Field -->
                        <div class="col-md-4">
                            <label for="placeholder" class="form-label">Placeholder Text</label>
                            <input type="text" name="placeholder" class="form-control @error('placeholder') is-invalid @enderror"
                                id="placeholder" value="{{ old('placeholder', '+44 999999999') }}" required>
                            @error('placeholder')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Button Text Field -->
                        <div class="col-md-4">
                            <label for="button_text" class="form-label">Button Text</label>
                            <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror"
                                id="button_text" value="{{ old('button_text', 'Continue') }}" required>
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Field -->
                        <div class="col-md-12">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" required>
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
                            <a href="{{ route('phone-number-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection