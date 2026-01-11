<?php
require_once "../../env/DTO.php";

// Validate Name
if (empty($name) || empty($last_name))
    handleError("Name is required.");



// Validate Age
if (empty($age)) {
    handleError("Age is required.");
} elseif ($age < 18) {
    handleError("Age must be a valid number  18+.");
}
if(DB::table("users")->where("email", $email)->first()){
     handleError("Email is already in use.");
}
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
    header("Location:/register");
    exit;
}