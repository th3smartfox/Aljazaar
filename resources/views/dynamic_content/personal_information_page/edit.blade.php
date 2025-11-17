@extends('layouts.vertical', ['title' => 'Edit Personal Info Page'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Personal Information Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('personal-information-pages.index') }}">Personal Information Page</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Edit Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('personal-information-pages.update', $personalInformationPage->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Bar Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', $personalInformationPage->title) }}" required>
                        </div>

                        <!-- Status Field -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" required>
                                <option value="1" {{ old('status', $personalInformationPage->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $personalInformationPage->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <hr class="my-2">
                        <h6 class="text-primary">Labels</h6>
                        
                        <div class="col-md-4">
                            <label for="label_name" class="form-label">"Full Name" Label</label>
                            <input type="text" name="label_name" class="form-control @error('label_name') is-invalid @enderror"
                                id="label_name" value="{{ old('label_name', $personalInformationPage->label_name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="label_email" class="form-label">"Email Address" Label</label>
                            <input type="text" name="label_email" class="form-control @error('label_email') is-invalid @enderror"
                                id="label_email" value="{{ old('label_email', $personalInformationPage->label_email) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="label_phone" class="form-label">"Phone Number" Label</label>
                            <input type="text" name="label_phone" class="form-control @error('label_phone') is-invalid @enderror"
                                id="label_phone" value="{{ old('label_phone', $personalInformationPage->label_phone) }}" required>
                        </div>

                        <hr class="my-2">
                        <h6 class="text-primary">Buttons</h6>
                        <div class="col-md-6">
                            <label for="button_cancel" class="form-label">"Cancel" Button Text</label>
                            <input type="text" name="button_cancel" class="form-control @error('button_cancel') is-invalid @enderror"
                                id="button_cancel" value="{{ old('button_cancel', $personalInformationPage->button_cancel) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="button_save" class="form-label">"Save" Button Text</label>
                            <input type="text" name="button_save" class="form-control @error('button_save') is-invalid @enderror"
                                id="button_save" value="{{ old('button_save', $personalInformationPage->button_save) }}" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-3">
                            <button class="btn btn-primary" type="submit">Update form</button>
                            <a href="{{ route('personal-information-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection