@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')

    @include('partials.page-header', [
        'title' => 'Products',
        'subtitle' => 'Manage digital products available for purchase.',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Products'],
        ],
    'actions' => view('admin.products._header-actions'),
    ])

    <div class="card">

        {{-- Header: Bulk + Search + Filters + Add --}}
        <div class="card-header">
            <div class="row g-2 align-items-start">
                {{-- FILTERS (GET) --}}
                <div class="col-md-9">
                    <form method="GET" class="row g-2">

                        <div class="col-md-4">
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                class="form-control"
                                placeholder="Search products…"
                            >
                        </div>

                        <div class="col-md-3">
                            <select name="type" class="form-select">
                                <option value="">Filter by product type</option>
                                @foreach (['ebook', 'toolkit', 'planner', 'other'] as $type)
                                    <option value="{{ $type }}" @selected(request('type') === $type)>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Filter by status</option>
                                <option value="active" @selected(request('status') === 'active')>Active</option>
                                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="featured" class="form-select">
                                <option value="">Filter by featured</option>
                                <option value="yes" @selected(request('featured') === 'yes')>Featured</option>
                                <option value="no" @selected(request('featured') === 'no')>Not featured</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="bx bx-filter-alt me-1"></i> Filter
                            </button>

                            @if(request()->hasAny(['q','type','status','featured']))
                                <a href="{{ route('admin.products.index') }}"
                                   class="btn btn-outline-danger">
                                    <i class="bx bx-x-circle me-1"></i> Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- BULK ACTIONS (POST) --}}
                <div class="col-md-3">
                    <form method="POST" action="{{ route('admin.products.bulk') }}" id="bulk-form" class="d-flex gap-2">
                        @csrf

                        <select name="action" class="form-select" id="bulk-action">
                            <option value="">Bulk actions</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="feature">Mark as featured</option>
                            <option value="unfeature">Remove featured</option>
                            <option value="delete">Delete</option>
                        </select>

                        <button type="button"
                                class="btn btn-outline-primary"
                                id="apply-bulk">
                            <i class="bx bx-check-circle me-1"></i> Apply
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                <tr>
                    <th width="40">
                        <input id="select-all" class="form-check-input" type="checkbox">
                    </th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th class="text-center" title="Featured">
                        <i class="bx bxs-star text-warning"></i>Featured
                    </th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            <input
                                class="form-check-input row-checkbox"
                                type="checkbox"
                                name="ids[]"
                                value="{{ $product->id }}"
                                form="bulk-form"
                            >
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <img
                                    src="{{ $product->cover_image
                                        ? asset('storage/'.$product->cover_image)
                                        : asset('assets/img/placeholders/product-cover.jpg') }}"
                                    class="rounded me-2"
                                    style="width:40px;height:40px;object-fit:cover;"
                                >

                                <div style="max-width:320px">
                                    <div class="fw-semibold text-truncate"
                                         title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </div>
                                    <small class="text-muted">{{ $product->slug }}</small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="badge bg-label-info">
                                {{ ucfirst($product->type) }}
                            </span>
                        </td>

                        <td>
                            @money($product->final_price)
                        </td>

                        <td>
                            <form method="POST" action="{{ route('admin.products.toggle', $product) }}">
                                @csrf
                                @method('PATCH')
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        onchange="this.form.submit()"
                                        @checked($product->is_active)
                                    >
                                </div>
                            </form>
                        </td>
                        <td class="text-center">
                            <form method="POST"
                                  action="{{ route('admin.products.toggleFeatured', $product) }}">
                                @csrf
                                @method('PATCH')

                                <div class="form-check form-switch d-inline-flex justify-content-center">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        onchange="this.form.submit()"
                                        @checked($product->is_featured)
                                        title="Toggle featured"
                                    >
                                </div>
                            </form>
                        </td>

                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="btn btn-sm btn-outline-primary"
                               title="Edit">
                                <i class="icon-base bx bx-edit icon-sm"></i>
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST"
                                  class="d-inline delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="btn btn-sm btn-outline-danger delete-dialog"
                                        data-action="product"
                                        data-title="Delete product?">
                                    <i class="icon-base bx bx-trash icon-sm"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No products found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>

    <div class="modal fade" id="importProductsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST"
                  action="{{ route('admin.products.import') }}"
                  enctype="multipart/form-data"
                  class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Import Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">CSV / Excel File</label>
                        <input type="file"
                               name="file"
                               class="form-control"
                               accept=".csv,.xlsx"
                               required>
                    </div>

                    <div class="mt-3">
                        <small class="text-muted d-block mb-2">
                            Supported columns:
                            <code>
                                name,type,price,sale_price,short_description,description,cover_image,is_active,is_featured,external_url
                            </code>
                        </small>

                        <a href="{{ route('admin.products.import.template') }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-download me-1"></i>
                            Download CSV Template
                        </a>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-primary">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const bulkAction = document.getElementById('bulk-action');
        const applyBulk = document.getElementById('apply-bulk');
        const bulkForm = document.getElementById('bulk-form');

        // Select all
        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                selectAll.checked = [...checkboxes].every(c => c.checked);
            });
        });

        applyBulk.addEventListener('click', () => {
            const selected = [...checkboxes].some(cb => cb.checked);

            if (!bulkAction.value || !selected) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nothing selected',
                    text: 'Select a bulk action and at least one product.'
                });
                return;
            }

            if (bulkAction.value === 'delete') {
                Swal.fire({
                    title: 'Delete selected products?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete',
                }).then(result => {
                    if (result.isConfirmed) {
                        bulkForm.submit();
                    }
                });
            } else {
                bulkForm.submit();
            }
        });

    </script>
@endpush
