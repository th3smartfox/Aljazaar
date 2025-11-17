@extends('layouts.vertical', ['title' => 'Create Card Details Page'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Card Details Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('card-details-pages.index') }}">Card Details Page</a></li>
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
                    <form class="row g-3" action="{{ route('card-details-pages.store') }}" method="POST">
                        @csrf
                        
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Bar Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', 'Card Details') }}" required>
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
                        <h6 class="text-primary">Page Content</h6>

                        <div class="col-md-6">
                            <label for="text_add_card" class="form-label">"Add Card" Text</label>
                            <input type="text" name="text_add_card" class="form-control @error('text_add_card') is-invalid @enderror"
                                id="text_add_card" value="{{ old('text_add_card', 'Add Credit/Debit Card') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="text_remember_card" class="form-label">"Remember Card" Text</label>
                            <input type="text" name="text_remember_card" class="form-control @error('text_remember_card') is-invalid @enderror"
                                id="text_remember_card" value="{{ old('text_remember_card', 'Remember my card for next purchases') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="hint_card_holder" class="form-label">"Card Holder" Hint</label>
                            <input type="text" name="hint_card_holder" class="form-control @error('hint_card_holder') is-invalid @enderror"
                                id="hint_card_holder" value="{{ old('hint_card_holder', "Card Holder's Name") }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="hint_card_number" class="form-label">"Card Number" Hint</label>
                            <input type="text" name="hint_card_number" class="form-control @error('hint_card_number') is-invalid @enderror"
                                id="hint_card_number" value="{{ old('hint_card_number', 'Card Number') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="hint_expiry_date" class="form-label">"Expiry Date" Hint</label>
                            <input type="text" name="hint_expiry_date" class="form-control @error('hint_expiry_date') is-invalid @enderror"
                                id="hint_expiry_date" value="{{ old('hint_expiry_date', 'Expiry Date') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="hint_cvc" class="form-label">"CVC" Hint</label>
                            <input type="text" name="hint_cvc" class="form-control @error('hint_cvc') is-invalid @enderror"
                                id="hint_cvc" value="{{ old('hint_cvc', 'CVC') }}" required>
                        </div>

                        <hr class="my-2">
                        <h6 class="text-primary">Payment Button</h6>

                        <div class="col-md-6">
                            <label for="text_total" class="form-label">"Total" Text</label>
                            <input type="text" name="text_total" class="form-control @error('text_total') is-invalid @enderror"
                                id="text_total" value="{{ old('text_total', 'Total') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="button_pay_now" class="form-label">"Pay Now" Button Text</label>
                            <input type="text" name="button_pay_now" class="form-control @error('button_pay_now') is-invalid @enderror"
                                id="button_pay_now" value="{{ old('button_pay_now', 'Pay Now') }}" required>
                        </div>


                        <!-- Submit Button -->
                        <div class="col-12 mt-3">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                            <a href="{{ route('card-details-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection