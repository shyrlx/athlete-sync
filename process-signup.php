<?php
// Database configuration credentials
$host = 'localhost';
$dbname = 'athlete_sync';
$db_user = 'root';
$db_pass = '';

try {
    // Initialize PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

// Process POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Retrieve and sanitize POST data
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $raw_password = $_POST['password'] ?? '';

    // Verify fields are not empty
    if (empty($full_name) || empty($email) || empty($raw_password)) {
        die(json_encode(["status" => "error", "message" => "All fields are required."]));
    }

    // Securely hash the password using PHP's native BCrypt wrapper
    $password_hash = password_hash($raw_password, PASSWORD_DEFAULT);

    try {
        // Prepare SQL insert statement (user_tier defaults to 'free' via database schema)
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (:full_name, :email, :password_hash)");
        
        // Execute with bound parameters to prevent SQL injection
        $stmt->execute([
            ':full_name' => $full_name,
            ':email' => $email,
            ':password_hash' => $password_hash
        ]);

        echo json_encode(["status" => "success", "message" => "Account successfully created."]);

    } catch (PDOException $e) {
        // Catch duplicate email unique constraint violations (MySQL Code: 23000)
        if ($e->getCode() == 23000) {
            echo json_encode(["status" => "error", "message" => "An account with this email already exists."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Registration failed."]);
        }
    }
}
?>
