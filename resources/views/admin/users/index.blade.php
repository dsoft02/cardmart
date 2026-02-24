@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')

    @include('partials.page-header', [
        'title' => 'User Management',
        'subtitle' => 'Manage administrators and customers',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'User Management']
        ],
        'actions' => '
            <a href="'.route('admin.users.create').'" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Create User
                </a>
        '
    ])

    <div class="card border-0 shadow-sm">

        {{-- FILTERS --}}
        <div class="card-body border-bottom">
            <form method="GET" class="row g-3">

                <div class="col-md-4">
                    <input type="text" name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Search name, email, phone">
                </div>

                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
                        <option value="user" {{ request('role')=='user'?'selected':'' }}>User</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status')==='1'?'selected':'' }}>Active</option>
                        <option value="0" {{ request('status')==='0'?'selected':'' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @forelse($users as $user)
                    <tr>

                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>

                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-label-dark">Admin</span>
                            @else
                                <span class="badge bg-label-info">User</span>
                            @endif
                        </td>

                        <td>
                            @if($user->is_active)
                                <span class="badge bg-label-success">Active</span>
                            @else
                                <span class="badge bg-label-danger">Inactive</span>
                            @endif
                        </td>

                        <td>{{ $user->created_at->format('d M Y') }}</td>

                        <td class="text-end">

                            <a href="{{ route('admin.users.edit',$user) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-edit icon-sm"></i>
                            </a>

                            @if(auth()->id() !== $user->id)
                                <form method="POST"
                                      action="{{ route('admin.users.destroy',$user) }}"
                                      class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger delete-dialog"
                                            data-action="User"
                                            data-title="Delete this user?">
                                        <i class="bx bx-trash icon-sm"></i>
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bx bx-user fs-1"></i>
                            <p class="mt-2 mb-0">No users found</p>
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="card-footer">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif

    </div>

@endsection
