@extends('layouts.vertical', ['title' => 'Edit Wallet Page Content'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Wallet Page</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('wallet-pages.index') }}">Wallet Page</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>

    <!-- Form Validation -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Edit Wallet Page Content</h5>
                </div><!-- end card header -->

                <div class="card-body">
                    <form class="row g-3" action="{{ route('wallet-pages.update', $walletPage->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="col-md-6">
                            <label for="text_hello" class="form-label">"Hello" Text</label>
                            <input type="text" name="text_hello" class="form-control @error('text_hello') is-invalid @enderror"
                                id="text_hello" value="{{ old('text_hello', $walletPage->text_hello) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="title_main_balance" class="form-label">"Main Balance" Title</label>
                            <input type="text" name="title_main_balance" class="form-control @error('title_main_balance') is-invalid @enderror"
                                id="title_main_balance" value="{{ old('title_main_balance', $walletPage->title_main_balance) }}" required>
                        </div>
                        
                        <hr class="my-2">
                        <h6 class="text-primary">Action Labels</h6>
                        
                        <div class="col-md-6">
                            <label for="label_withdraw" class="form-label">"Withdraw" Label</label>
                            <input type="text" name="label_withdraw" class="form-control @error('label_withdraw') is-invalid @enderror"
                                id="label_withdraw" value="{{ old('label_withdraw', $walletPage->label_withdraw) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="label_transfer" class="form-label">"Transfer" Label</label>
                            <input type="text" name="label_transfer" class="form-control @error('label_transfer') is-invalid @enderror"
                                id="label_transfer" value="{{ old('label_transfer', $walletPage->label_transfer) }}" required>
                        </div>

                        <hr class="my-2">
                        <h6 class="text-primary">Transactions Section</h6>

                        <div class="col-md-6">
                            <label for="title_latest_transactions" class="form-label">"Latest Transactions" Title</label>
                            <input type="text" name="title_latest_transactions" class="form-control @error('title_latest_transactions') is-invalid @enderror"
                                id="title_latest_transactions" value="{{ old('title_latest_transactions', $walletPage->title_latest_transactions) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="button_view_all" class="form-label">"View All" Button Text</label>
                            <input type="text" name="button_view_all" class="form-control @error('button_view_all') is-invalid @enderror"
                                id="button_view_all" value="{{ old('button_view_all', $walletPage->button_view_all) }}" required>
                        </div>
                        
                        <!-- Status Field -->
                        <div class="col-md-12 mt-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status" required>
                                <option value="1" {{ old('status', $walletPage->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $walletPage->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Update form</button>
                            <a href="{{ route('wallet-pages.index') }}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection