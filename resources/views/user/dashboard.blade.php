@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- PAGE TITLE --}}
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold">
                👋 Welcome back,
                {{ auth()->user()->firstname ?: auth()->user()->username }}
            </h4>
            <p class="text-muted mb-0">
                Here’s a quick overview of your activity.
            </p>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Total Orders</small>
                    <h4 class="fw-bold mb-0">{{ $totalOrders }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Total PINs Purchased</small>
                    <h4 class="fw-bold mb-0">{{ $totalPins }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Last Purchase</small>
                    <h6 class="fw-bold mb-0">
                        {{ $lastOrder?->created_at?->format('d M Y') ?? 'No orders yet' }}
                    </h6>
                </div>
            </div>
        </div>
    </div>

    {{-- ORDERS TABLE --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Recent Orders</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>Reference</th>
                    <th>Exam</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->reference }}</td>
                        <td>{{ $order->examType->name }}</td>
                        <td>{{ $order->quantity }}</td>

                        <td>
                            @if($order->status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>

                        <td>{{ $order->created_at->format('d M Y') }}</td>

                        <td>
                            @if($order->status === 'paid')
                                <a href="{{ route('user.orders.show', $order) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bx bx-show me-1"></i> View
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">

                            <div class="d-flex flex-column align-items-center">

                                <div class="mb-3">
                                    <i class="bx bx-receipt fs-1 text-muted"></i>
                                </div>

                                <h6 class="fw-semibold mb-1">No Orders Yet</h6>

                                <p class="text-muted mb-3">
                                    You haven’t made any purchases yet.
                                </p>

                                <a href="{{ route('home') }}#buyPins"
                                   class="btn btn-sm btn-warning">
                                    <i class="bx bx-cart me-1"></i>
                                    Buy Scratch Card
                                </a>

                            </div>

                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection
