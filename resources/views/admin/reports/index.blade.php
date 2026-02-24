@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')

    @include('partials.page-header', [
        'title' => 'Reports & Analytics',
        'subtitle' => 'Business performance overview',
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Reports']
        ],
        'actions' => '
            <a href="' . route('admin.reports.export.csv') . '" class="btn btn-outline-success me-2">
                <i class="bx bx-download me-1"></i> CSV
            </a>

            <a href="' . route('admin.reports.export.pdf') . '" class="btn btn-outline-danger">
                <i class="bx bx-file me-1"></i> PDF
            </a>
        '
    ])

    {{-- ================= FILTER BAR ================= --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">

            <form method="GET" class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label">From</label>
                    <input type="date"
                           name="from"
                           value="{{ request('from', $from->format('Y-m-d')) }}"
                           class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">To</label>
                    <input type="date"
                           name="to"
                           value="{{ request('to', $to->format('Y-m-d')) }}"
                           class="form-control">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-dark w-100">
                        <i class="bx bx-filter-alt me-1"></i>
                        Filter
                    </button>
                </div>

            </form>

            <div class="mt-3 d-flex flex-wrap gap-2">
                <a href="?preset=today" class="btn btn-sm btn-outline-primary">Today</a>
                <a href="?preset=7days" class="btn btn-sm btn-outline-primary">Last 7 Days</a>
                <a href="?preset=30days" class="btn btn-sm btn-outline-primary">Last 30 Days</a>
                <a href="?preset=thismonth" class="btn btn-sm btn-outline-primary">This Month</a>
            </div>

        </div>
    </div>



    {{-- ================= KPI ROW ================= --}}
    <div class="row g-4 mb-5">

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <small>Total Revenue</small>
                    <h3 class="fw-bold">
                        ₦{{ number_format($totalRevenue, 2) }}
                    </h3>

                    <span class="badge {{ $revenueGrowth >= 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ number_format($revenueGrowth, 2) }}%
                </span>
                    <small class="text-muted">vs previous period</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <small>Total Orders</small>
                    <h3 class="fw-bold">
                        {{ number_format($totalOrders) }}
                    </h3>
                    <small class="text-muted">
                        {{ $paidOrders }} paid
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <small>Sold PINs</small>
                    <h3 class="fw-bold">
                        {{ number_format($soldPins) }}
                    </h3>
                </div>
            </div>
        </div>

    </div>



    {{-- ================= CHART CONTROLS ================= --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <strong>Metric:</strong>
                <button class="btn btn-sm btn-outline-primary toggle-metric active"
                        data-metric="revenue">Revenue
                </button>
                <button class="btn btn-sm btn-outline-primary toggle-metric"
                        data-metric="orders">Orders
                </button>
            </div>

            <div>
                <strong>Chart Type:</strong>
                <button class="btn btn-sm btn-outline-secondary toggle-type active"
                        data-type="line">Line
                </button>
                <button class="btn btn-sm btn-outline-secondary toggle-type"
                        data-type="bar">Bar
                </button>
            </div>

        </div>
    </div>



    {{-- ================= MAIN CHART ================= --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header">
            <h6 class="mb-0">Performance Trend</h6>
        </div>
        <div class="card-body">
            <div id="mainChart"></div>
        </div>
    </div>



    {{-- ================= SALES PER EXAM ================= --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="mb-0">Sales Per Exam</h6>
        </div>
        <div class="card-body">
            <div id="examChart"></div>
        </div>
    </div>



    @push('scripts')
        <script>

            document.addEventListener("DOMContentLoaded", function () {

                let currentType = 'line';
                let currentMetric = 'revenue';

                let revenueData = @json($revenueData);
                let orderData = @json($orderData);
                let labels = @json($revenueLabels);

                let chart = new ApexCharts(document.querySelector("#mainChart"), {
                    chart: {
                        type: currentType,
                        height: 320,
                        toolbar: {show: false}
                    },
                    series: [{
                        name: 'Revenue',
                        data: revenueData
                    }],
                    xaxis: {categories: labels},
                    stroke: {curve: 'smooth'}
                });

                chart.render();


                /* Metric Toggle */
                document.querySelectorAll('.toggle-metric').forEach(btn => {

                    btn.addEventListener('click', function () {

                        document.querySelectorAll('.toggle-metric').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');

                        currentMetric = this.dataset.metric;

                        chart.updateSeries([{
                            name: currentMetric === 'revenue' ? 'Revenue' : 'Orders',
                            data: currentMetric === 'revenue' ? revenueData : orderData
                        }]);
                    });

                });


                /* Chart Type Toggle */
                document.querySelectorAll('.toggle-type').forEach(btn => {

                    btn.addEventListener('click', function () {

                        document.querySelectorAll('.toggle-type').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');

                        currentType = this.dataset.type;

                        chart.updateOptions({
                            chart: {type: currentType}
                        });

                    });

                });


                /* Sales Per Exam Chart */

                new ApexCharts(document.querySelector("#examChart"), {
                    chart: {type: 'bar', height: 320},
                    series: [{
                        name: 'Sold PINs',
                        data: @json($examChartData)
                    }],
                    xaxis: {
                        categories: @json($examChartLabels)
                    }
                }).render();

            });
        </script>
    @endpush

@endsection
