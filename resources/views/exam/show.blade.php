@extends('layouts.app')

@section('content')
    @include('partials.frontpage-header', [
        'title' => 'Buy ' . $exam->name,
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => $exam->name]
        ]
    ])
    {{-- PURCHASE SECTION --}}
    <section class="section-py bg-body">

        <div class="container">
            <div class="row g-5">

                <div class="col-lg-5">

                    <div class="card border-0 shadow-lg rounded-4 position-sticky">

                        <img class="card-img-top w-100" src="{{ $exam->cover_url }}" alt="{{ $exam->name }}">

                        <div class="card-body">
                        <h4 class="fw-bold mb-2">Buy {{ $exam->name }} Online</h4>

                            <div class="d-flex align-items-center justify-content-between mb-3">

                                <h3 class="text-primary fw-bold mb-0">
                                    ₦{{ number_format($exam->price, 2) }}
                                </h3>

                                @if($exam->stock_count > 0)
                                    <span class="badge bg-success-subtle text-success">
                                        In Stock ({{ $exam->stock_count }})
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">
                                        Out of Stock
                                    </span>
                                @endif

                            </div>

                        @if($exam->stock_count > 0)

                            {{-- QUANTITY --}}
                            <div class="mb-3">
                                <label class="form-label fw-medium">Quantity</label>
                                <div class="input-group">
                                    <button class="btn btn-danger" id="minusBtn">
                                        <x-lucide-minus class="fw-bold" />
                                    </button>
                                    <input type="text" name="quantity" id="quantity" class="form-control form-control-lg input-number text-center" value="1" min="1" max="100" readonly="">
                                    <button class="btn btn-success" id="plusBtn">
                                        <x-lucide-plus class="fw-bold" />
                                    </button>
                                </div>
                            </div>

                            {{-- TOTAL --}}
                            <div class="mb-4">
                                <small>Total Amount</small>
                                <div class="fs-4 fw-bold">
                                    ₦<span id="totalAmount">{{ number_format($exam->price, 2) }}</span>
                                </div>
                            </div>

                            {{-- FORM --}}
                            <form action="{{ route('order.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="exam_type_id" value="{{ $exam->id }}">
                                <input type="hidden" name="quantity" id="hiddenQuantity" value="1">

                                <button class="btn btn-primary w-100 py-3 fw-semibold">
                                    <x-lucide-shopping-cart class="me-1" /> Buy Now
                                </button>
                            </form>

                        @endif
                    </div>

                </div>

            </div>
            <div class="col-lg-7">

                {{-- ABOUT --}}
                @if($exam->about_content)
                    <div class="card border-0 shadow-sm rounded-4 p-5 mb-5">
                        <h4 class="fw-bold mb-3">About {{ $exam->name }}</h4>
                        {!! $exam->about_content !!}
                    </div>
                @endif

                {{-- HOW TO BUY --}}
                @if($exam->how_to_buy_content)
                    <div class="card border-0 shadow-sm rounded-4 p-5 mb-5">
                        <h4 class="fw-bold mb-3">How To Buy</h4>
                        {!! $exam->how_to_buy_content !!}
                    </div>
                @endif

                {{-- HOW TO CHECK --}}
                @if($exam->how_to_check_content)
                    <div class="card border-0 shadow-sm rounded-4 p-5">
                        <h4 class="fw-bold mb-3">How To Check Result</h4>
                        {!! $exam->how_to_check_content !!}
                    </div>
                @endif

            </div>

        </div>

        </div>

    </section>

@endsection

@push('scripts')
    <script>
        const price = {{ $exam->price }};
        const qtyInput = document.getElementById('quantity');
        const hiddenQty = document.getElementById('hiddenQuantity');
        const total = document.getElementById('totalAmount');

        document.getElementById('plusBtn')?.addEventListener('click', function () {
            qtyInput.value++;
            updateTotal();
        });

        document.getElementById('minusBtn')?.addEventListener('click', function () {
            if (qtyInput.value > 1) {
                qtyInput.value--;
                updateTotal();
            }
        });

        function updateTotal() {
            hiddenQty.value = qtyInput.value;
            total.innerText = (price * qtyInput.value).toLocaleString();
        }
    </script>
@endpush
