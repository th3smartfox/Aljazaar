@extends('layouts.vertical', ['title' => 'Order Details'])

@section('content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Order #{{ $order->order_number }}</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                <li class="breadcrumb-item active">Details</li>
            </ol>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Left Column: Order Details -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Order Items ({{ $order->items->sum('quantity') }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Add-ons</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->item && $item->item->image)
                                                <img src="{{ asset('storage/' . $item->item->image) }}" alt="{{ $item->item_name }}" class="rounded" height="40" width="40" style="object-fit: cover;">
                                            @else
                                                <span class="badge bg-light text-dark p-2 rounded-circle">
                                                    <i data-feather="box" style="width: 20px; height: 20px;"></i>
                                                </span>
                                            @endif
                                            <span class="ms-2 fw-semibold">{{ $item->item_name }}</span>
                                        </div>
                                    </td>
                                    <td>x {{ $item->quantity }}</td>
                                    <td>Rs. {{ number_format($item->price_at_purchase, 2) }}</td>
                                    <td>
                                        @if(!empty($item->selected_add_ons))
                                            @foreach($item->selected_add_ons as $addon)
                                                <small class="d-block">{{ $addon['name'] }} (+Rs. {{ $addon['price'] }})</small>
                                            @endforeach
                                        @else
                                            <small class="text-muted">N/A</small>
                                        @endif
                                    </td>
                                    <td>Rs. {{ number_format($item->price_at_purchase * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="row justify-content-end">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span>Sub Total:</span>
                                <span>Rs. {{ number_format($order->sub_total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Delivery Fee:</span>
                                <span>Rs. {{ number_format($order->delivery_fee, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Discount:</span>
                                <span class="text-danger">- Rs. {{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-16">
                                <span>Total Amount:</span>
                                <span>Rs. {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Status, Customer, Payment -->
        <div class="col-lg-4">
            <!-- Update Status -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Update Status</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label for="status" class="form-label">Order Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="out_for_delivery" {{ $order->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Customer & Address</h5>
                </div>
                <div class="card-body">
                    <strong>Customer:</strong>
                    <p class="mb-2">{{ $order->user->name }} ({{ $order->user->email }})</p>
                    
                    <strong>Shipping Address:</strong>
                    @if($order->address)
                        <address class="mb-0">
                            <strong>{{ $order->address->address_title }} ({{ $order->address->full_name }})</strong><br>
                            {{ $order->address->address_line }}<br>
                            {{ $order->address->street_number }}<br>
                            <abbr title="Phone">P:</abbr> {{ $order->address->phone }}
                        </address>
                    @endif
                </div>
            </div>

            <!-- NEW: Payment Details -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">Payment Details</h5>
                </div>
                <div class="card-body">
                    @if($order->payment)
                        <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                        <p><strong>Payment Status:</strong> 
                            @if($order->payment_status == 'completed')
                                <span class="badge bg-success-subtle text-success">Completed</span>
                            @elseif($order->payment_status == 'pending')
                                <span class="badge bg-warning-subtle text-warning">Pending</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </p>
                        <p><strong>Transaction ID:</strong> {{ $order->payment->transaction_id ?? 'N/A' }}</p>
                        <p><strong>Payment Date:</strong> {{ $order->payment->created_at->format('d M, Y h:i A') }}</p>
                    @else
                        <p class="text-muted">No payment record found for this order.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        // Feather icons ko initialize karein (agar zaroorat ho, 
        // aam taur par yeh app.js mein hota hai lekin add-ons ke liye zaroori hai)
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    </script>
@endsection