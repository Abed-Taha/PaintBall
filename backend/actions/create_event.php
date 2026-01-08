<?php
session_start();
require_once __DIR__ . "/../../env/host.php"; // Database connection
require_once __DIR__ . "/../../env/DTO.php"; // Data Transfer Object for responses

// Include validation logic
require_once __DIR__ . "/../requests/createEventRequest.php";

// Handle File Upload
$upload_dir = __DIR__ . "/../storage/images/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$file_name = time() . "_" . basename($_FILES["photo"]["name"]);
$target_file = $upload_dir . $file_name;
$relative_path =  $file_name;

if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    // File uploaded successfully
} else {
    DTO::session_error("Failed to upload photo.");
    header("Location: /admin/events");
    exit();
}

// Insert Event into Database
$data = [
    "name" => $name,
    "start_date" => $start_date,
    "photo" => $relative_path,
    "payment_price" => $payment_price,
    "payment_date" => $payment_date,
    "payment_type" => $payment_type,
    "map_id" => $map_id
];

try {
    $event = DB::table("events")->insert($data);

    if ($event) {
        DTO::session_success("Event created successfully!");
        header("Location: /admin"); // Or redirect to event list
    } else {
        // If insert fails, delete uploaded image to keep clean
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        DTO::session_error("Failed to create event in database.");
        header("Location: /admin/events");
    }
} catch (Exception $e) {
    // Log error and redirect
    if (file_exists($target_file)) {
        unlink($target_file);
    }
    DTO::session_error("An error occurred: " . $e->getMessage());
    header("Location: /admin/events");
}
exit();
