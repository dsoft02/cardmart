@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')

    @include('partials.page-header', [
        'title' => 'Order Details',
        'subtitle' => 'Reference: ' . $order->reference,
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Orders', 'url' => route('admin.orders.index')],
            ['label' => 'Order Details'],
        ],
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
                    <h6>Order Info</h6>
                    <p class="mb-1">Exam: {{ $order->examType->name }}</p>
                    <p class="mb-1">Quantity: {{ $order->quantity }}</p>
                    <p class="mb-1">Amount: ₦{{ number_format($order->amount, 2) }}</p>
                    <p class="mb-0">Status:
                        <span class="badge bg-label-success">
                        {{ ucfirst($order->status) }}
                    </span>
                    </p>
                </div>
            </div>

            <hr>

            <h6 class="mb-3">PIN Details</h6>

            <div class="table-responsive">
                <table class="table table-sm">

                    <thead>
                    <tr>
                        <th>Serial</th>
                        <th>PIN</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->pins as $pin)
                        <tr>
                            <td>{{ $pin->serial_number }}</td>
                            <td>{{ $pin->pin }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
