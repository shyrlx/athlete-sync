<?php
session_start();
// Security Gatekeeper: Prevent users from snooping on the dashboard without an active login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Your Athlete-Sync dashboard — manage your schedule, events, and training all in one place.">
<title>Dashboard | Athlete-Sync</title>
<link rel="stylesheet" href="style.css">
<style>
body{min-height:100vh;display:flex;flex-direction:column}
.dash-main{flex:1;padding-top:var(--nav-h);background:var(--bg)}
.dash-welcome{padding:48px 0 40px;border-bottom:1px solid var(--bdr)}
.welcome-row{display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:20px}
.welcome-left{display:flex;flex-direction:column;gap:8px}
.welcome-left h1{font-size:clamp(24px,3vw,36px);font-weight:800;letter-spacing:-.02em}
.welcome-left p{color:var(--txt2);font-size:15px}
.dash-date{font-size:12px;color:var(--txt3);letter-spacing:.06em;text-transform:uppercase;font-weight:600}
.dash-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;padding:32px 0}
.dash-stat{background:var(--card);border:1px solid var(--bdr);padding:24px 20px;display:flex;flex-direction:column;gap:6px;transition:border-color .2s,transform .2s}
.dash-stat:hover{border-color:var(--bdr2);transform:translateY(-2px)}
.dash-stat-label{font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--txt3)}
.dash-stat-value{font-size:clamp(28px,4vw,40px);font-weight:900;letter-spacing:-.03em;line-height:1}
.dash-stat:nth-child(1) .dash-stat-value{color:var(--blue)}
.dash-stat:nth-child(2) .dash-stat-value{color:var(--green)}
.dash-stat:nth-child(3) .dash-stat-value{color:#f59e0b}
.dash-stat:nth-child(4) .dash-stat-value{color:#8b5cf6}
.dash-section{padding:40px 0;border-top:1px solid var(--bdr)}
.dash-section-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px}
.dash-section-head h2{font-size:20px;font-weight:700;letter-spacing:-.01em}
.ai-form-panel{background:var(--card);border:1px solid var(--bdr);padding:24px;border-radius:8px;margin-bottom:32px;display:flex;flex-direction:column;gap:16px}
.ai-form-panel textarea{width:100%;height:100px;background:var(--bg);border:1px solid var(--bdr2);color:#fff;padding:16px;font-size:14px;resize:vertical;outline:none;border-radius:6px;font-family:inherit;transition:border-color .2s}
.ai-form-panel textarea:focus{border-color:var(--blue)}
.btn-submit{background:var(--blue);color:#fff;border:none;padding:12px 24px;font-weight:700;border-radius:6px;cursor:pointer;align-self:flex-start;transition:background .2s}
.btn-submit:hover{background:#2b6cb0}
.btn-submit:disabled{opacity:0.7;cursor:not-allowed}
.ai-empty-state{padding:40px;text-align:center;color:var(--txt3);font-size:14px;border:1px dashed var(--bdr2);border-radius:8px;background:rgba(255,255,255,.02)}
.dash-actions{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;padding:40px 0;border-top:1px solid var(--bdr)}
.dash-action{background:var(--card);border:1px solid var(--bdr);padding:28px 24px;display:flex;flex-direction:column;gap:12px;transition:border-color .2s,transform .2s;cursor:pointer}
.dash-action:hover{border-color:var(--bdr2);transform:translateY(-2px)}
.dash-action-icon{width:40px;height:40px;display:flex;align-items:center;justify-content:center;border:1px solid var(--bdr2);background:rgba(59,130,246,.06)}
.dash-action h3{font-size:16px;font-weight:700;color:#fff}
.dash-action p{font-size:13px;color:var(--txt2);line-height:1.6}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.5}}
.pulse-dot{width:8px;height:8px;background:var(--green);border-radius:50%;display:inline-block;animation:pulse 2s ease infinite}
@media(max-width:900px){ .dash-stats{grid-template-columns:1fr 1fr} .dash-actions{grid-template-columns:1fr} }
@media(max-width:640px){ .dash-stats{grid-template-columns:1fr} }
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
    <div class="nav-r">
      <a href="logout.php" class="btn btn-o btn-sm">Log out</a>
    </div>
  </div>
</nav>

<main class="dash-main">
  <section class="dash-welcome">
    <div class="wrap">
      <div class="welcome-row">
        <div class="welcome-left">
          <p class="eye"><span class="pulse-dot" style="margin-right:8px"></span> Dashboard Active</p>
          <h1>Welcome back, Athlete</h1>
          <p>Here's your training overview for this week.</p>
        </div>
        <span class="dash-date" id="dash-date"></span>
      </div>
    </div>
  </section>

  <div class="wrap">
    <div class="dash-stats">
      <div class="dash-stat"><span class="dash-stat-label">This Week</span><span class="dash-stat-value">7</span><span class="sm">Scheduled events</span></div>
      <div class="dash-stat"><span class="dash-stat-label">Completed</span><span class="dash-stat-value">3</span><span class="sm">Sessions done</span></div>
      <div class="dash-stat"><span class="dash-stat-label">Conflicts</span><span class="dash-stat-value">0</span><span class="sm">AI-resolved</span></div>
      <div class="dash-stat"><span class="dash-stat-label">Sync Status</span><span class="dash-stat-value">Live</span><span class="sm">All calendars synced</span></div>
    </div>
  </div>

  <div class="wrap">
    <div class="dash-section">
      <div class="dash-section-head">
        <h2>Upcoming Schedule</h2>
        <span class="caps">This week</span>
      </div>
      
      <form id="ai-schedule-form" class="ai-form-panel">
        <textarea name="prompt" id="schedule-prompt" placeholder="Paste your chaotic schedule or type your training layout here..."></textarea>
        <button type="submit" id="submit-btn" class="btn-submit">Generate Optimized Schedule</button>
      </form>

      <div class="dash-events" id="schedule-container">
        <div class="ai-empty-state">
          Your AI-generated schedule will appear here.<br>Submit your daily routine above to get started.
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  const now = new Date();
  document.getElementById('dash-date').textContent = now.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

  const aiForm = document.getElementById('ai-schedule-form');
  const submitBtn = document.getElementById('submit-btn');
  const scheduleContainer = document.getElementById('schedule-container');

  if (aiForm) {
    aiForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const promptText = document.getElementById('schedule-prompt').value.trim();
      if (!promptText) return alert('Please enter your schedule first.');

      const originalBtnText = submitBtn.innerText;
      submitBtn.innerText = '⚡ Processing Schedule...';
      submitBtn.disabled = true;

      try {
        const formData = new FormData();
        formData.append('prompt', promptText);

        const response = await fetch('./ai-schedule.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (data.status === 'success') {
          // Render layout with clean visual white-space line breaks
          scheduleContainer.innerHTML = `<div class="ai-empty-state" style="border-style:solid;text-align:left;color:#e2e8f0;line-height:1.7;white-space:pre-wrap;">${data.schedule}</div>`;
        } else {
          scheduleContainer.innerHTML = `<div class="ai-empty-state" style="color:#ef4444">❌ System Error: ${data.message}</div>`;
        }
      } catch (err) {
        scheduleContainer.innerHTML = `<div class="ai-empty-state" style="color:#ef4444">❌ Connection Failed. Check your Render network environment.</div>`;
      } finally {
        submitBtn.innerText = originalBtnText;
        submitBtn.disabled = false;
      }
    });
  }
</script>
</body>
</html>
