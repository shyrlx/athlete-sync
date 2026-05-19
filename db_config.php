<?php
// db_config.php

$host = '127.0.0.1'; // Render database host or localhost
$dbname = 'athlete_sync';
$db_user = 'root';
$db_pass = ''; // No password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_user, $db_pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Return a JSON error if the connection fails
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'DB Error: Connection failed.']);
    exit;
}
?>
