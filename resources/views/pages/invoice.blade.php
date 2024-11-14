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
                            <td>{{ $order->order_number }}<br />{{ $order->payment_time->format('d M, Y, h:i') }}
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
                                <h3 style="margin-block:0.5rem">{{ $order->payment_time->format('d M, Y, h:i') }}</h3>
                                <div>{{ $order->user->name }} <br />{{ $order->user->email }}
                                    <br />{{ $order->user->phone }}
                                </div>
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
                                <div style="text-align: center">
                                    <strong>Course name:</strong> {{ $order->course_name }} <br>
                                    <strong>Course duration:</strong> {{ $order->course_duration }}
                                    {{ $order->course_duration_type }} <br>
                                </div>
                                <div style="margin-top:1.5rem">
                                    <h3 style="margin-block: 0.5rem">Course Schedule:</h3>
                                    @foreach ($order->orderSchedule as $schedules)
                                        <strong>Course name:</strong> {{ $schedules->course_name }} <br>
                                        <strong>Course duration:</strong>
                                        {{ $schedules->duration }}{{ $schedules->duration_type }} <br>
                                        <strong>Batch:</strong>{{ $schedules->start_date->format('d M Y') }}
                                        {{ $schedules->time->format('h:i A') }} <br>
                                        <strong>Training mode:</strong>{{ $schedules->training_mode }}
                                        <p></p>
                                    @endforeach
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
                                <div>Rs. {{ $order->course_price }}/-</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:60%;"></td>
                            <td style="text-align: end">
                                <span><b>S.GST({{ (100 * $order->sgst) / $order->course_price }}%) :</b>
                                    &nbsp;&nbsp;</span>
                            </td>
                            <td style="text-align: end">
                                <div>Rs. {{ $order->sgst }}/-</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:60%;"></td>
                            <td style="text-align: end">
                                <span><b>C.GST({{ (100 * $order->cgst) / $order->course_price }}%) :</b>
                                    &nbsp;&nbsp;</span>
                            </td>
                            <td style="text-align: end">
                                <div>Rs. {{ $order->cgst }}/-</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:60%;"></td>
                            <td>
                                <span><b>Total :</b></span>
                            </td>
                            <td style="text-align: end">
                                <div>Rs. {{ $order->amount }}/-</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="text-align: center; padding-top: 30px;">Thank you for your order</div>
        <div style="text-align: center;"><b>{{ $order->order_number }}</b></div>
    </div>
</body>

</html>
