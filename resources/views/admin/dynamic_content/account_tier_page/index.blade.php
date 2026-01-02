@extends('layouts.vertical', ['title' => 'Account Tier Page Content'])

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4"
            style="background-image: url('/images/svg/card-bg.svg'); background-position: right center; background-repeat: no-repeat; background-size: contain;">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Account Tier Page Content</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">Dynamic Content</li>
                                <li class="breadcrumb-item active" aria-current="page">Account Tier Page</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <i data-feather="file-text" class="display-4 text-primary"
                                style="opacity: 0.5; transform: rotate(-15deg);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Account Tier Page Content</h5>
                @if($pages->isEmpty())
                    <a href="{{ route('account-tier-pages.create') }}" class="btn btn-primary">
                        <i data-feather="plus" class="icon-sm me-1"></i>
                        Add Content
                    </a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="pagesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>App Bar Title</th>
                                <th>Button Text</th>
                                <th>Subtitle</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                                <tr>
                                    <td>{{ $page->id }}</td>
                                    <td><strong>{{ $page->app_bar_title }}</strong></td>
                                    <td>{{ $page->button_text }}</td>
                                    <td>{{ Str::limit($page->subtitle, 50) ?? '-' }}</td>
                                    <td>{{ $page->updated_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('account-tier-pages.edit', $page->id) }}"
                                                class="btn btn-sm btn-primary" title="Edit">
                                                <i data-feather="edit" class="icon-sm"></i>
                                            </a>
                                            <form action="{{ route('account-tier-pages.destroy', $page->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this content?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i data-feather="trash-2" class="icon-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No content found. Click "Add Content" to create the first entry.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pages->isNotEmpty())
                    <div class="alert alert-info mt-3" role="alert">
                        <i data-feather="info" class="icon-sm me-2"></i>
                        <strong>Note:</strong> This content is displayed on the Account Tier subscription page in the mobile
                        app.
                    </div>
                @endif
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
