<?php
// Use a direct, simple connection string
$host = 'dpg-d85urindl75s73993gng-a';
$db   = 'athlete_sync';
$user = 'syncuser';
$pass = 'bHOdFi9esUhZsgtRPbol7STPByaRHnJ8';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}
?>
