<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CRM — Customer Relationship Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link href="assets/css/crm.css" rel="stylesheet"/>
  <style>
    body { margin:0; font-family:'Inter',sans-serif; background:#fff; }

    /* NAVBAR */
    .navbar {
      position: fixed; top:0; left:0; right:0; z-index:100;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid #e2e8f0;
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 40px; height: 64px;
    }
    .nav-logo { display:flex; align-items:center; gap:10px; font-size:18px; font-weight:700; color:#1e293b; text-decoration:none; }
    .nav-logo span { background:#4f46e5; color:#fff; width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:16px; }
    .nav-links { display:flex; align-items:center; gap:8px; }
    .nav-links a { padding:8px 18px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none; transition:all 0.2s; }
    .nav-links .btn-ghost { color:#475569; }
    .nav-links .btn-ghost:hover { background:#f1f5f9; color:#1e293b; }
    .nav-links .btn-filled { background:#4f46e5; color:#fff; }
    .nav-links .btn-filled:hover { background:#3730a3; }

    /* HERO */
    .hero {
      padding: 140px 40px 80px;
      background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 50%, #f0fdf4 100%);
      text-align: center;
    }
    .hero-badge {
      display: inline-flex; align-items:center; gap:6px;
      background:#ede9fe; color:green;
      padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600;
      margin-bottom:20px;
    }
    .hero h1 {
      font-size: clamp(32px, 5vw, 56px);
      font-weight: 800; color:black; line-height:1.15;
      margin-bottom: 16px;
    }
    .hero h1 span { color:black; }
    .hero p {
      font-size:17px; color:#64748b; max-width:560px;
      margin:0 auto 32px; line-height:1.7;
    }
    .hero-btns { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }
    .hero-btns a {
      padding:13px 28px; border-radius:10px; font-size:15px;
      font-weight:600; text-decoration:none; display:inline-flex;
      align-items:center; gap:8px; transition:all 0.2s;
    }
    .btn-hero-primary { background:#4f46e5; color:#fff; box-shadow:0 4px 14px rgba(79,70,229,0.3); }
    .btn-hero-primary:hover { background:#3730a3; transform:translateY(-1px); }
    .btn-hero-outline { background:#fff; color:#4f46e5; border:2px solid #4f46e5; }
    .btn-hero-outline:hover { background:#ede9fe; }

    /* FEATURES */
    .section { padding:80px 40px; }
    .section-title { text-align:center; margin-bottom:48px; }
    .section-title h2 { font-size:32px; font-weight:700; color:#1e293b; margin-bottom:10px; }
    .section-title p { font-size:15px; color:#64748b; max-width:480px; margin:0 auto; }
    .features-grid {
      display:grid; grid-template-columns:repeat(auto-fit, minmax(260px,1fr));
      gap:24px; max-width:1100px; margin:0 auto;
    }
    .feature-card {
      background:#fff; border:1px solid #e2e8f0; border-radius:14px;
      padding:28px; transition:all 0.2s;
    }
    .feature-card:hover { box-shadow:0 8px 24px rgba(0,0,0,0.08); transform:translateY(-3px); }
    .feature-icon {
      width:48px; height:48px; border-radius:12px;
      display:flex; align-items:center; justify-content:center;
      font-size:20px; margin-bottom:16px;
    }
    .feature-card h3 { font-size:16px; font-weight:600; color:#1e293b; margin-bottom:8px; }
    .feature-card p { font-size:13px; color:#64748b; line-height:1.6; }

    /* STATS BAR */
    .stats-bar {
      background:#4f46e5; padding:40px;
      display:flex; justify-content:center; gap:60px; flex-wrap:wrap;
    }
    .stat-item { text-align:center; color:#fff; }
    .stat-item .num { font-size:36px; font-weight:800; }
    .stat-item .lbl { font-size:13px; opacity:0.8; margin-top:4px; }

    /* CTA */
    .cta-section {
      background:linear-gradient(135deg,#1e1b4b,#4f46e5);
      padding:80px 40px; text-align:center; color:#fff;
    }
    .cta-section h2 { font-size:32px; font-weight:700; margin-bottom:12px; }
    .cta-section p { font-size:15px; opacity:0.85; margin-bottom:28px; }
    .cta-btns { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }
    .cta-btns a {
      padding:12px 26px; border-radius:10px; font-size:14px; font-weight:600;
      text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;
    }
    .btn-cta-white { background:#fff; color:#4f46e5; }
    .btn-cta-white:hover { background:#e0e7ff; }
    .btn-cta-ghost { background:rgba(255,255,255,0.1); color:#fff; border:1px solid rgba(255,255,255,0.3); }
    .btn-cta-ghost:hover { background:rgba(255,255,255,0.2); }

    /* FOOTER */
    footer { background:#0f172a; color:#94a3b8; text-align:center; padding:24px 40px; font-size:13px; }
    footer a { color:#94a3b8; text-decoration:none; }

    @media(max-width:600px) {
      .navbar { padding:0 20px; }
      .hero { padding:100px 20px 60px; }
      .section { padding:60px 20px; }
      .stats-bar { gap:30px; }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <span><i class="fa fa-chart-pie"></i></span> CRM System
  </a>
  <div class="nav-links">
    <a href="auth/login.php" class="btn-ghost" style="color:black;" >Login</a>
    
    <a href="admin/index.php" class="btn-ghost" style="color:black;">Admin</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-badge"><i class="fa fa-star"></i> Simple & Powerful CRM</div>
  <h1>Manage Customers &<br/><span>Grow Your Business</span></h1>
  <p>One platform to handle support tickets, service requests, and customer relationships — all in one place.</p>
  <div class="hero-btns">
    <a href="auth/registration.php" class="btn-hero-primary"><i class="fa fa-user-plus"></i> Create Free Account</a>
    <a href="auth/login.php" class="btn-hero-outline"><i class="fa fa-right-to-bracket"></i> Sign In</a>
  </div>
</section>

<!-- STATS -->
<div class="stats-bar">
  <div class="stat-item"><div class="num">100%</div><div class="lbl">Free to Use</div></div>
  <div class="stat-item"><div class="num">2</div><div class="lbl">User Roles</div></div>
  <div class="stat-item"><div class="num">18+</div><div class="lbl">Services to Quote</div></div>
  <div class="stat-item"><div class="num">24/7</div><div class="lbl">Ticket Support</div></div>
</div>

<!-- FEATURES -->
<section class="section" style="background:#f8fafc;">
  <div class="section-title">
    <h2>Everything You Need</h2>
    <p>A complete set of tools for managing your customers and their requests</p>
  </div>
  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon" style="background:#dbeafe; color:#2563eb;"><i class="fa fa-user-plus"></i></div>
      <h3>User Registration</h3>
      <p>Customers can create accounts instantly. Duplicate emails are automatically blocked.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon" style="background:#dcfce7; color:#16a34a;"><i class="fa fa-ticket"></i></div>
      <h3>Support Tickets</h3>
      <p>Raise, track and manage support tickets with priority levels and real-time status updates.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon" style="background:#ede9fe; color:#7c3aed;"><i class="fa fa-file-invoice-dollar"></i></div>
      <h3>Quote Requests</h3>
      <p>Submit service quotation requests by selecting from 18 different services with a single click.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon" style="background:#ffedd5; color:#ea580c;"><i class="fa fa-gauge-high"></i></div>
      <h3>Admin Dashboard</h3>
      <p>Live statistics, visitor charts, and full control over users, tickets and quotes.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon" style="background:#fef9c3; color:#ca8a04;"><i class="fa fa-shield-halved"></i></div>
      <h3>Secure Access</h3>
      <p>Separate login systems for users and admin. Session-based authentication on every page.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon" style="background:#fce7f3; color:#db2777;"><i class="fa fa-user-pen"></i></div>
      <h3>Profile Management</h3>
      <p>Users can update their profile, contact details, and change their password anytime.</p>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <h2>Ready to Get Started?</h2>
  <p>Create your free account in seconds and start managing customer relationships today.</p>
  <div class="cta-btns">
    <a href="auth/registration.php" class="btn-cta-white"><i class="fa fa-user-plus"></i> Sign Up Free</a>
    <a href="auth/login.php" class="btn-cta-ghost"><i class="fa fa-right-to-bracket"></i> Already have account? Login</a>
  </div>
</section>

<footer>
  <p>CRM System &nbsp;|&nbsp; Built with PHP &amp; MySQL &nbsp;|&nbsp; <a href="admin/index.php">Admin Panel</a></p>
</footer>

</body>
</html>
