@extends('admin.layouts.app')

@section('title', 'Exam Types')

@section('content')

    @include('partials.page-header', [
        'title' => 'Exam Types',
        'subtitle' => 'Manage available scratch card types',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Exam Types']
        ],
        'actions' => '
            <button class="btn btn-success me-2"
                data-bs-toggle="modal"
                data-bs-target="#importModal">
                <i class="bx bx-upload me-1"></i> Import PINs
            </button>

            <a href="' . route('admin.exam-types.create') . '" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Add Exam Type
            </a>
        '
    ])

    <div class="card border-0 shadow-sm">

        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead>
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Available PINs</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @forelse($examTypes as $exam)
                    <tr>
                        <td>
                            <img src="{{ $exam->logo_url }}"
                                 width="40"
                                 class="rounded">
                        </td>

                        <td class="fw-semibold">
                            {{ $exam->name }}
                        </td>

                        <td>₦{{ number_format($exam->price, 2) }}</td>

                        <td>
                        <span class="badge bg-label-info">
                            {{ $exam->available_pins_count }}
                        </span>
                        </td>

                        <td>
                            @if($exam->is_active)
                                <span class="badge bg-label-success">Active</span>
                            @else
                                <span class="badge bg-label-danger">Inactive</span>
                            @endif
                        </td>

                        <td class="text-end">

                            <div class="d-flex justify-content-end gap-2">

                                {{-- Manage PINs --}}
                                <a href="{{ route('admin.pins.index', ['exam_type' => $exam->id]) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Manage PINs">
                                    <i class="bx bx-key"></i>
                                </a>

                                {{-- Quick Import --}}
                                <button type="button"
                                        class="btn btn-sm btn-outline-success open-import"
                                        data-exam="{{ $exam->id }}"
                                        data-name="{{ $exam->name }}">
                                    <i class="bx bx-upload"></i>
                                </button>

                                {{-- Edit --}}
                                <a href="{{ route('admin.exam-types.edit', $exam) }}"
                                   class="btn btn-sm btn-outline-dark">
                                    <i class="bx bx-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form method="POST"
                                      action="{{ route('admin.exam-types.destroy', $exam) }}"
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger delete-dialog"
                                        data-action="Exam Type"
                                        data-title="Delete this exam type?">
                                        <i class="icon-base bx bx-trash icon-sm"></i>
                                    </button>
                                </form>

                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bx bx-layer fs-1"></i>
                            <p class="mt-2 mb-0">No exam types yet</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>

        @if($examTypes->hasPages())
            <div class="card-footer">
                {{ $examTypes->links() }}
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
                    <h5 class="modal-title">
                        Import PINs
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Exam Type</label>
                        <select name="exam_type_id"
                                class="form-select"
                                id="importExamSelect"
                                required>
                            @foreach($examTypes as $exam)
                                <option value="{{ $exam->id }}">
                                    {{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload CSV / Excel</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Required columns: <strong>serial_number</strong>, <strong>pin</strong>
                        </small>

                        <a href="{{ route('admin.pins.template') }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-download me-1"></i>
                            Sample
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.open-import').forEach(btn => {

                btn.addEventListener('click', function () {

                    const examId = this.dataset.exam;
                    const select = document.getElementById('importExamSelect');

                    select.value = examId;

                    const modal = new bootstrap.Modal(
                        document.getElementById('importModal')
                    );

                    modal.show();
                });

            });

        });
    </script>
@endpush
