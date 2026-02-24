@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    @include('partials.page-header', [
        'title' => '👋 Welcome back, ' . auth()->user()->name,
        'subtitle' => 'Here’s a real-time overview of CardMart.'
    ])

    {{-- KPI ROW --}}
    <div class="row g-4 mb-5">

        {{-- Total Users --}}
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <p class="mb-2">TOTAL USERS</p>
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-user icon-lg"></i>
                        </span>
                        </div>
                        <h2 class="mb-0 fw-bold">{{ $totalUsers }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <p class="mb-2">TOTAL ORDERS</p>
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-cart icon-lg"></i>
                        </span>
                        </div>
                        <h2 class="mb-0 fw-bold">{{ $totalOrders }}</h2>
                    </div>
                    <small class="text-muted">
                        {{ $pendingOrders }} pending
                    </small>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <p class="mb-2">TOTAL REVENUE</p>
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-money icon-lg"></i>
                        </span>
                        </div>
                        <h2 class="mb-0 fw-bold">
                            ₦{{ number_format($totalRevenue, 2) }}
                        </h2>
                    </div>
                    <small class="text-muted">
                        ₦{{ number_format($todayRevenue, 2) }} today
                    </small>
                </div>
            </div>
        </div>

        {{-- Available PINs --}}
        <div class="col-sm-6 col-lg-3">
            <div class="card card-border-shadow-info h-100">
                <div class="card-body">
                    <p class="mb-2">AVAILABLE PINs</p>
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-key icon-lg"></i>
                        </span>
                        </div>
                        <h2 class="mb-0 fw-bold">{{ $availablePins }}</h2>
                    </div>
                    <small class="text-muted">
                        {{ $soldPins }} sold
                    </small>
                </div>
            </div>
        </div>

    </div>


    {{-- LOW STOCK ALERT --}}
    @if($lowStockExamTypes->count())
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-label-danger">
                <h6 class="mb-0 text-danger">
                    <i class="bx bx-error-circle me-2"></i>
                    Low Stock Alert
                </h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    @foreach($lowStockExamTypes as $exam)
                        <li>
                            {{ $exam->name }} —
                            <strong>{{ $exam->available_pins_count }}</strong> PINs left
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    {{-- RECENT ORDERS --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h6 class="mb-0">Recent Orders</h6>
        </div>

        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead>
                <tr>
                    <th>Reference</th>
                    <th>User</th>
                    <th>Exam</th>
                    <th class="text-center">Qty</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td class="fw-semibold">{{ $order->reference }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->examType->name }}</td>
                        <td class="text-center fw-semibold">
                            {{ $order->quantity }}
                        </td>
                        <td>₦{{ $order->formatted_amount }}</td>
                        <td>
                            @if($order->status === 'paid')
                                <span class="badge bg-label-success">Paid</span>
                            @else
                                <span class="badge bg-label-warning">
                                {{ ucfirst($order->status) }}
                            </span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">

                            <div class="d-flex flex-column align-items-center">

                                <div class="mb-3">
                                    <i class="bx bx-cart-alt fs-1 text-muted"></i>
                                </div>

                                <h6 class="fw-semibold mb-1">No Recent Orders</h6>

                                <p class="text-muted mb-0">
                                    Orders will appear here once customers make purchases.
                                </p>

                            </div>

                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
