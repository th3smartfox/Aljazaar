@extends('layouts.vertical', ['title' => 'Edit Redeem Rewards Page Content'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('redeem-rewards-pages.index') }}">Redeem Rewards Page</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Redeem Rewards Page Content</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('redeem-rewards-pages.update', $redeemRewardsPage) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="app_bar_title" class="form-label">App Bar Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('app_bar_title') is-invalid @enderror"
                                    id="app_bar_title" name="app_bar_title" value="{{ old('app_bar_title', $redeemRewardsPage->app_bar_title) }}" required>
                                @error('app_bar_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="empty_title" class="form-label">Empty State Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('empty_title') is-invalid @enderror"
                                        id="empty_title" name="empty_title" value="{{ old('empty_title', $redeemRewardsPage->empty_title) }}" required>
                                    @error('empty_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="empty_subtitle" class="form-label">Empty State Subtitle <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('empty_subtitle') is-invalid @enderror"
                                        id="empty_subtitle" name="empty_subtitle" value="{{ old('empty_subtitle', $redeemRewardsPage->empty_subtitle) }}" required>
                                    @error('empty_subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="copy_button_text" class="form-label">Copy Button Text <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('copy_button_text') is-invalid @enderror"
                                        id="copy_button_text" name="copy_button_text" value="{{ old('copy_button_text', $redeemRewardsPage->copy_button_text) }}" required>
                                    @error('copy_button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="copied_message" class="form-label">Copied Message <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('copied_message') is-invalid @enderror"
                                        id="copied_message" name="copied_message" value="{{ old('copied_message', $redeemRewardsPage->copied_message) }}" required>
                                    @error('copied_message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="min_order_label" class="form-label">Min Order Label <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('min_order_label') is-invalid @enderror"
                                        id="min_order_label" name="min_order_label" value="{{ old('min_order_label', $redeemRewardsPage->min_order_label) }}" required>
                                    @error('min_order_label')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="max_discount_label" class="form-label">Max Discount Label <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('max_discount_label') is-invalid @enderror"
                                        id="max_discount_label" name="max_discount_label" value="{{ old('max_discount_label', $redeemRewardsPage->max_discount_label) }}" required>
                                    @error('max_discount_label')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="expired_label" class="form-label">Expired Label <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('expired_label') is-invalid @enderror"
                                        id="expired_label" name="expired_label" value="{{ old('expired_label', $redeemRewardsPage->expired_label) }}" required>
                                    @error('expired_label')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="redeemed_label" class="form-label">Redeemed Label <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('redeemed_label') is-invalid @enderror"
                                        id="redeemed_label" name="redeemed_label" value="{{ old('redeemed_label', $redeemRewardsPage->redeemed_label) }}" required>
                                    @error('redeemed_label')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="status" name="status"
                                        {{ old('status', $redeemRewardsPage->status) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">
                                        Active
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line me-1"></i> Update
                                </button>
                                <a href="{{ route('redeem-rewards-pages.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
