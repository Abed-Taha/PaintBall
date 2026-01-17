<?php
require_once __DIR__ . "/../../env/host.php"; // Your DB class
require_once __DIR__ . "/../../env/DTO.php";


// Start session to store messages if needed
session_start();

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method not allowed";
    exit;
}

// Get POST values
$email = isset($_POST['email']) ? $_POST['email'] : '';
$tokenExists = isset($_POST['token']) ? $_POST['token'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Basic validation

if (!$email) {
    DTO::session_error("Email is required.");
    header("Location: /login" . urlencode($email));
    exit;
}

if (!$tokenExists) {
    DTO::session_error("Invalid request.");
    header("Location: /login" . urlencode($email));
    exit;
}

require_once __DIR__ . "/../requests/passwordValidation.php";



// Token exists — update user password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$userUpdated = DB::table('users')
    ->where('email', $email)
    ->update(['password' => $hashedPassword]);

if (!$userUpdated) {
    DTO::session_error("Failed to update password. Please try again.");
    header("Location: /login" . urlencode($email));
    exit;
}

// Delete the token after successful reset
DB::table('email_verification')
    ->where('email', $email)
    ->delete();

// Redirect to login page with success message
DTO::session_success("Your password has been updated successfully! You can now login.");
header("Location: /login");
exit;
