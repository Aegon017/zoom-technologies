<html>

<head>
    <title>Certificate</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            background-color: #f7f7f7;
        }

        .certificate {
            /* height: 297mm; */
            border: 30px solid #B03A2E;
            padding: 50px;
            background-color: #ffffff;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-family: 'Times New Roman', serif;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            line-height: 1.6;
            overflow: hidden;
        }

        .certificate h1 {
            font-size: 48px;
            font-weight: bold;
            color: #B03A2E;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .certificate h2 {
            font-size: 36px;
            color: #5D6D7E;
            font-weight: normal;
            text-transform: capitalize;
        }

        .certificate p {
            font-size: 18px;
            line-height: 1.6;
            color: #4A4A4A;
            margin: 10px 0;
        }

        .certificate .details {
            text-align: left;
            width: 100%;
            margin-top: 20px;
            font-size: 16px;
            color: #333;
            margin-left: 50px;
        }

        .certificate .details p {
            margin: 8px 0;
        }

        .certificate .details strong {
            color: #B03A2E;
        }

        .certificate .signature {
            margin-top: 20px;
            width: 100%;
            text-align: right;
        }

        .certificate .signature img {
            width: 180px;
            margin-bottom: 10px;
        }

        .certificate .signature .coordinator {
            font-size: 16px;
            font-style: italic;
            color: #5D6D7E;
        }

        .certificate .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            width: 100%;
        }

        .certificate .footer img {
            width: 120px;
            margin: 10px 0;
        }

        .certificate .footer .address {
            font-size: 16px;
            color: #444;
            margin-bottom: 5px;
        }

        .certificate .footer .website {
            color: #B03A2E;
            font-weight: 600;
        }

        @media print {
            body {
                display: block;
                margin: 0;
                padding: 0;
            }

            .certificate {
                box-shadow: none;
                page-break-before: always;
            }
        }

        .logo {
            max-width: 30mm;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <h1>Zoom Education Certificate</h1>
        <img src="{{ asset('frontend/assets/img/logo.png') }}" class="logo" />
        <p>This is to certify that</p>
        <p style="font-size: 26px; font-weight: 600;">Mr. Dipti Ranjan Rout</p>
        <p>Has successfully completed the course in</p>
        <h2>Microsoft Azure</h2>

        <div class="details">
            <p><strong>Start Date:</strong> 30-10-2024</p>
            <p><strong>End Date:</strong> 14-11-2024</p>
            <p><strong>Reference No.:</strong> ZTT35 at Virtual Education Center</p>
        </div>

        <div class="signature">
            <img src="{{ asset('frontend/assets/img/logo.png') }}" class="logo" alt="Logo" />
            <div class="coordinator">
                <p>Course Co-Ordinator</p>
            </div>
        </div>

        <div class="footer">
            <div class="address">
                <p>Above HDFC Bank, Road No.12, Banjara Hills, Hyderabad - 500 034, INDIA</p>
            </div>
            <div class="website">
                <p>www.zoomgroup.com</p>
            </div>
        </div>
    </div>
</body>

</html>
