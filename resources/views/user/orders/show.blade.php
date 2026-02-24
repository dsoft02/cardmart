@extends('user.layouts.app')

@section('title', 'Order Details')

@section('content')

    @include('partials.page-header', [
        'title' => 'Order Details',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('user.dashboard')],
            ['label' => 'My Orders', 'url' => route('user.orders.index')],
            ['label' => 'Order Details'],
        ],
    ])

    <div class="card border-0 shadow-sm order-detail-card">

        <div class="card-body">

            {{-- Transaction ID --}}
            <div class="detail-row d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-semibold mb-1">Transaction ID</h6>
                    <p class="text-muted mb-0">{{ $order->reference }}</p>
                </div>

                <button class="btn btn-sm btn-success copy-btn"
                        data-clipboard-text="{{ $order->reference }}">
                    <i class="bx bx-copy"></i>
                </button>
            </div>

            <hr>

            {{-- Payment Method --}}
            <div class="detail-row">
                <h6 class="fw-semibold mb-1">Payment Method</h6>
                <p class="text-muted mb-0">{{ ucfirst($order->payment_method ?? 'Online Payment') }}</p>
            </div>

            <hr>

            {{-- Product --}}
            <div class="detail-row">
                <h6 class="fw-semibold mb-1">Product</h6>
                <p class="text-muted mb-0">
                    {{ $order->examType->name }} ({{ $order->quantity }})
                </p>
            </div>

            <hr>

            {{-- Amount --}}
            <div class="detail-row">
                <h6 class="fw-semibold mb-1">Amount</h6>
                <p class="text-muted mb-0">₦{{ $order->formatted_amount }}</p>
            </div>

            <hr>

            {{-- Date --}}
            <div class="detail-row">
                <h6 class="fw-semibold mb-1">Transaction Date</h6>
                <p class="text-muted mb-0">
                    {{ $order->created_at->format('M d, Y | h:ia') }}
                </p>
            </div>

            <hr>

            {{-- Status --}}
            <span class="badge rounded-pill px-3 py-2
            bg-{{ $order->status === 'paid' ? 'success' : 'warning' }}">
            {{ $order->status === 'paid' ? 'Completed' : ucfirst($order->status) }}
        </span>

        </div>

        {{-- Action Buttons --}}
        @if($order->status === 'paid')
            <div class="card-footer mt-4">

                <div class="d-flex flex-column flex-md-row gap-3">

                    {{-- View Cards --}}
                    <a href="{{ route('user.orders.cards', $order) }}"
                       class="btn btn-success flex-fill py-3 fw-semibold text-center">
                        <i class="bx bx-credit-card me-2"></i>
                        VIEW PURCHASED CARD(S)
                    </a>

                    {{-- Download Invoice --}}
                    <a href="{{ route('user.orders.invoice', $order) }}"
                       class="btn btn-outline-dark flex-fill py-3 fw-semibold text-center">
                        <i class="bx bx-download me-2"></i>
                        DOWNLOAD INVOICE
                    </a>

                </div>

            </div>
        @endif

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/clipboardjs/clipboard.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard.js') }}"></script>
@endpush
