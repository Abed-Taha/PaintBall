<?php
require_once __DIR__ . "/../../env/host.php";
require_once __DIR__ . "/../../env/DTO.php";

// Check if user is logged in and is an admin
if (!isset($_SESSION['user']) || !DB::hasRole('admin', $_SESSION['user']['id'])) {
    DTO::session_error("Unauthorized access.");
    header("Location: /login");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    DTO::session_error("Invalid request method.");
    header("Location: /admin/instructors");
    exit();
}

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

if (!$user_id || !$action) {
    DTO::session_error("Invalid request parameters.");
    header("Location: /admin/instructors");
    exit();
}

if ($action !== 'promote' && $action !== 'demote') {
    DTO::session_error("Invalid action.");
    header("Location: /admin/instructors");
    exit();
}

// Check if user exists
$user = DB::select('users')->where('id', $user_id)->first();
if (!$user) {
    DTO::session_error("User not found.");
    header("Location: /admin/instructors");
    exit();
}

// Prevent modifying another admin
if ($user['role'] === 'admin') {
    DTO::session_error("You cannot modify another admin account.");
    header("Location: /admin/instructors");
    exit();
}