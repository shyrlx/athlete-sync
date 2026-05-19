<?php
// ── 1. LOCAL SQLITE DATABASE CONFIGURATION ──
$connectionFailed = false;
$aiResponse = '';
$userInput = '';

try {
    // Connects to a local file-based database to prevent driver crashes
    $pdo = new PDO("sqlite:" . __DIR__ . "/athletesync.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS schedules (
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        prompt TEXT, 
        response TEXT, 
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    die("<div style='background:#b91c1c; color:#ffffff; padding:30px; font-family:sans-serif; text-align:center; font-weight:bold; font-size:18px; position:fixed; top:0; left:0; width:100%; z-index:99999;'>🚨 SQLITE ERROR: " . htmlspecialchars($e->getMessage()) . "</div>");
}

// Reads the Gemini API key from your Render Environment panel
$apiKey = getenv('GEMINI_API_KEY') ?: 'AIzaSyC6MPbP4ijN2TXNeYs0fs2SiX97CNuZKs4'; 

// ── 2. HANDLE AI SCHEDULE GENERATION FORM SUBMISSION ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['routine_prompt'])) {
        $userInput = trim($_POST['routine_prompt']);
        
        // FIXED: Switched to v1beta path which Gemini 3 Flash strictly requires
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash:generateContent?key=" . $apiKey;
        
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            $curlError = curl_error($ch);
        }
        curl_close($ch);

        if (isset($curlError)) {
            $aiResponse = "🚨 Container Network Error: " . htmlspecialchars($curlError);
        } elseif ($response) {
            $data = json_decode($response, true);
            
            // Checks if Google rejected the key or request structure
            if (isset($data['error'])) {
                $aiResponse = "🚨 Google API Error: " . htmlspecialchars($data['error']['message']) . " (Code: " . htmlspecialchars($data['error']['code']) . ")";
            } elseif (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $rawMarkdown = $data['candidates'][0]['content']['parts'][0]['text'];
                
                // Formats AI markdown tables into HTML rows
                $aiResponse = preg_replace_callback('/\|(.+)\|/', function($matches) {
                    $cells = explode('|', trim($matches[1]));
                    $rowHtml = '<tr>';
                    foreach ($cells as $cell) {
                        $rowHtml .= '<td>' . htmlspecialchars(trim($cell)) . '</td>';
                    }
                    $rowHtml .= '</tr>';
                    return $rowHtml;
                }, $rawMarkdown);
                
                if ($aiResponse === $rawMarkdown) {
                    $aiResponse = nl2br(htmlspecialchars($rawMarkdown));
                }
                
                // Optional local logging
                try {
                    $stmt = $pdo->prepare("INSERT INTO schedules (prompt, response) VALUES (?, ?)");
                    $stmt->execute([$userInput, $aiResponse]);
                } catch (PDOException $dbErr) {
                    // Fail silently if database writes are blocked
                }
            } else {
                $aiResponse = "🚨 Unrecognized API Response Structure. Raw snippet: " . htmlspecialchars(substr($response, 0, 250));
            }
        } else {
            $aiResponse = "🚨 Network Error: Received an empty response from the API endpoint.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Athlete-Sync — AI-driven sports scheduling platform. Plan smarter, play more, stress less.">
  <title>Athlete-Sync | Own Your Game Time</title>
  <link rel="stylesheet" href="./css/style.css">
  <style>
    /* UI Styles */
    .hero { min-height: 100vh; display: flex; align-items: center; padding-top: var(--nav-h); background: var(--bg); position: relative; overflow: hidden }
    .hero::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 60% 60% at 70% 50%, rgba(59, 130, 246, .07) 0%, transparent 70%); pointer-events: none }
    .hero-left { display: flex; flex-direction: column; gap: 24px; max-width: 520px }
    .hero-btns { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 8px }
    .hero-img-wrap { position: relative; border: 1px solid var(--bdr2); overflow: hidden; background: var(--surf) }
    .hero-img-wrap img { width: 100%; height: 500px; object-fit: cover; object-position: center top }
    .hero-img-wrap::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 80px; background: linear-gradient(to top, var(--bg), transparent) }
    .inverse { background: var(--surf); border-top: 1px solid var(--bdr); border-bottom: 1px solid var(--bdr) }
    .inv-left { display: flex; flex-direction: column; gap: 20px; padding-right: 16px }
    .inv-icon-wrap { width: 52px; height: 52px; border: 1px solid rgba(34, 197, 94, .35); background: rgba(34, 197, 94, .08); display: flex; align-items: center; justify-content: center; margin-bottom: 4px }
    .inv-img { position: relative; overflow: hidden; border: 1px solid var(--bdr2) }
    .inv-img img { width: 100%; height: 460px; object-fit: cover }
    .ai-container { background: var(--card); border: 1px solid var(--bdr); padding: 32px; border-radius: 4px; margin-top: 40px; }
    .ai-textarea { width: 100%; min-height: 120px; background: var(--bg); border: 1px solid var(--bdr); color: #fff; padding: 16px; font-family: inherit; font-size: 14px; resize: vertical; margin-bottom: 16px; }
    .ai-textarea:focus { border-color: var(--blue); outline: none; }
    .response-box { background: var(--surf); border-left: 4px solid var(--blue); padding: 24px; margin-top: 24px; overflow-x: auto; }
    .response-box table { width: 100%; border-collapse: collapse; margin-top: 16px; }
    .response-box td, .response-box th { border: 1px solid var(--bdr); padding: 12px; font-size: 14px; color: var(--txt2); }
    @media(max-width:640px) { .hero-img-wrap img { height: 320px } .inv-img img { height: 300px } }
  </style>
</head>

<body>
  <nav class="nav">
    <div class="nav-in">
      <a href="./index.php" class="logo"><span class="logo-txt">Athlete-Sync</span></a>
      <div class="nav-links">
        <a href="./how-it-works.html">How it works</a>
        <a href="./updates.html">Updates</a>
      </div>
      <div class="nav-r" style="display:flex;align-items:center;gap:24px;">
        <a href="./login.html" style="font-size:14px;font-weight:600;color:var(--txt2);">Login</a>
        <a href="./get-started.html" class="btn btn-p btn-sm">Get started</a>
      </div>
    </div>
  </nav>

  <section class="hero page-top">
    <div class="wrap" style="width:100%;padding-top:40px;padding-bottom:80px">
      <div class="g2" style="align-items:center">
        <div class="hero-left">
          <p class="eye">Effortless scheduling for athletes</p>
          <h1 class="d1">Own your<br>game time</h1>
          <p class="sub" style="max-width:420px">Plan smarter. Play more. Stress less.</p>
          <div class="hero-btns">
            <a href="#ai-scheduler" class="btn btn-p btn-lg">Try AI App</a>
            <a href="./how-it-works.html" class="btn btn-o btn-lg">Learn more</a>
          </div>
        </div>
        <div class="hero-img-wrap">
          <img src="./images/running_man.jpg" alt="Male athlete sprinting on track" loading="eager">
        </div>
      </div>
    </div>
  </section>

  <section id="ai-scheduler" class="sec" style="background: var(--bg); border-top: 1px solid var(--bdr);">
    <div class="wrap">
      <div class="tc" style="margin-bottom:32px">
        <p class="eye">Live Prototype</p>
        <h2 class="d3">Chaotic Schedule Engine</h2>
      </div>

      <div class="ai-container">
        <form method="POST" action="#ai-scheduler">
          <label for="routine_prompt" class="stat-label" style="display:block;margin-bottom:12px;text-transform:uppercase;">Drop your chaotic query here:</label>
          <textarea id="routine_prompt" name="routine_prompt" class="ai-textarea" placeholder="Enter your routine..."><?php echo !empty($userInput) ? htmlspecialchars($userInput) : "I am a working guy. My job starts at 9:00 AM and I get back home around 6:30 PM. I am totally exhausted after work, but I love pickleball and want to manage at least 1 hour of playing time daily without destroying my sleep schedule or burning out. Fix my routine and give me a game plan!"; ?></textarea>
          <button type="submit" class="btn btn-p btn-lg" style="width:100%">Unleash the Chaos ⚡</button>
        </form>

        <?php if (!empty($aiResponse)): ?>
          <div class="response-box">
            <span class="stat-label" style="color:var(--blue)">Generated Manifest:</span>
            <div style="margin-top:12px; color:var(--txt2); line-height:1.6;">
              <?php echo $aiResponse; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="inverse sec">
    <div class="wrap">
      <div class="g2">
        <div class="inv-left">
          <div class="inv-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"><circle cx="12" cy="12" r="10" /><polyline points="9,12 11,14 15,10" /></svg>
          </div>
          <h2 class="d3">Effortless scheduling.<br>More game time.</h2>
          <p class="sub">Let AI handle your sports routine. We sync your matches, training, and recovery cycles so you can focus on performance.</p>
        </div>
        <div class="inv-img">
          <img src="./images/gym_training.jpg" alt="Athlete training in premium gym facility" loading="lazy">
        </div>
      </div>
    </div>
  </section>

  <footer class="footer" style="background:var(--surf); padding:30px 0; border-top:1px solid var(--bdr);">
    <div class="wrap" style="display:flex; justify-content:space-between; align-items:center; color:var(--txt3); font-size:12px;">
        <span>Made by Shyrlx</span>
        <span>&copy; 2026 Athlete-Sync. All rights reserved.</span>
    </div>
  </footer>
</body>
</html>
