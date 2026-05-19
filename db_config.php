<?php
// CHANGE THIS TO YOUR RENDER DATABASE EXTERNAL HOST URL
$host = 'postgresql://syncuser:bHOdFi9esUhZsgtRPbol7STPByaRHnJ8@dpg-d85urindl75s73993gng-a.oregon-postgres.render.com/athletesync'; 
$dbname = 'athlete_sync';
$db_user = 'YOUR_DB_USER';
$db_pass = 'YOUR_DB_PASSWORD';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // We are logging the REAL error so we can see it in Render Logs
    error_log("Connection failed: " . $e->getMessage());
    die(json_encode(['status' => 'error', 'message' => 'DB Connection Failed']));
}
?>
