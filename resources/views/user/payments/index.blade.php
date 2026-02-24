@extends('user.layouts.app')

@section('title', 'Payment History')


@section('content')

    @include('partials.page-header', [
       'title' => 'Payment History',
       'breadcrumbs' => [
           ['label' => 'Dashboard', 'url' => route('user.dashboard')],
           ['label' => 'Payment History'],
       ],
   ])

    <div class="card border-0 shadow-sm">

        <div class="card-datatable table-responsive">
            <table class="table align-middle mb-0">

                <thead class="table-light">
                <tr>
                    <th>Reference</th>
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date & Time</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>

                @forelse($payments as $payment)
                    <tr>

                        <td class="fw-semibold">
                            {{ $payment->reference }}
                        </td>

                        <td>
                            {{ ucfirst($payment->payment_method ?? 'Online') }}
                        </td>

                        <td class="fw-semibold">
                            ₦{{ number_format($payment->amount, 2) }}
                        </td>

                        <td>
                            <span class="badge rounded-pill bg-success">
                                Paid
                            </span>
                        </td>

                        <td>
                            {{ $payment->paid_at?->format('d M Y | h:ia') }}
                        </td>

                        <td class="text-end">
                            <a href="{{ route('user.payments.show', $payment) }}"
                               class="btn btn-sm btn-outline-dark">
                                <i class="bx bx-show"></i>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bx bx-receipt fs-2 d-block mb-2"></i>
                                No payment history yet.
                            </div>
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
        @if ($payments->hasPages())
            <div class="card-footer">
                {{ $payments->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
