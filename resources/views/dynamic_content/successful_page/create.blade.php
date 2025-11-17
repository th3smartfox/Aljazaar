@extends('layouts.vertical', ['title' => 'Create Successful Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Successful Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('successful-pages.index') }}">Successful Page</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Create New Successful Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('successful-pages.store') }}" method="POST">
                        @csrf

                        <!-- Main Heading -->
                        <div class="col-md-12">
                            <label for="main_heading" class="form-label">Main Heading</label>
                            <input type="text" name="main_heading" class="form-control @error('main_heading') is-invalid @enderror"
                                id="main_heading" value="{{ old('main_heading', 'Thank You! Order Completed') }}" required>
                            @error('main_heading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sub Heading -->
                        <div class="col-md-12">
                            <label for="sub_heading" class="form-label">Sub Heading</label>
                            <textarea name="sub_heading" class="form-control @error('sub_heading') is-invalid @enderror"
                                id="sub_heading" rows="2">{{ old('sub_heading', 'Please rate your experience with Royal Butcher') }}</textarea>
                            @error('sub_heading')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <a href="{{ route('successful-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection