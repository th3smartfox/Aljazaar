@extends('layouts.vertical', ['title' => 'Edit Reward'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('rewards.index') }}">Rewards</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Reward: {{ $reward->code }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('rewards.update', $reward) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="code" class="form-label">Reward Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-uppercase @error('code') is-invalid @enderror"
                                        id="code" name="code" value="{{ old('code', $reward->code) }}" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="discount_type" class="form-label">Discount Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('discount_type') is-invalid @enderror"
                                        id="discount_type" name="discount_type" required>
                                        <option value="percentage" {{ old('discount_type', $reward->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                        <option value="fixed" {{ old('discount_type', $reward->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
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
                                            id="discount_value" name="discount_value"
                                            value="{{ old('discount_value', $reward->discount_value) }}" required>
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
                                            id="min_order_amount" name="min_order_amount"
                                            value="{{ old('min_order_amount', $reward->min_order_amount) }}">
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
                                            id="max_discount" name="max_discount"
                                            value="{{ old('max_discount', $reward->max_discount) }}">
                                        @error('max_discount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description" rows="3">{{ old('description', $reward->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('expiry_date') is-invalid @enderror"
                                        id="expiry_date" name="expiry_date"
                                        value="{{ old('expiry_date', $reward->expiry_date->format('Y-m-d\TH:i')) }}" required>
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            {{ old('is_active', $reward->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line me-1"></i> Update Reward
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
                        <h5 class="mb-0">Reward Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Created:</span>
                            <strong>{{ $reward->created_at->format('M d, Y') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Status:</span>
                            @if($reward->isExpired())
                                <span class="badge bg-danger">Expired</span>
                            @elseif($reward->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                        <hr>
                        <a href="{{ route('rewards.show', $reward) }}" class="btn btn-outline-primary w-100">
                            <i class="ri-eye-line me-1"></i> View Assigned Users
                        </a>
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
