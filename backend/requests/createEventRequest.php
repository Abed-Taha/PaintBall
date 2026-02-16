<?php
require_once __DIR__ . "/../../env/DTO.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    handleError("Invalid Request Method.");
}



if (
    !isset($_SESSION["user"]) ||
    !DB::hasRole('admin', $_SESSION["user"]["id"])
) {
    handleError("You don't have access for this action");
}

// Sanitize and retrieve input data
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$start_date = htmlspecialchars(trim($_POST['start_date'] ?? ''));
$payment_price = htmlspecialchars(trim($_POST['payment_price'] ?? ''));
$payment_date = htmlspecialchars(trim($_POST['payment_date'] ?? ''));
$map_id = htmlspecialchars(trim($_POST['map_id'] ?? ''));
$description = htmlspecialchars(trim($_POST['description'] ?? ''));
// Put sanitized description back into POST so DTO/session preserves cleaned data


// Validate Name
if (empty($name)) {
    handleError("Event name is required.");
}

// Validate Start Date
if (empty($start_date)) {
    handleError("Start date is required.");
}

// Validate Payment Price
if (empty($payment_price) || !is_numeric($payment_price)) {
    handleError("Valid payment price is required.");
}

// Validate Payment Date
if (empty($payment_date)) {
    handleError("Payment date is required.");
}



// Validate Map ID
$map = DB::select('maps')->where('id', $map_id)->first();
if (empty($map_id) || !is_numeric($map_id) || is_null($map)) {
    handleError("Valid map selection is required.");
}

// Validate Description
if (empty($description)) {
    handleError("Event description is required.");
}

if (strlen($description) < 10) {
    handleError("Description must be at least 10 characters.");
}

if (strlen($description) > 1000) {
    handleError("Description must not exceed 1000 characters.");
}

// Validate Photo Upload
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    handleError("Event photo is required.");
} else {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $file_name = $_FILES['photo']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_extensions)) {
        handleError("Invalid file type. Only JPG, JPEG, PNG, GIF, and WEBP are allowed.");
    }

    if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
        handleError("File size must be less than 2MB.");
    }
}

function handleError($message)
{
    DTO::session_error($message, $_POST);
    header("Location: /admin/events");
    exit;
}
