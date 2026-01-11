<?php
require_once __DIR__ . "/../../env/host.php";
require_once __DIR__ . "/../../env/DTO.php";



// Start session if needed
session_start();

//ADMIN AUTHORIZATION CHECK 
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    DTO::session_error("You are not authorized to access this page");
    header("Location:/login");
    exit;}

// Validate input
$userId = $_GET['id'] ?? null;
$action = null;

if (isset($_GET['delete'])) {
    $action = 'delete';
} elseif (isset($_GET['restore'])) {
    $action = 'restore';
}

if (!$userId || !$action) {
    DTO::session_error("Something went wrong when parsing the data ");
    header("Location:/admin/users");
    exit;
}


$userId = (int) $userId; // cast to integer for safety

try {
    // Delete action: soft delete
    if ($action === 'delete') {
        DB::select('users')
            ->where('id', $userId)
            ->update(['deleted_at' => date('Y-m-d H:i:s')]);

        DTO::session_success("user Disabled Successfully");
    }
    // Restore action: remove deleted_at
    elseif ($action === 'restore') {
        DB::select('users')
            ->where('id', $userId)
            ->update(['deleted_at' => null]);
        DTO::session_success("user Restored Successfully");
    }

    header("Location:/admin/users");
    exit;

} catch (PDOException $e) {
    handleError('Database error: ' . $e->getMessage());
}

function handleError($message)
{
    DTO::session_error($message);
    header("Location:/admin/users");
    exit;
}
