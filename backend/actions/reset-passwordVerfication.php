<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();
require_once __DIR__ . "/../../env/host.php"; // your query builder
require_once __DIR__ . "/../../env/DTO.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$email = $_POST['email'] ?? '';

if (!$email) {
    DTO::session_error("Email is required.");
    header("Location: /reset-password");
    exit;
}

// Check user
$user = DB::select("users")->where("email", $email)->first();

if (!$user) {
    DTO::session_error("If the email exists, a reset link was sent.");
}

// Remove old tokens (optional but recommended)
DB::table('email_verification')
    ->where('email', $email)
    ->delete();

// Create token
$token = bin2hex(random_bytes(32));
$hashedToken = password_hash($token, PASSWORD_DEFAULT);
$expiredAt = date("Y-m-d H:i:s", strtotime("+10 minutes"));

// Store token
DB::table('email_verification')->insert([
    'email' => $email,
    'token' => $token,
    'user_id' => $user['id'],
    'expired_at' => $expiredAt
]);

// Send reset email
require_once __DIR__ . "/../../mail/resetMail.php"; // your query builder


