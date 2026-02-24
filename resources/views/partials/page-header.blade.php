@props([
    'title',
    'subtitle' => null,
    'actions' => null,
    'breadcrumbs' => null,
])

{{-- Page Header --}}
<div class="row mb-4">
    <div class="col-md-8">
        <h4 class="fw-bold mb-1">
            {{ $title }}
        </h4>

        @if ($subtitle)
            <p class="text-muted mb-0">
                {{ $subtitle }}
            </p>
        @endif
    </div>

    @if ($actions)
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            {!! $actions !!}
        </div>
    @endif

    @if ($breadcrumbs)
        <div class="col-12 mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom-icon mb-0">
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                            @if (!$loop->last)
                                <a href="{{ $breadcrumb['url'] ?? 'javascript:void(0);' }}">
                                    {{ $breadcrumb['label'] }}
                                </a>
                                <i class="breadcrumb-icon icon-base bx bx-chevron-right align-middle"></i>
                            @else
                                {{ $breadcrumb['label'] }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>
    @endif

    <div class="col-12 mt-2">
        @include('partials.alerts')
    </div>
</div>
