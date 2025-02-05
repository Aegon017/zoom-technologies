<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Order Payment Notification</title>
    <style>
        /* public/css/style.css */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .header {
            background-color: white;
            padding: 20px;
            text-align: center;
            color: black;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header .company-logo img {
            width: 10rem;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .content h2 {
            color: #fd630d;
            font-size: 24px;
        }

        .content table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .content table,
        .content th,
        .content td {
            border: 1px solid #ddd;
        }

        .content th,
        .content td {
            padding: 8px;
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #fd630d;
            text-decoration: none;
            margin: 0 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-logo">
            <img alt="Logo" class="logo" src="{{ asset('frontend/assets/img/logo.png') }}" />
        </div>
        <h3 class="mt-3">Order payment {{ $order->payment->status }} notification</h3>
    </div>

    @if ($order->payment->status == 'success')
        <div class="content">
            <p>Dear <strong>{{ $order->user->name }}</strong>,</p>
            <p>We are pleased to inform you that your order <a href="#">with order number:
                    {{ $order->order_number }}</a> placed on {{ $order->payment->date }}
                {{ $order->payment->time }} has been successfully
                processed.</p>
            <p>Here are the details of your order:</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Course name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->course->name ?? $order->package->name }}</td>
                        <td>{{ $order->payment->currency }}
                            {{ rtrim(rtrim(number_format($order->courseOrPackage_price, 3, '.', ''), '0'), '.') }}/-
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Batch</th>
                        <th>Training Mode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->schedule as $schedule)
                        <tr>
                            <td>{{ $schedule->course->name }}</td>
                            <td>{{ $schedule->start_date }} {{ $schedule->time }}
                            </td>
                            <td>{{ $schedule->training_mode }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table">
                <tbody>
                    <tr>
                        <td>Payment mode:</td>
                        <td>{{ $order->payment->method ?? 'None' }}</td>
                    </tr>
                    <tr>
                        <td>Subtotal:</td>
                        <td>{{ $order->payment->currency }}
                            {{ rtrim(rtrim(number_format($order->courseOrPackage_price, 3, '.', ''), '0'), '.') }}/-
                        </td>
                    </tr>
                    <tr>
                        <td>Discount @if ($order->payment->coupon)
                                ( {{ $order->payment->coupon->code }} )
                            @endif:</td>
                        <td>- {{ $order->payment->currency }}
                            {{ rtrim(rtrim(number_format($order->discount, 3, '.', ''), '0'), '.') }}/-
                        </td>
                    </tr>
                    <tr>
                        <td>Taxes:</td>
                        <td>
                            CGST ({{ (100 * $order->cgst) / ($order->courseOrPackage_price - $order->discount) }}%):
                            {{ $order->payment->currency }}
                            {{ rtrim(rtrim(number_format($order->cgst, 3, '.', ''), '0'), '.') }}/-<br>
                            SGST ({{ (100 * $order->sgst) / ($order->courseOrPackage_price - $order->discount) }}%):
                            {{ $order->payment->currency }}
                            {{ rtrim(rtrim(number_format($order->sgst, 3, '.', ''), '0'), '.') }}/-
                        </td>
                    </tr>
                    <tr>
                        <td>Total Price:</td>
                        <td>{{ $order->payment->currency }} {{ $order->payment->amount }}/-</td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-2">
                {!! $thankyou->content !!}
            </div>
            <h3 class="text-orange mt-2 mb-0">{{ $thankyou->heading }}</h3>
            <p class="mt-1">{{ $thankyou->sub_heading }}<br>
                <i class="fas fa-envelope"></i> <strong>Email:</strong>
                @foreach ($thankyou->email as $email)
                    @php
                        $mail = App\Models\Email::find($email)->email;
                    @endphp
                    <a href="mailto:{{ $mail }}" style="color: #007bff;">{{ $mail }}</a>
                @endforeach
                <br>
                <i class="fas fa-mobile-alt"></i> <strong>Phone:</strong>
                @foreach ($thankyou->mobile as $mobile)
                    @php
                        $number = App\Models\MobileNumber::find($mobile)->number;
                    @endphp
                    <a href="tel:{{ $number }}" style="color: #007bff;">{{ $number }}</a>
                @endforeach
            </p>
            <p>Thank you for your purchase! We hope you enjoy your experience.</p>
            <p>Sincerely,<br /><strong>Zoom Technologies Team</strong></p>
        </div>
    @else
        <div class="content">
            <p>Dear <strong>{{ $order->user->name }}</strong>,</p>
            <p>We regret to inform you that your order <a href="#">with order number:
                    {{ $order->order_number }}</a> placed on {{ $order->payment->date }}
                {{ $order->payment->time }} has not been processed due
                to a payment {{ $order->payment->status }}. This occurred because of
                {{ $order->payment->description }}.</p>
            <p>Here are the details of your order:</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->course->name ?? $order->package->name }}</td>
                        <td>{{ $order->payment->currency }}
                            {{ rtrim(rtrim(number_format($order->courseOrPackage_price, 3, '.', ''), '0'), '.') }}/-
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Batch</th>
                        <th>Training Mode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->schedule as $schedule)
                        <tr>
                            <td>{{ $schedule->course->name }}</td>
                            <td>{{ $schedule->start_date }} {{ $schedule->time }}
                            </td>
                            <td>{{ $schedule->training_mode }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table">
                <tbody>
                    <tr>
                        <td>Payment mode:</td>
                        <td>{{ $order->payment->method ?? 'None' }}</td>
                    </tr>
                    <tr>
                        <td>Subtotal:</td>
                        <td>{{ $order->payment->currency }}
                            {{ rtrim(rtrim(number_format($order->courseOrPackage_price, 3, '.', ''), '0'), '.') }}/-
                        </td>
                    </tr>
                    <tr>
                        <td>Discount @if ($order->payment->coupon)
                                ( {{ $order->payment->coupon->code }} )
                            @endif:</td>
                        <td>- {{ $order->payment->currency }}
                            {{ rtrim(rtrim(number_format($order->discount, 3, '.', ''), '0'), '.') }}/-
                        </td>
                    </tr>
                    <tr>
                        <td>Taxes:</td>
                        <td>
                            CGST ({{ (100 * $order->cgst) / ($order->courseOrPackage_price - $order->discount) }}%):
                            {{ $order->payment->currency }}
                            {{ rtrim(rtrim(number_format($order->cgst, 3, '.', ''), '0'), '.') }}/-<br>
                            SGST ({{ (100 * $order->sgst) / ($order->courseOrPackage_price - $order->discount) }}%):
                            {{ $order->payment->currency }}
                            {{ rtrim(rtrim(number_format($order->sgst, 3, '.', ''), '0'), '.') }}/-
                        </td>
                    </tr>
                    <tr>
                        <td>Total Price:</td>
                        <td>{{ $order->payment->currency }} {{ $order->payment->amount }}/-</td>
                    </tr>
                </tbody>
            </table>
            <p>
                For any further assistance or query feel free to reach out to us by Call/ WhatsApp at +91 9391191563 or
                emailing us at priya@zoomgroup.com
            </p>
            <p>Thank you for your understanding.</p>
            <p>Sincerely,<br /><strong>Zoom Technologies Team</strong></p>
        </div>
    @endif

    <div class="footer">
        <p>© 2025 Zoom Technologies. All rights reserved.</p>
        <p>
            <a href="#">Terms</a> | <a href="#">Privacy</a>
        </p>
    </div>
</body>

</html>
