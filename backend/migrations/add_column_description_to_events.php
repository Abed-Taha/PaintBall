<?php
require_once __DIR__ . "/../../env/host.php";

try {
    // Connect
    $host = "localhost:3306";
    $db = "PaintBall";
    $user = "root";
    $pass = "";

    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Add pending_data column (TEXT/JSON) allowing NULL
    $sql = "ALTER TABLE events ADD COLUMN description TEXT NOT NULL";
    $pdo->exec($sql);
} catch (Exception $e) {

}