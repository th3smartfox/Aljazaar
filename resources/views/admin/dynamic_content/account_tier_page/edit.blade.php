@extends('layouts.vertical', ['title' => 'Edit Account Tier Page Content'])

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4"
            style="background-image: url('/images/svg/card-bg.svg'); background-position: right center; background-repeat: no-repeat; background-size: contain;">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Edit Account Tier Page Content</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('account-tier-pages.index') }}">Account Tier Page</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <i data-feather="edit" class="display-4 text-primary"
                                style="opacity: 0.5; transform: rotate(-15deg);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Page Content Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('account-tier-pages.update', $accountTierPage->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="app_bar_title" class="form-label">App Bar Title <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('app_bar_title') is-invalid @enderror"
                                id="app_bar_title" name="app_bar_title"
                                value="{{ old('app_bar_title', $accountTierPage->app_bar_title) }}" required>
                            @error('app_bar_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Title displayed in the app bar</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="button_text" class="form-label">Button Text <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('button_text') is-invalid @enderror"
                                id="button_text" name="button_text"
                                value="{{ old('button_text', $accountTierPage->button_text) }}" required>
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Text for subscription button</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="header_image" class="form-label">Header Image URL</label>
                            <input type="text" class="form-control @error('header_image') is-invalid @enderror"
                                id="header_image" name="header_image"
                                value="{{ old('header_image', $accountTierPage->header_image) }}"
                                placeholder="https://example.com/image.png">
                            @error('header_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">URL for the header image (optional)</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="subtitle" class="form-label">Subtitle</label>
                            <textarea class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle"
                                rows="2">{{ old('subtitle', $accountTierPage->subtitle) }}</textarea>
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Subtitle text displayed below the header</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="terms_text" class="form-label">Terms Text</label>
                            <textarea class="form-control @error('terms_text') is-invalid @enderror" id="terms_text" name="terms_text"
                                rows="3">{{ old('terms_text', $accountTierPage->terms_text) }}</textarea>
                            @error('terms_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">General terms text (optional)</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="terms_of_service_text" class="form-label">Terms of Service Text <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('terms_of_service_text') is-invalid @enderror" id="terms_of_service_text"
                                name="terms_of_service_text" rows="3" required>{{ old('terms_of_service_text', $accountTierPage->terms_of_service_text) }}</textarea>
                            @error('terms_of_service_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Terms of Service content</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="privacy_policy_text" class="form-label">Privacy Policy Text <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('privacy_policy_text') is-invalid @enderror" id="privacy_policy_text"
                                name="privacy_policy_text" rows="3" required>{{ old('privacy_policy_text', $accountTierPage->privacy_policy_text) }}</textarea>
                            @error('privacy_policy_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Privacy Policy content</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="renewal_notice" class="form-label">Renewal Notice</label>
                            <textarea class="form-control @error('renewal_notice') is-invalid @enderror" id="renewal_notice"
                                name="renewal_notice" rows="2">{{ old('renewal_notice', $accountTierPage->renewal_notice) }}</textarea>
                            @error('renewal_notice')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Notice about subscription renewal (optional)</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('account-tier-pages.index') }}" class="btn btn-secondary">
                            <i data-feather="x" class="icon-sm me-1"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="save" class="icon-sm me-1"></i>
                            Update Content
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
