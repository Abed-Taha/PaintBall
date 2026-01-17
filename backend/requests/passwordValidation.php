<?php
// Validate Password
if (empty($password)) {
    handleError("Password is required.");
} else {
    // Minimum 8 characters
    if (strlen($password) < 8) {
        handleError("Password must be at least 8 characters long.");
    }

    // At least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        handleError("Password must contain at least one uppercase letter.");
    }

    // At least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        handleError("Password must contain at least one lowercase letter.");
    }

    // At least one number
    if (!preg_match('/[0-9]/', $password)) {
        handleError("Password must contain at least one number.");
    }

    // At least one special character
    if (!preg_match('/[\W_]/', $password)) {
        handleError("Password must contain at least one special character.");
    }

    if ($password != $confirm_password) {
        handleError("Password are not match !");
    }
}



function handleError($message)
{
    http_response_code(400);
    DTO::session_error($message, $_POST);
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}