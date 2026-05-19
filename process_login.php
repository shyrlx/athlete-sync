<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "Email and password are required.";
        exit;
    }

    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Invalid email or password.";
        }
        $stmt->close();
    } else {
        echo "Database error.";
    }
} else {
    echo "Invalid request method.";
}
?>
