@extends('admin.layouts.app')

@section('title', 'PIN Management')

@section('content')

    @include('partials.page-header', [
        'title' => 'PIN Management',
        'subtitle' => 'Manage all uploaded scratch cards',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'PIN Management']
    ],
    'actions' => '
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bx bx-upload me-1"></i> Import PINs
        </button>
    '
    ])

    <div class="card border-0 shadow-sm">

        {{-- FILTERS --}}
        <div class="card-body border-bottom">

            <form method="GET" class="row g-3">

                <div class="col-md-4">
                    <select name="exam_type" class="form-select">
                        <option value="">All Exam Types</option>
                        @foreach($examTypes as $exam)
                            <option value="{{ $exam->id }}"
                                {{ request('exam_type') == $exam->id ? 'selected' : '' }}>
                                {{ $exam->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available
                        </option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary">
                        <i class="bx bx-filter-alt me-1"></i>
                        Filter
                    </button>
                </div>

            </form>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead>
                <tr>
                    <th>Exam</th>
                    <th>Serial</th>
                    <th>PIN</th>
                    <th>Status</th>
                    <th>Sold To</th>
                    <th>Order</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @forelse($pins as $pin)
                    <tr>

                        <td>{{ $pin->examType->name }}</td>

                        <td class="fw-semibold">{{ $pin->masked_serial }}</td>

                        <td class="fw-semibold">{{ $pin->masked_pin }}</td>

                        <td>
                            @if($pin->status === 'available')
                                <span class="badge bg-label-success">Available</span>
                            @else
                                <span class="badge bg-label-danger">Sold</span>
                            @endif
                        </td>

                        <td>
                            @if($pin->user)
                                {{ $pin->user->name }}
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            @if($pin->order)
                                <a href="{{ route('admin.orders.show', $pin->order) }}">
                                    {{ $pin->order->reference }}
                                </a>
                            @else
                                —
                            @endif
                        </td>

                        <td>{{ $pin->created_at->format('d M Y') }}</td>

                        <td class="text-end">

                            @if($pin->status !== 'sold')

                                <form method="POST"
                                      action="{{ route('admin.pins.destroy', $pin) }}"
                                      class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger delete-dialog"
                                            data-action="PIN"
                                            data-title="Delete this PIN?">
                                        <i class="bx bx-trash icon-sm"></i>
                                    </button>
                                </form>

                            @endif

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bx bx-key fs-1"></i>
                            <p class="mt-2 mb-0">No PINs found</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>

        @if($pins->hasPages())
            <div class="card-footer">
                {{ $pins->withQueryString()->links() }}
            </div>
        @endif

    </div>


    {{-- IMPORT MODAL --}}
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST"
                  action="{{ route('admin.pins.import') }}"
                  enctype="multipart/form-data"
                  class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Import PINs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Exam Type</label>
                        <select name="exam_type_id" class="form-select" required>
                            @foreach($examTypes as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload CSV / Excel</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">
                            File must contain columns: <strong>serial_number</strong>, <strong>pin</strong>
                        </small>

                        <a href="{{ route('admin.pins.template') }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-download me-1"></i>
                            Download Sample
                        </a>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">
                        <i class="bx bx-upload me-1"></i>
                        Import
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection
