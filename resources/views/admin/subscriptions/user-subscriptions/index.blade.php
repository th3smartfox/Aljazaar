@extends('layouts.vertical', ['title' => 'User Subscriptions'])

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4"
            style="background-image: url('/images/svg/card-bg.svg'); background-position: right center; background-repeat: no-repeat; background-size: contain;">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">User Subscriptions</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">User Subscriptions</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <i data-feather="users" class="display-4 text-primary"
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
            <div class="card-header">
                <h5 class="mb-0">All User Subscriptions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="subscriptionsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Plan</th>
                                <th>Status</th>
                                <th>Trial</th>
                                <th>Started</th>
                                <th>Expires</th>
                                <th>Auto-Renew</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $subscription->user->name }}</strong><br>
                                                <small class="text-muted">{{ $subscription->user->phone_number }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $subscription->plan->name }}</strong><br>
                                        <small class="text-muted">${{ number_format($subscription->plan->price, 2) }}</small>
                                    </td>
                                    <td>
                                        @if($subscription->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($subscription->status === 'trial')
                                            <span class="badge bg-info">Trial</span>
                                        @elseif($subscription->status === 'expired')
                                            <span class="badge bg-danger">Expired</span>
                                        @elseif($subscription->status === 'cancelled')
                                            <span class="badge bg-secondary">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($subscription->is_on_trial)
                                            <span class="badge bg-warning">On Trial</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $subscription->start_date?->format('M d, Y') ?? '-' }}</td>
                                    <td>
                                        @if($subscription->end_date)
                                            {{ $subscription->end_date->format('M d, Y') }}
                                            @if($subscription->end_date->isFuture())
                                                <br><small
                                                    class="text-muted">{{ $subscription->end_date->diffForHumans() }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($subscription->auto_renew)
                                            <span class="badge bg-primary">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($subscription->status === 'active' || $subscription->status === 'trial')
                                            <form action="{{ route('user-subscriptions.cancel', $subscription->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to cancel this subscription?');">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Cancel">
                                                    <i data-feather="x-circle" class="icon-sm"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No user subscriptions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
