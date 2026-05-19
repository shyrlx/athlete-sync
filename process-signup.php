<?php
session_start();
$host = 'localhost'; $dbname = 'athlete_sync'; $db_user = 'root'; $db_pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $db_user, $db_pass);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['full_name'], $_POST['email'], $hash]);
    
    $_SESSION['user_id'] = $pdo->lastInsertId();
    echo json_encode(['status' => 'success']);
}
