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
    $sql = "ALTER TABLE email_verification ADD COLUMN pending_data TEXT NULL DEFAULT NULL";
    
    $pdo->exec($sql);
    echo "Column 'pending_data' added to 'email_verification' successfully.";
    
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Duplicate column name") !== false) {
        echo "Column 'pending_data' already exists.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
