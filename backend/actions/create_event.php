<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/PaintBall/env/host.php"; // Database connection
require_once $_SERVER["DOCUMENT_ROOT"] . "/PaintBall/env/DTO.php"; // Data Transfer Object for responses

// Include validation logic
require_once $_SERVER["DOCUMENT_ROOT"] . "/PaintBall/backend/requests/createEventRequest.php";

// Handle File Upload
$upload_dir = $_SERVER["DOCUMENT_ROOT"] . "/PaintBall/backend/storage/images/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$file_name = time() . "_PaintBall_event." .  pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
$target_file = $upload_dir . $file_name;
$relative_path =  $file_name;

if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    // File uploaded successfully
} else {
    DTO::session_error("Failed to upload photo.");
    $redirect = $_SERVER['HTTP_REFERER'] ?? '/PaintBall/index.php?v=admin/create_event';
    header("Location: " . $redirect);
    exit();
}

// Insert Event into Database
$data = [
    "name" => $name,
    "start_date" => $start_date,
    "photo" => $relative_path,
    "payment_price" => $payment_price,
    "payment_date" => $payment_date,
    "map_id" => $map_id,
    "description" => $description
];

try {
    $event = DB::table("events")->insert($data);

    if ($event) {
        DTO::session_success("Event created successfully!");
        header("Location: /PaintBall/index.php?v=admin/mainPage"); // Or redirect to event list
    } else {
        // If insert fails, delete uploaded image to keep clean
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        DTO::session_error("Failed to create event in database.");
        header("Location: /PaintBall/index.php?v=admin/create_event");
    }
} catch (Exception $e) {
    // Log error and redirect
    if (file_exists($target_file)) {
        unlink($target_file);
    }
    DTO::session_error("An error occurred: " . $e->getMessage());
    $redirect = $_SERVER['HTTP_REFERER'] ?? '/PaintBall/admin/events';
    header("Location: " . $redirect);
}
exit();
