@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('content')

    @include('partials.page-header', [
        'title' => 'Add Product',
        'subtitle' => 'Create a new digital product.',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Products', 'url' => route('admin.products.index')],
            ['label' => 'Add Product'],
        ],
    ])

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @include('admin.products._form')

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.products.index') }}"
                       class="btn btn-outline-secondary me-2">
                        Cancel
                    </a>
                    <button class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>

@endsection
