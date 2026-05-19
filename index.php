<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Athlete-Sync — AI-driven sports scheduling platform. Plan smarter, play more, stress less.">
  <title>Athlete-Sync | Own Your Game Time</title>
  <link rel="stylesheet" href="./css/style.css">
  <style>
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
            <a href="dashboard.php" class="btn btn-p btn-lg">Get Started</a>
            <a href="./how-it-works.html" class="btn btn-o btn-lg">Learn more</a>
          </div>
        </div>
        <div class="hero-img-wrap">
          <img src="./images/running_man.jpg" alt="Male athlete sprinting on track" loading="eager">
        </div>
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
