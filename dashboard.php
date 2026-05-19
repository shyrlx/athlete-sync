<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$aiResponse = '';
$userInput = '';
$apiKey = getenv('GEMINI_API_KEY');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = $_POST['routine_prompt'];
    
    // Direct URL to the stable 1.5-flash model
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;
    
    $payload = json_encode([
        "contents" => [["parts" => [["text" => $userInput]]]]
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20); // Longer timeout
    
    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        $aiResponse = "Connection Error: " . $error;
    } else {
        $data = json_decode($result, true);
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            $aiResponse = $data['candidates'][0]['content']['parts'][0]['text'];
        } else {
            $aiResponse = "API Error: " . $result;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <form method="POST">
        <textarea name="routine_prompt" placeholder="Enter schedule..."></textarea>
        <button type="submit">Unleash</button>
    </form>
    <div><?php echo nl2br(htmlspecialchars($aiResponse)); ?></div>
</body>
</html>
