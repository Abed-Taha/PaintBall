<?php
require_once __DIR__ . "/../../../security/blockRoutes.php";
block(basename(__FILE__));

$sent = false;
$email = '';
if (isset($_GET['token'])) {
    $token = $_GET["token"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $toEmail = trim($_POST['email'] ?? '');

    if (!empty($toEmail) && empty($token)) {
        require_once "backend/actions/reset-passwordVerfication.php"; // your query builder
        $sent = true;
    }



}
if (!empty($token)) {
    $m = DB::select("email_verification")
        ->where("token", $token)
        ->first();
    $email = DB::select("users")
        ->where("id", $m["user_id"])
        ->first();
    $email = $email["email"];
}

?>

<title>Reset Password - PaintBall</title>
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

    .card {
        background-color: #8b5e3c;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
        padding: 40px;
        max-width: 500px;
        width: 100%;
        text-align: center;
    }

    h2 {
        color: #e0aa25;
        margin-bottom: 20px;
        font-size: 28px;
    }

    p {
        color: #dddddd;
        font-size: 15px;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    input {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        border: none;
        margin-bottom: 20px;
        font-size: 15px;
    }

    button {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        border: none;
        background-color: #e0aa25;
        color: #6e472c;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        color: #6e472c;
        background-color: #e0aa25;
        opacity: 0.85;
    }

    .resend {
        margin-top: 15px;
        background: none;
        border: 1px solid #e0aa25;
        color: #e0aa25;
    }
</style>

<div class="card">

    <?php if ($sent): ?>
        <!-- SUCCESS STATE -->
        <div style="font-size: 46px;">✉️</div>
        <h2>Email Sent</h2>
        <p>
            We have sent a verification email to <strong>
                <?= htmlspecialchars($email) ?>
            </strong>.
            Please check your inbox and follow the link.
        </p>

        <form method="POST">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <button type="submit" class="resend">Resend Email</button>
        </form>

    <?php elseif (!empty($token)): ?>
        <!-- TOKEN RECEIVED STATE -->
        <div style="font-size: 46px;">✅</div>
        <h2>Verification SUCCESS</h2>
        <form method="POST" action="backend/actions/resetPasswordAction.php">
            <input type="email" name="email" value="<?= $email ?>" readonly>
            <input type="hidden" name="token" value="true">
            <input type="password" placeholder="new_password" name="password">
            <input type="password" placeholder="confirm_password" name="confirm_password">
            <button type="submit" class="resend">Reset passsword</button>
        </form>

    <?php else: ?>
        <!-- EMAIL INPUT FORM -->
        <div style="font-size: 46px;">📧</div>
        <h2>Verify Your Email</h2>
        <p>x
            Enter your email address and we will send you a verification link.
        </p>

        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send Verification Email</button>
        </form>



    <?php endif; ?>

</div>