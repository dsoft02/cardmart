@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')

    @include('partials.page-header', [
        'title' => 'Edit User',
        'subtitle' => 'Update user details and permissions',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'User Management', 'url' => route('admin.users.index')],
            ['label' => 'Edit User']
        ]
    ])

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                @include('admin.users._form')

                <div class="mt-4">
                    <button class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Update User
                    </button>
                </div>

            </form>

        </div>

    </div>

@endsection
