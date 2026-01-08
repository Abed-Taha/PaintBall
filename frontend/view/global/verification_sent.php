<?php
require_once __DIR__ . "/../../../security/blockRoutes.php";
block(basename(__FILE__));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Sent</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #6e472c;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            background-color: #8b5e3c;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            border: 1px solid #3d3d3d;
        }

        .card h2 {
            color: #e0aa25; /* Gold/Orange accent */
            margin-bottom: 20px;
            font-size: 28px;
        }

        .card p {
            color: #cccccc;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }


        .icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: #e0aa25;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="icon">✉️</div>
        <h2>Verification Email Sent</h2>
        <p>
            We have sent a verification email to your address. Please check your inbox and click the link to verify your account.
        </p>
        
        <div style="margin-top: 20px;">
            <p style="font-size: 14px; margin-bottom: 10px;">Didn't receive the email?</p>
            <form action="/backend/actions/resend_verification.php" method="POST">
                <button type="submit" style="
                    background: none;
                    border: 1px solid #e0aa25;
                    color: #e0aa25;
                    padding: 8px 16px;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 14px;
                    transition: all 0.3s ease;
                " onmouseover="this.style.background='#e0aa25'; this.style.color='#6e472c'" 
                  onmouseout="this.style.background='none'; this.style.color='#e0aa25'">
                    Resend Verification Link
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
