<?php
require_once "../../env/DTO.php";

// Validate Name
if (empty($name))
    handleError("Name is required.");

// Validate Age
if (empty($age)) {
    handleError("Age is required.");
} elseif (!is_numeric($age)) {
    handleError("Age must be a number.");
} elseif ($age < 18) {
    handleError("Age must be a valid number 18+.");
}


// Validate Email
if (empty($email)) {
    handleError("Email is required.");
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    handleError("Email format is invalid.");
}

// Validate Phone
if (empty($phone)) {
    handleError("Phone is required.");
} elseif (!preg_match("/^[0-9]{8,15}$/", $phone)) {
    handleError("Phone must be 8 to 15 digits.");
}

// Validate Password (Only if provided)
if (!empty($new_password)) {
    // Minimum 8 characters
    if (strlen($new_password) < 8) {
        handleError("Password must be at least 8 characters long.");
    }

    // At least one uppercase letter
    if (!preg_match('/[A-Z]/', $new_password)) {
        handleError("Password must contain at least one uppercase letter.");
    }

    // At least one lowercase letter
    if (!preg_match('/[a-z]/', $new_password)) {
        handleError("Password must contain at least one lowercase letter.");
    }

    // At least one number
    if (!preg_match('/[0-9]/', $new_password)) {
        handleError("Password must contain at least one number.");
    }

    // At least one special character
    if (!preg_match('/[\W_]/', $new_password)) {
        handleError("Password must contain at least one special character.");
    }
}

function handleError($message)
{
    DTO::session_error($message, $_POST);
    header("Location:/edit_profile");
    exit;
}
