@extends('layouts.vertical', ['title' => 'Edit Add Address Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Add Address Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('add-address-pages.index') }}">Add Address Page</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Edit Add Address Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('add-address-pages.update', $addAddressPage->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Bar Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', $addAddressPage->title) }}" required>
                        </div>

                        <!-- Status Field -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" required>
                                <option value="1" {{ old('status', $addAddressPage->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $addAddressPage->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <hr class="my-2">
                        <h6 class="text-primary">Recipient Information</h6>
                        <div class="col-md-12">
                            <label for="text_recipient_info" class="form-label">Section Title ("Recipient Information")</label>
                            <input type="text" name="text_recipient_info" class="form-control @error('text_recipient_info') is-invalid @enderror"
                                id="text_recipient_info" value="{{ old('text_recipient_info', $addAddressPage->text_recipient_info) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="label_name" class="form-label">"Full Name" Label</label>
                            <input type="text" name="label_name" class="form-control @error('label_name') is-invalid @enderror"
                                id="label_name" value="{{ old('label_name', $addAddressPage->label_name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="label_phone" class="form-label">"Phone Number" Label</label>
                            <input type="text" name="label_phone" class="form-control @error('label_phone') is-invalid @enderror"
                                id="label_phone" value="{{ old('label_phone', $addAddressPage->label_phone) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="label_email" class="form-label">"Email Address" Label</label>
                            <input type="text" name="label_email" class="form-control @error('label_email') is-invalid @enderror"
                                id="label_email" value="{{ old('label_email', $addAddressPage->label_email) }}" required>
                        </div>

                        <hr class="my-2">
                        <h6 class="text-primary">Shipping Address</h6>
                        <div class="col-md-12">
                            <label for="text_shipping_address" class="form-label">Section Title ("Shipping Address")</label>
                            <input type="text" name="text_shipping_address" class="form-control @error('text_shipping_address') is-invalid @enderror"
                                id="text_shipping_address" value="{{ old('text_shipping_address', $addAddressPage->text_shipping_address) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="label_address_title" class="form-label">"Address Title" Label</label>
                            <input type="text" name="label_address_title" class="form-control @error('label_address_title') is-invalid @enderror"
                                id="label_address_title" value="{{ old('label_address_title', $addAddressPage->label_address_title) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="label_address_line" class="form-label">"Address" Label</label>
                            <input type="text" name="label_address_line" class="form-control @error('label_address_line') is-invalid @enderror"
                                id="label_address_line" value="{{ old('label_address_line', $addAddressPage->label_address_line) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="label_street_number" class="form-label">"Street Number" Label</label>
                            <input type="text" name="label_street_number" class="form-control @error('label_street_number') is-invalid @enderror"
                                id="label_street_number" value="{{ old('label_street_number', $addAddressPage->label_street_number) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="label_landmark" class="form-label">"Nearest Landmark" Label</label>
                            <input type="text" name="label_landmark" class="form-control @error('label_landmark') is-invalid @enderror"
                                id="label_landmark" value="{{ old('label_landmark', $addAddressPage->label_landmark) }}" required>
                        </div>
                        
                        <hr class="my-2">
                        <h6 class="text-primary">Buttons</h6>
                        <div class="col-md-6">
                            <label for="button_cancel" class="form-label">"Cancel" Button Text</label>
                            <input type="text" name="button_cancel" class="form-control @error('button_cancel') is-invalid @enderror"
                                id="button_cancel" value="{{ old('button_cancel', $addAddressPage->button_cancel) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="button_save" class="form-label">"Save" Button Text</label>
                            <input type="text" name="button_save" class="form-control @error('button_save') is-invalid @enderror"
                                id="button_save" value="{{ old('button_save', $addAddressPage->button_save) }}" required>
                        </div>


                        <!-- Submit Button -->
                        <div class="col-12 mt-3">
                            <button class="btn btn-primary" type="submit">Update form</button>
                            <a href="{{ route('add-address-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection