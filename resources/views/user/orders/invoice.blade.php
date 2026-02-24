<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #ffffff;
            color: #2c3e50;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            width: 100%;
            background: #ffffff;
        }

        .header {
            text-align: center;
            padding: 5px 0;
        }

        .header img {
            height: 60px;
        }

        .content {
            padding: 10px 30px;
        }

        h2 {
            margin-top: 0;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .summary-table td {
            border: 1px solid #dcdcdc;
            padding: 10px;
        }

        .summary-table td:first-child {
            background: #f8f9fb;
            width: 40%;
            font-weight: bold;
        }

        .section-title {
            margin-top: 30px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #555;
        }

    </style>
</head>
<body>

<div class="wrapper">

    <div class="header">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
    </div>

    <div class="content">

        <p>Hi {{ $order->user->name }},</p>

        <p>
            Thank you for choosing {{ config('app.name') }}.
            Here's a summary of your order.
        </p>

        <table class="summary-table">
            <tr>
                <td>Transaction ID</td>
                <td>{{ $order->reference }}</td>
            </tr>
            <tr>
                <td>Payment Gateway</td>
                <td>{{ ucfirst($order->payment_method ?? 'Online Payment') }}</td>
            </tr>
            <tr>
                <td>Product</td>
                <td>{{ $order->examType->name }} (₦{{ number_format($order->amount, 2) }})</td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td>{{ $order->quantity }}</td>
            </tr>
            <tr>
                <td>Total Paid</td>
                <td>₦{{ number_format($order->amount, 2) }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>{{ $order->paid_at?->format('d-M-Y h:ia') }}</td>
            </tr>
        </table>

        <div class="section-title">
            Find your purchased scratch cards below:
        </div>

        <table width="100%" style="border-collapse: collapse; margin-top:15px;">

            <thead>
            <tr>
                <th style="border:1px solid #dcdcdc; padding:12px; background:#f1f3f5; text-align:left;">
                    Product
                </th>
                <th style="border:1px solid #dcdcdc; padding:12px; background:#f1f3f5; text-align:left;">
                    Token
                </th>
                <th style="border:1px solid #dcdcdc; padding:12px; background:#f1f3f5; text-align:left;">
                    Serial No
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach($order->pins as $pin)
                <tr>
                    <td style="border:1px solid #dcdcdc; padding:12px;">
                        {{ $order->examType->name }}
                    </td>

                    <td style="border:1px solid #dcdcdc; padding:12px; font-weight:bold;">
                        {{ $pin->pin }}
                    </td>

                    <td style="border:1px solid #dcdcdc; padding:12px; font-weight:bold;">
                        {{ $pin->serial_number }}
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

        <div class="footer">
            <p>
                For inquiries and prompt assistance,
                send us a Whatsapp message via <strong>09169442847</strong>
                or email us at <strong>info@cardmart.ng</strong>
            </p>

            <p>
                Regards,<br>
                {{ config('app.name') }} Team
            </p>
        </div>

    </div>

</div>

</body>
</html>
