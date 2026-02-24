@extends('user.layouts.app')

@section('title', 'Order Success')

@section('content')

    <div class="card shadow-sm p-5 printable-area">

        <div class="text-center mb-4">
            <i class="bx bx-check-circle text-success" style="font-size:60px;"></i>
            <h3 class="fw-bold text-success mt-3">Payment Successful 🎉</h3>
            <p class="text-muted">
                {{ $order->examType->name }} PIN(s) assigned.
            </p>
        </div>

        <hr>

        <h5 class="mb-3">PIN Details</h5>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>PIN</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->pins as $pin)
                    <tr>
                        <td>{{ $pin->serial_number }}</td>
                        <td>
                                <span class="masked-pin"
                                      data-pin="{{ $pin->pin }}">
                                    ************
                                </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary reveal-btn">
                                Reveal
                            </button>
                            <button class="copy-btn copy-btn-sq"
                                    data-clipboard-text="{{ $pin->pin }}">
                                <i class="bx bx-copy"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex gap-3 no-print">
            <a href="{{ route('user.orders.invoice', $order) }}"
               class="btn btn-primary">
                Download PDF
            </a>

            <a href="{{ route('user.dashboard') }}"
               class="btn btn-outline-secondary">
                Dashboard
            </a>
        </div>

    </div>

@endsection

@push('styles')
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendor/clipboardjs/clipboard.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard.js') }}"></script>
@endpush
