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
if (DB::table("users")->where("email", $email)->first()) {
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


function handleError($message)
{
    http_response_code(400);
    DTO::session_error($message, $_POST);
    header("Location:/register");
    exit;
}