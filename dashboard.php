<?php
session_start();

// 1. Force users to login. If no session, boot them to login page
if (!isset($_SESSION['user_email'])) {
    header("Location: ./login.html");
    exit();
}

$user_email = $_SESSION['user_email'] ?? '';
$user_name = $_SESSION['user_name'] ?? 'Athlete';
$is_admin = ($user_email === 'yugdanidhariya007@gmail.com');
$recent_users_count = 0;

// 2. Run the secret 7-day user countdown tracker if YOU log in
if ($is_admin) {
    $host = 'dpg-d85urindl75s73993gng-a';
    $db   = 'athletesync';
    $user = 'syncuser';
    $pass = 'bHOdFi9esUhZsgtRPbol7STPByaRHnJ8';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRORS => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM users WHERE created_at >= NOW() - INTERVAL 7 DAY");
        $row = $stmt->fetch();
        $recent_users_count = $row['total'] ?? 0;
    } catch (\PDOException $e) {
        $recent_users_count = "Error connecting";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | Athlete-Sync</title>
<link rel="stylesheet" href="./css/style.css">
<style>
body{min-height:100vh;display:flex;flex-direction:column;background:#0d0e12;color:#fff;font-family:sans-serif;}
.container{max-width:1200px;margin:0 auto;padding:0 24px;}
.dash-main{padding-top:80px;}
.dash-welcome{padding:48px 0 40px;}
.admin-widget{background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.3);padding:16px 20px;margin-bottom:32px;border-radius:8px;}
.admin-widget h3{color:#f59e0b;font-size:14px;font-weight:700;margin:0;}
.admin-widget p{color:#a0aec0;font-size:13px;margin:4px 0 0;}
.ai-section{padding:40px 0 80px;border-top:1px solid #2d3748;}
.ai-panel{background:#1a202c;border:1px solid #2d3748;padding:24px;border-radius:8px;display:flex;flex-direction:column;gap:16px;}
.ai-panel textarea{width:100%;height:120px;background:#0d0e12;border:1px solid #4a5568;color:#fff;padding:16px;font-size:14px;resize:vertical;outline:none;border-radius:6px;}
.ai-panel textarea:focus{border-color:#3182ce;}
.btn-submit{background:#3182ce;color:#fff;border:none;padding:12px 24px;font-weight:700;border-radius:6px;cursor:pointer;align-self:flex-start;transition:background 0.2s;}
.btn-submit:hover{background:#2b6cb0;}
.btn-submit:disabled{background:#4a5568;cursor:not-allowed;}
.schedule-result-box{background:#0d0e12;border:1px solid #4a5568;padding:24px;min-height:160px;font-size:14px;color:#e2e8f0;line-height:1.7;white-space:pre-wrap;border-radius:6px;}
.loading-spinner {color:#f59e0b;font-weight:600;display:none;}
</style>
</head>
<body>

<main class="dash-main">
  <div class="container">
    
    <div class="dash-welcome">
      <h1>Welcome back, <?php echo htmlspecialchars($user_name); ?></h1>
      <p>Manage your schedules and optimize your windows.</p>
    </div>

    <?php if ($is_admin): ?>
    <div class="admin-widget">
      <h3>Admin Control Center Active</h3>
      <p>📊 <strong><?php echo $recent_users_count; ?></strong> new athletes have registered on Athlete-Sync in the last 7 days.</p>
    </div>
    <?php endif; ?>

    <section class="ai-section">
      <div class="ai-head">
        <h2>Generate Optimized AI Schedule</h2>
      </div>
      
      <div class="ai-panel">
        <textarea id="user-prompt" placeholder="Paste your messy calendar or type your training layout here..."></textarea>
        
        <button id="submit-prompt-btn" class="btn-submit" type="button">Optimize Schedule</button>
        <div id="loading-indicator" class="loading-spinner">⚡ Processing direct connection to Gemini Engine...</div>
        
        <h3>Your Optimized Calendar Layout</h3>
        <div id="schedule-result" class="schedule-result-box">Your optimized AI schedule will generate here...</div>
      </div>
    </section>

  </div>
</main>

<script>
document.getElementById('submit-prompt-btn').addEventListener('click', () => {
    const promptInput = document.getElementById('user-prompt');
    const resultBox = document.getElementById('schedule-result');

    const promptText = promptInput.value.trim();
    if (!promptText) {
        alert("Please enter a training layout first!");
        return;
    }

    resultBox.innerText = "🚀 Opening Secure AI Processing Window... Check your browser tabs!";

    // Formulate a pre-filled prompt directly to Google AI Studio's public web workspace
    const encodedPrompt = encodeURIComponent(
        "Act as an expert athletic coordinator. Optimize the following messy calendar layout for maximum recovery and performance windows: " + promptText
    );
    
    // This opens Google AI Studio with your text injected right into the workspace
    const aiStudioUrl = `https://aistudio.google.com/live?prompt=${encodedPrompt}`;
    
    // Open it in a clean, secondary browser tab natively
    window.open(aiStudioUrl, '_blank');
    
    // Reset the layout notification state smoothly
    setTimeout(() => {
        resultBox.innerText = "✅ Prompt sent! Your optimized schedule is generating inside the open Google AI Studio tab.";
    }, 1500);
});
</script>

</body>
</html>
