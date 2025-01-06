<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <title>Order Payment Notification</title>
    <style>
        /* public/css/style.css */
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
        <h3 class="mt-3">Your Account Has Been Created</h3>
    </div>
    <div class="content">
        <p>Dear <strong>{{ $user->name }}</strong>,</p>
        <p>We are excited to welcome you to zoom technologies!</p>
        <p>Your account has been successfully created, and here are your login details:</p>
        <p>Username: {{ $user->email }}</p>
        <p>Password: {{ $password }}</p>
        <p>Please keep your login details safe. You can now log in to your account and begin using our services.</p>
        <p>Log in here: {{ route('login') }}</p>
        <p>If you have any questions or need assistance, feel free to contact our support team at support@zoomgroup.com.
        </p>
        <p>Thank you for registering with us!</p>
        <p>Sincerely,<br /><strong>Zoom Technologies Team</strong></p>
    </div>
    <div class="footer">
        <p>© 2025 Zoom Technologies. All rights reserved.</p>
        <p>
            <a href="#">Terms</a> | <a href="#">Privacy</a>
        </p>
    </div>
</body>

</html>
