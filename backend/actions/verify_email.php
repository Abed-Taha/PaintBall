<?php
session_start();
require_once __DIR__ . "/../../env/host.php";

if (!isset($_GET['token'])) {
    $_SESSION['response'] = [
        'status' => 'error',
        'message' => 'Invalid verification link.'
    ];
    header("Location:/");
    exit();
}

$token = $_GET['token'];

// Find token in email_verification
$verification = DB::table("email_verification")->where("token", $token)->first();

if (!$verification) {
    $_SESSION['response'] = [
        'status' => 'error',
        'message' => 'Invalid or expired verification link.'
    ];
    header("Location:/");
    exit();
}

// Check expiration
if (strtotime($verification['expired_at']) < time()) {
    $_SESSION['response'] = [
        'status' => 'error',
        'message' => 'Verification link has expired.'
    ];
    header("Location:/");
    exit();
}

// Token is valid. Update user.
$pendingData = json_decode($verification['pending_data'] ?? '', true);

if ($pendingData) {
    // Atomic Update: Apply pending changes
    $userId = $verification['user_id'];
    
    // 1. Update User Table (includes new email)
    if (isset($pendingData['user']) && !empty($pendingData['user'])) {
        // Ensure verified status is updated
        $pendingData['user']['verified'] = date("Y-m-d H:i:s");
        // Ensure email is the new email from verification record (redundant but safe)
        $pendingData['user']['email'] = $verification['email'];
        
        DB::table("users")->where("id", $userId)->update($pendingData['user']);
    }

    // 2. Update Instructor Table
    if (isset($pendingData['instructor']) && !empty($pendingData['instructor'])) {
        $instructorExists = DB::select('instructors')->where('user_id', $userId)->first();
        if ($instructorExists) {
             DB::table("instructors")->where("user_id", $userId)->update($pendingData['instructor']);
        } else {
             // Create if not exists (migrated to instructor via profile edit?)
             $pendingData['instructor']['user_id'] = $userId;
             DB::table("instructors")->insert($pendingData['instructor']);
        }
    }
    
    $updated = true; // Updates performed
} else {
    // Legacy/Registration Flow (Just update email/stat)
    // Or resend flow without pending data? (Should have pending data if profile update)
    // Registration flow doesn't have pending data, user is already in DB.
    $updated = DB::table("users")->where("id", $verification['user_id'])->update([
        "email" => $verification['email'],
        "verified" => date("Y-m-d H:i:s")
    ]);
}

if ($updated) {
    // Delete verification record
    DB::table("email_verification")->where("id", $verification['id'])->delete();

    // Auto-login: Set session user
    $user = DB::table("users")->where("id", $verification['user_id'])->first();
    
    // Safety check if user exists
    if ($user) {
        $_SESSION['user'] = $user;
        $_SESSION['response'] = [
            'status' => 'success',
            'message' => 'Email verified successfully! You are now logged in.'
        ];
    } else {
        // Should not happen, but fallback
        $_SESSION['response'] = [
            'status' => 'error',
            'message' => 'Verification successful, but user retrieval failed. Please login.'
        ];
    }
} else {
    $_SESSION['response'] = [
        'status' => 'error',
        'message' => 'Failed to verify email. Please try again.'
    ];
}

header("Location:/");
exit();
