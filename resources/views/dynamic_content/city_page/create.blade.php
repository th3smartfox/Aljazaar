@extends('layouts.vertical', ['title' => 'Create City Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Select City Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('select-city-pages.index') }}">Select City Page</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Create New City Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('select-city-pages.store') }}" method="POST">
                        @csrf

                        <!-- Main Heading Field -->
                        <div class="col-md-6">
                            <label for="main_heading" class="form-label">Main Heading</label>
                            <input type="text" name="main_heading" class="form-control @error('main_heading') is-invalid @enderror"
                                id="main_heading" value="{{ old('main_heading', 'Select Your City') }}" required>
                            @error('main_heading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Button Text Field -->
                        <div class="col-md-6">
                            <label for="button_text" class="form-label">Button Text</label>
                            <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror"
                                id="button_text" value="{{ old('button_text', 'Next') }}" required>
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sub Heading Field -->
                        <div class="col-md-12">
                            <label for="sub_heading" class="form-label">Sub Heading</label>
                            <textarea name="sub_heading" class="form-control @error('sub_heading') is-invalid @enderror"
                                id="sub_heading" rows="3">{{ old('sub_heading', 'Choose your city to start exploring nearby restaurants and cuisines.') }}</textarea>
                            @error('sub_heading')
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
                            <a href="{{ route('select-city-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection