<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Not logged in."); // Simplify for testing
}

$apiKey = getenv('GEMINI_API_KEY');

// DIAGNOSTIC: This will print the first 4 chars of your key to the screen
echo "DEBUG: API Key detected: " . ($apiKey ? substr($apiKey, 0, 4) . "..." : "EMPTY!") . "<br>";

$aiResponse = "Waiting for input...";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiKey = getenv('GEMINI_API_KEY');
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["contents" => [["parts" => [["text" => "hi"]]]]]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose debugging
    
    $result = curl_exec($ch);
    $error = curl_error($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    if ($error) {
        $aiResponse = "CURL ERROR: " . $error;
    } else {
        $aiResponse = "HTTP CODE: " . $info['http_code'] . " | RESPONSE: " . $result;
    }
}
?>
<form method="POST">
    <button type="submit">Test Connection</button>
</form>
<pre><?php echo $aiResponse; ?></pre>
