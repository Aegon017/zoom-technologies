<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <style>
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

        .header .company-logo {
            display: inline-block;
            vertical-align: middle;
        }

        .header .company-logo img {
            width: 10rem;
        }

        .header .company-name {
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
            font-size: 24px;
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

        .content p {
            font-size: 16px;
            line-height: 1.5;
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

        .content .billing-address {
            margin-top: 20px;
        }

        .content .billing-address h3 {
            color: #fd630d;
            font-size: 20px;
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

        .footer .company-logo {
            display: block;
            margin: 10px auto;
        }

        .footer .company-logo img {
            width: 40px;
            height: 40px;
        }

        .footer .mailer-logo {
            display: block;
            margin: 10px auto;
        }

        .footer .mailer-logo img {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-logo">
            <img alt="Logo" class="logo" src="{{ asset('frontend/assets/img/logo.png') }}" />
        </div>
        <h3 class="mt-3">New Enrollment Notification for {{ $order->course_name }}</h3>
    </div>

    <div class="content">
        <p>Dear Admin,</p>
        <p>We are pleased to inform you that a new student has enrolled in your course:</p>
        <p><strong>Course Name:</strong> {{ $order->course_name }}</p>
        <p><strong>Batch:</strong> @php
            $courseSchedulesJson = html_entity_decode($order->course_schedule);
            $courseSchedulesArray = json_decode($courseSchedulesJson, true);
        @endphp
            @if ($courseSchedulesArray)
                @foreach ($courseSchedulesArray as $item)
                    @php
                        [$course_name, $course_time] = array_map('trim', explode(',', $item));
                        [$date, $time, $mode] = array_map('trim', explode(' ', $course_time)) + ['Not specified'];

                        $dateTimeObject = new DateTime("$date $time");
                    @endphp
                    <br>{{ $course_name }}:
                    {{ $dateTimeObject->format('d M Y h:i A') }}
                    {{ $mode }}
                @endforeach
            @else
                @php
                    [$course_name, $course_time] = array_map('trim', explode(',', $order->course_schedule));
                    [$date, $time, $mode] = array_map('trim', explode(' ', $course_time)) + ['Not specified'];

                    $dateTimeObject = new DateTime("$date $time");
                @endphp
                {{ $dateTimeObject->format('d M Y h:i A') }} <br>
                Training Mode: {{ $mode }}
            @endif
        </p>
        <p><strong>Enrolled Student:</strong> {{ $order->user->name }}</p>
        <p><strong>Student email:</strong> {{ $order->user->email }}</p>
        <p><strong>Student phone:</strong> {{ $order->user->phone }}</p>
        <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
        <p><strong>Enrollment Date:</strong> {{ $order->payment_time }}</p>
        <p><strong>Payment Details:</strong></p>
        <table>
            <tbody>
                <tr>
                    <td>Price:</td>
                    <td>Rs. {{ $order->course_price }}/-</td>
                </tr>
                <tr>
                    <td>Payment Method:</td>
                    <td>
                        @if ($order->payment_mode)
                            {{ $order->payment_mode }}
                        @else
                            none
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Taxes (18%):</td>
                    <td>
                        C.GST (9%): Rs. {{ $order->cgst }}/-<br>
                        S.GST (9%): Rs. {{ $order->sgst }}/-
                    </td>
                </tr>
                <tr>
                    <td>Total Amount:</td>
                    <td>Rs. {{ $order->amount }}/-</td>
                </tr>
            </tbody>
        </table>
        <p>Thank you for being a part of our educational community! Please ensure the student receives all necessary
            materials to start their course.</p>
        <p>Best regards,<br /><strong>Zoom Technologies Team</strong></p>
    </div>

    <div class="footer">
        <p>© 2024 Zoom Technologies. All rights reserved.</p>
        <p>
            <a href="#">Terms</a> | <a href="#">Privacy</a>
        </p>
    </div>

</body>