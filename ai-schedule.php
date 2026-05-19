<?php
header('Content-Type: application/json');
session_start();

// 1. Auth Gatekeeper
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized session. Please log in again.']);
    exit();
}

// 2. Fetch the API Key from Render
$apiKey = getenv('GEMINI_API_KEY');
if (!$apiKey) {
    echo json_encode(['status' => 'error', 'message' => 'Missing GEMINI_API_KEY inside Render environment settings.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prompt'])) {
    $userInput = trim($_POST['prompt']);
    
    if (empty($userInput)) {
        echo json_encode(['status' => 'error', 'message' => 'Prompt text field cannot be empty.']);
        exit();
    }

    // Direct, stable API route for the Gemini 1.5 Flash sequence
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;
    
    $payload = json_encode([
        "contents" => [["parts" => [["text" => $userInput]]]]
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 25);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    
    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        echo json_encode(['status' => 'error', 'message' => 'Network Layer Issue: ' . $curlError]);
        exit();
    }

    $data = json_decode($response, true);

    if (isset($data['error'])) {
        echo json_encode(['status' => 'error', 'message' => 'Google API Error: ' . $data['error']['message']]);
    } elseif (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        $aiText = $data['candidates'][0]['content']['parts'][0]['text'];
        echo json_encode(['status' => 'success', 'schedule' => $aiText]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unexpected layout signature from API endpoint.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request Strategy.']);
}
?>
