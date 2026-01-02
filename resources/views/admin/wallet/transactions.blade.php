@extends('layouts.vertical', ['title' => 'Wallet Transactions'])

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary-subtle shadow-none position-relative overflow-hidden mb-4"
            style="background-image: url('/images/svg/card-bg.svg'); background-position: right center; background-repeat: no-repeat; background-size: contain;">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-1">Wallet Transactions</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted"
                                        href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Wallet Transactions</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <i data-feather="activity" class="display-4 text-primary"
                                style="opacity: 0.5; transform: rotate(-15deg);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">All Wallet Transactions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $transaction->wallet->user->name }}</strong><br>
                                                <small
                                                    class="text-muted">{{ $transaction->wallet->user->phone_number }}</small>
                                            </div>
                                        </div>
                                    </td>
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
                                    <td colspan="7" class="text-center text-muted py-4">No transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->hasPages())
                    <div class="mt-3">
                        {{ $transactions->links() }}
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
