<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Government Polytechnic Nainital - Digital Brochure</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- AOS Animation Library -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Particles.js -->
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

  <style>

    /* ===== BASE STYLES ===== */
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'Poppins',sans-serif;background:#f5f7fa;overflow-x:hidden;line-height:1.6}

/* ===== COLLEGE COLORS ===== */
:root{
    --primary-color:#1a237e;
    --secondary-color:#800000;
    --accent-color:#ffd700;
    --dark-text:#1a1a2e;
    --light-text:#666;
    --white:#ffffff;
    --light-bg:#f5f7fa;
}

/* ===== TOPBAR ===== */
.topbar{background:linear-gradient(90deg,#1a237e,#283593);color:#fff;padding:8px 0;font-size:14px}
.topbar .container{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap}
.topbar-left{display:flex;align-items:center;gap:20px}
.topbar-left i{margin-right:8px;color:#ffd700}
.topbar-right{display:flex;align-items:center;gap:15px}
.topbar-right a{color:#fff;text-decoration:none;font-size:13px;transition:0.3s}
.topbar-right a:hover{color:#ffd700}

/* ===== HEADER ===== */
.header-area{background:#fff;box-shadow:0 2px 15px rgba(0,0,0,0.1);padding:18px 0;position:sticky;top:0;z-index:1000}
.logo-section{display:flex;align-items:center;gap:12px}
.logo-box{background:transparent;padding:0}
.logo-box img{width:90px;height:auto;display:block}
.logo-text h4{margin:0;color:var(--primary-color);font-weight:700;font-size:15px;line-height:1.2;white-space:nowrap}
.logo-text span{color:var(--secondary-color);font-size:12px;font-weight:600;white-space:nowrap}

/* ===== NAVIGATION ===== */
.main-nav{display:flex;align-items:center;gap:2px;flex-wrap:nowrap;justify-content:flex-end}
.main-nav a{color:var(--dark-text);text-decoration:none;font-weight:600;font-size:13px;padding:8px 12px;border-radius:5px;transition:all 0.3s;white-space:nowrap}
.main-nav a:hover{background:var(--primary-color);color:#fff}
.main-nav a.active{background:var(--primary-color);color:#fff}
.main-nav a.highlight{background:var(--secondary-color);color:#fff}

/* NEW BUTTON - FAST BLINKING WITH WHITE TEXT */
.new-btn{background:#ff0000;color:#ffffff;padding:6px 14px;border-radius:20px;font-weight:700;font-size:12px;display:inline-block;animation:blink 0.3s infinite;text-decoration:none;transition:0.3s;border:none;cursor:pointer}
.new-btn:hover{background:#cc0000;transform:scale(1.1);color:#ffffff}
.new-btn i{margin-right:5px}
@keyframes blink{
0%,100%{opacity:1;transform:scale(1);}
50%{opacity:0.5;transform:scale(0.95);}
}

/* ===== MARQUEE SECTION - MOVING TEXT ===== */
.marquee-section{background:linear-gradient(90deg,var(--secondary-color),#9c1a1a,var(--secondary-color));padding:12px 0;overflow:hidden}
.marquee-container{overflow:hidden;white-space:nowrap}
.marquee-content{display:inline-block;animation:marquee 20s linear infinite}
.marquee-content span{margin-right:60px;font-size:16px;font-weight:600;color:#fff;display:inline-flex;align-items:center;gap:10px}
.marquee-content span i{color:var(--accent-color)}
@keyframes marquee{
0%{transform:translateX(0);}
100%{transform:translateX(-50%);}
}

    :root {
      --primary-color: #004080;
      --secondary-color: #0056b3;
      --accent-color: #ffc107;
      --text-dark: #333;
      --text-light: #666;
      --bg-light: #f8f9fa;
      --bg-dark: #1a1a2e;
      --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
      overflow-x: hidden;
      scroll-behavior: smooth;
    }

    /* --- Enhanced Navigation --- */
    .navbar {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(20px);
      box-shadow: 0 4px 30px rgba(0,0,0,0.1);
      padding: 1rem 0;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .navbar.scrolled {
      padding: 0.5rem 0;
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 2px 20px rgba(0,0,0,0.15);
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.8rem;
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .nav-link {
      color: var(--text-dark) !important;
      font-weight: 500;
      margin: 0 15px;
      padding: 10px 0 !important;
      position: relative;
      transition: all 0.3s ease;
    }

    .nav-link::before {
      content: '';
      position: absolute;
      width: 0;
      height: 3px;
      bottom: 0;
      left: 50%;
      background: var(--gradient-primary);
      transition: all 0.3s ease;
      border-radius: 2px;
    }

    .nav-link:hover::before,
    .nav-link.active::before {
      width: 100%;
      left: 0;
    }

    .nav-link:hover,
    .nav-link.active {
      color: var(--primary-color) !important;
      transform: translateY(-2px);
    }

    .btn-apply {
      background: var(--gradient-primary);
      color: white;
      padding: 12px 30px;
      border-radius: 50px;
      font-weight: 600;
      border: none;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
    }

    .btn-apply::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s;
    }

    .btn-apply:hover::before {
      left: 100%;
    }

    .btn-apply:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 10px 30px rgba(0, 64, 128, 0.4);
      color: white;
    }

    /* --- Hero Section Enhanced --- */
    .hero-section {
      background: linear-gradient(135deg, rgba(0, 64, 128, 0.92), rgba(0, 86, 179, 0.95)), 
                  url('https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      color: white;
      padding: 200px 0 150px;
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
        radial-gradient(circle at 20% 80%, rgba(255, 193, 7, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
      animation: heroGlow 6s ease-in-out infinite alternate;
    }

    @keyframes heroGlow {
      0% { opacity: 0.8; }
      100% { opacity: 1; }
    }

    .hero-title {
      font-size: clamp(2.5rem, 5vw, 4.5rem);
      font-weight: 800;
      margin-bottom: 25px;
      line-height: 1.1;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .hero-subtitle {
      font-size: 1.4rem;
      margin-bottom: 40px;
      opacity: 0.95;
      font-weight: 300;
    }

    /* --- Section Styling Enhanced --- */
    section {
      padding: 100px 0;
    }

    .section-title {
      text-align: center;
      margin-bottom: 70px;
    }

    .section-title h2 {
      font-size: clamp(2rem, 4vw, 3.2rem);
      font-weight: 700;
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 20px;
      position: relative;
    }

    .section-title h2::after {
      content: '';
      display: block;
      width: 100px;
      height: 5px;
      background: var(--gradient-primary);
      margin: 20px auto 0;
      border-radius: 3px;
      box-shadow: 0 2px 10px rgba(0, 64, 128, 0.3);
    }

    .section-title p {
      color: var(--text-light);
      font-size: 1.2rem;
      max-width: 700px;
      margin: 0 auto;
      font-weight: 300;
    }

    /* --- About Section Enhanced --- */
    .about-section {
      background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
      position: relative;
    }

    .about-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: var(--gradient-primary);
      box-shadow: 0 0 20px rgba(0, 64, 128, 0.1);
    }

    .about-img {
      border-radius: 25px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0,0,0,0.15);
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
    }

    .about-img::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, rgba(0, 64, 128, 0.1), rgba(255, 193, 7, 0.1));
      opacity: 0;
      transition: opacity 0.3s;
    }

    .about-img:hover::before {
      opacity: 1;
    }

    .about-img img {
      width: 100%;
      height: auto;
      transition: all 0.6s ease;
    }

    .about-img:hover img {
      transform: scale(1.08) rotate(1deg);
    }

    .stat-box {
      text-align: center;
      padding: 40px 20px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.08);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      height: 100%;
      position: relative;
      overflow: hidden;
    }

    .stat-box::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--gradient-primary);
    }

    .stat-box:hover {
      transform: translateY(-15px) scale(1.02);
      box-shadow: 0 25px 60px rgba(0,0,0,0.15);
    }

    .stat-number {
      font-size: clamp(2rem, 4vw, 3.5rem);
      font-weight: 800;
      background: var(--gradient-primary);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 15px;
    }

    /* --- Courses Section Enhanced --- */
    .courses-section {
      background: var(--bg-light);
      position: relative;
    }

    .course-card {
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0,0,0,0.08);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      height: 100%;
      border: none;
      position: relative;
    }

    .course-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--gradient-primary);
      transform: scaleX(0);
      transition: transform 0.4s ease;
    }

    .course-card:hover::before {
      transform: scaleX(1);
    }

    .course-card:hover {
      transform: translateY(-15px);
      box-shadow: 0 25px 60px rgba(0,0,0,0.2);
    }

    .course-icon {
      height: 160px;
      background: var(--gradient-primary);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 3.5rem;
      position: relative;
      overflow: hidden;
    }

    .course-icon::after {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
      transform: rotate(45deg);
      transition: all 0.6s;
      opacity: 0;
    }

    .course-card:hover .course-icon::after {
      opacity: 1;
      animation: shine 1.5s infinite;
    }

    @keyframes shine {
      0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
      100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    /* --- Contact Section Enhanced --- */
    .contact-section {
      background: linear-gradient(135deg, var(--bg-light) 0%, #e9f1ff 100%);
    }

    .contact-card {
      background: white;
      padding: 50px;
      border-radius: 25px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.1);
      transition: all 0.4s ease;
      border: 1px solid rgba(255,255,255,0.2);
    }

    .contact-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 30px 80px rgba(0,0,0,0.15);
    }

    .contact-info-item {
      display: flex;
      align-items: flex-start;
      gap: 20px;
      margin-bottom: 30px;
      padding: 20px;
      background: rgba(0, 64, 128, 0.02);
      border-radius: 15px;
      transition: all 0.3s ease;
    }

    .contact-info-item:hover {
      background: rgba(0, 64, 128, 0.05);
      transform: translateX(10px);
    }

    .contact-icon {
      width: 60px;
      height: 60px;
      background: var(--gradient-primary);
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.4rem;
      flex-shrink: 0;
      box-shadow: 0 5px 20px rgba(0, 64, 128, 0.3);
    }

    /* --- Enhanced Footer --- */
    

    .footer-main {
    background: linear-gradient(135deg, #0d1b2a 0%, #1a237e 50%, #0d1b2a 100%);
    color: #fff;
    padding: 60px 0 0;
}

.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.5fr;
    gap: 40px;
    margin-bottom: 40px;
}

.footer-about h3 {
    color: var(--accent-color);
    margin-bottom: 20px;
    font-size: 22px;
    font-weight: 700;
}
    
     .footer-about p {
    line-height: 1.8;
    opacity: 0.9;
    font-size: 14px;
    color: #ccc;
}

/* ===== FOOTER SOCIAL ICONS - PLATFORM SPECIFIC COLORS ===== */
.footer-social {
    margin-top: 20px;
    display: flex;
    gap: 10px;
}

.footer-social a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    font-size: 18px;
    text-decoration: none;
    transition: all 0.3s ease;
}
/* Facebook - Blue */
.footer-social a.facebook:hover {
    background: #1877f2;
    transform: translateY(-3px);
}

/* Instagram - Purple/Yellow Gradient */
.footer-social a.instagram:hover {
    background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
    transform: translateY(-3px);
}

/* Twitter/X - Blue */
.footer-social a.twitter:hover {
    background: #1da1f2;
    transform: translateY(-3px);
}

/* YouTube - Red */
.footer-social a.youtube:hover {
    background: #ff0000;
    transform: translateY(-3px);
}

/* ===== FOOTER LINKS - CLEAN WITHOUT ARROWS ===== */
.footer-links h4 {
    color: var(--accent-color);
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: 700;
}

.footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links ul li {
    margin-bottom: 12px;
}

.footer-links ul li a {
    color: #ccc;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.footer-links ul li a:hover {
    color: var(--accent-color);
    padding-left: 5px;
}
/* ===== CONTACT INFO - CLICKABLE ===== */
.contact-info {
    list-style: none;
    padding: 0;
    margin: 0;
}

.contact-info li {
    margin-bottom: 15px;
}

.contact-info li a {
    color: #ccc;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 12px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.05);
}

.contact-info li a:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

.contact-info li a i {
    width: 20px;
    text-align: center;
    font-size: 16px;
}

/* Phone - Green hover */
.contact-info li a.phone:hover {
    color: #25D366;
}

/* Email - Orange hover */
.contact-info li a.email:hover {
    color: #EA4335;
}

/* Location - Blue hover */
.contact-info li a.location:hover {
    color: #4285F4;
}

/* ===== FOOTER GALLERY SECTION - NEW ===== */
.footer-gallery h4 {
    color: var(--accent-color);
    margin-bottom: 20px;
    font-size: 18px;
    font-weight: 700;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}

.gallery-grid a {
    display: block;
    overflow: hidden;
    border-radius: 8px;
    position: relative;
}

.gallery-grid a img {
    width: 100%;
    height: 70px;
    object-fit: cover;
    transition: all 0.3s ease;
}

.gallery-grid a:hover img {
    transform: scale(1.1);
    filter: brightness(1.1);
}

.gallery-grid a::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(26, 35, 126, 0.3);
    opacity: 0;
    transition: all 0.3s ease;
}

.gallery-grid a:hover::after {
    opacity: 1;
}

/* ===== FOOTER BOTTOM ===== */


.footer-bottom {
    background: rgba(0, 0, 0, 0.3);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding: 20px 50px;
    text-align: center;
    border-top:2px solid #ffd700;
    
}

.footer-bottom p {
    margin: 0;
    font-size: 14px;
    color: #aaa;
}

.footer-bottom p i {
    color: #ebe4e4;
    margin: 0 5px;
}

    /* --- Responsive Design --- */
    @media (max-width: 768px) {
      .hero-section {
        padding: 120px 0 80px;
      }

      .hero-title {
        font-size: 2.5rem !important;
      }

      .navbar-brand {
        font-size: 1.4rem;
      }

      section {
        padding: 60px 0;
      }

      .section-title h2 {
        font-size: 2.2rem;
      }

      .about-img,
      .contact-card {
        margin-bottom: 30px;
      }

      .footer {
        padding: 50px 0 20px;
      }
    }

    @media (max-width: 576px) {
      .hero-title {
        font-size: 2rem !important;
      }

      .hero-subtitle {
        font-size: 1.1rem;
      }

      .btn-apply {
        padding: 12px 25px;
        font-size: 0.95rem;
      }
    }

    /* --- Loading Animation --- */
    .loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: var(--gradient-primary);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      transition: opacity 0.5s ease;
    }

    .loader.hidden {
      opacity: 0;
      pointer-events: none;
    }

    .spinner {
      width: 60px;
      height: 60px;
      border: 4px solid rgba(255,255,255,0.3);
      border-top: 4px solid white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* --- Scroll Progress Bar --- */
    .scroll-progress {
      position: fixed;
      top: 0;
      left: 0;
      width: 0%;
      height: 4px;
      background: var(--gradient-primary);
      z-index: 1001;
      transition: width 0.1s ease;
      box-shadow: 0 2px 10px rgba(0, 64, 128, 0.5);
    }
  </style>
</head>
<body>

    <!-- TOPBAR -->
<div class="topbar">
<div class="container">
<div class="topbar-left">
<i class="fas fa-graduation-cap"></i>
<span>Welcome to Government Polytechnic Nainital</span>
</div>
<div class="topbar-right">
<a href="tel:+919411158375"><i class="fas fa-phone"></i> +91 9411158375</a>
<a href="mailto:info@gpnainital.ac.in"><i class="fas fa-envelope"></i> info@gpnainital.ac.in</a>
</div>
</div>
</div>

<!-- HEADER -->
<header class="header-area">
<div class="container">
<div class="d-flex justify-content-between align-items-center flex-wrap">
<div class="logo-section">
<div class="logo-box">
<img src="Government_Polytechnic_Nainital_logo.png" alt="College Logo">
</div>
<div class="logo-text">
<h4>Uttarakhand Government Institute Of Polytechnic</h4>
<span>Nainital | Established 1956</span>
</div>
</div>
<nav class="main-nav">
<a href="index.php"><i class="fas fa-home"></i> Home</a>
<a href="book.php"><i class="fas fa-book"></i> Books</a>
<a href="notes.php"><i class="fas fa-sticky-note"></i> Notes</a>
<a href="videos.php"><i class="fas fa-video"></i> Videos</a>
<a href="audios.php"><i class="fas fa-headphones"></i> Audios</a>
<a href="brochure.php"class="active"><i class="fas fa-users"></i> Brochure</a>
<a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
<a href="announcement.php" class="new-btn"><i class="fas fa-bullhorn"></i> NEW</a>
</nav>
</div>
</div>
</header>

<!-- MARQUEE SECTION - MOVING TEXT -->
<div class="marquee-section">
<div class="marquee-container">
<div class="marquee-content">
<span><i class="fas fa-graduation-cap"></i> Welcome to Digital Audio Video Book Platform</span>
<span><i class="fas fa-book"></i> Access Books, Notes & Study Materials</span>
<span><i class="fas fa-video"></i> Watch Video Lectures Anytime</span>
<span><i class="fas fa-headphones"></i> Listen to Audio Lectures</span>
<span><i class="fas fa-university"></i> Government Polytechnic Nainital</span>
<span><i class="fas fa-graduation-cap"></i> Welcome to Digital Audio Video Book Platform</span>
<span><i class="fas fa-book"></i> Access Books, Notes & Study Materials</span>
<span><i class="fas fa-video"></i> Watch Video Lectures Anytime</span>
<span><i class="fas fa-headphones"></i> Listen to Audio Lectures</span>
<span><i class="fas fa-university"></i> Government Polytechnic Nainital</span>
</div>
</div>
</div>

  <!-- Loading Screen -->
  <div class="loader" id="loader">
    <div class="spinner"></div>
  </div>

  <!-- Scroll Progress Bar -->
  <div class="scroll-progress" id="scrollProgress"></div>

 

  <!-- Hero Section -->
  <section id="home" class="hero-section">
    <div class="container position-relative">
      <div class="row align-items-center">
        <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
          <h1 class="hero-title display-3 fw-bold mb-4">
            Excellence in <span style="color: var(--accent-color);">Technical</span> Education
          </h1>
          <p class="hero-subtitle lead mb-5">
            Government Polytechnic Nainital - Shaping Future Engineers Since 1975 with World-Class Infrastructure & Industry-Aligned Curriculum
          </p>
          
        </div>
        <div class="col-lg-5 text-center" data-aos="zoom-in" data-aos-delay="400">
          <div class="hero-image-container">
            <img src = "images\college\cp12.jpg"
                 alt="GPN Nainital Campus" class="img-fluid rounded-4 shadow-lg" style="max-height: 500px; object-fit: cover;">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="about-section">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Why Choose <span class="text-primary fw-bold">GPN Nainital?</span></h2>
        <p class="lead">A premier Government institution with 48+ years of excellence in technical education</p>
      </div>
      
      <div class="row align-items-center g-5">
        <div class="col-lg-6" data-aos="fade-right">
          <div class="about-img">
            <img src="images\college\cp2.jpg">
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <div class="about-content">
            <h3 class="display-6 fw-bold mb-4 text-primary">Our Legacy of Excellence</h3>
            <p class="lead mb-4">
              Established in 1975, Government Polytechnic Nainital is committed to delivering quality technical education with modern infrastructure and industry-relevant curriculum.
            </p>
            <div class="row g-3 mb-4">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <i class="bi bi-check-circle-fill text-success me-2" style="font-size: 1.5rem;"></i>
                  <span>Government Approved</span>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <i class="bi bi-check-circle-fill text-success me-2" style="font-size: 1.5rem;"></i>
                  <span>AICTE Affiliated</span>
                </div>
              </div>
            
            <a href="#contact" class="btn btn-outline-primary btn-lg px-5">
              <i class="bi bi-chat-dots me-2"></i>Get In Touch
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Admissions Section (Replaced Facilities) -->
  <section id="admissions" class="py-5 bg-light">
    <div class="container">
      <div class="section-title text-center" data-aos="fade-up">
        <h2>Admission <span class="text-primary fw-bold">Process 2025</span></h2>
        <p class="lead">Simple 3-step admission process for Diploma courses</p>
      </div>
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="text-center p-5 bg-white rounded-4 shadow-lg h-100 transition-all">
            <div class="step-icon mb-4 mx-auto">
              <i class="bi bi-1-circle-fill display-4 text-primary"></i>
            </div>
            <h4 class="h3 fw-bold mb-3">Step 1: Apply Online</h4>
            <p class="lead text-muted">Fill online application form through JEEP portal</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="text-center p-5 bg-white rounded-4 shadow-lg h-100 transition-all">
            <div class="step-icon mb-4 mx-auto">
              <i class="bi bi-2-circle-fill display-4 text-primary"></i>
            </div>
            <h4 class="h3 fw-bold mb-3">Step 2: Entrance Exam</h4>
            <p class="lead text-muted">Appear for Joint Entrance Examination Polytechnic (JEEP)</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="text-center p-5 bg-white rounded-4 shadow-lg h-100 transition-all">
            <div class="step-icon mb-4 mx-auto">
              <i class="bi bi-3-circle-fill display-4 text-primary"></i>
            </div>
            <h4 class="h3 fw-bold mb-3">Step 3: Counselling</h4>
            <p class="lead text-muted">Participate in counselling & confirm admission</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Courses Section -->
  <section id="courses" class="courses-section">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Diploma <span class="text-primary fw-bold">Programs</span></h2>
        <p class="lead">Industry-aligned 3-year diploma courses with excellent placement opportunities</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="course-card h-100">
            <div class="course-icon">
              <i class="bi bi-building"></i>
            </div>
            <div class="p-4">
              <h3 class="course-title h4 fw-bold mb-3">Civil Engineering</h3>
              <p class="course-desc text-muted mb-4">Construction Management â€¢ Surveying â€¢ Structural Design â€¢ AutoCAD</p>
              <a href="civil.html" class="course-link">
                View Details <i class="bi bi-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="course-card h-100">
            <div class="course-icon">
              <i class="bi bi-lightning-charge"></i>
            </div>
            <div class="p-4">
              <h3 class="course-title h4 fw-bold mb-3">Electrical Engineering</h3>
              <p class="course-desc text-muted mb-4">Power Systems â€¢ Electrical Machines â€¢ PLC â€¢ Renewable Energy</p>
              <a href="electrical.html" class="course-link">
                View Details <i class="bi bi-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="course-card h-100">
            <div class="course-icon">
              <i class="bi bi-cpu"></i>
            </div>
            <div class="p-4">
              <h3 class="course-title h4 fw-bold mb-3">Electronics Engineering</h3>
              <p class="course-desc text-muted mb-4">VLSI Design â€¢ Embedded Systems â€¢ IoT â€¢ Digital Electronics</p>
              <a href="electronics.html" class="course-link">
                View Details <i class="bi bi-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="course-card h-100">
            <div class="course-icon">
              <i class="bi bi-laptop"></i>
            </div>
            <div class="p-4">
              <h3 class="course-title h4 fw-bold mb-3">Information Technology</h3>
              <p class="course-desc text-muted mb-4">Programming â€¢ Web Development â€¢ Cloud Computing â€¢ AI/ML</p>
              <a href="it.html" class="course-link">
                View Details <i class="bi bi-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
          <div class="course-card h-100">
            <div class="course-icon">
              <i class="bi bi-gear"></i>
            </div>
            <div class="p-4">
              <h3 class="course-title h4 fw-bold mb-3">Mechanical Engineering</h3>
              <p class="course-desc text-muted mb-4">CAD/CAM â€¢ Manufacturing â€¢ Automobile â€¢ Robotics</p>
              <a href="mech.html" class="course-link">
                View Details <i class="bi bi-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
          <div class="course-card h-100">
            <div class="course-icon">
              <i class="bi bi-capsule"></i>
            </div>
            <div class="p-4">
              <h3 class="course-title h4 fw-bold mb-3">Pharmacy</h3>
              <p class="course-desc text-muted mb-4">Pharmaceutical Chemistry â€¢ Pharmacology â€¢ Quality Control</p>
              <a href="pharmacy.html" class="course-link">
                View Details <i class="bi bi-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <!-- Contact Section -->
<section id="contact" class="contact-section">
  <div class="container">
    <div class="section-title" data-aos="fade-up">
      <h2>Let's <span class="text-primary fw-bold">Connect</span></h2>
      <p class="lead">Ready to start your technical journey? Get in touch with our admission team</p>
    </div>
    
    <!-- Wider Full-width Contact Information Column (IN BETWEEN) -->
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-8" data-aos="fade-up" data-aos-delay="200">
        <div class="contact-card p-5">
          <h3 class="h2 fw-bold mb-5 text-primary text-center">Contact Information</h3>
          
          <div class="row g-4">
            <!-- Address -->
            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="contact-info-item h-100">
                <div class="contact-icon">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-2">Campus Address</h5>
                  <p class="mb-0 lh-lg">
                    Government Polytechnic Nainital<br>
                    <strong>Education City, Nainital</strong><br>
                    Pin: 263001, Uttarakhand, India
                  </p>
                </div>
              </div>
            </div>

            <!-- Phone -->
            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="contact-info-item h-100">
                <div class="contact-icon">
                  <i class="bi bi-telephone"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-2">Phone Numbers</h5>
                  <p class="mb-0 lh-lg">
                    <a href="tel:+919411158375" class="text-decoration-none fw-semibold text-success fs-6">+91 9411158375</a><br>
                    <a href="tel:+919876543210" class="text-decoration-none fw-semibold text-success fs-6">+91 98765 43210</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Email -->
            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="contact-info-item h-100">
                <div class="contact-icon">
                  <i class="bi bi-envelope"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-2">Email Addresses</h5>
                  <p class="mb-0 lh-lg">
                    <a href="mailto:principal@gpnainital.edu.in" class="text-decoration-none fw-semibold text-danger fs-6">principal@gpnainital.edu.in</a><br>
                    <a href="mailto:admission@gpnainital.edu.in" class="text-decoration-none fw-semibold text-danger fs-6">admission@gpnainital.edu.in</a><br>
                    <a href="mailto:info@gpnainital.ac.in" class="text-decoration-none fw-semibold text-danger fs-6">info@gpnainital.ac.in</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- Office Hours -->
            <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="contact-info-item h-100">
                <div class="contact-icon">
                  <i class="bi bi-clock"></i>
                </div>
                <div>
                  <h5 class="fw-bold mb-2">Office Hours</h5>
                  <p class="mb-0 lh-lg">
                    <strong>Mon - Sat:</strong> 10:00 AM - 5:00 PM<br>
                    <span class="text-muted fs-6">Sunday: Closed</span><br>
                    <strong>Emergency:</strong> 24/7 Available
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Action Buttons - Full Width -->
          <div class="text-center mt-5 pt-4 border-top">
            <div class="d-flex flex-column flex-lg-row gap-3 justify-content-center flex-wrap">
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- CTA Section -->
<!-- CTA Section - Phone Number in Display Div -->
<section style="background: linear-gradient(135deg, #001f3f 0%, #0d1b2a 100%);" class="text-white py-5 position-relative overflow-hidden">
  <div class="container text-center">
    <div class="row align-items-center">
      <div class="col-lg-8 mx-auto" data-aos="zoom-in">
        <h2 class="display-5 fw-bold mb-4">Ready to Start Your Journey?</h2>
        <p class="lead mb-5 opacity-90 fs-5">Join thousands of successful alumni who started their careers at GPN Nainital</p>
        
        <!-- Phone Number Display Div -->
        <div class="phone-display-div mb-4 p-4 rounded-4 shadow-lg" data-aos="fade-up" data-aos-delay="200">
          <div class="row align-items-center g-3">
            <div class="col-auto">
              <div class="phone-icon-circle">
                <i class="bi bi-telephone-fill"></i>
              </div>
            </div>
            <div class="col">
              <div class="h4 fw-bold mb-1 text-white">Call Admission Office</div>
              <a href="tel:+919411158375" class="phone-number-display fs-3 fw-bold text-warning text-decoration-none">
                +91 94111 58375
              </a>
              <div class="text-white-50 small mt-1">Tap to call</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- Enhanced Footer -->
<footer class="footer-main">
   <div class="container">
<div class="footer-grid">
<div class="footer-about">
<h3>Government Polytechnic Nainital</h3>
<p>We are a premier technical institute in Uttarakhand, committed to providing quality education and making learning resources accessible to all students through our Digital Audio Video Book Platform.</p>
<div class="footer-social">
<a href="https://facebook.com" class="facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
<a href="https://instagram.com" class="instagram" target="_blank"><i class="fab fa-instagram"></i></a>
<a href="https://twitter.com" class="twitter" target="_blank"><i class="fab fa-twitter"></i></a>
<a href="https://youtube.com" class="youtube" target="_blank"><i class="fab fa-youtube"></i></a>
</div>
</div>
<div class="footer-links">
<h4>Quick Links</h4>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="book.php">Books</a></li>
<li><a href="notes.php">Notes</a></li>
<li><a href="videos.php">Videos</a></li>
<li><a href="officestaff.html">staff</a></li>
<li><a href="faculty.html">faculty</a></li>
<li><a href="department.html">department</a></li>


</ul>
</div>
<div class="footer-links">
<h4>Resources</h4>
<ul>
<li><a href="audios.php">Audios</a></li>
<li><a href="brochure.php">Brochure</a></li>
<li><a href="contact.php">Contact</a></li>
<li><a href="feedback.php">Feedback</a></li>
<li><a href="announcement.php">New Announcement</a></li>
</ul>
</div>
<div class="footer-gallery">
<h4>Photo Gallery</h4>
<div class="gallery-grid">
<a href="images/college/cp12.jpg" target="_blank"><img src="images/college/cp12.jpg" alt="Gallery 1"></a>
<a href="images/college/cp2.jpg" target="_blank"><img src="images/college/cp2.jpg" alt="Gallery 2"></a>
<a href="images/college/cp3.jpg" target="_blank"><img src="images/college/cp3.jpg" alt="Gallery 3"></a>
<a href="images/college/cp4.jpg" target="_blank"><img src="images/college/cp4.jpg" alt="Gallery 4"></a>
<a href="images/college/CP11.jpg" target="_blank"><img src="images/college/CP11.jpg" alt="Gallery 5"></a>
<a href="images/college/cp6.jpg" target="_blank"><img src="images/college/cp6.jpg" alt="Gallery 6"></a>
<a href="images/college/cp7.jpg" target="_blank"><img src="images/college/cp7.jpg" alt="Gallery 7"></a>
<a href="images/college/cp9.jpg" target="_blank"><img src="images/college/cp9.jpg" alt="Gallery 8"></a>
<a href="images/college/cp10.jpg" target="_blank"><img src="images/college/cp10.jpg" alt="Gallery 9"></a>
</div>
</div>
<div class="footer-links">
<h4>Contact Info</h4>
<ul class="contact-info">
<li><a href="tel:+919411158375" class="phone"><i class="fas fa-phone"></i> +91 9411158375</a></li>
<li><a href="mailto:info@gpnainital.ac.in" class="email"><i class="fas fa-envelope"></i> info@gpnainital.ac.in</a></li>
<li><a href="https://maps.google.com/?q=Government+Polytechnic+Nainital" target="_blank" class="location"><i class="fas fa-map-marker-alt"></i> Nainital, Uttarakhand</a></li>
</ul>
</div>
</div>
</div>
<div class="footer-bottom">
<p><i class="fas fa-copyright"></i> 2025 Digital Audio Video Book | Government Polytechnic Nainital. All Rights Reserved.</p>
</div>


       
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  
  <script>
    // Initialize AOS with enhanced settings
    AOS.init({
      duration: 1000,
      easing: 'ease-in-out-cubic',
      once: true,
      offset: 100
    });

    // Loading Screen
    window.addEventListener('load', () => {
      const loader = document.getElementById('loader');
      setTimeout(() => {
        loader.classList.add('hidden');
      }, 1500);
    });

    // Navbar Scroll Effect
    window.addEventListener('scroll', () => {
      const navbar = document.getElementById('navbar');
      if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Scroll Progress Bar
    window.addEventListener('scroll', () => {
      const scrollProgress = document.getElementById('scrollProgress');
      const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
      scrollProgress.style.width = scrolled + '%';
    });

    // Smooth Scroll for Navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
          
          // Mobile navbar collapse
          const navbarCollapse = document.getElementById('navbarNav');
          if (navbarCollapse.classList.contains('show')) {
            new bootstrap.Collapse(navbarCollapse).hide();
          }
        }
      });
    });

    // Active Navbar Link on Scroll
    window.addEventListener('scroll', () => {
      let current = '';
      const sections = document.querySelectorAll('section');
      const scrollY = window.pageYOffset;

      sections.forEach(section => {
        const sectionTop = section.offsetTop - 200;
        if (scrollY >= sectionTop) {
          current = section.getAttribute('id');
        }
      });

      document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
          link.classList.add('active');
        }
      });
    });

    // Contact Form Handler
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Simulate form submission
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      
      submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Sending...';
      submitBtn.disabled = true;
      
      setTimeout(() => {
        alert('Thank you! Your message has been sent successfully. We will contact you within 24 hours.');
        this.reset();
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
      }, 2000);
    });

    // Course Cards Hover Animation
    document.querySelectorAll('.course-card').forEach(card => {
      card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-20px) scale(1.02)';
      });
      
      card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
      });
    });

    // Counter Animation for Stats
    function animateCounters() {
      const counters = document.querySelectorAll('.stat-number');
      counters.forEach(counter => {
        const target = parseInt(counter.textContent.replace('+', ''));
        const increment = target / 100;
        let current = 0;
        
        const updateCounter = () => {
          if (current < target) {
            current += increment;
            counter.textContent = Math.floor(current) + (target > 100 ? '+' : '%');
            requestAnimationFrame(updateCounter);
          } else {
            counter.textContent = target + (target > 100 ? '+' : '%');
          }
        };
        
        if (window.scrollY + window.innerHeight > counter.parentElement.offsetTop) {
          updateCounter();
        }
      });
    }

    window.addEventListener('scroll', animateCounters);
    window.addEventListener('load', animateCounters);

    // Parallax Effect for Hero Image
    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      const heroSection = document.querySelector('.hero-section');
      const speed = scrolled * 0.5;
      heroSection.style.transform = `translateY(${speed}px)`;
    });

    // WhatsApp Button
    const whatsappBtn = document.querySelector('.btn-outline-light[href*="whatsapp"]');
    if (whatsappBtn) {
      whatsappBtn.href = 'https://wa.me/919876543210?text=Hi%20GPN%20Nainital%2C%20I%20want%20to%20know%20more%20about%20admissions.';
    }
  </script>

</body>
</html>