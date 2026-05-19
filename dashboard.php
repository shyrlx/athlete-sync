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
    if (!empty($_POST['routine_prompt'])) {
        $userInput = trim($_POST['routine_prompt']);
        
        // 1. Using the stable production model ID
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;
        
        $payload = [
            "contents" => [["parts" => [["text" => $userInput]]]]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            $aiResponse = "🚨 cURL Error: " . $error;
        } elseif (!$response) {
            $aiResponse = "🚨 API Error: Server returned empty response. Check if GEMINI_API_KEY is set in Render Environment.";
        } else {
            $data = json_decode($response, true);
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $aiResponse = nl2br(htmlspecialchars($data['candidates'][0]['content']['parts'][0]['text']));
            } else {
                $aiResponse = "🚨 API Response Data Error: " . json_encode($data);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .container { padding: 40px; color: #fff; }
        .box { background: #1a1a1a; padding: 20px; border: 1px solid #333; }
        textarea { width: 100%; height: 100px; background: #000; color: #fff; }
    </style>
</head>
<body>
  <div class="container">
    <div class="box">
        <form method="POST">
            <textarea name="routine_prompt"><?php echo htmlspecialchars($userInput); ?></textarea>
            <button type="submit">Unleash</button>
        </form>
        <div style="margin-top:20px;"><?php echo $aiResponse; ?></div>
    </div>
  </div>
</body>
</html>
