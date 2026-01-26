<?php
require_once  $_SERVER["DOCUMENT_ROOT"] . "/backend/services/UserService.php";


// Start session if needed
session_start();

//ADMIN AUTHORIZATION CHECK 
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    handleError("You are not authorized to access this page");
}

// Validate input
$userId = $_POST['id'] ?? null;
$action = null;

if (isset($_POST['delete'])) {
    $action = 'delete';
} elseif (isset($_POST['restore'])) {
    $action = 'restore';
}

if (!$userId || !$action) {
    handleError("Something went wrong when parsing the data ");
}


$userId = (int) $userId; // cast to integer for safety

try {
    // Delete action: soft delete
    if ($action === 'delete') {
        if (UserService::deleteUser($userId)) {
            DTO::session_success("user Disabled Successfully");
        } else {
            handleError("Failed to delete user");
        }
    }
    // Restore action: remove deleted_at
    elseif ($action === 'restore') {
        if (UserService::restoreUser($userId)) {
            DTO::session_success("user Restored Successfully");
        } else {
            handleError("Failed to restore user");
        }
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
