<?php
session_start();
require_once __DIR__ . "/../../env/host.php"; // Database connection
require_once __DIR__ . "/../../env/DTO.php"; // Data Transfer Object for responses

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    DTO::session_error("Invalid Request Method.");
    header("Location: /battle");
    exit();
}

$type = $_POST['type'] ?? 'game';

if ($type === 'game') {
    // Basic validation and sanitization
    $team_id = $_POST['team_id'] ?? null;
    $opponent_id = $_POST['opponent_id'] ?? null;
    $instructor_id = $_POST['instructor_id'] ?? null;
    $game_duration = $_POST['game_duration'] ?? null;
    $bundel_id = $_POST['bundel_id'] ?? null;
    $map_id = $_POST['map_id'] ?? null;
    $date = $_POST['date'] ?? null;
    $payment_price = $_POST['payment_price'] ?? null;
    $payment_type = $_POST['payment_type'] ?? null;
    $payment_date = $_POST['payment_date'] ?? null;

    if (!$team_id || !$opponent_id || !$instructor_id || !$game_duration || !$bundel_id || !$map_id || !$date || !$payment_price || !$payment_type || !$payment_date || !isset($_FILES['photo'])) {
        DTO::session_error("All fields are required for game booking.", $_POST);
        header("Location: /battle");
        exit();
    }

    // Handle Photo Upload
    $upload_dir = __DIR__ . "/../../backend/storage/images/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_ext = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
    $file_name = time() . "_reservation_" . uniqid() . "." . $file_ext;
    $target_file = $upload_dir . $file_name;

    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        DTO::session_error("Failed to upload photo.", $_POST);
        header("Location: /battle");
        exit();
    }

    try {
        // 1. Insert into games table
        $game_data = [
            "team_id" => $team_id,
            "opponent_id" => $opponent_id,
            "instructor_id" => $instructor_id,
            "game_duration" => $game_duration,
            "bundel_id" => $bundel_id,
            "photo" => $file_name
        ];

        $game = DB::table("games")->insert($game_data);

        if (!$game || !isset($game['id'])) {
            throw new Exception("Failed to insert into games table.");
        }

        $game_id = $game['id'];

        // 2. Insert into game_reservations table
        $reservation_data = [
            "team_id" => $team_id,
            "date" => $date,
            "status" => "pending",
            "payment_price" => $payment_price,
            "payment_type" => $payment_type,
            "payment_date" => $payment_date,
            "map_id" => $map_id,
            "game_id" => $game_id
        ];

        $reservation = DB::table("game_reservations")->insert($reservation_data);

        if ($reservation) {
            DTO::session_success("Game reservation created successfully!");
            header("Location: /battle");
        } else {
            throw new Exception("Failed to insert into game_reservations table.");
        }

    } catch (Exception $e) {
        // Cleanup: Delete uploaded photo if DB insert fails
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        DTO::session_error("An error occurred: " . $e->getMessage(), $_POST);
        header("Location: /battle");
    }
} else if ($type === 'instructor') {
    $instructor_id = $_POST['instructor_id'] ?? null;
    $payment_price = $_POST['payment_price'] ?? null;
    $payment_type = $_POST['payment_type'] ?? null;
    $payment_date = $_POST['payment_date'] ?? null;
    $user_id = $_SESSION['user']['id'] ?? null;

    if (!$instructor_id || !$payment_price || !$payment_type || !$payment_date || !$user_id) {
        DTO::session_error("All fields are required for instructor booking.", $_POST);
        header("Location: /battle");
        exit();
    }

    try {
        $reservation_data = [
            "user_id" => $user_id,
            "instructor_id" => $instructor_id,
            "payment_price" => $payment_price,
            "payment_type" => $payment_type,
            "payment_date" => $payment_date
        ];

        $reservation = DB::table("instructor_reservation")->insert($reservation_data);

        if ($reservation) {
            DTO::session_success("Instructor booked successfully!");
            header("Location: /battle");
        } else {
            throw new Exception("Failed to book instructor.");
        }
    } catch (Exception $e) {
        DTO::session_error("An error occurred: " . $e->getMessage(), $_POST);
        header("Location: /battle");
    }
}
exit();
