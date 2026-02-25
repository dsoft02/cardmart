<!doctype html>

<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="layout-navbar-fixed layout-compact"
    dir="ltr"
    data-skin="default"
    data-assets-path="/assets/"
    data-template="front-pages-no-customizer"
    data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>{{ page_title(trim($__env->yieldContent('title'))) }}</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/front-page.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/nouislider/nouislider.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}"/>

    <!-- Page CSS -->
    @stack('styles')

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
<!-- Navbar: Start -->
<nav class="layout-navbar shadow-none py-0">
    <div class="container">
        <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">
            <!-- Menu logo wrapper: Start -->
            <div class="navbar-brand app-brand d-flex py-0 me-4 me-xl-8">
                <!-- Mobile menu toggle: Start-->
                <button
                    class="navbar-toggler border-0 px-0 me-4"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="icon-base bx bx-menu icon-lg align-middle text-heading fw-medium"></i>
                </button>
                <!-- Mobile menu toggle: End-->
                <a href="{{ route('home') }}" class="app-brand-link">
                      <span class="app-brand-logo">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="CardMart" width="150px">
                      </span>
                </a>
            </div>
            <!-- Menu logo wrapper: End -->
            <!-- Menu wrapper: Start -->
            <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                <button
                    class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl p-2"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="icon-base bx bx-x icon-lg"></i>
                </button>
                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('home') }}">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('home') }}#buyPins">
                            Buy Pins
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('home') }}#whyChooseUs">
                            Why Choose Us
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('home') }}#faqs">
                            FAQ
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-medium"
                           href="javascript:void(0);"
                           id="checkResultDropdown"
                           data-bs-toggle="dropdown"
                           data-trigger="hover">
                            Check Result
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="checkResultDropdown">
                            <li>
                                <a class="dropdown-item" href="https://www.waecdirect.org" target="_blank">
                                    WAEC
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="https://results.neco.gov.ng" target="_blank">
                                    NECO
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="https://eworld.nabteb.gov.ng/" target="_blank">
                                    NABTEB
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <div class="landing-menu-overlay d-lg-none"></div>
            <!-- Menu wrapper: End -->
            <!-- Toolbar: Start -->
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- navbar button: Start -->
                <li class="nav-item dropdown">
                    @auth
                        <a class="btn btn-primary dropdown-toggle"
                           href="#"
                           id="userDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <span class="tf-icons icon-base bx bx-user me-1"></span>
                            <span class="d-none d-md-inline">Account</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ Auth::user()->routeFor('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ Auth::user()->routeFor('profile') }}">
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/password/change') }}">
                                    Change Password
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <span class="tf-icons icon-base bx bx-log-in-circle me-1"></span>
                            <span class="d-none d-md-inline">Login/Register</span>
                        </a>
                    @endauth
                </li>
                <!-- navbar button: End -->
            </ul>
            <!-- Toolbar: End -->
        </div>
    </div>
</nav>
<!-- Navbar: End -->

<!-- Sections:Start -->
<div data-bs-spy="scroll" class="scrollspy-example">
    @yield('content')
</div>

<!-- / Sections:End -->

<!-- Footer: Start -->
<footer class="landing-footer bg-body footer-text">
    <div class="footer-bottom py-3 py-md-5">
        <div
            class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
            <div class="mb-2 mb-md-0">
            <span class="footer-bottom-text"
            >©
              <script>
                document.write(new Date().getFullYear());
              </script>
            </span>
                <a href="https://felixcodigitalltd.com.ng" target="_blank" class="text-white">Felixco Digital Limited,</a>
            </div>
            <div>
{{--                Powered By: <a href="https://ebendev.xyz" target="_blank">Ebendev</a>--}}
            </div>
        </div>
    </div>
</footer>
<!-- Footer: End -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/theme.js  -->

<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/nouislider/nouislider.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>

<!-- Main JS -->

<script src="{{ asset('assets/js/backend.js') }}"></script>


@include('partials.flash-toast')
<script src="{{ asset('assets/js/flash-toast.js') }}"></script>

@stack('scripts')

</body>
</html>
