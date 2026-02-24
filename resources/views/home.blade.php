@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/home.css') }}"/>
@endpush

@section('content')

    <!-- Hero: Start -->
    <section id="hero-animation">
        <div class="landing-hero">
            <div class="container">
                <div class="row align-items-center min-vh-100">

                    <!-- LEFT CONTENT -->
                    <div class="col-lg-6">

                    <span class="badge bg-label-primary mb-4 rounded-pill p-3 px-5">
                        Secure & Instant PIN Delivery
                    </span>

                        <h1 class="hero-title mb-4">
                            Buy Examination Scratch Cards
                            <span class="text-highlight">Securely & Instantly</span>
                        </h1>

                        <p class="fs-5 text-muted mb-5">
                            Purchase WAEC, NECO, NABTEB and Verification PINs with
                            secure payment and instant email delivery.
                        </p>

                        <div class="d-flex gap-3 mb-5">
                            <a href="#landingFeatures" class="btn btn-hero-primary btn-lg">
                                Buy Now →
                            </a>
                            <a href="#landingFAQ" class="btn btn-hero-outline btn-lg">
                                Learn More
                            </a>
                        </div>

                        <!-- STATS -->
                        <div class="row hero-stats border-top">
                            <div class="col-4">
                                <h3 class="mb-0">10K+</h3>
                                <p class="small text-muted">PINs Delivered</p>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0">5K+</h3>
                                <p class="small text-muted">Active Users</p>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0">100%</h3>
                                <p class="small text-muted">Secure Payment</p>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT FLOATING CARDS -->
                    <div class="col-lg-6 position-relative hero-cards">

                        <div class="floating-card">
                            <div class="icon-box">
                                <i class="bx bx-time-five"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Platform Availability</small>
                                <h5 class="fw-bold mb-0">24/7</h5>
                            </div>
                        </div>

                        <div class="floating-card card-2">
                            <div class="icon-box">
                                <i class="bx bx-bar-chart-alt-2"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Total PINs Sold</small>
                                <h5 class="fw-bold mb-0">10,245</h5>
                            </div>
                        </div>

                        <div class="floating-card card-3">
                            <div class="icon-box">
                                <i class="bx bx-check-shield"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Successful Payments</small>
                                <h5 class="fw-bold text-success mb-0">99.9%</h5>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Hero: End -->
    <!-- Pin section: Start -->
    <section id="buyPins" class="section-py">
        <div class="container">
            <div class="text-center mb-4">
                <span class="badge bg-label-primary">Available Exam Cards</span>
            </div>
            <h4 class="text-center mb-12">
            <span class="position-relative fw-extrabold z-1"
            >Select your preferred
              <img
                  src="{{ asset('assets/img/icons/section-title-icon.png') }}"
                  alt="laptop charging"
                  class="section-title-img position-absolute object-fit-contain bottom-0 z-n1"/>
            </span>
                exam type and proceed to payment
            </h4>
            <div class="row gx-0 gy-6 g-sm-12">
                @foreach($examTypes as $exam)
                    <div class="col-lg-4 col-sm-6 mb-5">
                        <a href="{{ route('exam.show', $exam->slug) }}"
                           style="text-decoration: none; color: inherit;">

                            <div class="exam-card">

                                @if($exam->cover_image)
                                    <img src="{{ asset('storage/'.$exam->cover_image) }}"
                                         class="w-100">
                                @endif
                                <h3 class="exam-title">
                                    {{ $exam->name }}
                                </h3>
                                <div class="exam-card-footer">

                                    <div class="price">
                                        ₦{{ number_format($exam->price, 2) }}
                                    </div>

                                    @if($exam->stock_count > 0)
                                        <div class="btn btn-outline-success btn-sm">
                                            In Stock
                                        </div>
                                    @else
                                        <div class="btn btn-outline-danger btn-sm">
                                            Out of Stock
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- pins section: End -->


    <!-- WHY CHOOSE US: Start -->
    <section id="whyChooseUs" class="section-py bg-body">
        <div class="container">
            <div class="text-center mb-4">
                <span class="badge bg-label-primary">Why Choose Us</span>
            </div>

            <h4 class="text-center mb-1">
            <span class="position-relative fw-extrabold z-1">
                Fast, Secure & Reliable
                <img
                    src="{{ asset('assets/img/icons/section-title-icon.png') }}"
                    alt=""
                    class="section-title-img position-absolute object-fit-contain bottom-0 z-n1"
                />
            </span>
                PIN Delivery
            </h4>

            <p class="text-center mb-12">
                Everything you need to purchase and receive your PIN instantly, with zero stress.
            </p>
            <div class="row gx-0 gy-6 g-sm-12">
                <div class="col-lg-4 col-sm-6 text-center">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <div class="mb-4 text-primary">
                                @include('icons.paper')
                            </div>
                            <h3 class="mb-0">Instant Delivery</h3>
                            <p class="fw-medium mb-0">Receive your PIN immediately after successful payment.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <div class="mb-4 text-primary">
                                @include('icons.check')
                            </div>
                            <h3 class="mb-0">Secure Payments</h3>
                            <p class="fw-medium mb-0">We use trusted payment gateways for safe transactions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 text-center">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <div class="mb-4 text-primary">
                                @include('icons.user')
                            </div>
                            <h3 class="mb-0">Reliable Support</h3>
                            <p class="fw-medium mb-0">Our support team is available to assist you anytime.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- WHY CHOOSE US: End -->

    <!-- FAQ: Start -->
    <section id="faqs" class="section-py landing-faq">
        <div class="container">
            <div class="text-center mb-4">
                <span class="badge bg-label-primary">FAQ</span>
            </div>
            <h4 class="text-center mb-1">
                Frequently asked
                <span class="position-relative fw-extrabold z-1"
                >questions
              <img
                  src="{{ asset('assets/img/icons/section-title-icon.png') }}"
                  alt="laptop charging"
                  class="section-title-img position-absolute object-fit-contain bottom-0 z-n1"/>
            </span>
            </h4>
            <p class="text-center mb-12 pb-md-4">
                Browse through these FAQs to find answers to commonly asked questions.
            </p>
            <div class="row gy-12 align-items-center">
                <div class="col-lg-5">
                    <div class="text-center">
                        <img
                            src="{{ asset('assets/img/illustration/faq.png') }}"
                            alt="faq boy with logos"
                            class="faq-image"/>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="accordion" id="faqAccordion">
                        @foreach($faqs as $faq)
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                    <button
                                        type="button"
                                        class="accordion-button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#accordion{{ $faq->id }}"
                                        aria-controls="accordion{{ $faq->id }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>

                                <div id="accordion{{ $faq->id }}" class="accordion-collapse collapse"
                                     data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ: End -->

@endsection
@push('scripts')
@endpush
