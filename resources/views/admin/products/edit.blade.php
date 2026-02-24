@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')

    @include('partials.page-header', [
        'title' => 'Edit Product',
        'subtitle' => 'Update product details and pricing.',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Products', 'url' => route('admin.products.index')],
            ['label' => 'Edit Product'],
        ],
    ])

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.products._form')

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.products.index') }}"
                       class="btn btn-outline-secondary me-2">
                        Back
                    </a>
                    <button class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>

@endsection
