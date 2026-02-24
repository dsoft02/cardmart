@extends('layouts.app')

@section('title', 'Forgot Password')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/page-auth.css') }}" />
@endpush
@section('content')
    @include('partials.frontpage-header', [
        'title' => 'Forgot Password',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Forgot Password']
        ]
    ])
    <section class="bg-body section-py">
        <div class="container">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner">
                    <!-- Login -->
                    <div class="card px-sm-6 px-0">
                        <div class="card-body">
                            <div class="text-center">
                                <h2 class="mb-1 fw-bold">Recover Password</h2>
                                <p class="mb-6 fw-medium">Enter your email and we'll send you instructions to reset your password</p>
                            </div>

                            @include('partials.alerts')

                            <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('password.email') }}">
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

                                {{-- Submit --}}
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="icon-base bx bx-rocket icon-sm me-2"></i>Send Reset Link
                                </button>
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
