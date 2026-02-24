@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')

    @include('partials.page-header', [
        'title' => 'Settings',
        'subtitle' => 'Manage system configuration and preferences.',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Settings'],
        ],
    ])

    <form method="POST" action="{{ route('admin.settings.store') }}">
        @csrf

        <div class="row g-4">
            @include('admin.settings.partials.general')
            @include('admin.settings.partials.booking')
            @include('admin.settings.partials.currency')
            @include('admin.settings.partials.payment-methods')
            @include('admin.settings.partials.manual-payment')
            @include('admin.settings.partials.gateways.stripe')
            @include('admin.settings.partials.gateways.paypal')
        </div>

        <div class="mt-4 text-end">
            <button class="btn btn-primary">
                <i class="bx bx-save"></i> Save Settings
            </button>
        </div>
    </form>

@endsection

@push('scripts')
    @include('admin.settings.partials.gateway-js')
@endpush
