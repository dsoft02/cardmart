@extends('layouts.app')

@section('title', 'Sign Up')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/page-auth.css') }}" />
@endpush
@section('content')
    @include('partials.frontpage-header', [
        'title' => 'Sign Up',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Sign Up']
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
                                <h2 class="mb-1 fw-bold">Create Account</h2>
                                <p class="mb-6 fw-medium">Please fill out the following fields to signup</p>
                            </div>

                            @include('partials.alerts')

                            <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('register') }}">
                                @csrf

                                {{-- Fullname --}}
                                <div class="mb-6 form-control-validation">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        autocomplete="username"
                                        placeholder="Enter your Full Name"
                                        class="form-control @error('name') is-invalid @enderror"
                                    />

                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-6 form-control-validation">
                                    <label for="email" class="form-label">Email</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        autocomplete="email"
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
                                            autocomplete="password"
                                            placeholder="••••••••••••"
                                            class="form-control @error('password') is-invalid @enderror"
                                        />
                                        <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                                    </div>

                                    @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-6" id="captcha-container">
                                    {!! Captcha::display() !!}
                                </div>

                                {{-- Submit --}}
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="icon-base bx bx-user icon-sm me-2"></i>Sign up
                                </button>
                            </form>

                            {{-- Sign In --}}
                            <p class="text-center">
                                <span>Already have an account?</span>
                                <a href="{{ route('login') }}">
                                    <span>Sign in</span>
                                </a>
                            </p>

                            {{-- Social --}}
                            <div class="divider my-6">
                                <div class="divider-text">OR</div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <a href="{{ route('auth.google.redirect') }}" class="btn btn-google-plus w-100 me-1_5">
                                    <i class="icon-base bx bxl-google icon-sm me-2"></i>Signup with Google
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
