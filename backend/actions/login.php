<?php


session_start();
require_once __DIR__ . "/../../env/host.php"; // your query builder
require_once "../../env/DTO.php"; //data transfer object ;


header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION["error"] = "Invalid Request.";
    header("Location:/login");
}

$email = htmlspecialchars(trim($_POST["email"] ?? ""));
$password = htmlspecialchars(trim($_POST["password"] ?? ""));

$user = DB::select("users")->where("email", $email)->first();

// if not verifcated yet . 
function verified() {
global $user ;
if (is_null($user["verified"])) {
    // Generate Token
    $token = bin2hex(random_bytes(32));
    $expiredAt = date("Y-m-d H:i:s", strtotime("+10 minutes"));

    // Check if there is an existing verification record for this user and email
    $existing = DB::table("email_verification")->where("user_id", $user["id"])->where("email", $email)->first();

    if ($existing) {
        // Update existing token
        DB::table("email_verification")->where("id", $existing["id"])->update([
            "token" => $token,
            "expired_at" => $expiredAt,
            "created_at" => date("Y-m-d H:i:s")
        ]);
    } else {
        // Create new
        DB::table("email_verification")->insert([
            "user_id" => $user["id"],
            "email" => $email,
            "token" => $token,
            "expired_at" => $expiredAt
        ]);
    }

    require_once __DIR__ . "/../../mail/mail.php";
    
    // Store in session for resend capability
    $_SESSION['pending_verification_email'] = $email;

    sendVerificationEmail($email, $token);
    header("Location:/verification_sent");
    exit;
}
}

if ($user && password_verify($password, $user["password"])) {
    verified();
    if (!is_null($user["deleted_at"])) {
        DTO::session_error("This account is Disabled !");
        header("Location:/login");
        exit;
    }

    DTO::session_success("Welcome back " . $user['name']);
    $_SESSION["user"] = $user;
    header("Location:/");
} else {
    DTO::session_error("Invalid email or password.", $_POST);
    header("Location:/login");
    exit;
}
