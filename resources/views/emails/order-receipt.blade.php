<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
</head>
<body style="margin:0;padding:0;background-color:#f2f2f2;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f2f2f2;padding:30px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;border-collapse:collapse;">

                <!-- HEADER -->
                <tr style="background: #000;">
                    <td align="center" style="padding:25px 20px;border-bottom:1px solid #e5e5e5;">
                        <img src="{{ config('app.url') }}/assets/img/logo.png"
                             alt="{{ config('app.name') }}"
                             style="height:60px;display:block;">
                    </td>
                </tr>

                <!-- CONTENT -->
                <tr>
                    <td style="padding:30px 30px 20px 30px;color:#2c3e50;font-size:14px;line-height:1.6;">

                        <p style="margin:0 0 15px 0;">
                            Hi {{ $order->user->name }},
                        </p>

                        <p style="margin:0 0 20px 0;">
                            Thank you for choosing {{ config('app.name') }}.
                            Here's a summary of your order.
                        </p>

                        <!-- SUMMARY TABLE -->
                        <table width="100%" cellpadding="8" cellspacing="0" role="presentation" style="border-collapse:collapse;font-size:14px;">
                            @php
                                $labelStyle = "border:1px solid #dcdcdc;background:#f8f9fb;font-weight:bold;width:40%;";
                                $valueStyle = "border:1px solid #dcdcdc;";
                            @endphp

                            <tr>
                                <td style="{{ $labelStyle }}">Transaction ID</td>
                                <td style="{{ $valueStyle }}">{{ $order->reference }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $labelStyle }}">Payment Gateway</td>
                                <td style="{{ $valueStyle }}">{{ ucfirst($order->payment_method ?? 'Online Payment') }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $labelStyle }}">Product</td>
                                <td style="{{ $valueStyle }}">{{ $order->examType->name }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $labelStyle }}">Quantity</td>
                                <td style="{{ $valueStyle }}">{{ $order->quantity }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $labelStyle }}">Total Paid</td>
                                <td style="{{ $valueStyle }}">₦{{ number_format($order->amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td style="{{ $labelStyle }}">Date</td>
                                <td style="{{ $valueStyle }}">{{ $order->paid_at?->format('d-M-Y h:ia') }}</td>
                            </tr>
                        </table>

                        <!-- SECTION TITLE -->
                        <p style="margin:30px 0 15px 0;font-weight:bold;">
                            Purchased Scratch Cards
                        </p>

                        <!-- PINS TABLE -->
                        <table width="100%" cellpadding="10" cellspacing="0" role="presentation" style="border-collapse:collapse;font-size:14px;">
                            <tr>
                                <th align="left" style="border:1px solid #dcdcdc;background:#f1f3f5;">Product</th>
                                <th align="left" style="border:1px solid #dcdcdc;background:#f1f3f5;">Token</th>
                                <th align="left" style="border:1px solid #dcdcdc;background:#f1f3f5;">Serial No</th>
                            </tr>

                            @foreach($order->pins as $pin)
                                <tr>
                                    <td style="border:1px solid #dcdcdc;">
                                        {{ $order->examType->name }}
                                    </td>
                                    <td style="border:1px solid #dcdcdc;font-weight:bold;">
                                        {{ $pin->pin }}
                                    </td>
                                    <td style="border:1px solid #dcdcdc;font-weight:bold;">
                                        {{ $pin->serial_number }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <!-- FOOTER TEXT -->
                        <p style="margin:30px 0 5px 0;font-size:13px;color:#555;">
                            For inquiries and prompt assistance, send us a WhatsApp message via
                            <strong>{{ config('app.support_phone') }}</strong>
                            or email
                            <strong>{{ config('app.support_email') }}</strong>.
                        </p>

                        <p style="margin:15px 0 0 0;">
                            Regards,<br>
                            {{ config('app.name') }} Team
                        </p>

                    </td>
                </tr>
                <tr style="background: #f2f2f2;">
                    <td align="center" style="padding:20px 30px 30px 30px;font-size:12px;color:#999;">
                        © {{ now()->year }} {{ config('app.name') }}. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
