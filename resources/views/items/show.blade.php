@extends('layouts.vertical', ['title' => 'Item Details'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Item Details</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Items</a></li>
                <li class="breadcrumb-item active">View</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <!-- Main Item Details -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row">
                        <!-- Item Image -->
                        <div class="col-md-5 text-center">
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                    class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                            @else
                                <div class="border rounded bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <i data-feather="box" style="width: 100px; height: 100px; color: #aaa;"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Item Info -->
                        <div class="col-md-7">
                            <h3 class="fw-semibold">{{ $item->name }}</h3>
                            
                            <p class="text-muted">
                                <span class="badge bg-primary-subtle text-primary fs-14">{{ $item->category->name ?? 'N/A' }}</span>
                            </p>
                            
                            <div class="mt-3">
                                <h4 class="fw-bold text-dark">
                                    Rs. {{ number_format($item->discounted_price, 2) }}
                                    @if($item->discount_percent > 0)
                                        <small class="text-muted text-decoration-line-through fs-16 ms-2">
                                            Rs. {{ number_format($item->base_price, 2) }}
                                        </small>
                                        <small class="badge bg-danger-subtle text-danger fs-14 ms-2">
                                            {{ $item->discount_percent }}% off
                                        </small>
                                    @endif
                                </h4>
                            </div>

                            <hr>

                            <h6 class="fw-semibold">Description</h6>
                            <p>{{ $item->description ?? 'No description provided.' }}</p>

                            <div class="mt-3">
                                <span class="fw-semibold">Status:</span>
                                @if ($item->status)
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add-ons Details -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i data-feather="plus-square" class="me-1" style="width: 20px;"></i>
                        Available Add-ons
                    </h5>
                </div>
                <div class="card-body">
                    @if ($item->customization_options && count($item->customization_options) > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($item->customization_options as $addon)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="fw-medium">{{ $addon['name'] ?? 'N/A' }}</span>
                                    <span class="text-dark">
                                        + Rs. {{ number_format($addon['price'] ?? 0, 2) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center">No add-ons available for this item.</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-3">
                 <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary w-100">Edit Item</a>
                 <a href="{{ route('items.index') }}" class="btn btn-light w-100 mt-2">Back to List</a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- Scripts zaroori nahi hain is page ke liye --}}
@endsection