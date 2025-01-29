<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            width: 297mm;
            height: 210mm;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .certificate_main_div {
            position: relative;
            width: 100%;
            height: 100%;
            background-image: url({{ asset('frontend/assets/img/Certificate-bg-image.png') }});
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .certificate_name {
            position: absolute;
            top: 36.5%;
            font-size: 60px;
            font-weight: 500;
            color: #0e48e9;
            text-align: center;
            width: 100%;
            letter-spacing: 3px;
        }

        .certificate_course_name {
            position: absolute;
            top: 58%;
            font-size: 27px;
            font-weight: 400;
            color: #ff6a10;
            text-align: center;
            width: 100%;
        }

        .certificate_course_duration {
            position: absolute;
            top: 63.5%;
            font-size: 20px;
            font-weight: 600;
            color: #202938;
            text-align: center;
            width: 100%;
        }

        .certificate_reference_no {
            position: absolute;
            bottom: 18.9%;
            font-size: 20px;
            font-weight: 600;
            color: #323a48;
            left: 58%;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="certificate_main_div">
        <h1 class="certificate_name">Mr. {{ $userName }}</h1>
        <h3 class="certificate_course_name">{{ $courseName }}</h3>
        <h4 class="certificate_course_duration">{{ Carbon\Carbon::parse($batchDate)->format('F d, Y') }} -
            {{ $endDate->format('F d, Y') }}
        </h4>
        <h5 class="certificate_reference_no">{{ $receiptNo }}</h5>
    </div>
</body>

</html>
