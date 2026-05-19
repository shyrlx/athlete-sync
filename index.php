<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Athlete-Sync — AI-driven sports scheduling platform. Plan smarter, play more, stress less.">
  <title>Athlete-Sync | Own Your Game Time</title>
  <link rel="stylesheet" href="./css/style.css">
  <style>
    /* ── INDEX PAGE STYLES ── */

    /* Hero */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding-top: var(--nav-h);
      background: var(--bg);
      position: relative;
      overflow: hidden
    }

    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse 60% 60% at 70% 50%, rgba(59, 130, 246, .07) 0%, transparent 70%);
      pointer-events: none
    }

    .hero-left {
      display: flex;
      flex-direction: column;
      gap: 24px;
      max-width: 520px
    }

    .hero-btns {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      margin-top: 8px
    }

    .hero-img-wrap {
      position: relative;
      border: 1px solid var(--bdr2);
      overflow: hidden;
      background: var(--surf)
    }

    .hero-img-wrap img {
      width: 100%;
      height: 500px;
      object-fit: cover;
      object-position: center top
    }

    .hero-img-wrap::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 80px;
      background: linear-gradient(to top, var(--bg), transparent)
    }

    /* Inverse Value */
    .inverse {
      background: var(--surf);
      border-top: 1px solid var(--bdr);
      border-bottom: 1px solid var(--bdr)
    }

    .inv-left {
      display: flex;
      flex-direction: column;
      gap: 20px;
      padding-right: 16px
    }

    .inv-icon-wrap {
      width: 52px;
      height: 52px;
      border: 1px solid rgba(34, 197, 94, .35);
      background: rgba(34, 197, 94, .08);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 4px
    }

    .inv-img {
      position: relative;
      overflow: hidden;
      border: 1px solid var(--bdr2)
    }

    .inv-img img {
      width: 100%;
      height: 460px;
      object-fit: cover
    }

    /* Stats */
    .stats-section {
      background: var(--bg)
    }

    .stat-card {
      border: 1px solid var(--bdr);
      background: var(--card);
      padding: 40px 32px;
      display: flex;
      flex-direction: column;
      gap: 8px;
      transition: border-color .2s, transform .2s
    }

    .stat-card:hover {
      border-color: var(--bdr2);
      transform: translateY(-3px)
    }

    .stat-card:nth-child(2) .stat {
      color: var(--green)
    }

    .stat-label {
      font-size: 13px;
      color: var(--txt3);
      font-weight: 500;
      letter-spacing: .04em;
      text-transform: uppercase
    }

    /* Gallery */
    .gallery-section {
      background: var(--surf);
      border-top: 1px solid var(--bdr);
      border-bottom: 1px solid var(--bdr)
    }

    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 3px
    }

    .gal-item {
      overflow: hidden;
      aspect-ratio: 1;
      background: var(--card);
      position: relative
    }

    .gal-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform .5s ease, filter .4s
    }

    .gal-item:hover img {
      transform: scale(1.06);
      filter: brightness(1.1)
    }

    .gal-item::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(59, 130, 246, .15), transparent);
      opacity: 0;
      transition: opacity .3s
    }

    .gal-item:hover::after {
      opacity: 1
    }

    /* Testimonials */
    .testi-section {
      background: var(--bg)
    }

    .testi-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px
    }

    .testi-card {
      background: var(--card);
      border: 1px solid var(--bdr);
      padding: 28px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      transition: border-color .25s, transform .25s
    }

    .testi-card:hover {
      border-color: var(--bdr2);
      transform: translateY(-2px)
    }

    .quote-mark {
      font-size: 36px;
      color: var(--blue);
      line-height: 1;
      font-weight: 900;
      opacity: .6
    }

    .testi-quote {
      font-size: 14px;
      color: var(--txt2);
      line-height: 1.7;
      flex: 1
    }

    .testi-author {
      border-top: 1px solid var(--bdr);
      padding-top: 14px;
      display: flex;
      flex-direction: column;
      gap: 2px
    }

    .testi-name {
      font-size: 13px;
      font-weight: 700;
      color: #fff
    }

    .testi-role {
      font-size: 11px;
      color: var(--txt3);
      letter-spacing: .06em;
      text-transform: uppercase
    }

    /* Event Feed */
    .events-section {
      background: var(--surf);
      border-top: 1px solid var(--bdr);
      border-bottom: 1px solid var(--bdr)
    }

    .event-cards {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1px;
      background: var(--bdr);
      border: 1px solid var(--bdr);
      margin: 40px 0 32px
    }

    .ev-card {
      background: var(--card);
      padding: 24px 20px;
      display: flex;
      flex-direction: column;
      gap: 6px;
      transition: background .2s
    }

    .ev-card:hover {
      background: var(--surf)
    }

    .ev-date {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .1em;
      text-transform: uppercase;
      color: var(--blue)
    }

    .ev-title {
      font-size: 15px;
      font-weight: 700;
      color: #fff;
      line-height: 1.3
    }

    .ev-venue {
      font-size: 12px;
      color: var(--txt3)
    }

    .ev-live {
      display: inline-block;
      padding: 2px 8px;
      background: rgba(34, 197, 94, .15);
      border: 1px solid rgba(34, 197, 94, .3);
      color: var(--green);
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      width: fit-content
    }

    /* CTA Banner */
    .cta-banner {
      background: linear-gradient(135deg, var(--surf) 0%, rgba(30, 41, 59, .8) 100%);
      border-top: 1px solid var(--bdr);
      border-bottom: 1px solid var(--bdr);
      padding: 80px 0;
      position: relative;
      overflow: hidden
    }

    .cta-banner::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse 50% 80% at 0% 50%, rgba(59, 130, 246, .06) 0%, transparent 70%)
    }

    .cta-inner {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
      position: relative
    }

    .cta-right {
      display: flex;
      flex-direction: column;
      gap: 20px
    }

    @media(max-width:900px) {
      .testi-grid {
        grid-template-columns: 1fr 1fr
      }

      .event-cards {
        grid-template-columns: 1fr 1fr
      }
    }

    @media(max-width:640px) {
      .hero-img-wrap img {
        height: 320px
      }

      .testi-grid {
        grid-template-columns: 1fr
      }

      .event-cards {
        grid-template-columns: 1fr
      }

      .gallery-grid {
        grid-template-columns: 1fr 1fr
      }

      .cta-inner {
        grid-template-columns: 1fr;
        gap: 32px
      }

      .inv-img img {
        height: 300px
      }
    }
  </style>
