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
        <h3 class="mt-3">Your Training Session Details - {{ $order->course_name }}</h3>
    </div>

    <div class="content">
        <p>Dear <strong>{{ $order->user->name }}</strong>,</p>
        <p>We are pleased to inform you that your order with order number:
            <strong>{{ $order->order_number }}</strong>, placed on <strong>{{ $order->payment_time }}</strong>, has
            been successfully processed.
        </p>
        <p>This email contains the details of your upcoming training sessions. Please find the
            <strong>{{ $order->course_name }}</strong> course session information below:
        </p>
        @foreach ($order->orderSchedule as $schedules)
            <h3>{{ $schedules->course_name }}:</h3>
            <p>Batch: {{ $schedules->start_date->format('d M Y') }} {{ $schedules->time->format('h:i A') }}</p>
            <p>Training Mode: {{ $schedules->training_mode }}</p>
            @if ($schedules->training_mode == 'Online')
                @if ($schedules->zoom_meeting_url && $schedules->meeting_id && $schedules->meeting_password)
                    <p>Zoom Meeting Link: <a href="{{ $schedules->zoom_meeting_url }}">Click here to join
                            the meeting</a></p>
                    <p>Meeting ID: {{ $schedules->meeting_id }}</p>
                    <p>Meeting Password: {{ $schedules->meeting_password }}</a></p>
                @else
                    <p><strong>Zoom details are missing. Please contact our customer support.</strong></p>
                @endif
            @endif
            <hr>
        @endforeach
        <p>Thank you for your purchase! We hope you enjoy your experience.</p>
        <p>Sincerely,<br /><strong>Zoom Technologies Team</strong></p>
    </div>

    <div class="footer">
        <p>© 2024 Zoom Technologies. All rights reserved.</p>
        <p>
            <a href="#">Terms</a> | <a href="#">Privacy</a>
        </p>
    </div>
</body>

</html>
