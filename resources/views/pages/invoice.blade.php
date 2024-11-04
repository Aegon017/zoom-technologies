<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 100%;
            margin: auto;
            padding: 10px;
            border: 1px solid #eee;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 5px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset('frontend/assets/img/logo.png'))) }}"
                                    style="width: 100%; max-width: 150px;" alt="Logo" />
                            </td>
                            <td>{{ $id }}<br />{{ \Carbon\Carbon::parse($payment_time)->format('d M, Y, h:i') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <h4>Zoom Technologies (India) Pvt. Ltd.</h4>
                                zoomtechnologies.company.site<br />GST registration number 36AAACZ0692A1ZK<br />Zoom
                                Technologies (India) Pvt. Ltd.<br />#205,2nd Floor,HUDA Maitrivanam,
                                Ameerpet<br />Hyderabad, Telangana 500038<br />India
                            </td>
                            <td>
                                <h4>Customer service</h4>
                                +91 90599 49865<br /><a style="color: #333;text-decoration: none;"
                                    href="mailto:ks@zoomgroup.com">ks@zoomgroup.com</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <hr>
                    <table>
                        <tr>
                            <td>
                                <h3>{{ \Carbon\Carbon::parse($payment_time)->format('d M, Y, h:i') }}</h3>
                                <div>{{ $name }} <br />{{ $email }} <br />{{ $phone }}</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="3">
                    <hr>
                    <table>
                        <tr>
                            <td>
                                <div>
                                    Course name: {{ $course_name }} <br>
                                    Course duration: {{ $course_duration }} {{ $course_duration_type }} <br>
                                    @php
                                        $courseSchedulesJson = html_entity_decode($course_schedule);
                                        $courseSchedulesArray = json_decode($courseSchedulesJson, true);
                                    @endphp
                                    @if ($courseSchedulesArray)
                                        Course Schedule: <br>
                                        @foreach ($courseSchedulesArray as $item)
                                            @php
                                                [$course_name, $course_time] = array_map('trim', explode(',', $item));
                                                [$date, $time, $mode] = array_map(
                                                    'trim',
                                                    explode(' ', $course_time),
                                                ) + ['Not specified'];

                                                $dateTimeObject = new DateTime("$date $time");
                                            @endphp
                                            <li style="margin-left: 2rem">{{ $course_name }}:
                                                {{ $dateTimeObject->format('d M Y h:i A') }}
                                                {{ $mode }}</li>
                                        @endforeach
                                    @else
                                        <div>
                                            @php
                                                [$course_name, $course_time] = array_map(
                                                    'trim',
                                                    explode(',', $course_schedule),
                                                );
                                                [$date, $time, $mode] = array_map(
                                                    'trim',
                                                    explode(' ', $course_time),
                                                ) + ['Not specified'];

                                                $dateTimeObject = new DateTime("$date $time");
                                            @endphp
                                            Course Schedule: {{ $dateTimeObject->format('d M Y h:i A') }} <br>
                                            Training Mode: {{ $mode }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td style="padding-top: 18px;">
                                <div></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="3">
                    <hr>
                    <table>
                        <tr>
                            <td style="width:60%;"></td>
                            <td style="text-align: end">
                                <span><b>Price :</b> &nbsp;&nbsp;</span>
                            </td>
                            <td style="text-align: end">
                                <div>Rs. {{ $course_price }}/-</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:60%;"></td>
                            <td style="text-align: end">
                                <span><b>S.GST(9%) :</b> &nbsp;&nbsp;</span>
                            </td>
                            <td style="text-align: end">
                                <div>Rs. {{ $sgst }}/-</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:60%;"></td>
                            <td style="text-align: end">
                                <span><b>C.GST(9%) :</b> &nbsp;&nbsp;</span>
                            </td>
                            <td style="text-align: end">
                                <div>Rs. {{ $cgst }}/-</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:60%;"></td>
                            <td>
                                <span><b>Total :</b></span>
                            </td>
                            <td style="text-align: end">
                                <div>Rs. {{ $total_price }}/-</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="text-align: center; padding-top: 30px;">Thank you for your order</div>
        <div style="text-align: center;"><b>{{ $id }}</b></div>
    </div>
</body>

</html>
