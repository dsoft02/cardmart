@php
    use App\Helpers\MenuHelper;
@endphp

    <!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
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

        {{-- MAIN --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Main Menu</span>
        </li>
        {{-- Dashboard --}}
        <li class="menu-item {{ MenuHelper::active('admin.dashboard') }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon bx bx-home"></i>
                <div>Dashboard</div>
            </a>
        </li>


        {{-- Orders --}}
        <li class="menu-item {{ MenuHelper::active('admin.orders.*') }}">
            <a href="{{ route('admin.orders.index') }}" class="menu-link">
                <i class="menu-icon bx bx-cart"></i>
                <div>Orders</div>
            </a>
        </li>

        {{-- Payments --}}
        <li class="menu-item {{ MenuHelper::active('admin.payments.*') }}">
            <a href="{{ route('admin.payments.index') }}" class="menu-link">
                <i class="menu-icon bx bx-credit-card"></i>
                <div>Payments</div>
            </a>
        </li>

        {{-- Exam Types --}}
        <li class="menu-item {{ MenuHelper::active('admin.exam-types.*') }}">
            <a href="{{ route('admin.exam-types.index') }}" class="menu-link">
                <i class="menu-icon bx bx-layer"></i>
                <div>Exam Types</div>
            </a>
        </li>

        {{-- PIN Management --}}
        <li class="menu-item {{ MenuHelper::active('admin.pins.*') }}">
            <a href="{{ route('admin.pins.index') }}" class="menu-link">
                <i class="menu-icon bx bx-key"></i>
                <div>PIN Management</div>
            </a>
        </li>


        <li class="menu-item {{ MenuHelper::active('admin.users.*') }}">
            <a href="{{ route('admin.users.index') }}" class="menu-link">
                <i class="menu-icon bx bx-user"></i>
                <div>Users</div>
            </a>
        </li>


        <li class="menu-item {{ MenuHelper::active('admin.reports.*') }}">
            <a href="{{ route('admin.reports.index') }}" class="menu-link">
                <i class="menu-icon bx bx-bar-chart"></i>
                <div>Reports</div>
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
