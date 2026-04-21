<?php include 'db.php';

$success = false;

if(isset($_POST['submit']))
{
    $fname = $_POST['first_name'] ?? '';
    $lname = $_POST['last_name'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $message = $_POST['message'] ?? '';

    $query = "INSERT INTO contact(first_name,last_name,mobile,email,address,message)
              VALUES('$fname','$lname','$mobile','$email','$address','$message')";

    if(mysqli_query($conn,$query))
    {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <title>Contact Us - Government Polytechnic Nainital</title>
<!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
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


      --primary: #03366b;
      --accent: #0b79d0;
      --accent-hover: #0056b3;
      --bg: #f4f8fb;
      --card: #ffffff;
      --text: #111827;
      --muted: #6b7280;
      --radius: 12px;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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

/* NEW BUTTON */
.new-btn{background:#ff0000;color:#ffffff;padding:6px 14px;border-radius:20px;font-weight:700;font-size:12px;display:inline-block;animation:blink 0.3s infinite;text-decoration:none;transition:0.3s;border:none;cursor:pointer}
.new-btn:hover{background:#cc0000;transform:scale(1.1);color:#ffffff}
.new-btn i{margin-right:5px}
@keyframes blink{
0%,100%{opacity:1;transform:scale(1);}
50%{opacity:0.5;transform:scale(0.95);}
}

/* ===== MARQUEE SECTION ===== */
.marquee-section{background:linear-gradient(90deg,var(--secondary-color),#9c1a1a,var(--secondary-color));padding:12px 0;overflow:hidden}
.marquee-container{overflow:hidden;white-space:nowrap}
.marquee-content{display:inline-block;animation:marquee 20s linear infinite}
.marquee-content span{margin-right:60px;font-size:16px;font-weight:600;color:#fff;display:inline-flex;align-items:center;gap:10px}
.marquee-content span i{color:var(--accent-color)}
@keyframes marquee{
0%{transform:translateX(0);}
100%{transform:translateX(-50%);}
}



    /* --- Main Layout --- */
    main {
      max-width: 1100px;
      margin: 30px auto;
      padding: 0 20px;
    }

    .page-title {
      text-align: left;
      color: var(--primary);
      margin-bottom: 25px;
      font-size: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 2px solid #e5e7eb;
      padding-bottom: 10px;
    }
    .page-title i { font-size: 24px; color: var(--accent); }

    /* --- Top Info Cards --- */
    .top-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 25px;
    }

    .info-card {
      background: var(--card);
      border-radius: var(--radius);
      padding: 20px;
      box-shadow: var(--shadow);
      display: flex;
      gap: 15px;
      align-items: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: default;
      position: relative;
      overflow: hidden;
    }

    .info-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-hover);
    }

    /* Make Address Card Clickable */
    .info-card.clickable {
      cursor: pointer;
    }
    .info-card.clickable::after {
      content: '\f0c1'; /* External link icon */
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      position: absolute;
      top: 10px;
      right: 10px;
      color: var(--muted);
      opacity: 0.5;
    }
    .info-card.clickable:hover {
      border: 1px solid var(--accent);
    }

    .info-card .icon {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #e0f2fe, #ffffff);
      color: var(--primary);
      font-size: 20px;
      flex-shrink: 0;
    }

    .info-card .meta {
      font-size: 14px;
    }
    .info-card .meta .label {
      display: block;
      color: var(--muted);
      font-size: 12px;
      margin-bottom: 4px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .info-card .meta a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 600;
      word-break: break-word;
    }
    .info-card .meta a:hover {
      text-decoration: underline;
    }

    /* --- Social Row --- */
    .social-row {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin-bottom: 30px;
      justify-content: center;
    }
    .social-pill {
      background: var(--card);
      padding: 8px 16px;
      border-radius: 50px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      text-decoration: none;
      color: var(--text);
      font-weight: 600;
      font-size: 13px;
      transition: all 0.3s ease;
      border: 1px solid transparent;
    }
    .social-pill:hover {
      background: var(--primary);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(3, 54, 107, 0.3);
    }
    .social-pill i {
      width: 18px;
      text-align: center;
    }

    /* --- Layout: Form + Side --- */
    .layout {
      display: grid;
      grid-template-columns: 1fr 350px;
      gap: 25px;
      margin-top: 20px;
    }

    /* --- Form Card --- */
    .card {
      background: var(--card);
      border-radius: var(--radius);
      padding: 25px;
      box-shadow: var(--shadow);
    }

    .card h3 {
      margin: 0 0 20px;
      color: var(--primary);
      font-size: 20px;
    }

    .form-row {
      display: flex;
      gap: 15px;
      margin-bottom: 15px;
    }

    .form-row .col {
      flex: 1;
    }

    label {
      display: block;
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 6px;
      font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    textarea {
      width: 100%;
      padding: 12px 15px;
      border-radius: 8px;
      border: 1px solid #d1d5db;
      font-size: 14px;
      outline: none;
      background: #fff;
      transition: all 0.3s ease;
    }

    input:focus,
    textarea:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(11, 121, 208, 0.1);
    }

    textarea {
      resize: vertical;
      min-height: 120px;
    }

    .submit-row {
      display: flex;
      gap: 12px;
      align-items: center;
      margin-top: 15px;
    }

    .btn {
      background: var(--primary);
      color: #fff;
      padding: 12px 24px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-weight: 700;
      font-size: 14px;
      display: inline-flex;
      gap: 8px;
      align-items: center;
      transition: all 0.3s ease;
    }

    .btn:hover {
      background: var(--accent);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(3, 54, 107, 0.3);
    }

    .small-muted {
      font-size: 13px;
      color: var(--muted);
    }

    .small-muted a {
      color: var(--accent);
      text-decoration: none;
    }

    /* --- Side Contact --- */
    .side {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .side .side-card {
      background: var(--card);
      padding: 20px;
      border-radius: 12px;
      box-shadow: var(--shadow);
    }

    .side .side-card h4 {
      margin: 0 0 15px;
      color: var(--primary);
      font-size: 16px;
    }

    .side .link-list {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .side .link-list a {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: var(--text);
      padding: 10px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .side .link-list a:hover {
      background: #f3f7fb;
      color: var(--accent);
    }

    .side .link-list i {
      width: 30px;
      text-align: center;
      color: var(--primary);
    }

    

    
    /* --- Responsive Design --- */
    @media (max-width: 980px) {
      .top-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .layout {
        grid-template-columns: 1fr;
      }
      .side {
        order: -1;
      }
    }

    @media (max-width: 560px) {
      .top-grid {
        grid-template-columns: 1fr;
      }
      .header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
      }
      .logo-section {
        flex-direction: column;
      }
      .nav-section {
        flex-direction: column;
        align-items: center;
      }
      
      .form-row {
        flex-direction: column;
        gap: 0;
      }
    }



/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .footer-grid {grid-template-columns:1fr 1fr;gap:30px}
    .footer-gallery {grid-column:1/-1}
    .footer-about {grid-column:1/-1;text-align:center}
    .footer-social {justify-content:center}
    .footer-links {text-align:center}
    .gallery-grid {grid-template-columns:repeat(6,1fr);max-width:400px;margin:0 auto}
}

@media (max-width: 768px) {
    .footer-grid {grid-template-columns:1fr;gap:25px}
    .footer-main {padding:40px 0 0}
    .gallery-grid {grid-template-columns:repeat(3,1fr)}
    .page-title h1{font-size:28px}
    .main-nav a{padding:6px 8px;font-size:11px}
}

@media(max-width:1200px){
.main-nav a{padding:7px 10px;font-size:12px}
.logo-text h4{font-size:14px}
}

@media(max-width:992px){
.footer-grid{grid-template-columns:1fr 1fr}
.header-area .container .d-flex{flex-direction:column;gap:15px}
.logo-section{justify-content:center}
.main-nav{justify-content:center;flex-wrap:wrap}
}

@media(max-width:768px){
.topbar .container{flex-direction:column;gap:8px;text-align:center}
.logo-section{justify-content:center;flex-direction:column;gap:8px}
.main-nav{justify-content:center;gap:2px}
.logo-box img{width:60px}
.logo-text h4{font-size:13px}
.logo-text span{font-size:11px}
.marquee-content span{font-size:14px;margin-right:40px}
.audio-category-header{font-size:15px;padding:15px}
.audio-item{padding:12px}
}


/* ===== FOOTER ===== */
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

.footer-social a.facebook:hover {background:#1877f2;transform:translateY(-3px)}
.footer-social a.instagram:hover {background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);transform:translateY(-3px)}
.footer-social a.twitter:hover {background:#1da1f2;transform:translateY(-3px)}
.footer-social a.youtube:hover {background:#ff0000;transform:translateY(-3px)}

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

.contact-info li a i {width:20px;text-align:center;font-size:16px}
.contact-info li a.phone:hover {color:#25D366}
.contact-info li a.email:hover {color:#EA4335}
.contact-info li a.location:hover {color:#4285F4}

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
<a href="audios.php" ><i class="fas fa-headphones"></i> Audios</a>
<a href="brochure.php"><i class="fas fa-users"></i> Brochure</a>
<a href="contact.php"class="active"><i class="fas fa-envelope"></i> Contact</a>
<a href="announcement.php" class="new-btn"><i class="fas fa-bullhorn"></i> NEW</a>
</nav>
</div>
</div>
</header>

<!-- MARQUEE SECTION -->
<div class="marquee-section">
<div class="marquee-container">
<div class="marquee-content">
<span><i class="fas fa-graduation-cap"></i> Welcome to Digital Audio Video Book Platform</span>
<span><i class="fas fa-book"></i> Access Books, Notes & Study Materials</span>
<span><i class="fas fa-video"></i> Watch Video Lectures Anytime</span>
<span><i class="fas fa-headphones"></i> Listen to Audio Lectures</span>
<span><i-university"></i> Government Polytechnic N class="fas faainital</span>
<span><i class="fas fa-graduation-cap"></i> Welcome to Digital Audio Video Book Platform</span>
<span><i class="fas fa-book"></i> Access Books, Notes & Study Materials</span>
<span><i class="fas fa-video"></i> Watch Video Lectures Anytime</span>
<span><i class="fas fa-headphones"></i> Listen to Audio Lectures</span>
<span><i class="fas fa-university"></i> Government Polytechnic Nainital</span>
</div>
</div>
</div>

  <main>
    <div class="page-title">
      <i class="fa-solid fa-address-book"></i>
      <div>
        <div style="font-weight: 800">Contact Us</div>
        <div style="font-size: 13px; color: var(--muted)">Get in touch â€” questions, admissions, or general enquiry</div>
      </div>
    </div>

    <!-- Top Info Cards -->
    <div class="top-grid" role="region" aria-label="contact highlights">
      <!-- Address Card - Now Clickable for Google Maps -->
      <div class="info-card clickable" onclick="window.open('https://www.google.com/maps/search/?api=1&query=Government+Polytechnic+Nainital+Sherwani+Nainital', '_blank')">
        <div class="icon"><i class="fa-solid fa-location-dot"></i></div>
        <div class="meta">
          <span class="label">Address</span>
          <div>P.O. Sherwani, Nainital, Uttarakhand 263001</div>
        </div>
      </div>

      <div class="info-card">
        <div class="icon"><i class="fa-solid fa-phone"></i></div>
        <div class="meta">
          <span class="label">Phone</span>
          <div><a href="tel:+919412126488">+91 9412126488</a></div>
        </div>
      </div>

      <div class="info-card">
        <div class="icon"><i class="fa-brands fa-whatsapp"></i></div>
        <div class="meta">
          <span class="label">WhatsApp</span>
          <div><a href="https://wa.me/919412126488" target="_blank" rel="noopener">+91 9412126488</a></div>
        </div>
      </div>

      <div class="info-card">
        <div class="icon"><i class="fa-solid fa-envelope"></i></div>
        <div class="meta">
          <span class="label">Email</span>
          <div><a href="mailto:goverment@gmail.com">govinital@gmail.com</a></div>
        </div>
      </div>
    </div>

    <!-- Social Row -->
    <div class="social-row" aria-hidden="false">
      <a class="social-pill" href="https://www.instagram.com/govermentpolytechnicnainital?igsh=MXBldjRzeWhxcGJpdQ==" target="_blank" rel="noopener">
        <i class="fa-brands fa-instagram"></i> Instagram
      </a>
      <a class="social-pill" href="https://twitter.com/gpnainital" target="_blank" rel="noopener">
        <i class="fa-brands fa-x-twitter"></i> Twitter / X
      </a>
      <a class="social-pill" href="https://youtube.com/@govermentpolytechnicnainital?si=BRSTxPPQglxHoZ0S" target="_blank" rel="noopener">
        <i class="fa-brands fa-youtube"></i> YouTube
      </a>
      <a class="social-pill" href="https://t.me/gpnainital" target="_blank" rel="noopener">
        <i class="fa-brands fa-telegram"></i> Telegram
      </a>
      <a class="social-pill" href="http://www.linkedin.com/in/goverment-polytechnic-nainital-07b032385" target="_blank" rel="noopener">
        <i class="fa-brands fa-linkedin"></i> LinkedIn
      </a>
    </div>

    <!-- Main Layout: Form + Side -->
    <div class="layout">
      <!-- Left: Contact Form -->
      <section class="card" aria-labelledby="contact-form-title">
        <h3 id="contact-form-title">Contact Center</h3>

        <form method="POST" action="">
          <div class="form-row">
            <div class="col">
              <label for="fname">First Name *</label>
              <input id="fname" name ="first_name" type="text" placeholder="First name" required>
            </div>
            <div class="col">
              <label for="lname">Last Name</label>
              <input id="lname" name="last_name" type="text" placeholder="Last name">
            </div>
          </div>

          <div class="form-row">
            <div class="col">
              <label for="mobile">Mobile No *</label>
              <input id="mobile" name="mobile" type="tel" placeholder="+91 9XXXXXXXXX" required>
            </div>
            <div class="col">
              <label for="email">Email ID *</label>
              <input id="email" name="email" type="email" placeholder="your@email.com" required>
            </div>
          </div>

          <div style="margin-bottom: 15px">
            <label for="address">Address</label>
            <input id="address" name="address" type="text" placeholder="Your address (optional)">
          </div>

          <div style="margin-bottom: 15px">
            <label for="message">Message *</label>
            <textarea id="message" name="message"  placeholder="Write your message here..." required></textarea>
          </div>

          <div class="submit-row">
            <button class="btn" type="submit" name="submit">
              <i class="fa-solid fa-paper-plane"></i> Send Message
            </button>
            <div class="small-muted">
              Or write to us at <a href="mailto:governital@gmail.com">goveal@gmail.com</a>
            </div>
          </div>
        </form>
      </section>

      <!-- Right: Side Contact Cards -->
      <aside class="side" aria-label="quick contact">
        <div class="side-card">
          <h4>Quick Contact</h4>
          <div class="link-list">
            <a href="tel:+919412126488">
              <i class="fa-solid fa-phone"></i> Call: +91 9412126488
            </a>
            <a href="https://wa.me/919412126488" target="_blank" rel="noopener">
              <i class="fa-brands fa-whatsapp"></i> WhatsApp: +91 9412126488
            </a>
            <a href="mailto:govermentpolytechnicnainital@gmail.com">
              <i class="fa-solid fa-envelope"></i> Email: govermentnital@gmail.com
            </a>
            <a href="https://www.google.com/maps/search/?api=1&query=Government+Polytechnic+Nainital+Sherwani+Nainital" target="_blank" rel="noopener">
              <i class="fa-solid fa-location-dot"></i> Location / Directions
            </a>
          </div>
        </div>

        <div class="side-card">
          <h4>Follow Us</h4>
          <div class="link-list">
            <a href="https://whatsapp.com/channel/0029Vb5x3FL1NCraVeo6Zr3t" target="_blank" rel="noopener">
              <i class="fa-brands fa-whatsapp"></i> WhatsApp Channel
            </a>
            <a href="https://www.instagram.com/govermentpolytechnicnainital?igsh=MXBldjRzeWhxcGJpdQ==" target="_blank" rel="noopener">
              <i class="fa-brands fa-instagram"></i> Instagram
                          </a>
            <a href="https://twitter.com/gpnainital" target="_blank" rel="noopener">
              <i class="fa-brands fa-x-twitter"></i> Twitter / X
            </a>
            <a href="https://youtube.com/@govermentpolytechnicnainital?si=BRSTxPPQglxHoZ0S" target="_blank" rel="noopener">
              <i class="fa-brands fa-youtube"></i> YouTube
            </a>
            <a href="https://t.me/gpnainital" target="_blank" rel="noopener">
              <i class="fa-brands fa-telegram"></i> Telegram
            </a>
            <a href="http://www.linkedin.com/in/goverment-polytechnic-nainital-07b032385" target="_blank" rel="noopener">
              <i class="fa-brands fa-linkedin"></i> LinkedIn
            </a>
          </div>
        </div>
      </aside>
    </div>
  </main>

  



<!-- FOOTER -->
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



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Toggle category accordion
function toggleCategory(header) {
const category = header.parentElement;
category.classList.toggle('open');
}


    

    // Add smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });

    // Add animation on scroll for cards
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = 1;
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.info-card, .card, .side-card').forEach(el => {
      el.style.opacity = 0;
      el.style.transform = 'translateY(20px)';
      el.style.transition = 'all 0.5s ease';
      observer.observe(el);
    });
  </script>
  

<?php if($success){ ?>
<script>
Swal.fire({
  title: "Success ðŸŽ‰",
  text: "Your message has been sent successfully!",
  icon: "success",
  confirmButtonText: "OK"
}).then(() => {
  window.location.href = "contact.php";
});
</script>
<?php } ?>

</body>
</html>