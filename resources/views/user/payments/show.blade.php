@extends('user.layouts.app')

@section('title', 'Payment Details')

@section('content')

    @include('partials.page-header', [
        'title' => 'Payment Details',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('user.dashboard')],
            ['label' => 'Payment History', 'url' => route('user.payments.index')],
            ['label' => 'Payment Details'],
        ],
    ])

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            {{-- Reference --}}
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-semibold mb-1">Transaction Reference</h6>
                    <p class="text-muted mb-0">{{ $order->reference }}</p>
                </div>

                <button class="btn btn-sm btn-success copy-btn"
                        data-clipboard-text="{{ $order->reference }}">
                    <i class="bx bx-copy"></i>
                </button>
            </div>

            <hr>

            {{-- Payment Method --}}
            <div>
                <h6 class="fw-semibold mb-1">Payment Method</h6>
                <p class="text-muted mb-0">
                    {{ ucfirst($order->payment_method ?? 'Online Payment') }}
                </p>
            </div>

            <hr>

            {{-- Product --}}
            <div>
                <h6 class="fw-semibold mb-1">Product</h6>
                <p class="text-muted mb-0">
                    {{ $order->examType->name }}
                </p>
            </div>

            <hr>

            {{-- Quantity --}}
            <div>
                <h6 class="fw-semibold mb-1">Quantity</h6>
                <p class="text-muted mb-0">
                    {{ $order->quantity }}
                </p>
            </div>

            <hr>

            {{-- Amount --}}
            <div>
                <h6 class="fw-semibold mb-1">Amount Paid</h6>
                <p class="fw-bold fs-5 mb-0">
                    ₦{{ number_format($order->amount, 2) }}
                </p>
            </div>

            <hr>

            {{-- Payment Date --}}
            <div>
                <h6 class="fw-semibold mb-1">Payment Date</h6>
                <p class="text-muted mb-0">
                    {{ $order->paid_at?->format('M d, Y | h:ia') }}
                </p>
            </div>

            <hr>

            {{-- Status --}}
            <span class="badge rounded-pill px-3 py-2 bg-success">
                Paid
            </span>

        </div>

        {{-- Action Buttons --}}
        <div class="card-footer d-flex flex-column flex-md-row gap-3">

            <a href="{{ route('user.orders.show', $order) }}"
               class="btn btn-outline-dark flex-fill text-center">
                <i class="bx bx-show me-2"></i>
                VIEW ORDER
            </a>

            <a href="{{ route('user.orders.invoice', $order) }}"
               class="btn btn-success flex-fill text-center">
                <i class="bx bx-download me-2"></i>
                DOWNLOAD INVOICE
            </a>

        </div>

    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/clipboardjs/clipboard.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard.js') }}"></script>
@endpush
