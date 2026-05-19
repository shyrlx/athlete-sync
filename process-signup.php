<?php
// Start the session so we can log the user in automatically
session_start();

$host = 'localhost';
$dbname = 'athlete_sync';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $raw_password = $_POST['password'] ?? '';

    if (empty($full_name) || empty($email) || empty($raw_password)) {
        die(json_encode(["status" => "error", "message" => "All fields are required."]));
    }

    $password_hash = password_hash($raw_password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (:full_name, :email, :password_hash)");
        
        $stmt->execute([
            ':full_name' => $full_name,
            ':email' => $email,
            ':password_hash' => $password_hash
        ]);

        // FIX: Grab the newly created User ID and save it to the session
        $new_user_id = $pdo->lastInsertId();
        $_SESSION['user_id'] = $new_user_id;
        $_SESSION['user_name'] = $full_name;

        echo json_encode(["status" => "success", "message" => "Account successfully created."]);

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(["status" => "error", "message" => "An account with this email already exists."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Registration failed."]);
        }
    }
}
?>
