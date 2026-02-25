@extends('layouts.app')

@section('title', 'Login')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/page-auth.css') }}" />
@endpush
@section('content')
    @include('partials.frontpage-header', [
        'title' => 'Login',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Login']
        ]
    ])
    <section class="bg-body py-6">
        <div class="container">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner">
                    <!-- Login -->
                    <div class="card px-sm-6 px-0">
                        <div class="card-body">
                            <div class="text-center">
                                <h2 class="mb-1 fw-bold">Reset Password</h2>
                                <p class="mb-6 fw-medium">Your new password must be different from previously used passwords</p>
                            </div>

                            @include('partials.alerts')

                            <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                {{-- Email --}}
                                <div class="mb-6 form-control-validation">
                                    <label for="email" class="form-label">Email</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', $request->email) }}"
                                        autofocus
                                        autocomplete="username"
                                        placeholder="Enter your email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        readonly
                                    />

                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-6 form-password-toggle form-control-validation">
                                    <label class="form-label" for="password">New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="password"
                                            id="password"
                                            class="form-control"
                                            name="password"
                                            placeholder="••••••••••••"
                                            aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="mb-6 form-password-toggle form-control-validation">
                                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="password"
                                            id="password_confirmation"
                                            class="form-control"
                                            name="password_confirmation"
                                            placeholder="••••••••••••"
                                            aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <button type="submit" class="btn btn-primary d-grid w-100">{{ __('Set new password') }}</button>
                            </form>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-chevron-left icon-20px scaleX-n1-rtl me-1_5 align-top"></i>
                                    Back to login
                                </a>
                            </div>


                        </div>
                    </div>
                    <!-- /Login -->
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
@endpush

