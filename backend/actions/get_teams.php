<?php
session_start();
require_once __DIR__ . '/../../env/host.php';
require_once __DIR__ . '/../../env/DTO.php';
require_once __DIR__ . '/../services/TeamService.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    echo json_encode(["status" => 401, "message" => "Unauthorized"]);
    exit;
}

$userId = $_SESSION['user']['id'];
$search = isset($_GET['search']) ? trim($_GET['search']) : null;

try {
    $teams = TeamService::searchTeams($search, 10);
    $hasAnyTeam = TeamService::hasAnyTeam($userId);
    
    // Check which teams the user has already joined
    foreach ($teams as &$team) {
        $team['is_joined'] = TeamService::isUserInTeam($userId, $team['id']);
    }

    echo json_encode([
        "status" => 200, 
        "data" => $teams,
        "is_already_in_any_team" => $hasAnyTeam
    ]);
} catch (Exception $e) {
    echo json_encode(["status" => 500, "message" => $e->getMessage()]);
}
