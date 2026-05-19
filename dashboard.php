<?php
session_start();
// Auth Gatekeeper: If the user isn't logged in, redirect them away instantly
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$aiResponse = '';
$userInput = '';

// Pull the secure variable from your Render Environment panel
$apiKey = getenv('GEMINI_API_KEY'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['routine_prompt'])) {
        $userInput = trim($_POST['routine_prompt']);
        
        // Updated to the correct v1 stable endpoint for Gemini 3 Flash
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-3-flash:generateContent?key=" . $apiKey;
        
        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $userInput . " Provide the response configuration or schedule template as a clean Markdown table structure if applicable."]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        // Critical headers required for secure cloud container requests
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        // Bypasses local container SSL validation bugs if Render's certs are skewed
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $rawMarkdown = $data['candidates'][0]['content']['parts'][0]['text'];
                
                // Formats AI markdown tables into clean visual HTML rows
                $aiResponse = preg_replace_callback('/\|(.+)\|/', function($matches) {
                    $cells = explode('|', trim($matches[1]));
                    $rowHtml = '<tr>';
                    foreach ($cells as $cell) {
                        $rowHtml .= '<td>' . htmlspecialchars(trim($cell)) . '</td>';
                    }
                    $rowHtml .= '</tr>';
                    return $rowHtml;
                }, $rawMarkdown);
                
                // If the response didn't contain a markdown table, pass the text cleanly
                if ($aiResponse === $rawMarkdown) {
                    $aiResponse = nl2br(htmlspecialchars($rawMarkdown));
                }
            } else {
                // Helpful debugging message if your API key configuration has an issue
                $aiResponse = "🚨 API Error: The server connected, but the API key was rejected or throttled. Check your GEMINI_API_KEY variable in Render.";
            }
        } else {
            $aiResponse = "🚨 Network Error: Unable to reach the API endpoint from this container network layer.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlete-Sync | Dashboard</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .dashboard-container { padding: 80px 0; background: var(--bg); min-height: 100vh; color: #fff; }
        .ai-box { background: var(--card); border: 1px solid var(--bdr); padding: 32px; border-radius: 4px; margin-top: 24px; }
        .ai-textarea { width: 100%; min-height: 120px; background: var(--bg); border: 1px solid var(--bdr); color: #fff; padding: 16px; margin-bottom: 16px; resize: vertical; font-family: inherit; }
        .response-box { background: var(--surf); border-left: 4px solid var(--blue); padding: 24px; margin-top: 24px; overflow-x: auto; }
        .response-box table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .response-box td { border: 1px solid var(--bdr); padding: 12px; color: var(--txt2); font-size: 14px; }
    </style>
</head>
<body>
  <nav class="nav">
    <div class="nav-in">
      <a href="./index.php" class="logo"><span class="logo-txt">Athlete-Sync</span></a>
      <div class="nav-r">
        <a href="logout.php" class="btn btn-o btn-sm">Logout</a>
      </div>
    </div>
  </nav>

  <div class="dashboard-container">
    <div class="wrap">
      <h2>Welcome Back, Athlete!</h2>
      <p class="sub">Your account session is active and secure.</p>
      
      <div class="ai-box">
        <form method="POST" action="dashboard.php">
          <label class="stat-label" style="display:block;margin-bottom:12px;text-transform:uppercase;">Optimize Dynamic Routine:</label>
          <textarea name="routine_prompt" class="ai-textarea" placeholder="Describe your chaotic training schedule..."><?php echo htmlspecialchars($userInput); ?></textarea>
          <button type="submit" class="btn btn-p btn-lg" style="width:100%">Unleash the Chaos ⚡</button>
        </form>

        <?php if (!empty($aiResponse)): ?>
          <div class="response-box">
            <h4 style="color:var(--blue); margin-bottom: 8px;">Your Optimized Schedule Matrix:</h4>
            <div style="line-height:1.6;"><?php echo $aiResponse; ?></div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
