<?php

session_start();
require_once __DIR__ . "/../../env/host.php"; // your query builder
header("Content-Type: application/json; charset=UTF-8");



if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION["error"] = "Invalid Request.";
    header("Location:/register");
}


$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$last_name = htmlspecialchars(trim($_POST['last_name'] ?? ''));

$age = htmlspecialchars(trim($_POST['age'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$password = htmlspecialchars(trim($_POST['password'] ?? ''));
$confirm_password = htmlspecialchars(trim($_POST["confirm_password"]) ?? '');

require_once "../requests/registerRequest.php";
require_once "../requests/passwordValidation.php";

$hashed = password_hash($password, PASSWORD_BCRYPT);
$fullName = $name . " " . $last_name;

// Insert using your Query Builder
$user = DB::table("users")->insert([
    "name" => $fullName,
    "age" => $age,
    "email" => $email,
    "phone" => $phone,
    "password" => $hashed,
]);

// Token Generation
$token = bin2hex(random_bytes(32));
$expiredAt = date("Y-m-d H:i:s", strtotime("+10 minutes"));

// Insert into email_verification
DB::table("email_verification")->insert([
    "user_id" => $user["id"],
    "email" => $email,
    "token" => $token,
    "expired_at" => $expiredAt
]);

// Store in session for resend capability
$_SESSION['pending_verification_email'] = $email;

require_once __DIR__ . "/../../mail/mail.php";

DTO::session_success("Welcome " . $user["name"]);
header("Location:/verification_sent");


?>