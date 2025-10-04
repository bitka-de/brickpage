<!DOCTYPE html>
<html lang="<?= app('site.language'); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= app('site.name') ?> - <?= app('site.tagline') ?></title>

  <!-- Asset Loading: Automatisch Dev/Production -->
  <?= Brick\Core\AssetHelper::viteAssets() ?>

  <link rel="icon" type="image/png" sizes="32x32" href="/img/fav/favicon-32x32.png">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap');

    :root {
      --primary: #6366f1;
      --primary-dark: #4f46e5;
      --accent: #f59e0b;
      --success: #10b981;
      --danger: #ef4444;
      --warning: #f59e0b;

      --text-900: #111827;
      --text-700: #374151;
      --text-500: #6b7280;
      --text-300: #d1d5db;

      --bg-50: #f9fafb;
      --bg-100: #f3f4f6;
      --bg-900: #111827;

      --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
      --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -2px rgb(0 0 0 / 0.05);
      --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      line-height: 1.6;
      color: var(--text-700);
      background: #ffffff;
      overflow-x: hidden;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
    }

    /* Navbar */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 50;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--text-300);
      padding: 16px 0;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      display: flex;
      align-items: center;
      text-decoration: none;
      font-weight: 700;
      font-size: 24px;
      color: var(--text-900);
      transition: transform 0.2s ease;
    }

    .logo:hover {
      transform: scale(1.02);
    }

    .logo img {
      height: 32px;
      margin-right: 12px;
    }

    .nav-links {
      display: flex;
      gap: 32px;
      list-style: none;
    }

    .nav-links a {
      text-decoration: none;
      color: var(--text-500);
      font-weight: 500;
      font-size: 15px;
      transition: all 0.2s ease;
      position: relative;
    }

    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: width 0.3s ease;
    }

    .nav-links a:hover {
      color: var(--primary);
    }

    .nav-links a:hover::after {
      width: 100%;
    }

    .nav-cta {
      background: var(--primary);
      color: white;
      padding: 12px 24px;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.2s ease;
      box-shadow: var(--shadow-sm);
    }

    .nav-cta:hover {
      background: var(--primary-dark);
      transform: translateY(-1px);
      box-shadow: var(--shadow-lg);
    }

    /* Hero Section */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M30 30c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20zm20 0c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .hero-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
      position: relative;
      z-index: 2;
    }

    .hero-text {
      color: white;
    }

    .hero-text h1 {
      font-size: 64px;
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 24px;
      background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-text .tagline {
      font-size: 24px;
      font-weight: 600;
      color: rgba(255, 255, 255, 0.9);
      margin-bottom: 20px;
    }

    .hero-text p {
      font-size: 18px;
      line-height: 1.7;
      color: rgba(255, 255, 255, 0.8);
      margin-bottom: 40px;
    }

    .hero-buttons {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 16px 32px;
      border-radius: 16px;
      text-decoration: none;
      font-weight: 600;
      font-size: 16px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: 2px solid transparent;
    }

    .btn-primary {
      background: white;
      color: var(--primary);
      box-shadow: var(--shadow-xl);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .btn-secondary {
      background: transparent;
      color: white;
      border-color: rgba(255, 255, 255, 0.3);
    }

    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: white;
    }

    /* Code Terminal */
    .code-terminal {
      background: var(--bg-900);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
      transform: perspective(1000px) rotateY(-5deg);
      transition: transform 0.3s ease;
    }

    .code-terminal:hover {
      transform: perspective(1000px) rotateY(0deg);
    }

    .terminal-header {
      background: #1f2937;
      padding: 16px 20px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .terminal-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
    }

    .terminal-dot.red {
      background: #ef4444;
    }

    .terminal-dot.yellow {
      background: #f59e0b;
    }

    .terminal-dot.green {
      background: var(--success);
    }

    .terminal-title {
      margin-left: 12px;
      color: #9ca3af;
      font-size: 14px;
      font-family: 'JetBrains Mono', monospace;
    }

    .terminal-status {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: 6px;
      color: var(--success);
      font-size: 12px;
      font-family: 'JetBrains Mono', monospace;
    }

    .status-dot {
      width: 8px;
      height: 8px;
      background: var(--success);
      border-radius: 50%;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        opacity: 1;
      }

      50% {
        opacity: 0.5;
      }
    }

    .terminal-content {
      padding: 24px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 14px;
      line-height: 1.6;
      color: #e5e7eb;
    }

    .code-line {
      margin-bottom: 4px;
    }

    .php {
      color: #a78bfa;
    }

    .string {
      color: #34d399;
    }

    .tag {
      color: #60a5fa;
    }

    .attr {
      color: #fbbf24;
    }

    .comment {
      color: #6b7280;
    }

    /* Features Section */
    .features {
      padding: 120px 0;
      background: var(--bg-50);
    }

    .section-header {
      text-align: center;
      max-width: 600px;
      margin: 0 auto 80px;
    }

    .section-header h2 {
      font-size: 48px;
      font-weight: 700;
      color: var(--text-900);
      margin-bottom: 16px;
    }

    .section-header p {
      font-size: 20px;
      color: var(--text-500);
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 32px;
    }

    .feature-card {
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--text-300);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
      transition: left 0.5s ease;
    }

    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-xl);
      border-color: var(--primary);
    }

    .feature-card:hover::before {
      left: 100%;
    }

    .feature-icon {
      width: 80px;
      height: 80px;
      padding: 1rem;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      margin-bottom: 24px;
      box-shadow: var(--shadow-lg);
    }

    .feature-icon svg {
      width: 40px;
      height: 40px;
      color: white;
    }

    .feature-card h3 {
      font-size: 24px;
      font-weight: 600;
      color: var(--text-900);
      margin-bottom: 12px;
    }

    .feature-card p {
      color: var(--text-500);
      line-height: 1.7;
    }

    /* Stats Section */
    .stats {
      padding: 80px 0;
      background: white;
    }

    .stats-header {
      text-align: center;
      margin-bottom: 60px;
    }

    .stats-header h2 {
      font-size: 36px;
      font-weight: 700;
      color: var(--text-900);
      margin-bottom: 12px;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 40px;
      max-width: 1000px;
      margin: 0 auto;
    }

    .stat-card {
      text-align: center;
      padding: 32px;
      background: var(--bg-50);
      border-radius: 16px;
      border: 1px solid var(--text-300);
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
    }

    .stat-value {
      font-size: 48px;
      font-weight: 800;
      color: var(--primary);
      margin-bottom: 8px;
    }

    .stat-label {
      font-size: 16px;
      font-weight: 500;
      color: var(--text-500);
    }

    .dev-status {
      margin-top: 40px;
      text-align: center;
    }

    .dev-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 12px 20px;
      background: rgba(99, 102, 241, 0.1);
      border: 1px solid rgba(99, 102, 241, 0.2);
      border-radius: 50px;
      color: var(--primary);
      font-weight: 500;
    }

    /* CTA Section */
    .cta {
      padding: 120px 0;
      background: var(--bg-900);
      color: white;
      text-align: center;
    }

    .cta h2 {
      font-size: 48px;
      font-weight: 700;
      margin-bottom: 16px;
    }

    .cta p {
      font-size: 20px;
      margin-bottom: 40px;
      opacity: 0.9;
    }

    .cta-buttons {
      display: flex;
      gap: 16px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-white {
      background: white;
      color: var(--text-900);
    }

    .btn-outline {
      background: transparent;
      color: white;
      border-color: rgba(255, 255, 255, 0.3);
    }

    .btn-outline:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .hero-content {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
      }

      .hero-text h1 {
        font-size: 40px;
      }

      .nav-links {
        display: none;
      }

      .features-grid {
        grid-template-columns: 1fr;
      }

      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .hero-buttons,
      .cta-buttons {
        justify-content: center;
      }

      .code-terminal {
        transform: none;
      }
    }

    /* Animations */
    .animate-fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .animate-fade-in.in-view {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="container">
      <div class="nav-content">
        <a href="/" class="logo">
          <?= app('site.name'); ?>
        </a>
        <ul class="nav-links">
          <li><a href="#features">Features</a></li>
          <li><a href="#stats">Status</a></li>
          <li><a href="/admin">Dashboard</a></li>
        </ul>
        <a href="/login" class="nav-cta">Los geht's</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <div class="hero-content">
        <div class="hero-text">
          <h1><?= app('site.tagline'); ?></h1>
          <p class="tagline">Live-Entwicklung neu gedacht</p>
          <p>Entwickle deine PHP-Anwendungen in Echtzeit. Sehe Änderungen sofort, deploye mit einem Klick. Brickpage macht Webentwicklung so einfach wie Lego bauen.</p>

          <div class="hero-buttons">
            <a href="/login" class="btn btn-primary">
              🚀 Jetzt starten
            </a>
            <a href="#features" class="btn btn-secondary">
              🎯 Features ansehen
            </a>
          </div>
        </div>

        <div class="code-terminal animate-fade-in">
          <div class="terminal-header">
            <div class="terminal-dot red"></div>
            <div class="terminal-dot yellow"></div>
            <div class="terminal-dot green"></div>
            <div class="terminal-title">editor.php</div>
            <div class="terminal-status">
              <div class="status-dot"></div>
              LIVE
            </div>
          </div>
          <div class="terminal-content">
            <div class="code-line"><span class="comment">// Brickpage Live Editor</span></div>
            <div class="code-line"><span class="php">&lt;?php</span></div>
            <div class="code-line">&nbsp;&nbsp;<span class="php">echo</span> <span class="string">"Hello World!"</span>;</div>
            <div class="code-line"><span class="php">?&gt;</span></div>
            <div class="code-line"><br></div>
            <div class="code-line"><span class="tag">&lt;div</span> <span class="attr">class</span>=<span class="string">"hero"</span><span class="tag">&gt;</span></div>
            <div class="code-line">&nbsp;&nbsp;<span class="tag">&lt;h1&gt;</span>Instant Magic!<span class="tag">&lt;/h1&gt;</span></div>
            <div class="code-line"><span class="tag">&lt;/div&gt;</span></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section (Modern 2025 Update) -->
  <section id="features" class="features">
    <style>
      /* Scoped modern styles for the Features section */
      #features .features-inner {
        position: relative;
        padding: 24px 0 8px;
      }

      /* subtle abstract background */
      #features::before {
        content: '';
        position: absolute;
        inset: -40% -10% auto -10%;
        height: 380px;
        background: radial-gradient( circle at 10% 20%, rgba(99,102,241,0.12), transparent 12% ),
                    radial-gradient( circle at 90% 80%, rgba(16,185,129,0.06), transparent 12% );
        filter: blur(50px);
        z-index: 0;
        pointer-events: none;
      }

      .features-grid-modern {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        position: relative;
        z-index: 1;
      }

      @media (max-width: 1100px) {
        .features-grid-modern { grid-template-columns: repeat(2, 1fr); }
      }
      @media (max-width: 680px) {
        .features-grid-modern { grid-template-columns: 1fr; }
      }

      .feature-card-modern {
        display: flex;
        flex-direction: column;
        gap: 14px;
        padding: 22px;
        border-radius: 14px;
        background: linear-gradient(180deg, rgba(255,255,255,0.55), rgba(255,255,255,0.38));
        border: 1px solid rgba(255,255,255,0.06);
        backdrop-filter: blur(8px) saturate(120%);
        box-shadow: 0 8px 30px rgba(12, 18, 38, 0.08);
        transition: transform 0.35s cubic-bezier(.2,.9,.3,1), box-shadow 0.35s;
        min-height: 150px;
      }

      .feature-card-modern:hover {
        transform: translateY(-10px) rotateZ(-0.25deg);
        box-shadow: 0 20px 50px rgba(12, 18, 38, 0.12);
      }

      .feature-top {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .feature-icon-modern {
        width: 64px;
        height: 64px;
        flex: 0 0 64px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(99,102,241,0.06));
        border: 1px solid rgba(99,102,241,0.12);
        color: var(--primary);
        box-shadow: 0 6px 18px rgba(99,102,241,0.06);
      }

      .feature-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-900);
        display: flex;
        gap: 8px;
        align-items: center;
      }

      .feature-badge {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 999px;
        background: linear-gradient(90deg, rgba(99,102,241,0.14), rgba(16,185,129,0.06));
        color: var(--primary);
        font-weight: 600;
      }

      .feature-desc {
        color: var(--text-700);
        line-height: 1.5;
        font-size: 14px;
      }

      .feature-meta {
        margin-top: auto;
        display: flex;
        gap: 10px;
        align-items: center;
      }

      .meta-chip {
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(0,0,0,0.03);
        color: var(--text-700);
        border: 1px solid rgba(0,0,0,0.03);
      }

      .feature-actions {
        margin-left: auto;
        display: inline-flex;
        gap: 8px;
      }

      .btn-ghost {
        background: transparent;
        border: 1px solid rgba(99,102,241,0.12);
        color: var(--primary);
        padding: 6px 10px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
      }

      /* small accent underline animation for headings */
      #features .section-header h2 {
        position: relative;
        display: inline-block;
      }
      #features .section-header h2::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 48px;
        height: 4px;
        border-radius: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        transform-origin: left center;
        transform: scaleX(1);
        opacity: 0.95;
      }
    </style>

    <div class="container features-inner">
      <div class="section-header animate-fade-in">
        <h2>Warum Brickpage?</h2>
        <p>Die perfekte Balance zwischen Power und Einfachheit — modern, performant, und developer-first.</p>
      </div>

      <div class="features-grid-modern">
        <div class="feature-card-modern animate-fade-in" role="article" aria-label="Live Preview">
          <div class="feature-top">
            <div class="feature-icon-modern" aria-hidden="true">
              <!-- live icon with gradient -->
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v4"></path>
                <path d="M12 15v4"></path>
                <path d="M5 12h4"></path>
                <path d="M15 12h4"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </div>
            <div>
              <div class="feature-title">Live Preview <span class="feature-badge">Zero-Delay</span></div>
              <div class="feature-desc">Instantes Live-Rendering mit selektivem Hot-Reload — nur das, was sich ändert, wird neu gerendert.</div>
            </div>
          </div>

          <div class="feature-meta">
            <div class="meta-chip">Diff-aware</div>
            <div class="meta-chip">Partial HMR</div>
            <div class="feature-actions">
              <button class="btn-ghost" aria-label="Mehr erfahren">Mehr</button>
            </div>
          </div>
        </div>

        <div class="feature-card-modern animate-fade-in" role="article" aria-label="Visual Editor">
          <div class="feature-top">
            <div class="feature-icon-modern" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 7h18"></path>
                <path d="M3 12h18"></path>
                <path d="M3 17h18"></path>
              </svg>
            </div>
            <div>
              <div class="feature-title">Visual Editor <span class="feature-badge">WYSIWYG + Code</span></div>
              <div class="feature-desc">Split-View mit Side-by-side Editing, responsiven Frames und integrierter Vorschau für Desktop/Tablet/Mobile.</div>
            </div>
          </div>

          <div class="feature-meta">
            <div class="meta-chip">Syntax Highlight</div>
            <div class="meta-chip">Multi-view</div>
            <div class="feature-actions">
              <button class="btn-ghost">Try Demo</button>
            </div>
          </div>
        </div>

        <div class="feature-card-modern animate-fade-in" role="article" aria-label="Security">
          <div class="feature-top">
            <div class="feature-icon-modern" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z"></path>
                <path d="M9 12h6"></path>
              </svg>
            </div>
            <div>
              <div class="feature-title">Security First <span class="feature-badge">Enterprise</span></div>
              <div class="feature-desc">Default sichere Konfigurationen: Auth, CSRF, Policy-Layer und verschlüsselte Backups.</div>
            </div>
          </div>

          <div class="feature-meta">
            <div class="meta-chip">RBAC</div>
            <div class="meta-chip">Audit-Logs</div>
            <div class="feature-actions">
              <button class="btn-ghost">Docs</button>
            </div>
          </div>
        </div>

        <div class="feature-card-modern animate-fade-in" role="article" aria-label="Performance">
          <div class="feature-top">
            <div class="feature-icon-modern" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12h3l3 8 4-16 3 8h4"></path>
              </svg>
            </div>
            <div>
              <div class="feature-title">Rapid Development <span class="feature-badge">Edge-ready</span></div>
              <div class="feature-desc">Optimierte Build-Pipeline, CDN-cache friendly assets und smartes Debouncing für Entwicklerfluss ohne Lag.</div>
            </div>
          </div>

          <div class="feature-meta">
            <div class="meta-chip">Tiny Bundles</div>
            <div class="meta-chip">Edge Cache</div>
            <div class="feature-actions">
              <button class="btn-ghost">Performance</button>
            </div>
          </div>
        </div>

        <div class="feature-card-modern animate-fade-in" role="article" aria-label="Routing">
          <div class="feature-top">
            <div class="feature-icon-modern" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 21v-6a9 9 0 0 1 9-9h6"></path>
                <path d="M21 21h-6a9 9 0 0 0-9-9"></path>
              </svg>
            </div>
            <div>
              <div class="feature-title">Smart Routing <span class="feature-badge">Auto</span></div>
              <div class="feature-desc">Declarative routes, auto-discovery, middleware stacks und first-class parameter handling.</div>
            </div>
          </div>

          <div class="feature-meta">
            <div class="meta-chip">Middleware</div>
            <div class="meta-chip">Auto-Discovery</div>
            <div class="feature-actions">
              <button class="btn-ghost">Learn</button>
            </div>
          </div>
        </div>

        <div class="feature-card-modern animate-fade-in" role="article" aria-label="Developer Joy">
          <div class="feature-top">
            <div class="feature-icon-modern" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div>
              <div class="feature-title">Developer Joy <span class="feature-badge">Focus</span></div>
              <div class="feature-desc">Shortcuts, toasts, keyboard-first UX und eine vollständig lokalisierte deutsche Oberfläche.</div>
            </div>
          </div>

          <div class="feature-meta">
            <div class="meta-chip">Shortcuts</div>
            <div class="meta-chip">Toasts</div>
            <div class="feature-actions">
              <button class="btn-ghost">Get Started</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section (modernized to match Features, icons removed) -->
  <section id="stats" class="stats">
    <style>
      /* Scoped modern styles for the Stats section to match Features (simplified, no icons) */
      #stats {
        padding: 80px 0;
        background: white;
        position: relative;
      }

      #stats .stats-inner {
        position: relative;
        z-index: 1;
      }

      #stats .stats-header {
        text-align: center;
        margin-bottom: 36px;
      }

      #stats .stats-header h2 {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-900);
        margin-bottom: 8px;
        position: relative;
        display: inline-block;
      }

      #stats .stats-header p {
        color: var(--text-500);
        margin-top: 4px;
      }

      .stats-grid-modern {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1100px;
        margin: 0 auto;
      }

      @media (max-width: 1100px) {
        .stats-grid-modern { grid-template-columns: repeat(2, 1fr); }
      }
      @media (max-width: 680px) {
        .stats-grid-modern { grid-template-columns: 1fr; }
      }

      .stat-card-modern {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 18px;
        border-radius: 14px;
        background: linear-gradient(180deg, rgba(255,255,255,0.72), rgba(250,250,250,0.92));
        border: 1px solid rgba(15, 23, 42, 0.04);
        box-shadow: 0 8px 24px rgba(12, 18, 38, 0.06);
        min-height: 120px;
        align-items: center; /* center content since no icons */
        text-align: center;
      }

      /* stat-top simplified: value above label */
      .stat-top {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: center;
        width: 100%;
      }

      .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-900);
      }

      .stat-label {
        font-size: 13px;
        color: var(--text-700);
        font-weight: 600;
      }

      .stat-meta {
        margin-top: auto;
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: center;
        width: 100%;
      }

      .meta-chip {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(0,0,0,0.03);
        color: var(--text-700);
        border: 1px solid rgba(0,0,0,0.03);
      }

      .dev-badge-modern {
        display: inline-flex;
        gap: 10px;
        align-items: center;
        padding: 10px 14px;
        border-radius: 999px;
        background: linear-gradient(90deg, rgba(99,102,241,0.08), rgba(16,185,129,0.03));
        border: 1px solid rgba(99,102,241,0.08);
        color: var(--primary);
        font-weight: 600;
        margin: 20px auto 0;
      }

      /* subtle underline like features */
      #stats .stats-header h2::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 48px;
        height: 4px;
        border-radius: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        transform-origin: left center;
        transform: scaleX(1);
        opacity: 0.95;
      }
    </style>

    <div class="container stats-inner">
      <div class="stats-header animate-fade-in">
        <h2>System Status</h2>
        <p>Kurzer Überblick über Environment, Version und Entwicklungsmodus</p>
      </div>

      <div class="stats-grid-modern">
        <div class="stat-card-modern animate-fade-in" role="status" aria-label="Environment">
          <div class="stat-top">
            <div class="stat-value"><?= htmlspecialchars(substr((string)_get('env'), 0, 3), ENT_QUOTES, 'UTF-8') ?></div>
            <div class="stat-label">Environment</div>
          </div>
          <div class="stat-meta">
            <div class="meta-chip">Full: <?= htmlspecialchars((string)_get('env'), ENT_QUOTES, 'UTF-8') ?></div>
            <div class="meta-chip">Safe Read</div>
          </div>
        </div>

        <div class="stat-card-modern animate-fade-in" role="status" aria-label="App Version">
          <div class="stat-top">
            <div class="stat-value"><?= htmlspecialchars((string)_get('app.version'), ENT_QUOTES, 'UTF-8') ?></div>
            <div class="stat-label">Version</div>
          </div>
          <div class="stat-meta">
            <div class="meta-chip">Release</div>
            <div class="meta-chip">Immutable</div>
          </div>
        </div>

        <div class="stat-card-modern animate-fade-in" role="status" aria-label="Debug Mode">
          <div class="stat-top">
            <div class="stat-value"><?= _get('debug') ? 'ON' : 'OFF' ?></div>
            <div class="stat-label">Debug Mode</div>
          </div>
          <div class="stat-meta">
            <div class="meta-chip"><?= _get('debug') ? 'Verbose' : 'Silent' ?></div>
            <div class="meta-chip">Logs <?= _get('debug') ? 'Verbose' : 'Standard' ?></div>
          </div>
        </div>

        <div class="stat-card-modern animate-fade-in" role="status" aria-label="Asset Mode">
          <div class="stat-top">
            <div class="stat-value"><?= _get('dev_mode') ? 'DEV' : 'PROD' ?></div>
            <div class="stat-label">Asset Mode</div>
          </div>
          <div class="stat-meta">
            <div class="meta-chip"><?= _get('dev_mode') ? 'Hot Reload' : 'Optimized' ?></div>
            <div class="meta-chip"><?= _get('dev_mode') ? 'Vite' : 'Bundled' ?></div>
          </div>
        </div>
      </div>

      <?php if (_get('dev_mode')): ?>
        <div class="dev-badge-modern">
          <div class="status-dot" style="width:10px;height:10px;border-radius:999px;background:var(--success);box-shadow:0 0 8px rgba(16,185,129,0.6)"></div>
          Vite Dev Server läuft — Hot Reload aktiv
        </div>
      <?php endif; ?>
    </div>
  </section>

  <section id="faq" class="features">
    <style>
      /* Scoped FAQ styles matching page design */
      #faq {
        padding: 80px 0;
        background: var(--bg-50);
        position: relative;
      }

      #faq .container {
        max-width: 1000px;
      }

      #faq .section-header {
        text-align: center;
        margin-bottom: 40px;
      }

      #faq .section-header h2 {
        font-size: 36px;
        font-weight: 700;
        color: var(--text-900);
        margin-bottom: 8px;
      }

      .faq-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
      }

      @media (max-width: 900px) {
        .faq-grid { grid-template-columns: 1fr; }
      }

      .faq-item {
        background: white;
        border-radius: 12px;
        padding: 14px;
        border: 1px solid var(--text-300);
        box-shadow: var(--shadow-sm);
        transition: box-shadow 0.25s ease, transform 0.25s ease;
        overflow: hidden;
        position: relative;
      }

      .faq-item:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
      }

      .faq-question {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        background: transparent;
        border: none;
        padding: 6px 0;
        font-size: 16px;
        font-weight: 700;
        color: var(--text-900);
        cursor: pointer;
        text-align: left;
      }

      .faq-question:focus {
        outline: 3px solid rgba(99,102,241,0.12);
        border-radius: 8px;
      }

      .faq-chev {
        margin-left: auto;
        transition: transform 0.25s ease;
        color: var(--primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
      }

      .faq-item[aria-expanded="true"] .faq-chev {
        transform: rotate(180deg);
      }

      .faq-answer {
        margin-top: 10px;
        color: var(--text-700);
        line-height: 1.6;
        font-size: 14px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s cubic-bezier(.2,.9,.3,1), opacity 0.25s ease;
        opacity: 0;
      }

      .faq-item[aria-expanded="true"] .faq-answer {
        opacity: 1;
        /* large enough to contain content; will expand naturally */
        max-height: 400px;
      }

      .faq-meta {
        margin-top: 12px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
      }

      .meta-chip {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(99,102,241,0.08);
        color: var(--primary);
        border: 1px solid rgba(99,102,241,0.08);
        font-weight: 600;
      }
    </style>

    <div class="container">
      <div class="section-header animate-fade-in">
        <h2>Häufig gestellte Fragen</h2>
        <p>Kurze Antworten zu Development-Workflow, Sicherheit und Deployment mit Brickpage.</p>
      </div>

      <div class="faq-grid">
        <article class="faq-item animate-fade-in" role="button" tabindex="0" aria-expanded="false">
          <button class="faq-question" aria-controls="faq1">
            Wie funktioniert das Live-Preview / Hot-Reload?
            <span class="faq-chev" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </span>
          </button>
          <div id="faq1" class="faq-answer">
            Brickpage beobachtet nur die veränderten Komponenten und rendert selektiv neu (Partial HMR). Assets werden über Vite im Dev-Modus live nachgeladen.
            <div class="faq-meta">
              <span class="meta-chip">Zero-Delay</span>
              <span class="meta-chip">Diff-aware</span>
            </div>
          </div>
        </article>

        <article class="faq-item animate-fade-in" role="button" tabindex="0" aria-expanded="false">
          <button class="faq-question" aria-controls="faq2">
            Ist die Plattform sicher für Produktion?
            <span class="faq-chev" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </span>
          </button>
          <div id="faq2" class="faq-answer">
            Ja. Brickpage liefert sichere Defaults (Auth, CSRF-Schutz, Policy-Layer). Produktions-Builds nutzen optimierte Bundles und verschlüsselte Backups.
            <div class="faq-meta">
              <span class="meta-chip">RBAC</span>
              <span class="meta-chip">Audit-Logs</span>
            </div>
          </div>
        </article>

        <article class="faq-item animate-fade-in" role="button" tabindex="0" aria-expanded="false">
          <button class="faq-question" aria-controls="faq3">
            Wie deployed man in die Produktion?
            <span class="faq-chev" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </span>
          </button>
          <div id="faq3" class="faq-answer">
            Production-Builds werden via CI erstellt; Assets werden gepackt und CDN-freundlich ausgeliefert. Optionales One-Click-Deploy in CI/CD-Integrationen.
            <div class="faq-meta">
              <span class="meta-chip">Edge-ready</span>
              <span class="meta-chip">CDN</span>
            </div>
          </div>
        </article>

        <article class="faq-item animate-fade-in" role="button" tabindex="0" aria-expanded="false">
          <button class="faq-question" aria-controls="faq4">
            Unterstützt Brickpage mehrere Umgebungen (Dev/Staging/Prod)?
            <span class="faq-chev" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </span>
          </button>
          <div id="faq4" class="faq-answer">
            Ja — Umgebungen sind first-class. Konfigurationen, Feature-Toggles und sichere Secrets-Management erlauben getrennte Flows für Dev, Staging und Prod.
            <div class="faq-meta">
              <span class="meta-chip">Env-Aware</span>
              <span class="meta-chip">Config Profiles</span>
            </div>
          </div>
        </article>

        <article class="faq-item animate-fade-in" role="button" tabindex="0" aria-expanded="false">
          <button class="faq-question" aria-controls="faq5">
            Gibt es eine deutsche Dokumentation und Support?
            <span class="faq-chev" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </span>
          </button>
          <div id="faq5" class="faq-answer">
            Ja, die Oberfläche ist lokalisiert und die Dokumentation sowie Support-Artikel sind auf Deutsch verfügbar. Für Enterprise-Kunden gibt es dedizierten Support.
            <div class="faq-meta">
              <span class="meta-chip">DE Docs</span>
              <span class="meta-chip">Enterprise Support</span>
            </div>
          </div>
        </article>
      </div>
    </div>

    <script>
      // FAQ accordion behavior (accessible, keyboard friendly)
      (function() {
        const items = document.querySelectorAll('#faq .faq-item');

        function toggleItem(item, expand) {
          item.setAttribute('aria-expanded', expand ? 'true' : 'false');
        }

        items.forEach(item => {
          const button = item.querySelector('.faq-question');
          const answer = item.querySelector('.faq-answer');

          // click toggles
          button.addEventListener('click', (e) => {
            const expanded = item.getAttribute('aria-expanded') === 'true';
            // allow multiple open; if you want single-open, close others here
            toggleItem(item, !expanded);
          });

          // keyboard support: Enter / Space to toggle
          item.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              const expanded = item.getAttribute('aria-expanded') === 'true';
              toggleItem(item, !expanded);
            }
            // Home / End to navigate between items
            if (e.key === 'Home') {
              e.preventDefault();
              items[0].focus();
            }
            if (e.key === 'End') {
              e.preventDefault();
              items[items.length - 1].focus();
            }
          });
        });
      })();
    </script>
  </section>

  <!-- CTA Section -->
  <section class="cta">
    <div class="container">
      <h2>Bereit durchzustarten?</h2>
      <p>Erlebe Live-Coding der nächsten Generation</p>
      <div class="cta-buttons">
        <a href="/login" class="btn btn-white">
          🚀 Jetzt einloggen
        </a>
        <a href="/register" class="btn btn-outline">
          ✨ Account erstellen
        </a>
      </div>
    </div>
  </section>

  <script>
    // Intersection Observer für Animationen
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
        }
      });
    }, observerOptions);

    // Alle animierbaren Elemente beobachten
    document.querySelectorAll('.animate-fade-in').forEach((el) => {
      observer.observe(el);
    });

    // Smooth Scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Navbar Scroll Effect
    window.addEventListener('scroll', () => {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.style.background = 'rgba(255, 255, 255, 0.95)';
        navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
      } else {
        navbar.style.background = 'rgba(255, 255, 255, 0.9)';
        navbar.style.boxShadow = 'none';
      }
    });
  </script>
</body>

</html>