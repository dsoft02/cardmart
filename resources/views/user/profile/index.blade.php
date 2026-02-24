@extends('user.layouts.app')

@section('title', 'My Profile')

@section('content')
    @include('partials.page-header', [
            'title' => 'My Profile',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('user.dashboard')],
                ['label' => 'My Profile'],
            ],
        ])

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Account Details</h5>
        </div>

        <div class="card-body">
            <form id="formProfileUpdate" method="POST" action="{{ route('user.profile.update') }}">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text"
                       name="name"
                       value="{{ auth()->user()->name }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text"
                       class="form-control"
                       name="phone"
                       value="{{ old('phone', auth()->user()->phone) }}">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email"
                       value="{{ auth()->user()->email }}"
                       class="form-control"
                       disabled>
            </div>

            <button class="btn btn-primary">
                <i class="bx bx-save me-1"></i>
                Update Profile
            </button>
        </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Security</h5>
        </div>

        <div class="card-body">

            @if (!auth()->user()->google_id)

                <form id="formChangePassword" method="POST" action="{{ route('user.profile.password.update') }}" onsubmit="return false">
                    @csrf

                    <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                        <label class="form-label" for="current_password">Current Password</label>
                        <div class="input-group input-group-merge">
                            <input
                                class="form-control"
                                type="password"
                                name="current_password"
                                id="current_password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                        </div>
                    </div>
                    <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                        <label class="form-label" for="password">New Password</label>
                        <div class="input-group input-group-merge">
                            <input
                                class="form-control"
                                type="password"
                                id="password"
                                name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                        </div>
                    </div>

                    <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                        <label class="form-label" for="password_confirmation">Confirm New Password</label>
                        <div class="input-group input-group-merge">
                            <input
                                class="form-control"
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                            <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                        </div>
                    </div>

                    <h6 class="text-body">Password Requirements:</h6>
                    <ul class="ps-4 mb-0">
                        <li class="mb-4">Minimum 8 characters long - the more, the better</li>
                        <li class="mb-4">At least one lowercase character</li>
                        <li>At least one number, symbol, or whitespace character</li>
                    </ul>

                    <div class="mt-6">
                        <button type="submit" class="btn btn-danger">
                            <i class="bx bx-lock-alt me-1"></i>
                            Update Password
                        </button>
                    </div>
                </form>

            @else
                <div class="alert alert-info mb-0">
                    You signed in using Google. Password changes are managed via Google.
                </div>
            @endif

        </div>
    </div>

@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/form-validation.css') }}" />
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('assets/js/profile.js') }}"></script>
@endpush
