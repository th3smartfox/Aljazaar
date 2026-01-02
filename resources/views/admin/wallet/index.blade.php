@extends('layouts.vertical', ['title' => 'User Wallets'])

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4"
            style="background-image: url('/images/svg/card-bg.svg'); background-position: right center; background-repeat: no-repeat; background-size: contain;">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">User Wallets</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Wallets</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <i data-feather="credit-card" class="display-4 text-primary"
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
                <h5 class="mb-0">All User Wallets</h5>
                <a href="{{ route('wallet-transactions.index') }}" class="btn btn-primary">
                    <i data-feather="list" class="icon-sm me-1"></i>
                    View All Transactions
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="walletsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Balance</th>
                                <th>Points</th>
                                <th>Total Transactions</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wallets as $wallet)
                                <tr>
                                    <td>{{ $wallet->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $wallet->user->name }}</strong><br>
                                                <small class="text-muted">{{ $wallet->user->phone_number }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-success">${{ number_format($wallet->balance, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">{{ number_format($wallet->points, 2) }} pts</span>
                                    </td>
                                    <td>{{ $wallet->transactions->count() }}</td>
                                    <td>{{ $wallet->updated_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('wallets.show', $wallet->user_id) }}"
                                                class="btn btn-sm btn-info" title="View Details">
                                                <i data-feather="eye" class="icon-sm"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#adjustBalanceModal{{ $wallet->id }}" title="Adjust Balance">
                                                <i data-feather="dollar-sign" class="icon-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Adjust Balance Modal -->
                                <div class="modal fade" id="adjustBalanceModal{{ $wallet->id }}" tabindex="-1"
                                    aria-labelledby="adjustBalanceModalLabel{{ $wallet->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="adjustBalanceModalLabel{{ $wallet->id }}">
                                                    Adjust Balance - {{ $wallet->user->name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('wallets.adjust', $wallet->user_id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Balance</label>
                                                        <input type="text" class="form-control"
                                                            value="${{ number_format($wallet->balance, 2) }}" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="amount{{ $wallet->id }}" class="form-label">Amount
                                                            <span class="text-danger">*</span></label>
                                                        <input type="number" step="0.01" min="0.01" class="form-control"
                                                            id="amount{{ $wallet->id }}" name="amount" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="type{{ $wallet->id }}" class="form-label">Type <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-select" id="type{{ $wallet->id }}"
                                                            name="type" required>
                                                            <option value="add">Add Funds</option>
                                                            <option value="deduct">Deduct Funds</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description{{ $wallet->id }}"
                                                            class="form-label">Description <span
                                                                class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="description{{ $wallet->id }}" name="description" rows="2"
                                                            required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No wallets found.</td>
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
