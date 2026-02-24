@extends('admin.layouts.app')

@section('title', 'Payment Details')

@section('content')

    @include('partials.page-header', [
        'title' => 'Payment Details',
        'subtitle' => 'Reference: ' . $order->reference,
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Payments', 'url' => route('admin.payments.index')],
            ['label' => 'Details']
        ]
    ])

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-6">
                    <h6>User</h6>
                    <p class="mb-1">{{ $order->user->name }}</p>
                    <small class="text-muted">{{ $order->user->email }}</small>
                </div>

                <div class="col-md-6">
                    <h6>Payment Info</h6>
                    <p class="mb-1">Method: {{ ucfirst($order->payment_method) }}</p>
                    <p class="mb-1">Amount: ₦{{ number_format($order->amount, 2) }}</p>
                    <p class="mb-1">Status:
                        <span class="badge bg-label-success">
                        {{ ucfirst($order->status) }}
                    </span>
                    </p>
                    <p class="mb-0">
                        Date: {{ $order->paid_at?->format('d M Y | h:ia') }}
                    </p>
                </div>

            </div>

            <hr>

            <h6 class="mb-3">Associated Order</h6>

            <p class="mb-1">
                Exam: {{ $order->examType->name }}
            </p>

            <p class="mb-1">
                Quantity: {{ $order->quantity }}
            </p>

        </div>

    </div>

@endsection
