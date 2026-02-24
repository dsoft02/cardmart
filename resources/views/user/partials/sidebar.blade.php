@php
    use App\Helpers\MenuHelper;
@endphp

    <!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand px-3">
        <a href="{{ route('user.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo">
                <img src="{{ asset('assets/img/icon.png') }}" width="64px" alt=""/>
            </span>
            <span
                class="app-brand-text app-brand-text-sm menu-text fw-bold ms-2 text-white">{{ config('app.name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base bx bx-chevron-left"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Main</span>
        </li>
        {{-- Dashboard --}}
        <li class="menu-item {{ MenuHelper::active('user.dashboard') }}">
            <a href="{{ route('user.dashboard') }}" class="menu-link">
                <i class="menu-icon bx bx-home"></i>
                <div>Dashboard</div>
            </a>
        </li>

        {{-- Buy Scratch Card --}}
        <li class="menu-item {{ MenuHelper::active('exams.*') }}">
            <a href="{{ route('home') }}#buyPins" class="menu-link">
                <i class="menu-icon bx bx-cart"></i>
                <div>Buy Scratch Card</div>
            </a>
        </li>

        {{-- My Orders --}}
        <li class="menu-item {{ MenuHelper::active('user.orders.*') }}">
            <a href="{{ route('user.orders.index') }}" class="menu-link">
                <i class="menu-icon bx bx-receipt"></i>
                <div>My Orders</div>
            </a>
        </li>

        {{-- Payment History --}}
        <li class="menu-item {{ MenuHelper::active('user.payments.*') }}">
            <a href="{{ route('user.payments.index') }}" class="menu-link">
                <i class="menu-icon bx bx-credit-card"></i>
                <div>Payment History</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Account</span>
        </li>

        {{-- Profile --}}
        <li class="menu-item {{ MenuHelper::active('user.profile.*') }}">
            <a href="{{ route('user.profile.index') }}" class="menu-link">
                <i class="menu-icon bx bx-user"></i>
                <div>Profile</div>
            </a>
        </li>

        {{-- Logout --}}
        <li class="menu-item">
            <form method="POST" action="{{ route('logout') }}" class="d-inline-block p-0">
                @csrf
                <button class="menu-link btn border-0 bg-transparent text-start px-0 w-100">
                    <i class="menu-icon bx bx-log-out"></i>
                    <div>Logout</div>
                </button>
            </form>
        </li>
    </ul>
</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
        <i class="bx bx-menu icon-base"></i>
        <i class="bx bx-chevron-right icon-base"></i>
    </a>
</div>
<!-- / Menu -->
