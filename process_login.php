<?php
session_start();
$host = 'localhost'; $dbname = 'athlete_sync'; $db_user = 'root'; $db_pass = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $db_user, $db_pass);
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $_POST['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($_POST['password'], $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
        }
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'DB Error.']);
}
