@extends('layouts.vertical', ['title' => 'Rewards Management'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Rewards</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Rewards Management</h4>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">All Rewards</h5>
                        <a href="{{ route('rewards.create') }}" class="btn btn-primary">
                            <i class="ri-add-line me-1"></i> Create Reward
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" class="row g-3 mb-4">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search by code or description..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="discount_type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="percentage" {{ request('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    <option value="fixed" {{ request('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ri-search-line me-1"></i> Filter
                                </button>
                            </div>
                            @if(request()->hasAny(['search', 'status', 'discount_type']))
                                <div class="col-md-2">
                                    <a href="{{ route('rewards.index') }}" class="btn btn-outline-secondary w-100">
                                        <i class="ri-refresh-line me-1"></i> Clear
                                    </a>
                                </div>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Discount</th>
                                        <th>Min Order</th>
                                        <th>Expiry</th>
                                        <th>Assigned</th>
                                        <th>Redeemed</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rewards as $reward)
                                        <tr>
                                            <td>
                                                <strong class="font-monospace">{{ $reward->code }}</strong>
                                                @if($reward->description)
                                                    <br><small class="text-muted">{{ Str::limit($reward->description, 40) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($reward->discount_type === 'percentage')
                                                    <span class="badge bg-info">{{ $reward->discount_value }}%</span>
                                                    @if($reward->max_discount)
                                                        <br><small class="text-muted">Max: ${{ number_format($reward->max_discount, 2) }}</small>
                                                    @endif
                                                @else
                                                    <span class="badge bg-success">${{ number_format($reward->discount_value, 2) }}</span>
                                                @endif
                                            </td>
                                            <td>${{ number_format($reward->min_order_amount, 2) }}</td>
                                            <td>
                                                <span class="{{ $reward->isExpired() ? 'text-danger' : '' }}">
                                                    {{ $reward->expiry_date->format('M d, Y') }}
                                                    @if($reward->isExpired())
                                                        <br><small class="text-danger">(Expired)</small>
                                                    @endif
                                                </span>
                                            </td>
                                            <td>{{ $reward->user_rewards_count ?? 0 }}</td>
                                            <td>{{ $reward->redeemed_count ?? 0 }}</td>
                                            <td>
                                                @if($reward->isExpired())
                                                    <span class="badge bg-danger">Expired</span>
                                                @elseif($reward->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('rewards.show', $reward) }}" class="btn btn-info" title="View">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                    <a href="{{ route('rewards.edit', $reward) }}" class="btn btn-warning" title="Edit">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                    <form action="{{ route('rewards.destroy', $reward) }}" method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this reward?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Delete">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No rewards found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($rewards->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $rewards->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
