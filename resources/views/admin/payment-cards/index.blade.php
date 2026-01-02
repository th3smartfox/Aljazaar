@extends('layouts.vertical', ['title' => 'Payment Cards'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payment Cards</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Payment Cards</h4>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">All Payment Cards</h5>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" class="row g-3 mb-4">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search by name, email, or card..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="brand" class="form-select">
                                    <option value="">All Brands</option>
                                    <option value="visa" {{ request('brand') == 'visa' ? 'selected' : '' }}>Visa</option>
                                    <option value="mastercard" {{ request('brand') == 'mastercard' ? 'selected' : '' }}>Mastercard</option>
                                    <option value="amex" {{ request('brand') == 'amex' ? 'selected' : '' }}>American Express</option>
                                    <option value="discover" {{ request('brand') == 'discover' ? 'selected' : '' }}>Discover</option>
                                    <option value="dinersclub" {{ request('brand') == 'dinersclub' ? 'selected' : '' }}>Diners Club</option>
                                    <option value="jcb" {{ request('brand') == 'jcb' ? 'selected' : '' }}>JCB</option>
                                    <option value="unionpay" {{ request('brand') == 'unionpay' ? 'selected' : '' }}>UnionPay</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ri-search-line me-1"></i> Filter
                                </button>
                            </div>
                            @if(request()->hasAny(['search', 'brand']))
                                <div class="col-md-2">
                                    <a href="{{ route('payment-cards.index') }}" class="btn btn-outline-secondary w-100">
                                        <i class="ri-refresh-line me-1"></i> Clear
                                    </a>
                                </div>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Card</th>
                                        <th>Brand</th>
                                        <th>Expiry</th>
                                        <th>Default</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cards as $card)
                                        <tr>
                                            <td>{{ $card->id }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $card->user->name ?? 'N/A' }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $card->user->email ?? $card->user->phone_number ?? '' }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>**** **** **** {{ $card->last_four_digits }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $card->card_holder_name }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @switch($card->brand)
                                                    @case('visa')
                                                        <span class="badge bg-primary">
                                                            <i class="ri-visa-line me-1"></i> Visa
                                                        </span>
                                                        @break
                                                    @case('mastercard')
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="ri-mastercard-line me-1"></i> Mastercard
                                                        </span>
                                                        @break
                                                    @case('amex')
                                                        <span class="badge bg-info">
                                                            American Express
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">
                                                            {{ ucfirst($card->brand) }}
                                                        </span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <span class="{{ $card->isExpired() ? 'text-danger' : '' }}">
                                                    {{ $card->expiry_month }}/{{ $card->expiry_year }}
                                                    @if($card->isExpired())
                                                        <br><small class="text-danger">(Expired)</small>
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                @if($card->is_default)
                                                    <span class="badge bg-success">Default</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>{{ $card->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <form action="{{ route('payment-cards.toggle-default', $card->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $card->is_default ? 'btn-warning' : 'btn-outline-success' }}"
                                                            title="{{ $card->is_default ? 'Remove Default' : 'Set as Default' }}">
                                                            <i class="ri-star-{{ $card->is_default ? 'fill' : 'line' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('payment-cards.destroy', $card->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this card?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Card">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No payment cards found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($cards->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $cards->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
