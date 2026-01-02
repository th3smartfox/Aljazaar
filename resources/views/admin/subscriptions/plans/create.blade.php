@extends('layouts.vertical', ['title' => 'Create Subscription Plan'])

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4"
            style="background-image: url('/images/svg/card-bg.svg'); background-position: right center; background-repeat: no-repeat; background-size: contain;">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Create Subscription Plan</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('subscription-plans.index') }}">Subscription Plans</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Create</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <i data-feather="plus-circle" class="display-4 text-primary"
                                style="opacity: 0.5; transform: rotate(-15deg);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Plan Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('subscription-plans.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Plan Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0"
                                class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="discount_per_order" class="form-label">Discount Per Order <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('discount_per_order') is-invalid @enderror"
                                id="discount_per_order" name="discount_per_order" value="{{ old('discount_per_order') }}"
                                placeholder="e.g., 10%, $5" required>
                            @error('discount_per_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="duration_days" class="form-label">Duration (Days) <span
                                    class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control @error('duration_days') is-invalid @enderror"
                                id="duration_days" name="duration_days" value="{{ old('duration_days') }}" required>
                            @error('duration_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="trial_days" class="form-label">Trial Days <span
                                    class="text-danger">*</span></label>
                            <input type="number" min="0" class="form-control @error('trial_days') is-invalid @enderror"
                                id="trial_days" name="trial_days" value="{{ old('trial_days', 0) }}" required>
                            @error('trial_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="badge" class="form-label">Badge</label>
                            <input type="text" class="form-control @error('badge') is-invalid @enderror" id="badge"
                                name="badge" value="{{ old('badge') }}" placeholder="e.g., Popular, Best Value">
                            @error('badge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Optional badge to display on the plan</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label d-block">Options</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="is_recommended" name="is_recommended"
                                    value="1" {{ old('is_recommended') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_recommended">
                                    Recommended Plan
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('subscription-plans.index') }}" class="btn btn-secondary">
                            <i data-feather="x" class="icon-sm me-1"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="save" class="icon-sm me-1"></i>
                            Create Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Initialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        </script>
    @endpush
@endsection
