<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Attendance Certificate</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .certificate-container {
            background-color: #f4f4f4;
            margin: 50px auto;
            padding: 40px;
            border: 5px solid #0054a3;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }

        .certificate-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .certificate-header h1 {
            font-size: 36px;
            color: #fd5222;
            margin: 0;
        }

        .certificate-header h2 {
            font-size: 24px;
            margin: 5px 0;
        }

        .certificate-body {
            text-align: center;
            margin: 30px 0;
        }

        .certificate-body p {
            font-size: 20px;
            margin: 10px 0;
        }

        .certificate-footer {
            text-align: center;
            margin-top: 50px;
            font-size: 16px;
        }

        .signature {
            display: inline-block;
            margin-top: 30px;
            font-style: italic;
            text-decoration: underline;
            font-size: 18px;
        }

        .instructor-name {
            font-size: 18px;
            margin-top: 10px;
        }

        .date {
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="certificate-container">
        <div class="certificate-header">
            <h1>Certificate of Attendance</h1>
            <h2>Presented to</h2>
        </div>

        <div class="certificate-body">
            <p><strong>{{ $userName }}</strong></p>
            <p>For attending the course</p>
            <p><strong>{{ $courseName }}</strong></p>
            <p>Batch: <strong>{{ $batchDate->format('d M Y') }},
                    {{ $batchTime->format('h:i A') }}</strong></p>
            <p>Training mode: <strong>{{ $trainingMode }}</strong></p>
        </div>

        <div class="certificate-footer">
            <div class="signature">
                <p>Instructor's Signature:</p>
            </div>
            <div class="instructor-name">
                <p><strong>Instructor</strong></p>
            </div>
            <div class="date">
                <p>{{ today()->format('d M Y') }}</p>
            </div>
        </div>
    </div>

</body>

</html>
