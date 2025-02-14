<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            color: #007BFF;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.5;
            margin: 15px 0;
        }
        .email-body a {
            display: inline-block;
            background: #007BFF;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
        }
        .email-footer {
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="https://images.scalebranding.com/love-guru-logo-1f2e37cd-fa14-4782-9b92-b3029c6a9adc.jpg" alt="Your Company Logo" width="50%"  height="10%">
            <h1>Email Verification Mail</h1>
        </div>
        <div class="email-body">
            <p>Thank you for signing up! Please verify your email address by clicking the button below:</p>
            <a href="{{ url('account/verify', $token) }}" target="_blank">Verify Email</a>
            <p>If you did not request this, please ignore this email.</p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
