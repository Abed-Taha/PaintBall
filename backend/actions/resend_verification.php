<?php
session_start();
require_once __DIR__ . "/../../env/host.php";
require_once __DIR__ . "/../../env/DTO.php";
require_once __DIR__ . "/../../mail/mail.php";

$emailToVerify = null;
$userId = null;

// Case 1: Registration flow (email in session)
if (isset($_SESSION['pending_verification_email'])) {
    $emailToVerify = $_SESSION['pending_verification_email'];
    // We need user ID to update the record.
    // Query users table by email? No, the user might be unverified.
    // Query email_verification by email (if unique per user logic holds).
    // Or users table.
    $user = DB::table("users")->where("email", $emailToVerify)->first();
    if ($user) {
        $userId = $user['id'];
    }
}

// Case 2: Profile Update flow (User logged in)
if (!$emailToVerify && isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['id'];
    // Check if there is a pending verification for this user
    $pending = DB::table("email_verification")->where("user_id", $userId)->first();
    if ($pending) {
        $emailToVerify = $pending['email'];
    }
}

// If we still don't have an email, we can't resend
if (!$emailToVerify || !$userId) {
    DTO::session_error("No pending verification found.");
    header("Location:/");
    exit;
}

// Rate limiting could be added here (check last created_at?)

// Generate new token
$token = bin2hex(random_bytes(32));
$expiredAt = date("Y-m-d H:i:s", strtotime("+10 minutes"));

// Update or Insert in email_verification
// Check if record exists (we might have found it above)
$existing = DB::table("email_verification")->where("user_id", $userId)->where("email", $emailToVerify)->first();

if ($existing) {
    DB::table("email_verification")->where("id", $existing['id'])->update([
        "token" => $token,
        "expired_at" => $expiredAt,
        "created_at" => date("Y-m-d H:i:s") // refresh created_at
    ]);
} else {
    // Should not happen normally if flow is correct, but safe fallback
    DB::table("email_verification")->insert([
        "user_id" => $userId,
        "email" => $emailToVerify,
        "token" => $token,
        "expired_at" => $expiredAt
    ]);
}

// Send Email
if (sendVerificationEmail($emailToVerify, $token)) {
    DTO::session_success("Verification link resent to $emailToVerify.");
} else {
    DTO::session_error("Failed to resend email. Please try again later.");
}

header("Location:/verification_sent");
exit;
