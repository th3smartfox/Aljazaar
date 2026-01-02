@extends('layouts.vertical', ['title' => 'Reward Details'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('rewards.index') }}">Rewards</a></li>
                            <li class="breadcrumb-item active">{{ $reward->code }}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Reward: {{ $reward->code }}</h4>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Reward Summary -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h3 class="mb-1">
                            @if($reward->discount_type === 'percentage')
                                {{ $reward->discount_value }}%
                            @else
                                ${{ number_format($reward->discount_value, 2) }}
                            @endif
                        </h3>
                        <p class="mb-0">Discount</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h3 class="mb-1">{{ $reward->user_rewards_count ?? 0 }}</h3>
                        <p class="mb-0">Assigned Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h3 class="mb-1">{{ $reward->redeemed_count ?? 0 }}</h3>
                        <p class="mb-0">Redeemed</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card {{ $reward->isExpired() ? 'bg-danger' : 'bg-warning' }} text-white">
                    <div class="card-body">
                        <h3 class="mb-1">{{ $reward->expiry_date->format('M d') }}</h3>
                        <p class="mb-0">{{ $reward->isExpired() ? 'Expired' : 'Expires' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Reward Details -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Details</h5>
                        <a href="{{ route('rewards.edit', $reward) }}" class="btn btn-sm btn-warning">
                            <i class="ri-pencil-line"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <th>Code:</th>
                                <td><code class="fs-5">{{ $reward->code }}</code></td>
                            </tr>
                            <tr>
                                <th>Type:</th>
                                <td>{{ ucfirst($reward->discount_type) }}</td>
                            </tr>
                            <tr>
                                <th>Value:</th>
                                <td>{{ $reward->formatted_discount }}</td>
                            </tr>
                            <tr>
                                <th>Min Order:</th>
                                <td>${{ number_format($reward->min_order_amount, 2) }}</td>
                            </tr>
                            @if($reward->max_discount)
                                <tr>
                                    <th>Max Discount:</th>
                                    <td>${{ number_format($reward->max_discount, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @if($reward->isExpired())
                                        <span class="badge bg-danger">Expired</span>
                                    @elseif($reward->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Expiry:</th>
                                <td>{{ $reward->expiry_date->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                        @if($reward->description)
                            <hr>
                            <p class="mb-0 text-muted">{{ $reward->description }}</p>
                        @endif
                    </div>
                </div>

                <!-- Assign Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Assign Reward</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('rewards.assign-form', $reward) }}" class="btn btn-primary w-100 mb-2">
                            <i class="ri-user-add-line me-1"></i> Assign to Users
                        </a>
                        <form action="{{ route('rewards.assign-all', $reward) }}" method="POST"
                            onsubmit="return confirm('Assign this reward to ALL users?');">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="ri-group-line me-1"></i> Assign to All Users
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Assigned Users -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Assigned Users ({{ $reward->user_rewards_count ?? 0 }})</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Assigned On</th>
                                        <th>Status</th>
                                        <th>Redeemed At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($userRewards as $userReward)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $userReward->user->name ?? 'N/A' }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $userReward->user->email ?? $userReward->user->phone_number ?? '' }}</small>
                                                </div>
                                            </td>
                                            <td>{{ $userReward->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @if($userReward->is_redeemed)
                                                    <span class="badge bg-success">Redeemed</span>
                                                @elseif($reward->isExpired())
                                                    <span class="badge bg-danger">Expired</span>
                                                @else
                                                    <span class="badge bg-warning">Available</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $userReward->redeemed_at ? $userReward->redeemed_at->format('M d, Y H:i') : '-' }}
                                            </td>
                                            <td>
                                                <form action="{{ route('rewards.remove-user', [$reward, $userReward->user]) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Remove this user from the reward?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Remove">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                No users assigned to this reward yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($userRewards->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $userRewards->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
