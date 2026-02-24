<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CardMart Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1, h2, h3 {
            margin: 0;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            max-height: 60px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
        }

        .meta {
            margin-top: 5px;
            font-size: 11px;
            color: #666;
        }

        .section {
            margin-top: 25px;
        }

        .kpi-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .kpi-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .kpi-label {
            background: #f5f5f5;
            font-weight: bold;
            width: 40%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .data-table th {
            background: #f0f0f0;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: center;
            color: #999;
        }
    </style>
</head>
<body>

{{-- ================= LOGO ================= --}}
<div class="logo">
    <img src="{{ asset('assets/img/logo.png') }}">
</div>


{{-- ================= HEADER ================= --}}
<div class="header">
    <h1>CardMart Business Report</h1>
    <div class="meta">
        Period: {{ $from->format('d M Y') }} - {{ $to->format('d M Y') }} <br>
        Generated: {{ now()->format('d M Y H:i') }}
    </div>
</div>


{{-- ================= KPI SUMMARY ================= --}}
<div class="section">
    <h3>Summary</h3>

    <table class="kpi-table">
        <tr>
            <td class="kpi-label">Total Revenue</td>
            <td>₦{{ number_format($totalRevenue, 2) }}</td>
        </tr>
        <tr>
            <td class="kpi-label">Total Orders</td>
            <td>{{ $totalOrders }}</td>
        </tr>
        <tr>
            <td class="kpi-label">Paid Orders</td>
            <td>{{ $paidOrders }}</td>
        </tr>
        <tr>
            <td class="kpi-label">Sold PINs</td>
            <td>{{ $soldPins }}</td>
        </tr>
        <tr>
            <td class="kpi-label">Revenue Growth</td>
            <td>
                {{ number_format($revenueGrowth, 2) }}%
            </td>
        </tr>
    </table>
</div>


{{-- ================= EXAM PERFORMANCE ================= --}}
<div class="section">
    <h3>Exam Performance</h3>

    <table class="data-table">
        <thead>
        <tr>
            <th>Exam Type</th>
            <th class="text-right">Sold Count</th>
        </tr>
        </thead>
        <tbody>
        @foreach($examSales as $exam)
            <tr>
                <td>{{ $exam->name }}</td>
                <td class="text-right">{{ $exam->sold_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


{{-- ================= ORDERS BREAKDOWN ================= --}}
<div class="section">
    <h3>Paid Orders Breakdown</h3>

    <table class="data-table">
        <thead>
        <tr>
            <th>Reference</th>
            <th>User</th>
            <th>Exam (Qty)</th>
            <th class="text-right">Amount</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->reference }}</td>
                <td>{{ $order->user->name ?? '-' }}</td>
                <td>
                    {{ $order->examType->name ?? '-' }}
                    ({{ $order->quantity }})
                </td>
                <td class="text-right">₦{{ number_format($order->amount, 2) }}</td>
                <td>{{ optional($order->paid_at)->format('d M Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


<div class="footer">
    © {{ now()->year }} CardMart — Confidential Business Report
</div>

</body>
</html>
