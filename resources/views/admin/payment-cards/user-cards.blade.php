@extends('layouts.vertical', ['title' => 'User Payment Cards'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('payment-cards.index') }}">Payment Cards</a></li>
                            <li class="breadcrumb-item active">{{ $user->name }}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Payment Cards - {{ $user->name }}</h4>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- User Info Card -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-lg me-3">
                                @if($user->profile_image_url)
                                    <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}"
                                        class="rounded-circle img-fluid">
                                @else
                                    <span class="avatar-title bg-primary rounded-circle fs-3">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $user->name }}</h5>
                                <p class="text-muted mb-0">{{ $user->email ?? $user->phone_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h3 class="mb-1">{{ $cards->count() }}</h3>
                                <p class="mb-0">Total Cards</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h3 class="mb-1">{{ $cards->where('is_default', true)->count() }}</h3>
                                <p class="mb-0">Default Card</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h3 class="mb-1">{{ $cards->filter(fn($c) => $c->isExpired())->count() }}</h3>
                                <p class="mb-0">Expired Cards</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards List -->
        <div class="row">
            @forelse($cards as $card)
                <div class="col-md-6 col-lg-4">
                    <div class="card {{ $card->is_default ? 'border-success' : '' }} {{ $card->isExpired() ? 'border-danger' : '' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    @switch($card->brand)
                                        @case('visa')
                                            <span class="badge bg-primary fs-6">
                                                <i class="ri-visa-line me-1"></i> Visa
                                            </span>
                                            @break
                                        @case('mastercard')
                                            <span class="badge bg-warning text-dark fs-6">
                                                <i class="ri-mastercard-line me-1"></i> Mastercard
                                            </span>
                                            @break
                                        @case('amex')
                                            <span class="badge bg-info fs-6">
                                                American Express
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary fs-6">
                                                {{ ucfirst($card->brand) }}
                                            </span>
                                    @endswitch
                                </div>
                                <div>
                                    @if($card->is_default)
                                        <span class="badge bg-success">Default</span>
                                    @endif
                                    @if($card->isExpired())
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                </div>
                            </div>

                            <h4 class="mb-3 font-monospace">
                                **** **** **** {{ $card->last_four_digits }}
                            </h4>

                            <div class="row">
                                <div class="col-8">
                                    <small class="text-muted">Card Holder</small>
                                    <p class="mb-0 fw-semibold">{{ $card->card_holder_name }}</p>
                                </div>
                                <div class="col-4 text-end">
                                    <small class="text-muted">Expiry</small>
                                    <p class="mb-0 fw-semibold {{ $card->isExpired() ? 'text-danger' : '' }}">
                                        {{ $card->expiry_month }}/{{ $card->expiry_year }}
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Added {{ $card->created_at->format('M d, Y') }}
                                </small>
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('payment-cards.toggle-default', $card->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn {{ $card->is_default ? 'btn-warning' : 'btn-outline-success' }}"
                                            title="{{ $card->is_default ? 'Remove Default' : 'Set as Default' }}">
                                            <i class="ri-star-{{ $card->is_default ? 'fill' : 'line' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('payment-cards.destroy', $card->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this card?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Delete Card">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="ri-bank-card-line fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">No Payment Cards</h5>
                            <p class="text-muted">This user hasn't saved any payment cards yet.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
