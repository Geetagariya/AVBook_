<?
$conn = mysqli_connect("localhost","root","","avbook_db",3307);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Digital Audio Video Book | Government Polytechnic Nainital</title>
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

/* ===== HERO SECTION ===== */
.hero{background:linear-gradient(135deg,rgba(26,35,126,0.95),rgba(40,53,147,0.9)),url('https://images.unsplash.com/photo-1562774053-701939374585?w=1920');background-size:cover;background-position:center;padding:100px 20px;text-align:center;color:#fff;position:relative;background-attachment:fixed}
.hero::before{content:'';position:absolute;top:0;left:0;width:100%;height:5px;background:linear-gradient(90deg,var(--secondary-color),var(--accent-color),var(--secondary-color))}
.hero-content{position:relative;z-index:2;max-width:800px;margin:0 auto}
.hero h1{font-size:42px;font-weight:700;margin-bottom:20px;font-family:'Playfair Display',serif}
.hero h1 span{color:var(--accent-color)}
.hero p{font-size:18px;opacity:0.95;line-height:1.8;margin-bottom:30px}
.hero-buttons{display:flex;gap:15px;justify-content:center;flex-wrap:wrap}
.btn-primary-custom{background:var(--accent-color);color:var(--primary-color);padding:14px 35px;border-radius:30px;text-decoration:none;font-weight:700;transition:all 0.3s;display:inline-block}
.btn-primary-custom:hover{background:#ffc107;transform:translateY(-2px);box-shadow:0 10px 25px rgba(0,0,0,0.3)}
.btn-outline-custom{background:transparent;border:2px solid #fff;color:#fff;padding:12px 33px;border-radius:30px;text-decoration:none;font-weight:600;transition:all 0.3s;display:inline-block}
.btn-outline-custom:hover{background:#fff;color:var(--primary-color)}




@keyframes fadeInUp {
from { opacity: 0; transform: translateY(30px); }
to { opacity: 1; transform: translateY(0); }
}

.hero img{
animation: float 3s ease-in-out infinite;
}

@keyframes float {
0%, 100% { transform: translateY(0); }
50% { transform: translateY(-15px); }
}




/* ===== REVEAL ANIMATION ===== */
.reveal{opacity:0;transform:translateY(50px);transition:all 0.8s ease-out}
.reveal.active{opacity:1;transform:translateY(0)}

/* ===== STATS SECTION ===== */
.stats-section{background:var(--primary-color);padding:40px 0;margin-top:-50px;position:relative;z-index:10}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;text-align:center}
.stat-item{color:#fff}
.stat-item i{font-size:36px;color:var(--accent-color);margin-bottom:10px}
.stat-item h3{font-size:32px;font-weight:700;margin:0}
.stat-item p{font-size:14px;opacity:0.9;margin:5px 0 0}

/* ===== ABOUT SECTION ===== */
.section{padding:80px 0}
.section-title{text-align:center;margin-bottom:50px}
.section-title h2{color:var(--primary-color);font-size:36px;font-weight:700;font-family:'Playfair Display',serif;margin-bottom:15px;position:relative;display:inline-block}
.section-title h2::after{content:'';position:absolute;bottom:-10px;left:50%;transform:translateX(-50%);width:60px;height:4px;background:var(--secondary-color)}
.section-title p{color:var(--light-text);font-size:16px;max-width:600px;margin:20px auto 0}
.about-content{display:grid;grid-template-columns:1fr 1fr;gap:50px;align-items:center}
.about-text h3{color:var(--primary-color);font-size:28px;margin-bottom:20px}
.about-text p{color:var(--light-text);line-height:1.9;margin-bottom:15px}
.about-features{display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-top:25px}
.about-features li{list-style:none;display:flex;align-items:center;gap:10px;color:var(--dark-text)}
.about-features li i{color:var(--secondary-color);font-size:18px}
.about-image{position:relative}
.about-image img{width:100%;border-radius:10px;box-shadow:0 20px 40px rgba(0,0,0,0.15)}
.about-image::before{content:'';position:absolute;top:-15px;left:-15px;width:100%;height:100%;border:4px solid var(--secondary-color);border-radius:10px;z-index:-1}

/* ===== FEATURES SECTION ===== */
.features-section{background:var(--light-bg)}
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:30px}
.feature-card{background:#fff;padding:40px 30px;border-radius:10px;text-align:center;transition:all 0.3s;box-shadow:0 5px 20px rgba(0,0,0,0.08);border-top:4px solid transparent}
.feature-card:hover{transform:translateY(-10px);box-shadow:0 15px 35px rgba(0,0,0,0.15);border-top-color:var(--secondary-color)}
.feature-icon{width:80px;height:80px;background:linear-gradient(135deg,var(--primary-color),#283593);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 25px}
.feature-icon i{font-size:32px;color:#fff}
.feature-card h3{color:var(--primary-color);font-size:20px;margin-bottom:15px}
.feature-card p{color:var(--light-text);line-height:1.7}
.feature-card a{color:var(--secondary-color);text-decoration:none;font-weight:600;margin-top:15px;display:inline-block;transition:0.3s}
.feature-card a:hover{color:var(--primary-color)}

/* ===== BROCHURE SECTION ===== */
.brochure-section{background:linear-gradient(135deg,var(--primary-color),#283593);padding:80px 0;text-align:center;color:#fff;position:relative;overflow:hidden;background-attachment:fixed}
.brochure-section::before{content:'';position:absolute;top:0;left:0;width:100%;height:100%;background:url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="white" opacity="0.05"/></svg>');background-size:30px 30px}
.brochure-content{position:relative;z-index:2}
.brochure-icon{width:120px;height:120px;background:rgba(255,255,255,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 30px;border:3px solid var(--accent-color)}
.brochure-icon i{font-size:50px;color:var(--accent-color)}
.brochure-section h2{font-size:36px;margin-bottom:20px;font-family:'Playfair Display',serif}
.brochure-section p{font-size:16px;opacity:0.9;max-width:600px;margin:0 auto 30px;line-height:1.8}
.brochure-btn{background:var(--accent-color);color:var(--primary-color);padding:16px 45px;border-radius:30px;text-decoration:none;font-weight:700;font-size:16px;display:inline-block;transition:all 0.3s}
.brochure-btn:hover{background:#ffc107;transform:scale(1.05);box-shadow:0 10px 30px rgba(0,0,0,0.3)}

/* ===== TEAM SECTION ===== */
.team-section{background:#fff}
.team-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:30px;text-align:center}
.team-card{background:var(--light-bg);padding:30px;border-radius:10px;transition:all 0.3s}
.team-card:hover{transform:translateY(-5px);box-shadow:0 15px 30px rgba(0,0,0,0.1)}
.team-card h4{color:var(--primary-color);margin:15px 0 5px;font-size:18px}
.team-card p{color:var(--light-text);font-size:14px;margin:0}

/* ===== SLIDESHOW SECTION - NEW ===== */
.slideshow-section {
    padding: 60px 0;
    background: #fff;
}

.slideshow-container {
    position: relative;
    max-width: 100%;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.slides {
    display: none;
    position: relative;
}

.slides img {
    width: 100%;
    height: 600px;
    object-fit: cover;
    display: block;
}

/* Slideshow overlay text */
.slide-text {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 40px 20px 20px;
    text-align: center;
}

.slide-text h3 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.slide-text p {
    font-size: 16px;
    opacity: 0.9;
}

/* Slideshow navigation dots */
.dot-container {
    text-align: center;
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%);
}

.dot {
    cursor: pointer;
    height: 12px;
    width: 12px;
    margin: 0 5px;
    background-color: rgba(255,255,255,0.5);
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.3s ease;
    border: 2px solid transparent;
}

.dot.active, .dot:hover {
    background-color: var(--accent-color);
    border-color: #fff;
}

/* Slideshow arrows */
.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.3s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
    background: rgba(0,0,0,0.3);
}

.next {
    right: 0;
    border-radius: 3px 0 0 3px;
}

.prev:hover, .next:hover {
    background: var(--secondary-color);
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

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }
    
    .footer-gallery {
        grid-column: 1 / -1;
    }
    
    .footer-about {
        grid-column: 1 / -1;
        text-align: center;
    }
    
    .footer-social {
        justify-content: center;
    }
    
    .footer-links {
        text-align: center;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(6, 1fr);
        max-width: 400px;
        margin: 0 auto;
    }
}

@media (max-width: 768px) {
    .footer-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .footer-main {
        padding: 40px 0 0;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .slides img {
        height: 300px;
    }
    
    .slide-text h3 {
        font-size: 20px;
    }
    
    .slide-text p {
        font-size: 14px;
    }
}

@media(max-width:1200px){
.main-nav a{padding:7px 10px;font-size:12px}
.logo-text h4{font-size:14px}
}

@media(max-width:992px){
.stats-grid{grid-template-columns:repeat(2,1fr)}
.about-content{grid-template-columns:1fr}
.features-grid{grid-template-columns:repeat(2,1fr)}
.team-grid{grid-template-columns:repeat(2,1fr)}
.footer-grid{grid-template-columns:1fr 1fr}
.header-area .container .d-flex{flex-direction:column;gap:15px}
.logo-section{justify-content:center}
.main-nav{justify-content:center;flex-wrap:wrap}
}

@media(max-width:768px){
.topbar .container{flex-direction:column;gap:8px;text-align:center}
.logo-section{justify-content:center;flex-direction:column;gap:8px}
.main-nav{justify-content:center;gap:2px}
.main-nav a{padding:6px 8px;font-size:11px}
.hero h1{font-size:28px}
.hero p{font-size:15px}
.stats-grid{grid-template-columns:1fr}
.features-grid{grid-template-columns:1fr}
.team-grid{grid-template-columns:1fr}
.footer-grid{grid-template-columns:1fr}
.gallery-slider img{height:250px}
.logo-box img{width:60px}
.logo-text h4{font-size:13px}
.logo-text span{font-size:11px}
.marquee-content span{font-size:14px;margin-right:40px}
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
<a href="index.php" class="active"><i class="fas fa-home"></i> Home</a>
<a href="book.php"><i class="fas fa-book"></i> Books</a>
<a href="notes.php"><i class="fas fa-sticky-note"></i> Notes</a>
<a href="videos.html"><i class="fas fa-video"></i> Videos</a>
<a href="audios.php"><i class="fas fa-headphones"></i> Audios</a>
<a href="brochure.html"><i class="fas fa-users"></i> Brochure</a>
<a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
<a href="announcement.html" class="new-btn"><i class="fas fa-bullhorn"></i> NEW</a>
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

<!-- SLIDESHOW SECTION - NEW -->
<section class="slideshow-section">
<div class="container">
<div class="slideshow-container reveal">
<div class="slides">
<img src="images/college/cp1.jpg" alt="cp1">
<div class="slide-text">
<h3>Government Polytechnic Nainital</h3>
<p>Excellence in Technical Education Since 1956</p>
</div>
</div>
<div class="slides">
<img src="images/college/cp7.jpg" alt="cp7">
<div class="slide-text">
<h3>Digital Learning Platform</h3>
<p>Access Books, Notes, Videos & Audio Lectures</p>
</div>
</div>
<div class="slides">
<img src="images/college/cp4.jpg" alt="cp4">
<div class="slide-text">
<h3>Quality Education</h3>
<p>Empowering Students with Digital Resources</p>
</div>
</div>
<div class="slides">
<img src="https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?w=1920" alt="Library">
<div class="slide-text">
<h3>Study Materials</h3>
<p>Comprehensive Resources for All Students</p>
</div>
</div>




<div class="slides">
<img src="images/college/cp6.jpg" alt="cp6">
</div>











<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<div class="dot-container">
<span class="dot" onclick="currentSlide(1)"></span>
<span class="dot" onclick="currentSlide(2)"></span>
<span class="dot" onclick="currentSlide(3)"></span>
<span class="dot" onclick="currentSlide(4)"></span>
</div>
</div>
</section>

<!-- HERO SECTION -->
<section class="hero">
<div class="hero-content reveal">
<img src="icons/play.png" style="width:150px">
<h1>Digital <span>Audio Video</span> Book Platform</h1>
<p>Access your study materials, lectures, and resources in one place. Books, Notes, Previous Year Papers, Audio Lectures, and Video Tutorials - all designed for your academic success.</p>
<div class="hero-buttons">
<a href="aboutUs.php" class="btn-primary-custom"><i class="fas fa-info-circle"></i> Learn More</a>
<a href="feedback.php"class="btn-outline-custom"><i class="fas fa-comment-dots"></i> Feedback</a>
</div>
</div>
</section>

<!-- STATS SECTION -->
<section class="stats-section">
<div class="container reveal">
<div class="stats-grid">
<div class="stat-item reveal active">
<i class="fas fa-book"></i>
<h3>500+</h3>
<p>Books & Notes</p>
</div>
<div class="stat-item reveal active">
<i class="fas fa-video"></i>
<h3>200+</h3>
<p>Videos</p>
</div>
<div class="stat-item reveal active">
<i class="fas fa-headphones"></i>
<h3>300+</h3>
<p>Audio Lectures</p>
</div>
<div class="stat-item reveal active">
<i class="fas fa-users"></i>
<h3>1000+</h3>
<p>Students</p>
</div>
</div>
</div>
</section>

<!-- ABOUT SECTION -->
<section id="about" class="section">
<div class="container">
<div class="section-title reveal">
<h2>About Our Project</h2>
<p>The Digital Audio Video Book is an innovative initiative to make learning resources easily accessible to all students.</p>
</div>
<div class="about-content">
<div class="about-text reveal">
<h3>Digital Learning Platform</h3>
<p>Our project aims to create a centralized digital platform where learners can find books, notes, recorded lectures, video tutorials, and other academic materials in one place.</p>
<p>With the help of this platform, students can download study materials, listen to subject-wise audio lectures, watch recorded sessions, and explore important references anytime and anywhere.</p>
<ul class="about-features">
<li><i class="fas fa-check-circle"></i> Books & Notes</li>
<li><i class="fas fa-check-circle"></i> Video Tutorials</li>
<li><i class="fas fa-check-circle"></i> Audio Lectures</li>
<li><i class="fas fa-check-circle"></i> College Brochure</li>
</ul>
</div>
<div class="about-image reveal">
<img src="images/college/cp1.jpg" alt="cp1">
</div>
</div>
</div>
</section>

<!-- FEATURES SECTION -->
<section class="section features-section">
<div class="container">
<div class="section-title reveal">
<h2>Our Features</h2>
<p>Everything you need for your studies in one place</p>
</div>
<div class="features-grid">
<div class="feature-card reveal">
<div class="feature-icon">
<i class="fas fa-book-open"></i>
</div>
<h3>Books & Notes</h3>
<p>Download study materials and reference books in PDF format for all subjects.</p>
<a href="book.html">View Books <i class="fas fa-arrow-right"></i></a>
</div>
<div class="feature-card reveal">
<div class="feature-icon">
<i class="fas fa-microphone-alt"></i>
</div>
<h3>Audio Lectures</h3>
<p>Listen to recorded lectures, motivational talks, and poems anytime.</p>
<a href="audios.html">Listen Now <i class="fas fa-arrow-right"></i></a>
</div>
<div class="feature-card reveal">
<div class="feature-icon">
<i class="fas fa-play-circle"></i>
</div>
<h3>Video Tutorials</h3>
<p>Watch subject tutorials and recorded classroom lectures.</p>
<a href="videos.html">Watch Videos <i class="fas fa-arrow-right"></i></a>
</div>
<div class="feature-card reveal">
<div class="feature-icon">
<i class="fas fa-file-alt"></i>
</div>
<h3>Notes</h3>
<p>Access subject-wise concise notes for quick revision.</p>
<a href="notes.html">View Notes <i class="fas fa-arrow-right"></i></a>
</div>
<div class="feature-card reveal">
<div class="feature-icon">
<i class="fas fa-phone-alt"></i>
</div>
<h3>Contact Us</h3>
<p>Get in touch with us for queries, help, and support.</p>
<a href="contact.html">Contact <i class="fas fa-arrow-right"></i></a>
</div>
<div class="feature-card reveal">
<div class="feature-icon">
<i class="fas fa-paper-plane"></i>
</div>
<h3>Reach Us</h3>
<p>Send your articles, books, audios, videos and materials.</p>
<a href="publisher.html">Submit <i class="fas fa-arrow-right"></i></a>
</div>
</div>
</div>
</section>

<!-- BROCHURE SECTION -->
<section class="brochure-section">
<div class="container">
<div class="brochure-content reveal">
<div class="brochure-icon">
<i class="fas fa-file-pdf"></i>
</div>
<h2>College Brochure</h2>
<p>Our college brochure gives complete details about our experienced faculty, supportive office staff, and the wide range of courses we offer. It helps you understand our academic environment and facilities.</p>
<a href="faculty.html" class="brochure-btn"><i class="fas fa-eye"></i> View Full Brochure</a>
</div>
</div>
</section>

<!-- TEAM SECTION -->
<section class="section team-section">
<div class="container">
<div class="section-title reveal">
<h2>Our Project Team</h2>
<p>Cosmic Tech - Students of Government Polytechnic Nainital</p>
</div>
<div class="team-grid">
<div class="team-card reveal">
<i class="fas fa-user-graduate fa-3x" style="color:#1a237e"></i>
<h4>Geeta Gariya</h4>
<p>Team Leader</p>
</div>
<div class="team-card reveal">
<i class="fas fa-user-graduate fa-3x" style="color:#1a237e"></i>
<h4>Babita Gaurh</h4>
<p>Team Member</p>
</div>
<div class="team-card reveal">
<i class="fas fa-user-graduate fa-3x" style="color:#1a237e"></i>
<h4>Yati Katyura</h4>
<p>Team Member</p>
</div>
<div class="team-card reveal">
<i class="fas fa-user-graduate fa-3x" style="color:#1a237e"></i>
<h4>Sneha Bisht</h4>
<p>Team Member</p>
</div>
<div class="team-card reveal">
<i class="fas fa-user-graduate fa-3x" style="color:#1a237e"></i>
<h4>Aakansha Arya</h4>
<p>Team Member</p>
</div>
<div class="team-card reveal">
<i class="fas fa-user-graduate fa-3x" style="color:#1a237e"></i>
<h4>Saloni Rautela</h4>
<p>Team Member</p>
</div>
</div>
</div>
</section>

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
<li><a href="videos.html">Videos</a></li>
</ul>
</div>
<div class="footer-links">
<h4>Resources</h4>
<ul>
<li><a href="audios.php">Audios</a></li>
<li><a href="brochure.html">Brochure</a></li>
<li><a href="contact.php">Contact</a></li>
<li><a href="feedback.php">Feedback</a></li>
<li><a href="announcement.html">New Announcement</a></li>
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
// ===== SLIDESHOW FUNCTIONALITY =====
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("slides");
    let dots = document.getElementsByClassName("dot");
    
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
}

// Auto slideshow - changes every 3 seconds
setInterval(function() {
    plusSlides(1);
}, 4000);

// REVEAL ANIMATION ON SCROLL
function reveal(){
var reveals = document.querySelectorAll('.reveal');
for(var i = 0; i < reveals.length; i++){
var windowHeight = window.innerHeight;
var elementTop = reveals[i].getBoundingClientRect().top;
var elementVisible = 100;
if(elementTop < windowHeight - elementVisible){
reveals[i].classList.add('active');
}
}
}
window.addEventListener('scroll', reveal);
window.addEventListener('load', reveal);

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
anchor.addEventListener('click', function (e) {
e.preventDefault();
document.querySelector(this.getAttribute('href')).scrollIntoView({
behavior: 'smooth'
});
});
});

// Navbar background change on scroll
window.addEventListener('scroll', function() {
const header = document.querySelector('.header-area');
if (window.scrollY > 50) {
header.style.boxShadow = "0 2px 20px rgba(0,0,0,0.15)";
} else {
header.style.boxShadow = "0 2px 15px rgba(0,0,0,0.1)";
}
});
</script>

</body>
</html>