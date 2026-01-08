<?php
require_once __DIR__ . "/../../env/host.php";

try {
    // Accessing a table triggers connection in the current DB class implementation
    DB::table('users'); 
    
    // Credentials (fallback if DB class doesn't expose connection easily)
    // Ideally we should use the existing connection from DB class if possible, 
    // but the DB class is a wrapper. We can modify it later to be more open.
    // For now, to be safe and quick for a migration script:
    
    $host = "localhost:3306";
    $db = "PaintBall";
    $user = "root";
    $pass = "";
    
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE IF NOT EXISTS email_verification (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT(20) UNSIGNED NOT NULL,
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        expired_at DATETIME NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    
    $pdo->exec($sql);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
