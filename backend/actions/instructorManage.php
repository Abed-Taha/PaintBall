<?php
session_start();
require_once __DIR__ . "/../requests/instructorManageRequest.php";

$new_role = '';
if ($action === 'promote') {
    $new_role = 'instructor';
} elseif ($action === 'demote') {
    $new_role = 'user';
}

try {
    $result = DB::table('users')->where('id', $user_id)->update(['role' => $new_role]);

    if ($result) {
        DTO::session_success("User role updated successfully.");
    } else {
        DTO::session_error("Failed to update user role.");
    }

} catch (Exception $e) {
    DTO::session_error("Error: " . $e->getMessage());
}

header("Location: /admin/instructors");
exit();
