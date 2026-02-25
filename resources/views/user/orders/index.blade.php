@extends('user.layouts.app')

@section('title', 'My Orders')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
@endpush

@section('content')
    @include('partials.page-header', [
        'title' => 'My Orders',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('user.dashboard')],
            ['label' => 'My Orders'],
        ],
    ])

    <form method="GET" class="mb-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="row g-3 align-items-end">

                {{-- Date Filter --}}
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Date</label>

                    <div class="date-filter-wrapper">
                        <i class="bx bx-calendar calendar-icon"></i>

                        <input type="text"
                               id="dateRange"
                               class="date-filter-input"
                               value="{{ request('from') && request('to')
                                ? \Carbon\Carbon::parse(request('from'))->format('d-M-Y') . ' to ' . \Carbon\Carbon::parse(request('to'))->format('d-M-Y')
                                : 'All Time' }}"
                               readonly>

                        <button type="button" id="clearDate" class="clear-date d-none">
                            &times;
                        </button>

                        <i class="bx bx-chevron-down dropdown-icon"></i>

                        <input type="hidden" name="from" id="fromDate" value="{{ request('from') }}">
                        <input type="hidden" name="to" id="toDate" value="{{ request('to') }}">
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-dark w-auto">
                        <i class="bx bx-filter-alt me-2"></i>Filter
                    </button>

                    @if(request()->hasAny(['from','to','status']))
                        <a href="{{ route('user.orders.index') }}"
                           class="btn btn-outline-secondary w-auto">
                            <i class="bx bx-x me-1"></i>Clear
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </form>

    <div class="row g-4">
        @forelse($orders as $order)
            <div class="col-12">
                <a href="{{ route('user.orders.show', $order) }}"
                   class="text-decoration-none order-card-link">

                    <div class="card border-0 shadow-sm order-card">
                        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">

                            {{-- Left --}}
                            <div class="d-flex align-items-center gap-3">

                                <div class="order-avatar d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('storage/' . $order->examType->logo) }}"
                                         alt="{{ $order->examType->name }}"
                                         class="img-fluid">
                                </div>

                                <div>
                                    <h5 class="mb-1 fw-semibold text-dark">
                                        {{ $order->examType->name }} ({{ $order->quantity }})
                                    </h5>

                                    <small class="text-muted">
                                        {{ $order->created_at->format('M d, Y | h:ia') }}
                                    </small>
                                </div>
                            </div>

                            {{-- Right --}}
                            <div class="text-end mt-3 mt-md-0">
                                <h4 class="fw-bold mb-2 text-dark">
                                    ₦{{ $order->formatted_amount }}
                                </h4>

                                <span class="badge px-3 py-2 rounded-pill
                                    @if($order->status === 'paid')
                                        bg-success
                                    @elseif($order->status === 'failed')
                                        bg-danger
                                    @else
                                        bg-warning text-dark
                                    @endif
                                ">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                        </div>
                    </div>

                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm empty-orders-card">
                    <div class="card-body text-center py-5">

                        <div class="empty-icon mb-3">
                            <i class="bx bx-receipt"></i>
                        </div>

                        <h5 class="fw-semibold mb-2">No Orders Yet</h5>
                        <p class="text-muted mb-0">
                            You haven’t made any purchases yet.
                        </p>

                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $orders->withQueryString()->links() }}
    </div>


@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let fromInput = document.getElementById('fromDate');
            let toInput   = document.getElementById('toDate');
            let display   = document.getElementById('dateRange');
            let clearBtn  = document.getElementById('clearDate');

            function updateDisplay(start, end) {
                display.value = start.format('DD-MMM-YYYY') + ' to ' + end.format('DD-MMM-YYYY');
                fromInput.value = start.format('YYYY-MM-DD');
                toInput.value   = end.format('YYYY-MM-DD');
                clearBtn.classList.remove('d-none');
            }

            $('#dateRange').daterangepicker({
                autoUpdateInput: false,
                showDropdowns: true,
                opens: 'right',
                locale: { cancelLabel: 'Clear' },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 14 Days': [moment().subtract(13, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [
                        moment().subtract(1, 'month').startOf('month'),
                        moment().subtract(1, 'month').endOf('month')
                    ],
                    'Last 3 Months': [moment().subtract(3, 'months'), moment()],
                    'Last 6 Months': [moment().subtract(6, 'months'), moment()],
                    'Last 12 Months': [moment().subtract(12, 'months'), moment()]
                }
            }, updateDisplay);

            // Show clear button if already filtered
            if (fromInput.value && toInput.value) {
                clearBtn.classList.remove('d-none');
            }

            // Clear button logic
            clearBtn.addEventListener('click', function () {
                fromInput.value = '';
                toInput.value   = '';
                display.value   = 'All Time';
                clearBtn.classList.add('d-none');
            });

        });
    </script>
@endpush
