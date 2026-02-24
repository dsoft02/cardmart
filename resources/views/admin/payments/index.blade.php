@extends('admin.layouts.app')

@section('title', 'Payments')

@section('content')

    @include('partials.page-header', [
        'title' => 'Payments',
        'subtitle' => 'View all successful transactions',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Payments']
        ]
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

    {{-- PAYMENTS TABLE --}}
    <div class="card border-0 shadow-sm">

        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead class="table-light">
                <tr>
                    <th>Reference</th>
                    <th>User</th>
                    <th>Exam</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>

                @forelse($payments as $payment)
                    <tr>

                        <td class="fw-semibold">
                            {{ $payment->reference }}
                        </td>

                        <td>
                            {{ $payment->user->name }}<br>
                            <small class="text-muted">
                                {{ $payment->user->email }}
                            </small>
                        </td>

                        <td>{{ $payment->examType->name }}</td>

                        <td>₦{{ number_format($payment->amount, 2) }}</td>

                        <td>
                            {{ ucfirst($payment->payment_method ?? 'Online') }}
                        </td>

                        <td>
                        <span class="badge bg-label-success">
                            {{ ucfirst($payment->status) }}
                        </span>
                        </td>

                        <td>
                            {{ $payment->paid_at?->format('d M Y | h:ia') }}
                        </td>

                        <td class="text-end">
                            <a href="{{ route('admin.payments.show', $payment) }}"
                               class="btn btn-sm btn-outline-dark">
                                <i class="bx bx-show"></i>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bx bx-credit-card fs-1 text-muted"></i>
                            <p class="mb-0 mt-2 text-muted">
                                No payments found
                            </p>
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>

        @if($payments->hasPages())
            <div class="card-footer">
                {{ $payments->withQueryString()->links() }}
            </div>
        @endif

    </div>

@endsection
