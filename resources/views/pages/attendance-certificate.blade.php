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

        .certify_that {
            position: absolute;
            top: 32%;
            font-size: 22px;
            font-weight: 900;
            color: #1f2837;
            text-align: center;
            width: 100%;
            letter-spacing: 3px;

        }

        .certificate_name {
            position: absolute;
            top: 38%;
            font-size: 52px;
            font-weight: 600;
            color: #0f3ecd;
            text-align: center;
            width: 100%;
            letter-spacing: 3px;
        }

        .has_completed {
            position: absolute;
            top: 53%;
            font-size: 22px;
            font-weight: 600;
            color: #1f2837;
            text-align: center;
            width: 100%;
        }

        .certificate_course_name {
            position: absolute;
            top: 57%;
            font-size: 24px;
            font-weight: 600;
            color: #ff6a10;
            text-align: center;
            width: 100%;
        }

        .certificate_course_duration {
            position: absolute;
            top: 61%;
            font-size: 24px;
            font-weight: 600;
            color: #1f2837;
            text-align: center;
            width: 100%;
        }

        .certificate_reference_no {
            position: absolute;
            bottom: 21%;
            font-size: 22px;
            font-weight: 600;
            color: #1f2837;
            text-align: center;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="certificate_main_div">
        <h2 class="certify_that">This is to certify that</h2>
        <h1 class="certificate_name">{{ $userName }}</h1>
        <h2 class="has_completed">has Completed</h2>
        <h3 class="certificate_course_name">{{ $courseName }}</h3>
        <h4 class="certificate_course_duration">{{ Carbon\Carbon::parse($batchDate)->format('F d, Y') }} -
            {{ Carbon\Carbon::parse($endDate)->format('F d, Y') }}
        </h4>
        <h5 class="certificate_reference_no">Reference No. {{ $receiptNo ?? $orderNumber }}</h5>
    </div>
</body>

</html>
