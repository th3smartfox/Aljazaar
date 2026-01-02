@extends('layouts.vertical', ['title' => 'Wallet Details'])

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4"
            style="background-image: url('/images/svg/card-bg.svg'); background-position: right center; background-repeat: no-repeat; background-size: contain;">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Wallet Details - {{ $user->name }}</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('wallets.index') }}">Wallets</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
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

        <div class="row">
            <!-- User Info Card -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($user->profile_image)
                            <img src="{{ Storage::url($user->profile_image) }}" class="rounded-circle mb-3"
                                style="width: 100px; height: 100px; object-fit: cover;" alt="user">
                        @else
                            <div class="mx-auto mb-3"
                                style="width: 100px; height: 100px; background-color: #f3f7f9; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <span class="display-4 text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->phone_number }}</p>
                    </div>
                </div>

                <!-- Wallet Balance Card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Wallet Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small">Main Balance</label>
                            <h3 class="mb-0 text-success">${{ number_format($wallet->balance, 2) }}</h3>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">Reward Points</label>
                            <h4 class="mb-0 text-warning">{{ number_format($wallet->points, 2) }} pts</h4>
                        </div>
                        <div>
                            <label class="text-muted small">Last Updated</label>
                            <p class="mb-0">{{ $wallet->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                        <hr>
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                            data-bs-target="#adjustBalanceModal">
                            <i data-feather="dollar-sign" class="icon-sm me-1"></i>
                            Adjust Balance
                        </button>
                    </div>
                </div>
            </div>

            <!-- Transactions Card -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Transaction History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="transactionsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($wallet->transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->id }}</td>
                                            <td>
                                                @if($transaction->type === 'top_up')
                                                    <span class="badge bg-success">Top Up</span>
                                                @elseif($transaction->type === 'withdrawal')
                                                    <span class="badge bg-danger">Withdrawal</span>
                                                @elseif($transaction->type === 'transfer_in')
                                                    <span class="badge bg-info">Transfer In</span>
                                                @elseif($transaction->type === 'transfer_out')
                                                    <span class="badge bg-warning">Transfer Out</span>
                                                @elseif($transaction->type === 'order_payment')
                                                    <span class="badge bg-primary">Order Payment</span>
                                                @elseif($transaction->type === 'refund')
                                                    <span class="badge bg-success">Refund</span>
                                                @endif
                                            </td>
                                            <td>{{ $transaction->description }}</td>
                                            <td>
                                                @if(in_array($transaction->type, ['top_up', 'transfer_in', 'refund']))
                                                    <span class="text-success fw-bold">+${{ number_format($transaction->amount, 2) }}</span>
                                                @else
                                                    <span class="text-danger fw-bold">-${{ number_format($transaction->amount, 2) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($transaction->status === 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($transaction->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($transaction->status === 'failed')
                                                    <span class="badge bg-danger">Failed</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $transaction->created_at->format('M d, Y H:i') }}<br>
                                                <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No transactions found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Adjust Balance Modal -->
    <div class="modal fade" id="adjustBalanceModal" tabindex="-1" aria-labelledby="adjustBalanceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adjustBalanceModalLabel">
                        Adjust Balance - {{ $user->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('wallets.adjust', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Current Balance</label>
                            <input type="text" class="form-control" value="${{ number_format($wallet->balance, 2) }}"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0.01" class="form-control" id="amount"
                                name="amount" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="add">Add Funds</option>
                                <option value="deduct">Deduct Funds</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
