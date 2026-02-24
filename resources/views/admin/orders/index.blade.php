@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')

    @include('partials.page-header', [
        'title' => 'Orders',
        'subtitle' => 'Manage all customer orders.',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Orders'],
        ],
    ])

{{-- FILTER BAR --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">

        <form method="GET" class="row g-3">

                <div class="col-md-4">
                    <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                           class="form-control"
                       placeholder="Search reference, name or email">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="paid" @selected(request('status')=='paid')>Paid</option>
                    <option value="pending" @selected(request('status')=='pending')>Pending</option>
                    <option value="failed" @selected(request('status')=='failed')>Failed</option>
                    </select>
                </div>

            <div class="col-md-2">
                <button class="btn btn-dark w-100">
                    <i class="bx bx-filter-alt me-1"></i>
                    Filter
                </button>
                </div>

            </form>
        </div>
</div>


{{-- ORDERS TABLE --}}
<div class="card border-0 shadow-sm">

        <div class="table-responsive">
        <table class="table align-middle mb-0">

            <thead class="table-light">
                <tr>
                <th>Reference</th>
                <th>User</th>
                <th>Exam</th>
                <th class="text-center">Qty</th>
                <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                <th></th>
                </tr>
                </thead>

                <tbody>
                @forelse($orders as $order)
                    <tr>

                    <td class="fw-semibold">
                        {{ $order->reference }}
                    </td>

                        <td>
                        {{ $order->user->name }}<br>
                                <small class="text-muted">
                            {{ $order->user->email }}
                                </small>
                        </td>

                    <td>{{ $order->examType->name }}</td>

                    <td class="text-center fw-semibold">
                        {{ $order->quantity }}
                    </td>

                    <td>₦{{ number_format($order->amount, 2) }}</td>

                        <td>
                        @if($order->status === 'paid')
                            <span class="badge bg-label-success">Paid</span>
                        @elseif($order->status === 'pending')
                            <span class="badge bg-label-warning">Pending</span>
                        @else
                            <span class="badge bg-label-danger">
                                {{ ucfirst($order->status) }}
                        </span>
                        @endif
                        </td>

                    <td>{{ $order->created_at->format('d M Y') }}</td>

                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $order) }}"
                           class="btn btn-sm btn-outline-dark">
                            <i class="bx bx-show"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bx bx-cart-alt fs-1 text-muted"></i>
                        <p class="mb-0 mt-2 text-muted">
                            No orders found
                        </p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    @if($orders->hasPages())
        <div class="card-footer">
            {{ $orders->withQueryString()->links() }}
        </div>
    @endif

    </div>

@endsection
