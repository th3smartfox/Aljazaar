@extends('layouts.vertical', ['title' => 'Assign Reward'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('rewards.index') }}">Rewards</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('rewards.show', $reward) }}">{{ $reward->code }}</a></li>
                            <li class="breadcrumb-item active">Assign</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Assign Reward: {{ $reward->code }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Select Users</h5>
                    </div>
                    <div class="card-body">
                        @if($users->isEmpty())
                            <div class="text-center py-4">
                                <i class="ri-checkbox-circle-line fs-1 text-success mb-3"></i>
                                <h5>All Users Assigned</h5>
                                <p class="text-muted">This reward has already been assigned to all users.</p>
                                <a href="{{ route('rewards.show', $reward) }}" class="btn btn-primary">
                                    <i class="ri-arrow-left-line me-1"></i> Back to Reward
                                </a>
                            </div>
                        @else
                            <form action="{{ route('rewards.assign', $reward) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <input type="text" class="form-control" id="searchUsers"
                                        placeholder="Search users by name or email...">
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                        <label class="form-check-label fw-bold" for="selectAll">
                                            Select All ({{ $users->count() }} users)
                                        </label>
                                    </div>
                                </div>

                                <div class="border rounded p-3" style="max-height: 400px; overflow-y: auto;" id="userList">
                                    @foreach($users as $user)
                                        <div class="form-check mb-2 user-item" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email ?? '') }}">
                                            <input class="form-check-input user-checkbox" type="checkbox"
                                                name="user_ids[]" value="{{ $user->id }}" id="user{{ $user->id }}">
                                            <label class="form-check-label" for="user{{ $user->id }}">
                                                <strong>{{ $user->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $user->email ?? $user->phone_number }}</small>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                @error('user_ids')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-check-line me-1"></i> Assign Reward
                                    </button>
                                    <a href="{{ route('rewards.show', $reward) }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Reward Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <th>Code:</th>
                                <td><code>{{ $reward->code }}</code></td>
                            </tr>
                            <tr>
                                <th>Discount:</th>
                                <td>{{ $reward->formatted_discount }}</td>
                            </tr>
                            <tr>
                                <th>Min Order:</th>
                                <td>${{ number_format($reward->min_order_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Expiry:</th>
                                <td>{{ $reward->expiry_date->format('M d, Y') }}</td>
                            </tr>
                        </table>
                        @if($reward->description)
                            <p class="text-muted mb-0">{{ $reward->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.user-checkbox');
            const searchInput = document.getElementById('searchUsers');
            const userItems = document.querySelectorAll('.user-item');

            // Select all functionality
            selectAll?.addEventListener('change', function() {
                checkboxes.forEach(cb => {
                    if (cb.closest('.user-item').style.display !== 'none') {
                        cb.checked = this.checked;
                    }
                });
            });

            // Search functionality
            searchInput?.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                userItems.forEach(item => {
                    const name = item.dataset.name;
                    const email = item.dataset.email;
                    if (name.includes(query) || email.includes(query)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
