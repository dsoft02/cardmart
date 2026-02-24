@extends('user.layouts.app')

@section('title', 'Purchased Cards')

@section('content')

    @include('partials.page-header', [
        'title' => 'Purchased Card(s)',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('user.dashboard')],
            ['label' => 'My Orders', 'url' => route('user.orders.index')],
            ['label' => 'Order Details', 'url' => route('user.orders.show', $order)],
            ['label' => 'Cards'],
        ],
    ])

    <div class="card border-0 shadow-sm p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">
                {{ $order->examType->name }} ({{ $order->quantity }})
            </h5>

            <div class="d-flex gap-2">
                <button id="downloadAllPdf" class="btn btn-danger btn-sm">
                    <i class="bx bx-file"></i> Download All PDF
                </button>

                <button onclick="window.print()" class="btn btn-dark btn-sm">
                    <i class="bx bx-printer"></i> Print All
                </button>
            </div>
        </div>

        <div class="row g-6" id="cardsWrapper">
            @foreach($order->pins as $pin)
                <div class="col-12 col-md-6 px-2">
                    <div class="pin-visual-card"
                         id="card-{{ $pin->id }}"
                         style="background-image: url('{{ $order->examType->cardbg_url }}')">

                        <div class="card-overlay">

                            {{-- Header Row --}}
                            <div class="d-flex justify-content-between align-items-start mb-4">

                                <h4 class="fw-bold mb-0">
                                    {{ $order->examType->name }}
                                </h4>

                                <button class="download-card card-action-btn"
                                        data-id="{{ $pin->id }}">
                                    <i class="bx bx-download"></i>
                                </button>

                            </div>

                            <div class="mb-3">
                                <small>Token</small>
                                <div class="fw-bold fs-5 d-flex align-items-center gap-2">
                                    {{ $pin->pin }}
                                    <button class="copy-btn"
                                            data-clipboard-text="{{ $pin->pin }}">
                                        <i class="bx bx-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <small>Serial No</small>
                                <div class="fw-bold fs-5 d-flex align-items-center gap-2">
                                    {{ $pin->serial_number }}
                                    <button class="copy-btn"
                                            data-clipboard-text="{{ $pin->serial_number }}">
                                        <i class="bx bx-copy"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
@push('styles')
    <style>
        @media print {

            body * {
                visibility: hidden;
            }

            #cardsWrapper,
            #cardsWrapper * {
                visibility: visible;
            }

            #cardsWrapper {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* ONE CARD PER ROW */
            #cardsWrapper .col-12.col-md-6 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            /* Add spacing between printed cards */
            .pin-visual-card {
                margin-bottom: 20px !important;
            }

            /* Hide action buttons in print */
            .copy-btn,
            .download-card {
                display: none !important;
            }

        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendor/clipboardjs/clipboard.js') }}"></script>
    <script src="{{ asset('assets/js/clipboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Download single card as image
            document.querySelectorAll('.download-card').forEach(btn => {
                btn.addEventListener('click', async function () {

                    const id = this.dataset.id;
                    const element = document.getElementById('card-' + id);

                    // Hide action buttons temporarily
                    const buttons = element.querySelectorAll('.copy-btn, .download-card');
                    buttons.forEach(el => el.style.visibility = 'hidden');

                    const canvas = await html2canvas(element);

                    // Restore buttons
                    buttons.forEach(el => el.style.visibility = 'visible');

                    const link = document.createElement('a');
                    link.download = 'card-' + id + '.png';
                    link.href = canvas.toDataURL();
                    link.click();
                });
            });

            // Download all as PDF
            document.getElementById('downloadAllPdf')
                .addEventListener('click', async function () {

                    const {jsPDF} = window.jspdf;
                    const pdf = new jsPDF('p', 'mm', 'a4');

                    const cards = document.querySelectorAll('.pin-visual-card');

                    const pageWidth = 210;   // A4 width in mm
                    const pageHeight = 297;  // A4 height in mm

                    const margin = 15;
                    const usableWidth = pageWidth - (margin * 2);

                    let yPosition = margin;
                    let cardCountOnPage = 0;

                    for (let i = 0; i < cards.length; i++) {

                        const buttons = cards[i].querySelectorAll('.copy-btn, .download-card');
                        buttons.forEach(el => el.style.visibility = 'hidden');

                        const canvas = await html2canvas(cards[i], {scale: 2});
                        buttons.forEach(el => el.style.visibility = 'visible');

                        const imgData = canvas.toDataURL('image/png');

                        const imgWidth = usableWidth;
                        const imgHeight = canvas.height * imgWidth / canvas.width;

                        // If 2 cards already placed, add new page
                        if (cardCountOnPage === 2) {
                            pdf.addPage();
                            yPosition = margin;
                            cardCountOnPage = 0;
                        }

                        pdf.addImage(imgData, 'PNG', margin, yPosition, imgWidth, imgHeight);

                        yPosition += imgHeight + 10; // spacing between cards
                        cardCountOnPage++;
                    }

                    pdf.save('purchased-cards.pdf');
                });

        });
    </script>
@endpush
