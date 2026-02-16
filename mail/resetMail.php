<?php
require_once __DIR__ . '/mailProvider.php'; // Composer autoload
        $resetLink = "http://localhost:8001/reset-password?token=" . $token;

        $Body = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: Arial, sans-serif;
            background-color: #c19066;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #c19066;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #6e472c;
            color: white;
            text-align: center;
            padding: 30px;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 30px;
            color: #333333;
            font-size: 16px;
            line-height: 1.6;
        }

        .content h1 {
            color: #e0aa25;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            margin: 20px 0;
            background-color: #e0aa25;
            color: #8b5e3c;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #6e472c;
            padding: 20px;
        }

        @media screen and (max-width: 600px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            Password Reset Request
        </div>
        <div class="content">
            <h1>Hello!</h1>
            <p>We received a request to reset your password. Click the button below to create a new password.</p>
            <a href="' . $resetLink . '" class="button">Reset Password</a>
            <p>If you did not request a password reset, you can safely ignore this email.</p>
        </div>
        <div class="footer">
            &copy; ' . date("Y") . ' PaintBall World. All rights reserved.
        </div>
    </div>
</body>

</html>
';

sendVerificationEmail($toEmail, $Body);