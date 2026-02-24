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
                            <h2 class="mb-1 fw-bold">Account Login</h2>
                            <p class="mb-6 fw-medium">Sign in to continue to your dashboard</p>
                        </div>

                        @include('partials.alerts')

                        <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('login') }}">
                            @csrf
                            {{-- Email --}}
                            <div class="mb-6 form-control-validation">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Enter your email"
                                    class="form-control @error('email') is-invalid @enderror"
                                />

                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-6 form-password-toggle form-control-validation">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        autocomplete="current-password"
                                        placeholder="••••••••••••"
                                        class="form-control @error('password') is-invalid @enderror"
                                    />
                                    <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                                </div>

                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Remember & Forgot --}}
                            <div class="my-7">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check mb-0">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="remember_me"
                                            name="remember"
                                            {{ old('remember') ? 'checked' : '' }}
                                        />
                                        <label class="form-check-label" for="remember_me">Remember Me</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-primary">
                                            Forgot Password?
                                        </a>
                                    @endif

                                </div>
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="icon-base bx bx-log-in icon-sm me-2"></i>Sign in
                            </button>
                        </form>

                        {{-- Register --}}
                        <p class="text-center">
                            <span>Don't have an account yet?</span>
                            <a href="{{ route('register') }}">
                                Sign Up
                            </a>
                        </p>

                        {{-- Social --}}
                        <div class="divider my-6">
                            <div class="divider-text">OR</div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="{{ route('auth.google.redirect') }}" class="btn btn-google-plus w-100 me-1_5">
                                <i class="icon-base bx bxl-google icon-sm me-2"></i>Continue with Google
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
