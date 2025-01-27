<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tax Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .invoice-box {
            margin: auto;
            padding: 5mm;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 5mm;
            border-bottom: 1px solid #000;
            padding-bottom: 3mm;
        }

        .logo {
            max-width: 30mm;
        }

        .company-details,
        .customer-details {
            margin-bottom: 3mm;
        }

        .section-title {
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 2mm;
            margin-bottom: 3mm;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
        }

        .schedule-table th,
        .schedule-table td {
            border: 1px solid #ddd;
            padding: 2mm;
            text-align: left;
        }

        .schedule-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .pricing-table {
            width: 100%;
            margin-top: 5mm;
        }

        .pricing-table tr td:last-child {
            text-align: right;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .footer {
            margin-top: 5mm;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 3mm;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <img src="{{ asset('frontend/assets/img/logo.png') }}" class="logo" alt="Logo" />
            <div class="text-right">
                <div class="bold" style="font-size: 14px;">TAX INVOICE</div>
                <div class="bold">Order No: {{ $order->order_number }}</div>
                <div>Date: {{ $order->payment->date }} {{ $order->payment->time }}</div>
            </div>
        </div>

        <div class="company-details">
            <div class="section-title">Seller Details</div>
            <div>
                <strong>Zoom Technologies (India) Pvt. Ltd.</strong><br>
                GST Registration No: 36AAACZ0692A1ZK<br>
                #205, 2nd Floor, HUDA Maitrivanam, Ameerpet<br>
                Hyderabad, Telangana 500038, India<br>
                Contact: +91 93911 91563 | Email: priya@zoomgroup.com
            </div>
        </div>

        <div class="customer-details">
            <div class="section-title">Customer Details</div>
            <div>
                <strong>Name:</strong> {{ $order->user->name }}<br>
                <strong>Email:</strong> {{ $order->user->email }}<br>
                <strong>Phone:</strong> {{ $order->user->phone }}<br>
                <strong>Address:</strong>
                @if ($address->address)
                    {{ $address->address }},
                @endif
                {{ $address->city }}, {{ $address->state }}
                @if ($address->zip_code)
                    - {{ $address->zip_code }}
                @endif,
                {{ $address->country }}
            </div>
        </div>

        <div>
            <div class="section-title">Course Details</div>
            <div class="text-center">
                <strong>Course:</strong> {{ $order->course->name ?? $order->package->name }}<br>
                <strong>Duration:</strong>
                {{ $order->course->duration ?? $order->package->duration }}
                {{ $order->course->duration_type ?? $order->package->duration_type }}
            </div>
        </div>
        <div>
            <div class="section-title">Course Schedule</div>
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Duration</th>
                        <th>Batch Start Date</th>
                        <th>Time</th>
                        <th>Training Mode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->schedule as $schedule)
                        <tr>
                            <td>{{ $schedule->course->name }}</td>
                            <td>
                                {{ $schedule->duration }}
                                {{ $schedule->duration_type }}
                            </td>
                            <td>{{ $schedule->start_date }}</td>
                            <td>{{ $schedule->time }}</td>
                            <td>{{ $schedule->training_mode }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <div class="section-title">Payment Details</div>
            <table class="pricing-table">
                <tr>
                    <td>Reference Number</td>
                    <td>{{ $order->payment->reference_number }}</td>
                </tr>
                <tr>
                    <td>Payment Mode</td>
                    <td>{{ $order->payment->method }}</td>
                </tr>
                <tr>
                    <td>Course Price</td>
                    <td>{{ $order->payment->currency }} {{ $order->courseOrPackage_price }}/-</td>
                </tr>
                <tr>
                    <td>SGST ({{ (100 * $order->sgst) / $order->courseOrPackage_price }}%)</td>
                    <td>{{ $order->payment->currency }} {{ $order->sgst }}/-</td>
                </tr>
                <tr>
                    <td>CGST ({{ (100 * $order->cgst) / $order->courseOrPackage_price }}%)</td>
                    <td>{{ $order->payment->currency }} {{ $order->cgst }}/-</td>
                </tr>
                <tr>
                    <td><strong>Total Amount</strong></td>
                    <td><strong>{{ $order->payment->currency }} {{ $order->payment->amount }}/-</strong></td>
                </tr>
            </table>
        </div>
        <div style="margin-top: 3mm;">
            <div class="section-title">Terms & Conditions</div>
            <ol style="font-size: 9px;">
                <li>The organization reserves the right to expel any student during the training period.</li>
                <li>Fees paid are non-refundable and cannot be transferred or adjusted against other courses, batches,
                    or students.</li>
                <li>Once a batch is allotted, it is final and cannot be changed. If a student fails to attend the
                    assigned batch, the fee paid will be forfeited.</li>
                <li>Any disputes will be subject to the jurisdiction of Hyderabad.</li>
                <li>Vehicles are kept at owners risk (Classroom).</li>
            </ol>
        </div>
        <div class="footer">
            <div>Thank you for your order</div>
            <div class="bold">{{ $order->order_number }}</div>
            <div>System-generated invoice. Signature not required.</div>
        </div>
    </div>
</body>

</html>
