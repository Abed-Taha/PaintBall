<?php
session_start();
require_once __DIR__ . '/../../env/host.php';
require_once __DIR__ . '/../../env/DTO.php';
require_once __DIR__ . '/../services/TeamService.php';

// Ensure user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    DTO::session_error("You must be logged in to join a team.");
    header("Location: /PaintBall/frontend/view/auth/login.php");
    exit;
}

$userId = $_SESSION['user']['id'];
$teamId = isset($_POST['team_id']) ? (int)$_POST['team_id'] : null;

if (!$teamId) {
    DTO::session_error("Invalid Team ID.");
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/PaintBall/frontend/view/main/reservation.php'));
    exit;
}

try {
    // 1. Check if user is already in ANY team
    if (TeamService::hasAnyTeam($userId)) {
        DTO::session_error("You are already a member of a team. You can only join one team.");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // 2. Check if team exists and has space
    $team = TeamService::getTeamById($teamId);
    if (!$team) {
        DTO::session_error("Team not found.");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $currentMembersCount = count($team['members'] ?? []);
    if ($currentMembersCount >= $team['max_number']) {
        DTO::session_error("This team is already full.");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // 3. Join team
    if (TeamService::joinTeam($userId, $teamId)) {
        DTO::session_success("Successfully joined the team!");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        DTO::session_error("Failed to join the team. Please try again.");
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
} catch (Exception $e) {
    DTO::session_error("An error occurred: " . $e->getMessage());
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
