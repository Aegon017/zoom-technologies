@php
    // Decode the JSON content of the course_schedule
    $courseSchedulesJson = html_entity_decode($order->course_schedule);
    $courseSchedulesArray = json_decode($courseSchedulesJson, true);
@endphp

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
        <h3 class="mt-3">Your Training Session Details – {{ $order->course_name }}</h3>
    </div>

    <div class="content">
        <p>Dear <strong>{{ $order->user->name }}</strong>,</p>
        <p>We are pleased to inform you that your order with order number:
            <strong>{{ $order->order_number }}</strong>, placed on <strong>{{ $order->payment_time }}</strong>, has
            been successfully processed.
        </p>
        <p>This email contains the details of your upcoming training sessions. Please find the session information
            below:</p>
        @if (is_array($courseSchedulesArray) && count($courseSchedulesArray) > 1)
            <h4>Courses Included in Your Package:</h4>
            @foreach ($courseSchedulesArray as $course)
                @php
                    [$course_name, $course_time] = array_map('trim', explode(',', $course));
                    [$date, $time, $mode] = array_map('trim', explode(' ', $course_time)) + ['Not specified'];
                    $dateTimeObject = new DateTime("$date $time");
                    $schedule = $schedules
                        ->where('start_date', $date)
                        ->where('time', $time)
                        ->where('training_mode', $mode)
                        ->whereHas('course', fn($query) => $query->where('name', $course_name))
                        ->first();
                @endphp
                <h3>{{ $course_name }}:</h3>
                <p>Date and Time: {{ $dateTimeObject->format('d M Y h:i A') }}</p>
                @if ($mode == 'Online')
                    <p>Training Mode: {{ $mode }}</p>
                    <p>Zoom Meeting Link: <a href="{{ $schedule->zoom_meeting_url }}">Click here to join the meeting</a>
                    </p>
                    <p>Meeting ID: {{ $schedule->meeting_id }}</p>
                    <p>Passcode: {{ $schedule->meeting_password }}</p>
                @else
                    <p>Training Mode: {{ $mode }}</p>
                @endif
                <hr>
            @endforeach
        @else
            @php
                $course = $order->course_schedule;
                [$course_name, $course_time] = array_map('trim', explode(',', $course));
                [$date, $time, $mode] = array_map('trim', explode(' ', $course_time)) + ['Not specified'];
                $dateTimeObject = new DateTime("$date $time");
                $schedule = $schedules
                    ->where('start_date', $date)
                    ->where('time', $time)
                    ->where('training_mode', $mode)
                    ->whereHas('course', fn($query) => $query->where('name', $course_name))
                    ->first();
            @endphp
            <h4>Course Included in Your Order:</h4>
            <h3>{{ $course_name }}:</h3>
            <p>Date and Time: {{ $dateTimeObject->format('d M Y h:i A') }}</p>
            @if ($mode == 'Online')
                <p>Training Mode: {{ $mode }}</p>
                <p>Zoom Meeting Link: <a href="{{ $schedule->zoom_meeting_url }}">Click here to join the meeting</a>
                </p>
                <p>Meeting ID: {{ $schedule->meeting_id }}</p>
                <p>Passcode: {{ $schedule->meeting_password }}</p>
            @else
                <p>Training Mode: {{ $mode }}</p>
            @endif
        @endif
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
