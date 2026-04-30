<?php
session_start();
require_once __DIR__ . '/../../env/host.php';
require_once __DIR__ . '/../../env/DTO.php';
require_once __DIR__ . '/../services/TeamService.php';
require_once __DIR__ . '/../requests/TeamValidation.php';

// Ensure user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    DTO::session_error("You must be logged in to create a team.");
    header("Location: /PaintBall/frontend/view/auth/login.php");
    exit;
}

$userId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is already in a team
    if (TeamService::hasAnyTeam($userId)) {
        DTO::session_error("You are already a member of a team. You cannot create a new one.");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $data = $_POST;
    $file = isset($_FILES['team_photo']) ? $_FILES['team_photo'] : null;

    // Validate
    $errors = TeamValidation::validateCreateTeam($data, $file);

    if (!empty($errors)) {
        // Handle errors
        DTO::session_error(implode(" ", $errors));
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
    $file = isset($_FILES['team_photo']) ? $_FILES['team_photo'] : null;

    // Handle File Upload
    $photoPath = null;
    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../storage/images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = 'team_' . time() . '_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $photoPath = $fileName;
        } else {
            DTO::session_error("Failed to upload team photo.");
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    // Create Team
    try {
        $team = TeamService::createTeam($data['team_name'], $data['max_players'], $photoPath);

        if ($team && isset($team['id'])) {
            // Auto join the team
            TeamService::joinTeam($userId, $team['id']);

            DTO::session_success("Team created successfully and you have automatically joined it!");
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            DTO::session_error("Failed to create team. Please try again.");
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    } catch (Exception $e) {
        DTO::session_error("An error occurred: " . $e->getMessage());
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
} else {
    // Not a POST request
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
