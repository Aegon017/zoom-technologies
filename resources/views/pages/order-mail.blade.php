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
                    {{ $order->order_number }}</a> placed on {{ $order->payment->date->format('d M Y') }}
                {{ $order->payment->time->format('h:i A') }} has been successfully
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
                        <td>{{ $order->course->name }}</td>
                        <td>Rs. {{ $order->course->actual_price }}/-</td>
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
                            <td>{{ $schedule->start_date->format('d M Y') }} {{ $schedule->time->format('h:i A') }}
                            </td>
                            <td>{{ $schedule->training_mode }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table">
                <tbody>
                    <tr>
                        <td>Subtotal:</td>
                        <td>Rs. {{ $order->course->actual_price }}/-</td>
                    </tr>
                    <tr>
                        <td>Payment mode:</td>
                        <td>{{ $order->payment->mode ?? 'None' }}</td>
                    </tr>
                    <tr>
                        <td>Taxes (18%):</td>
                        <td>
                            C.GST({{ 100 / ($order->course->actual_price / $order->cgst) }}%): Rs.
                            {{ $order->cgst }}/-<br>
                            S.GST({{ 100 / ($order->course->actual_price / $order->sgst) }}%): Rs.
                            {{ $order->sgst }}/-
                        </td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td>Rs. {{ $order->payment->amount }}/-</td>
                    </tr>
                </tbody>
            </table>

            <p>Thank you for your purchase! We hope you enjoy your experience.</p>
            <p>Sincerely,<br /><strong>Zoom Technologies Team</strong></p>
        </div>
    @else
        <div class="content">
            <p>Dear <strong>{{ $order->user->name }}</strong>,</p>
            <p>We regret to inform you that your order <a href="#">with order number:
                    {{ $order->order_number }}</a> placed on {{ $order->payment->date->format('d M Y') }}
                {{ $order->payment->time->format('h:i A') }} has not been processed due
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
                        <td>{{ $order->course->name }}</td>
                        <td>Rs. {{ $order->course->actual_price }}/-</td>
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
                            <td>{{ $schedule->start_date->format('d M Y') }} {{ $schedule->time->format('h:i A') }}
                            </td>
                            <td>{{ $schedule->training_mode }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table">
                <tbody>
                    <tr>
                        <td>Subtotal:</td>
                        <td>Rs. {{ $order->course->actual_price }}/-</td>
                    </tr>
                    <tr>
                        <td>Payment mode:</td>
                        <td>{{ $order->payment->mode ?? 'None' }}</td>
                    </tr>
                    <tr>
                        <td>Taxes (18%):</td>
                        <td>
                            C.GST({{ 100 / ($order->course->actual_price / $order->cgst) }}%): Rs.
                            {{ $order->cgst }}/-<br>
                            S.GST({{ 100 / ($order->course->actual_price / $order->sgst) }}%): Rs.
                            {{ $order->sgst }}/-
                        </td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td>Rs. {{ $order->payment->amount }}/-</td>
                    </tr>
                </tbody>
            </table>

            <p>Thank you for your understanding.</p>
            <p>Sincerely,<br /><strong>Zoom Technologies Team</strong></p>
        </div>
    @endif

    <div class="footer">
        <p>© 2024 Zoom Technologies. All rights reserved.</p>
        <p>
            <a href="#">Terms</a> | <a href="#">Privacy</a>
        </p>
    </div>
</body>

</html>
