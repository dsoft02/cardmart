<section class="page-hero section-py first-section-pt position-relative overflow-hidden">
    <div class="container position-relative z-2">
        <div class="row">
            <div class="col-12 text-white">

                {{-- TITLE --}}
                <h1 class="breadcrumb-title fw-bold">
                    {{ $title ?? '' }}
                </h1>

                {{-- SUBTITLE --}}
                @isset($subtitle)
                    <p class="text-white-75 mt-2 mb-3">
                        {{ $subtitle }}
                    </p>
                @endisset

                {{-- BREADCRUMB --}}
                @isset($breadcrumbs)
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-custom-icon mb-0">
                            @foreach($breadcrumbs as $crumb)

                                @if(!$loop->last)
                                    <li class="breadcrumb-item">
                                        <a href="{{ $crumb['url'] ?? '#' }}" class="text-white">
                                            {{ $crumb['label'] }}
                                        </a>
                                        <i class="breadcrumb-icon icon-base bx bx-chevron-right align-middle text-white"></i>
                                    </li>
                                @else
                                    <li class="breadcrumb-item active text-white">
                                        {{ $crumb['label'] }}
                                    </li>
                                @endif

                            @endforeach
                        </ol>
                    </nav>
                @endisset

            </div>
        </div>
    </div>
</section>