</head>

<body>

  <!-- NAV -->
  <nav class="nav">
    <div class="nav-in">
      <a href="./index.html" class="logo">
        <div class="logo-grid" aria-hidden="true">
          <span></span><span></span><span></span>
          <span></span><span></span><span></span>
          <span></span><span></span><span></span>
        </div>
        <span class="logo-txt">Athlete-Sync</span>
      </a>
      <div class="nav-links">
        <a href="./how-it-works.html">How it works</a>
        <a href="./updates.html">Updates</a>
      </div>
      <div class="nav-r" style="display:flex;align-items:center;gap:24px;">
        <a href="./login.html" style="font-size:14px;font-weight:600;color:var(--txt2);transition:color .2s"
          onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--txt2)'">Login</a>
        <a href="./get-started.html" class="btn btn-p btn-sm">Get started</a>
      </div>
      <button class="hmbg" id="hmbg" aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>
  <div class="mob-menu" id="mob-menu">
    <a href="./how-it-works.html">How it works</a>
    <a href="./updates.html">Updates</a>
    <a href="./login.html"
      style="font-size:16px;font-weight:600;color:var(--txt2);padding:10px 0;border-bottom:1px solid var(--bdr)">Login</a>
    <a href="./get-started.html" class="btn btn-p" style="margin-top:8px">Get started</a>
  </div>

  <!-- HERO -->
  <section class="hero page-top">
    <div class="wrap" style="width:100%;padding-top:40px;padding-bottom:80px">
      <div class="g2" style="align-items:center">
        <div class="hero-left">
          <p class="eye">Effortless scheduling for athletes</p>
          <h1 class="d1">Own your<br>game time</h1>
          <p class="sub" style="max-width:420px">Plan smarter. Play more. Stress less.</p>
          <div class="hero-btns">
            <a href="./get-started.html" class="btn btn-p btn-lg">Get started</a>
            <a href="./how-it-works.html" class="btn btn-o btn-lg">Learn more</a>
          </div>
        </div>
        <div class="hero-img-wrap">
          <img src="./images/running_man.jpg" alt="Male athlete sprinting on track" loading="eager">
        </div>
      </div>
    </div>
  </section>

  <!-- INVERSE VALUE -->
  <section class="inverse sec">
    <div class="wrap">
      <div class="g2">
        <div class="inv-left">
          <div class="inv-icon-wrap">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2"
              stroke-linecap="square">
              <circle cx="12" cy="12" r="10" />
              <polyline points="9,12 11,14 15,10" />
            </svg>
          </div>
          <div class="accent-bar"></div>
          <h2 class="d3">Effortless scheduling.<br>More game time.</h2>
          <p class="sub">Let AI handle your sports routine. We sync your matches, training, and recovery cycles so you
            can focus on performance, not calendars.</p>
          <ul class="col" style="gap:12px;margin-top:8px">
            <li class="row" style="gap:12px">
              <div class="check-icon"><svg viewBox="0 0 12 12" fill="none" stroke="#22c55e" stroke-width="2">
                  <polyline points="2,6 5,9 10,3" />
                </svg></div>
              <span class="sm">Automatic conflict detection &amp; resolution</span>
            </li>
            <li class="row" style="gap:12px">
              <div class="check-icon"><svg viewBox="0 0 12 12" fill="none" stroke="#22c55e" stroke-width="2">
                  <polyline points="2,6 5,9 10,3" />
                </svg></div>
              <span class="sm">Real-time sync across all your devices</span>
            </li>
            <li class="row" style="gap:12px">
              <div class="check-icon"><svg viewBox="0 0 12 12" fill="none" stroke="#22c55e" stroke-width="2">
                  <polyline points="2,6 5,9 10,3" />
                </svg></div>
              <span class="sm">Smart travel window calculations</span>
            </li>
          </ul>
        </div>
        <div class="inv-img">
          <img src="./images/gym_training.jpg" alt="Athlete training in premium gym facility" loading="lazy">
        </div>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <section class="stats-section sec">
    <div class="wrap">
      <div class="tc" style="margin-bottom:56px">
        <h2 class="d3">Real stats. Real impact.</h2>
      </div>
      <div class="g3">
        <div class="stat-card">
          <span class="stat">2+ hrs</span>
          <span class="stat-label">Daily usage</span>
          <p class="sm" style="margin-top:4px">Athletes spend over two hours managing their schedule through
            Athlete-Sync every day.</p>
        </div>
        <div class="stat-card">
          <span class="stat" style="color:var(--green)">1,500+</span>
          <span class="stat-label">Active athletes</span>
          <p class="sm" style="margin-top:4px">A growing community of competitive athletes, coaches, and team managers
            rely on our platform.</p>
        </div>
        <div class="stat-card">
          <span class="stat">98%</span>
          <span class="stat-label">User satisfaction</span>
          <p class="sm" style="margin-top:4px">Consistently rated top-tier by athletes who switched from manual
            scheduling tools.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- GALLERY -->
  <section class="gallery-section sec">
    <div class="wrap" style="margin-bottom:40px">
      <div class="tc">
        <h2 class="d3">Moments that move you</h2>
        <p class="sub" style="margin-top:12px">Real athletes. Real results. Real impact.</p>
      </div>
    </div>
    <div class="gallery-grid">
      <div class="gal-item"><img src="./images/gallery1.jpg" alt="Athlete training session" loading="lazy"></div>
      <div class="gal-item"><img src="./images/gallery2.jpg" alt="Athlete in motion" loading="lazy"></div>
      <div class="gal-item"><img src="./images/gallery3.jpg" alt="Athlete competing" loading="lazy"></div>
      <div class="gal-item"><img src="./images/gallery4.jpg" alt="Athlete focused" loading="lazy"></div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="testi-section sec">
    <div class="wrap">
      <div style="margin-bottom:52px">
        <p class="eye" style="margin-bottom:10px">What athletes say</p>
        <h2 class="d3">Real feedback. Real results.</h2>
        <p class="sub" style="margin-top:12px;max-width:520px">See how Athlete-Sync helps real people save time and stay
          focused.</p>
      </div>
      <div class="testi-grid">
        <div class="testi-card">
          <div class="quote-mark">"</div>
          <p class="testi-quote">"Athlete-Sync completely changed how I manage my training weeks. No more missed
            sessions or overlapping commitments. Everything just works."</p>
          <div class="testi-author">
            <span class="testi-name">Jamie Rivers</span>
            <span class="testi-role">Soccer Coach</span>
          </div>
        </div>
        <div class="testi-card">
          <div class="quote-mark">"</div>
          <p class="testi-quote">"The interface is as fast as my sprints. Everything I need is just two taps away. It's
            genuinely the best scheduling tool I've used."</p>
          <div class="testi-author">
            <span class="testi-name">Morgan Lee</span>
            <span class="testi-role">Badminton Player</span>
          </div>
        </div>
        <div class="testi-card">
          <div class="quote-mark">"</div>
          <p class="testi-quote">"Clean, fast, and powerful. Exactly what I need for my training cycles. The AI conflict
            resolution is genuinely impressive."</p>
          <div class="testi-author">
            <span class="testi-name">Taylor Quinn</span>
            <span class="testi-role">Runner</span>
          </div>
        </div>
        <div class="testi-card">
          <div class="quote-mark">"</div>
          <p class="testi-quote">"Managing a college sports schedule and classes was a nightmare until I found this.
            It's a game changer for student athletes."</p>
          <div class="testi-author">
            <span class="testi-name">Avery Kim</span>
            <span class="testi-role">Basketball Captain</span>
          </div>
        </div>
        <div class="testi-card">
          <div class="quote-mark">"</div>
          <p class="testi-quote">"The AI scheduling is terrifyingly accurate. It knows exactly when I need rest before a
            big race. Like having a personal coach in my pocket."</p>
          <div class="testi-author">
            <span class="testi-name">Jordan Blake</span>
            <span class="testi-role">Cyclist</span>
          </div>
        </div>
        <div class="testi-card">
          <div class="quote-mark">"</div>
          <p class="testi-quote">"Finally, an app that understands the specific needs of high-performance training
            cycles. Travel windows alone saved me three near-misses."</p>
          <div class="testi-author">
            <span class="testi-name">Casey Drew</span>
            <span class="testi-role">Tennis Enthusiast</span>
          </div>
        </div>
      </div>
      <div class="tc" style="margin-top:52px">
        <a href="./get-started.html" class="btn btn-p btn-lg">Get started</a>
      </div>
    </div>
  </section>

  <!-- EVENT FEED -->
  <section class="events-section sec">
    <div class="wrap">
      <p class="caps" style="margin-bottom:12px">Event feed</p>
      <div class="row between" style="flex-wrap:wrap;gap:16px">
        <div>
          <h2 class="d3">Your schedule, always up to date</h2>
          <p class="sub" style="margin-top:10px">Stay in the loop with every match, practice, and tournament.</p>
        </div>
      </div>
      <div class="event-cards">
        <div class="ev-card">
          <span class="ev-date">Mar 24 · 06:00 AM</span>
          <span class="ev-live">Live</span>
          <span class="ev-title">Morning Sprints</span>
          <span class="ev-venue">Olympic Stadium</span>
        </div>
        <div class="ev-card">
          <span class="ev-date">Mar 26 · 04:00 PM</span>
          <span class="ev-title">Team Strategy</span>
          <span class="ev-venue">Conference Hall B</span>
        </div>
        <div class="ev-card">
          <span class="ev-date">Mar 27 · 10:00 AM</span>
          <span class="ev-title">Recovery Session</span>
          <span class="ev-venue">Wellness Center</span>
        </div>
        <div class="ev-card">
          <span class="ev-date">Mar 28 · 03:00 PM</span>
          <span class="ev-title">Qualifiers</span>
          <span class="ev-venue">City Arena</span>
        </div>
      </div>
      <a href="./updates.html" class="btn btn-o">All events &rarr;</a>
    </div>
  </section>

  <!-- CTA BANNER -->
  <section class="cta-banner">
    <div class="wrap">
      <div class="cta-inner">
        <div>
          <h2 class="d1" style="line-height:1.05">Your time,<br>optimized.</h2>
        </div>
        <div class="cta-right">
          <p class="sub" style="font-size:20px;color:var(--txt2)">Smarter scheduling.<br>More time for you.</p>
          <div>
            <a href="./get-started.html" class="btn btn-p btn-lg">Get started</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="foot-in">
      <div class="foot-l">
        <span>Made by Shyrlx</span>
        <span>yugdanidhariya007@gmail.com</span>
      </div>
      <div class="foot-r" style="display:flex;flex-direction:column;align-items:flex-end;gap:8px">
        <span>&copy; 2026 Athlete-Sync. All rights reserved.</span>
        <div style="display:flex;gap:16px">
          <a href="./privacy.html" style="font-size:12px;color:var(--txt3);transition:color .2s"
            onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--txt3)'">Privacy Policy</a>
          <a href="./terms.html" style="font-size:12px;color:var(--txt3);transition:color .2s"
            onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--txt3)'">Terms & Conditions</a>
        </div>
      </div>
    </div>
  </footer>

  <style>
    @media (max-width: 650px) {

      /* Force the hamburger button cleanly to the far right */
      #hmbg {
        position: absolute !important;
        right: 16px !important;
        left: auto !important;
      }

      /* Push the mobile login link to the left so the hamburger button doesn't sit on it */
      .nav-r {
        margin-right: 48px !important;
      }
    }
  </style>

  <script>
    const hmbg = document.getElementById('hmbg');
    const mob = document.getElementById('mob-menu');
    hmbg.addEventListener('click', () => {
      mob.classList.toggle('open');
      const spans = hmbg.querySelectorAll('span');
      mob.classList.contains('open')
        ? (spans[0].style.cssText = 'transform:rotate(45deg) translate(5px,5px)', spans[1].style.opacity = '0', spans[2].style.cssText = 'transform:rotate(-45deg) translate(5px,-5px)')
        : (spans[0].style.cssText = '', spans[1].style.opacity = '', spans[2].style.cssText = '');
    });
  </script>
</body>

</html>
