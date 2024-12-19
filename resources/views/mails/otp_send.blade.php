<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
            background-color: #007bff;
            color: #ffffff;
            border-radius: 8px 8px 0 0;
        }
        .content {
            margin: 20px 0;
            text-align: center;
        }
        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Password Reset Request</h2>
        </div>
        <div class="content">
            <p>Hello {{ $email }},</p>
            <p>You requested to reset your password. Use the following OTP to complete the process:</p>
            <p class="otp">{{ $otp }}</p>
            <p>This OTP is valid for 10 minutes.</p>
        </div>
        <div class="footer">
            <p>If you didn't request a password reset, please ignore this email.</p>
            <p>Please do not reply to this message. This e-mail is confidential and may also be privileged</p>
            <p>Thank you, Applo Now </p>
        </div>
    </div>
</body>
</html>
