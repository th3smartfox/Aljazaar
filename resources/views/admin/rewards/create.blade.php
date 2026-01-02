@extends('layouts.vertical', ['title' => 'Create Reward'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('rewards.index') }}">Rewards</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Create Reward</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('rewards.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="code" class="form-label">Reward Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-uppercase @error('code') is-invalid @enderror"
                                        id="code" name="code" value="{{ old('code') }}" required
                                        placeholder="e.g., SAVE10, FLAT20">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Uppercase alphanumeric code</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="discount_type" class="form-label">Discount Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('discount_type') is-invalid @enderror"
                                        id="discount_type" name="discount_type" required>
                                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                    </select>
                                    @error('discount_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="discount_value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="discount-prefix">%</span>
                                        <input type="number" step="0.01" min="0"
                                            class="form-control @error('discount_value') is-invalid @enderror"
                                            id="discount_value" name="discount_value" value="{{ old('discount_value') }}" required>
                                        @error('discount_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="min_order_amount" class="form-label">Min Order Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0"
                                            class="form-control @error('min_order_amount') is-invalid @enderror"
                                            id="min_order_amount" name="min_order_amount" value="{{ old('min_order_amount', 0) }}">
                                        @error('min_order_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4" id="max-discount-group">
                                    <label for="max_discount" class="form-label">Max Discount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0"
                                            class="form-control @error('max_discount') is-invalid @enderror"
                                            id="max_discount" name="max_discount" value="{{ old('max_discount') }}">
                                        @error('max_discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">For percentage discounts</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description" rows="3"
                                    placeholder="e.g., Get 10% off on orders above $50">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('expiry_date') is-invalid @enderror"
                                        id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}" required>
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line me-1"></i> Create Reward
                                </button>
                                <a href="{{ route('rewards.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tips</h5>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li class="mb-2"><strong>Code:</strong> Use memorable uppercase codes like SAVE10, WELCOME20, FLAT50</li>
                            <li class="mb-2"><strong>Percentage:</strong> Apply % discount up to max_discount cap</li>
                            <li class="mb-2"><strong>Fixed:</strong> Apply fixed dollar amount off</li>
                            <li class="mb-2"><strong>Min Order:</strong> Minimum cart value required to use this reward</li>
                            <li><strong>Max Discount:</strong> Cap for percentage discounts (e.g., 10% off up to $20)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const discountType = document.getElementById('discount_type');
            const discountPrefix = document.getElementById('discount-prefix');
            const maxDiscountGroup = document.getElementById('max-discount-group');

            function updateDiscountUI() {
                if (discountType.value === 'percentage') {
                    discountPrefix.textContent = '%';
                    maxDiscountGroup.style.display = 'block';
                } else {
                    discountPrefix.textContent = '$';
                    maxDiscountGroup.style.display = 'none';
                }
            }

            discountType.addEventListener('change', updateDiscountUI);
            updateDiscountUI();
        });
    </script>
@endsection
