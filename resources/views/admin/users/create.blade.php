@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')

    @include('partials.page-header', [
        'title' => 'Create User',
        'subtitle' => 'Add a new administrator or customer',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'User Management', 'url' => route('admin.users.index')],
            ['label' => 'Create User']
        ]
    ])

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                @include('admin.users._form')

                <div class="mt-4">
                    <button class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Create User
                    </button>
                </div>

            </form>

        </div>

    </div>

@endsection
