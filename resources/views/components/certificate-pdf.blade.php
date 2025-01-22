<html>

<head>
    <title>
        Certificate
    </title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fff;
        }

        .certificate {
            border: 40px solid red;
            padding: 40px;
            text-align: center;
            position: relative;
            margin: 0px;
        }

        .certificate h1 {
            font-size: 40px;
            margin: 0;
            font-family: "Catamaran", serif;
            font-weight: 500;
            color: #034a9a;
        }

        .certificate img {
            padding: 20px 0px 40px 0px;
        }

        .certificate p {
            margin: 0px 0;
            font-size: 22px;
            font-family: "Catamaran", serif;
            font-weight: 500;
        }

        .certificate h2 {
            font-size: 26px;
            margin: 0;
            font-family: "Catamaran", serif;
            font-weight: 600;
        }

        .certificate .details {
            font-size: 18px;
            margin: 20px 0;
        }

        .certificate .signature {
            display: flex;
            align-items: flex-end;
            flex-direction: column;
        }

        .certificate .signature img {
            width: 200px;
            height: 100px;
            padding: 0px;
        }

        .certificate .footer {
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <h1>
            Zoom Education Certificate
        </h1>
        <img src="http://localhost/frontend/assets/img/logo.png" alt="">
        <p>
            This is to certify that
            <strong>
                Mr./Ms. {{ $certificate->user->name }}
            </strong>
        </p>
        <p>
            Has successfully completed the Course in
        </p>
        <h2>
            {{ $cert->course->name }}
        </h2>
        <div class="details">
            @php
                $startDate = Carbon\Carbon::parse($cert->start_date);
                $duration = $cert->duration;
                $durationType = $cert->duration_type;
                $endDate = $startDate->clone();

                switch ($durationType) {
                    case 'Day':
                        $endDate = $endDate->addDays($duration);
                        break;
                    case 'Week':
                        $endDate = $endDate->addWeeks($duration);
                        break;
                    case 'Month':
                        $endDate = $endDate->addMonths($duration);
                        break;
                    default:
                        $endDate = null;
                        break;
                }
            @endphp
            <p>
                Start Date: {{ $startDate->format('d M Y') }} &nbsp;&nbsp;&nbsp;
                End Date: {{ $endDate ? $endDate->format('d M Y') : 'N/A' }}
            </p>
            <p>
                Reference No. ZTT35 at Virtual Education Center.
            </p>
        </div>
        <div class="signature">
            <img alt="Signature of Course Co-Ordinator"
                src="{{ asset(Storage::url($cert->course->courseCoordinator->signature_image)) }}" />
            <p>
                Course Co-Ordinator
            </p>
        </div>
        <div class="footer">
            <p>
                {{ $companyAddress->location }}
            </p>
        </div>
    </div>
</body>

</html>
