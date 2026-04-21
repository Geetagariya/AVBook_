<?php include 'db.php'; ?>
<?php
$result = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Videos - Digital Audio Video Book</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

  <style>
/* ===== BASE STYLES ===== */
* { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { font-family: 'Inter', sans-serif; background: #f5f7fa; overflow-x: hidden; line-height: 1.6; }

/* ===== COLLEGE COLORS ===== */
:root {
    --primary-color: #1a237e;
    --secondary-color: #800000;
    --accent-color: #ffd700;
    --dark-text: #1a1a2e;
    --light-text: #666;
    --white: #ffffff;
    --light-bg: #f5f7fa;
}

/* ===== TOPBAR ===== */
.topbar {
    background: linear-gradient(90deg, #1a237e, #283593);
    color: #fff;
    padding: 8px 0;
    font-size: 14px;
}
.topbar .container { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
.topbar-left { display: flex; align-items: center; gap: 20px; }
.topbar-left i { margin-right: 8px; color: #ffd700; }
.topbar-right { display: flex; align-items: center; gap: 15px; }
.topbar-right a { color: #fff; text-decoration: none; font-size: 13px; transition: 0.3s; }
.topbar-right a:hover { color: #ffd700; }

/* ===== HEADER ===== */
.header-area {
    background: #fff;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    padding: 18px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
    transition: box-shadow 0.3s ease;
}
.logo-section { display: flex; align-items: center; gap: 12px; }
.logo-box { background: transparent; padding: 0; }
.logo-box img { width: 90px; height: auto; display: block; }
.logo-text h4 { margin: 0; color: var(--primary-color); font-weight: 700; font-size: 15px; line-height: 1.2; white-space: nowrap; }
.logo-text span { color: var(--secondary-color); font-size: 12px; font-weight: 600; white-space: nowrap; }

/* ===== NAVIGATION ===== */
.main-nav { display: flex; align-items: center; gap: 2px; flex-wrap: nowrap; justify-content: flex-end; }
.main-nav a { color: var(--dark-text); text-decoration: none; font-weight: 600; font-size: 13px; padding: 8px 12px; border-radius: 5px; transition: all 0.3s; white-space: nowrap; }
.main-nav a:hover { background: var(--primary-color); color: #fff; }
.main-nav a.active { background: var(--primary-color); color: #fff; }
.main-nav a.highlight { background: var(--secondary-color); color: #fff; }

/* NEW BUTTON */
.new-btn {
    background: #ff0000;
    color: #ffffff;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 12px;
    display: inline-block;
    animation: blink 2s infinite;
    text-decoration: none;
    transition: 0.3s;
    border: none;
    cursor: pointer;
}



 /* NEW BUTTON */
        .new-btn {
            background: #ff0000;
            color: #ffffff;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 12px;
            display: inline-block;
            animation: blink 0.3s infinite;
            text-decoration: none;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }

        .new-btn:hover {
            background: #cc0000;
            transform: scale(1.1);
            color: #ffffff;
        }

        .new-btn i {
            margin-right: 5px;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(0.95);
            }
        }



/* ===== MARQUEE SECTION ===== */
.marquee-section {
    background: linear-gradient(90deg, var(--secondary-color), #9c1a1a, var(--secondary-color));
    padding: 12px 0;
    overflow: hidden;
}
.marquee-container { overflow: hidden; white-space: nowrap; }
.marquee-content { display: inline-block; animation: marquee 20s linear infinite; }
.marquee-content span { margin-right: 60px; font-size: 16px; font-weight: 600; color: #fff; display: inline-flex; align-items: center; gap: 10px; }
.marquee-content span i { color: var(--accent-color); }
@keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* ===== PAGE HEADER ===== */
.page-header {
    background: linear-gradient(135deg, rgba(26, 35, 126, 0.95), rgba(40, 53, 147, 0.9)), url('https://images.unsplash.com/photo-1562774053-701939374585?w=1920');
    background-size: cover;
    background-position: center;
    padding: 80px 20px;
    text-align: center;
    color: #fff;
    position: relative;
    background-attachment: fixed;
}
.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, var(--secondary-color), var(--accent-color), var(--secondary-color));
}
.page-header-content { position: relative; z-index: 2; max-width: 800px; margin: 0 auto; }
.page-header h1 {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 15px;
    font-family: 'Playfair Display', serif;
}
.page-header h1 i { margin-right: 15px; color: var(--accent-color); }
.page-header p { font-size: 18px; opacity: 0.95; line-height: 1.8; }

/* ===== CAROUSEL SECTION ===== */
.carousel-section { padding: 40px 0; background: #fff; }
.carousel { border-radius: 15px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.15); }
.carousel-item { height: 400px; }
.carousel-item img { width: 100%; height: 100%; object-fit: cover; }
.carousel-caption {
    background: rgba(0,0,0,0.6);
    border-radius: 10px;
    padding: 20px;
    bottom: 30px;
}
.carousel-caption h5 { font-size: 24px; font-weight: 700; }
.carousel-caption p { font-size: 16px; }

/* ===== CONTENT SECTION ===== */
.content-section { padding: 60px 0; background: #fff; }
.content-container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }

/* ===== SECTION HEADERS ===== */
.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 3px solid var(--primary-color);
}
.section-header h2 {
    color: var(--primary-color);
    font-size: 28px;
    font-weight: 700;
    font-family: 'Playfair Display', serif;
}
.section-header h2 i { margin-right: 12px; color: var(--secondary-color); }
.section-header small { color: var(--light-text); font-size: 14px; }

/* ===== CHANNEL CARD & ROW ===== */
.channel-card {
    flex: 0 0 auto;
    width: 300px;
    background: #fff;
    border-radius: 12px;
    padding: 16px;
    box-sizing: border-box;
    border: 1px solid #e0e0e0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-right: 16px;
}
.channel-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}
.channel-card .thumb {
    width: 100%;
    height: 170px;
    object-fit: cover;
    border-radius: 10px;
    display: block;
    margin-bottom: 12px;
}
.channel-card h3 {
    margin: 0 0 8px 0;
    font-size: 18px;
    color: var(--primary-color);
    font-weight: 600;
}
.channel-card p { margin: 0; color: var(--light-text); font-size: 14px; line-height: 1.5; }
.channel-card .subscribers {
    margin-top: 10px;
    font-size: 13px;
    color: #28a745;
    font-weight: 600;
}
.channel-card .btn {
    margin-top: 12px;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.channel-card .btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
}
.channel-card .btn-outline-primary:hover {
    background: var(--primary-color);
    color: #fff;
}

/* ===== SCROLL BUTTONS ===== */
.position-relative { position: relative; }
.scroll-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(26, 35, 126, 0.9);
    color: #fff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 20;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
.scroll-btn:hover { background: var(--secondary-color); transform: translateY(-50%) scale(1.1); }
.scroll-left { left: 6px; }
.scroll-right { right: 6px; }

/* ===== CHANNEL ROW ===== */
.channel-row {
    display: flex;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding-bottom: 12px;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
}
.channel-row::-webkit-scrollbar { height: 8px; }
.channel-row::-webkit-scrollbar-thumb { background: var(--primary-color); border-radius: 8px; }
.channel-row::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 8px; }

/* ===== SEARCH & FILTER ===== */
.search-filter-section { padding: 30px 0; background: #f5f7fa; }
.search-box {
    background: #fff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}
.search-box input {
    padding: 14px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 15px;
    transition: all 0.3s ease;
}
.search-box input:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 4px rgba(26, 35, 126, 0.1);
}
.filter-btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.filter-btn.active, .filter-btn.btn-primary {
    background: var(--primary-color);
    color: #fff;
    border-color: var(--primary-color);
}
.filter-btn:not(.active):not(.btn-primary) {
    background: #fff;
    color: var(--primary-color);
    border-color: var(--primary-color);
}
.filter-btn:not(.active):not(.btn-primary):hover {
    background: var(--primary-color);
    color: #fff;
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
.footer-about h3 { color: var(--accent-color); margin-bottom: 20px; font-size: 22px; font-weight: 700; }
.footer-about p { line-height: 1.8; opacity: 0.9; font-size: 14px; color: #ccc; }
.footer-social { margin-top: 20px; display: flex; gap: 10px; }
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
.footer-social a:hover { transform: translateY(-3px); }
.footer-social a.facebook:hover { background: #1877f2; }
.footer-social a.instagram:hover { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
.footer-social a.twitter:hover { background: #1da1f2; }
.footer-social a.youtube:hover { background: #ff0000; }

.footer-links h4 { color: var(--accent-color); margin-bottom: 20px; font-size: 18px; font-weight: 700; }
.footer-links ul { list-style: none; padding: 0; margin: 0; }
.footer-links ul li { margin-bottom: 12px; }
.footer-links ul li a {
    color: #ccc;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}
.footer-links ul li a:hover { color: var(--accent-color); padding-left: 5px; }
.footer-links ul li a i { font-size: 12px; color: var(--secondary-color); }

.contact-info { list-style: none; padding: 0; margin: 0; }
.contact-info li { margin-bottom: 15px; }
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
.contact-info li a:hover { color: #fff; background: rgba(255, 255, 255, 0.1); transform: translateX(5px); }
.contact-info li a i { width: 20px; text-align: center; font-size: 16px; }
.contact-info li a.phone:hover { color: #25D366; }
.contact-info li a.email:hover { color: #EA4335; }
.contact-info li a.location:hover { color: #4285F4; }

.footer-gallery h4 { color: var(--accent-color); margin-bottom: 20px; font-size: 18px; font-weight: 700; }
.gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
.gallery-grid a { display: block; overflow: hidden; border-radius: 8px; position: relative; }
.gallery-grid a img { width: 100%; height: 70px; object-fit: cover; transition: all 0.3s ease; }
.gallery-grid a:hover img { transform: scale(1.1); filter: brightness(1.1); }
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
.gallery-grid a:hover::after { opacity: 1; }

.footer-bottom {
    background: rgba(0, 0, 0, 0.3);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding: 20px 50px;
    text-align: center;
    border-top: 2px solid #ffd700;
}
.footer-bottom p { margin: 0; font-size: 14px; color: #aaa; }
.footer-bottom p i { color: #ebe4e4; margin: 0 5px; }

/* ===== REVEAL ANIMATION ===== */
.reveal { opacity: 0; transform: translateY(50px); transition: all 0.8s ease-out; }
.reveal.active { opacity: 1; transform: translateY(0); }

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 30px; }
    .footer-gallery { grid-column: 1 / -1; }
    .footer-about { grid-column: 1 / -1; text-align: center; }
    .footer-social { justify-content: center; }
    .footer-links { text-align: center; }
    .gallery-grid { grid-template-columns: repeat(6, 1fr); max-width: 400px; margin: 0 auto; }
    .page-header h1 { font-size: 32px; }
    .channel-card { width: 260px; }
}

@media (max-width: 768px) {
    .footer-grid { grid-template-columns: 1fr; gap: 25px; }
    .footer-main { padding: 40px 0 0; }
    .gallery-grid { grid-template-columns: repeat(3, 1fr); }
    .page-header { padding: 60px 20px; }
    .page-header h1 { font-size: 26px; }
    .section-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    .channel-card { width: 240px; }
    .carousel-item { height: 250px; }
    .carousel-caption h5 { font-size: 18px; }
    .carousel-caption p { font-size: 14px; }
    .topbar .container { flex-direction: column; gap: 8px; text-align: center; }
    .logo-section { justify-content: center; flex-direction: column; gap: 8px; }
    .main-nav { justify-content: center; gap: 2px; flex-wrap: wrap; }
    .main-nav a { padding: 6px 8px; font-size: 11px; }
    .logo-box img { width: 60px; }
    .logo-text h4 { font-size: 13px; }
    .logo-text span { font-size: 11px; }
    .marquee-content span { font-size: 14px; margin-right: 40px; }
}

@media (max-width: 576px) {
    .channel-card { width: 200px; padding: 12px; }
    .channel-card .thumb { height: 120px; }
    .channel-card h3 { font-size: 15px; }
    .channel-card p { font-size: 12px; }
    .footer-bottom { padding: 15px 20px; }
        .scroll-btn { width: 36px; height: 36px; font-size: 14px; }
    .search-box input { padding: 12px 15px; font-size: 14px; }
    .filter-btn { padding: 8px 15px; font-size: 13px; }
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
                <a href="brochure.php"><i class="fas fa-users"></i> Brochure</a>
                <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
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
            <span><i class="fas fa-university"></i> Government Polytechnic Nainital</span>
            <span><i class="fas fa-graduation-cap"></i> Welcome to Digital Audio Video Book Platform</span>
            <span><i class="fas fa-book"></i> Access Books, Notes & Study Materials</span>
            <span><i class="fas fa-video"></i> Watch Video Lectures Anytime</span>
            <span><i class="fas fa-headphones"></i> Listen to Audio Lectures</span>
            <span><i class="fas fa-university"></i> Government Polytechnic Nainital</span>
        </div>
    </div>
</div>

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="page-header-content reveal">
        <h1><i class="fas fa-video"></i> YouTube Study Hub</h1>
        <p>A curated hub of high-quality YouTube channels for Engineering, Humanities & Business, Languages, Arts and Sciences</p>
    </div>
</section>

<!-- CAROUSEL SECTION -->
<section class="carousel-section">
    <div class="container">
        <div id="topCarousel" class="carousel slide carousel-fade shadow-lg rounded overflow-hidden" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="hover">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#topCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#topCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#topCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#topCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://thumbs.dreamstime.com/b/stack-books-library-ideal-use-as-banner-header-image-perfect-content-related-to-education-reading-libraries-365502391.jpg" class="d-block w-100" alt="Books and study" loading="lazy">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Books & Learning</h5>
                        <p>Knowledge at your fingertips</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://t4.ftcdn.net/jpg/04/63/37/51/360_F_463375173_vBKRkUbVoCuS9lpUmhdfCc13pprPr148.jpg" class="d-block w-100" alt="Classroom" loading="lazy">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Classroom Learning</h5>
                        <p>Engaging lessons for curious minds</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://t4.ftcdn.net/jpg/08/86/49/53/360_F_886495385_XudXZcfZb7FqTwSWpDjwOEWfsol6Sw6e.jpg" class="d-block w-100" alt="Online Education" loading="lazy">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Online Education</h5>
                        <p>Learn anywhere, anytime</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://as2.ftcdn.net/v2/jpg/04/19/26/97/1000_F_419269782_9LsP3TQndMVnZ2j3ZhTPhMjaqQpFAth9.jpg" class="d-block w-100" alt="Library" loading="lazy">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Library & Research</h5>
                        <p>Explore knowledge and research deeply</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#topCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#topCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- SEARCH & FILTER SECTION -->
<section class="search-filter-section">
    <div class="container">
        <div class="search-box">
            <div class="d-flex flex-column flex-md-row gap-4 mb-3 align-items-center">
                <input type="text" id="searchInput" class="form-control px-6 py-3 w-full md:w-1/2" placeholder="Search channels by name, description or subscriber count...">
                <div class="d-flex gap-3 flex-wrap">
                    <button class="filter-btn btn btn-primary active" data-category="all">All</button>
                    <button class="filter-btn btn btn-outline-primary" data-category="engineering">Engineering</button>
                    <button class="filter-btn btn btn-outline-primary" data-category="diploma">Diploma Subjects</button>
                    <button class="filter-btn btn btn-outline-primary" data-category="others">Others</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTENT SECTION -->
<section class="content-section">
    <div class="content-container">




<!-- ENGINEERING Row -->
<section class="py-5" id="all">
    <div class="section-header reveal">
        <h2><i class="fas fa-graduation-cap"></i> All</h2>
        <small>Swipe or click arrows to navigate</small>
    </div>

    <div class="position-relative reveal">
        
        <!-- LEFT BUTTON -->
        <button class="scroll-btn scroll-left" data-target="allRow">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- ROW START -->
        <div class="channel-row" id="engineeringRow" data-autoscroll="true">






<?php include 'db.php'; 
$sql = "SELECT * FROM videos ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
while($row = mysqli_fetch_assoc($result)) {
?>

<div class="channel-card" data-category="all">
<img class="thumb" src="<?php echo !empty($row['thumbnail']) ? $row['thumbnail'] : 'https://via.placeholder.com/300x170'; ?>">
    <h3><?php echo $row['title']; ?></h3>

    <p><?php echo $row['description']; ?></p>

    
	<p class="subscribers">
    Subscribers: <?php echo !empty($row['subscribers']) ? $row['subscribers'] : 'Not Available'; ?>
</p>

    <a href="<?php echo $row['youtube_link']; ?>" target="_blank" class="btn btn-outline-primary">
        Visit Channel →
    </a>
	
</div>

<?php 
}
} else {
    echo "<p style='padding:20px;'>No videos available</p>";
}
?>

 </div>
		
<!-- RIGHT BUTTON -->
        <button class="scroll-btn scroll-right" data-target="allRow">
            <i class="fas fa-chevron-right"></i>
        </button>
</div>
</section>





<!-- ENGINEERING Row -->
<section class="py-5" id="engineering">
    <div class="section-header reveal">
        <h2><i class="fas fa-graduation-cap"></i> Engineering</h2>
        <small>Swipe or click arrows to navigate</small>
    </div>

    <div class="position-relative reveal">
        
        <!-- LEFT BUTTON -->
        <button class="scroll-btn scroll-left" data-target="engineeringRow">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- ROW START -->
        <div class="channel-row" id="engineeringRow" data-autoscroll="true">






<?php include 'db.php'; 
$sql = "SELECT * FROM videos WHERE category='engineering' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
while($row = mysqli_fetch_assoc($result)) {
?>

<div class="channel-card" data-category="engineering">
<img class="thumb" src="<?php echo !empty($row['thumbnail']) ? $row['thumbnail'] : 'https://via.placeholder.com/300x170'; ?>">
    <h3><?php echo $row['title']; ?></h3>

    <p><?php echo $row['description']; ?></p>

    
	<p class="subscribers">
    Subscribers: <?php echo !empty($row['subscribers']) ? $row['subscribers'] : 'Not Available'; ?>
</p>

    <a href="<?php echo $row['youtube_link']; ?>" target="_blank" class="btn btn-outline-primary">
        Visit Channel →
    </a>
	
</div>

<?php 
}
} else {
    echo "<p style='padding:20px;'>No videos available</p>";
}
?>

 </div>
		
<!-- RIGHT BUTTON -->
        <button class="scroll-btn scroll-right" data-target="engineeringRow">
            <i class="fas fa-chevron-right"></i>
        </button>
</div>
</section>












<!-- Diploma Row -->
<section class="py-5" id="engineering">
    <div class="section-header reveal">
        <h2><i class="fas fa-graduation-cap"></i> Diploma</h2>
        <small>Swipe or click arrows to navigate</small>
    </div>

    <div class="position-relative reveal">
        
        <!-- LEFT BUTTON -->
        <button class="scroll-btn scroll-left" data-target="diplomaRow">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- ROW START -->
        <div class="channel-row" id="diplomaRow" data-autoscroll="true">






<?php include 'db.php'; 
$sql = "SELECT * FROM videos WHERE category='diploma' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
while($row = mysqli_fetch_assoc($result)) {
?>

<div class="channel-card" data-category="diploma">
<img class="thumb" src="<?php echo !empty($row['thumbnail']) ? $row['thumbnail'] : 'https://via.placeholder.com/300x170'; ?>">
    <h3><?php echo $row['title']; ?></h3>

    <p><?php echo $row['description']; ?></p>

    
	<p class="subscribers">
    Subscribers: <?php echo !empty($row['subscribers']) ? $row['subscribers'] : 'Not Available'; ?>
</p>

    <a href="<?php echo $row['youtube_link']; ?>" target="_blank" class="btn btn-outline-primary">
        Visit Channel →
    </a>
	
</div>

<?php 
}
} else {
    echo "<p style='padding:20px;'>No videos available</p>";
}
?>

 </div>
		
<!-- RIGHT BUTTON -->
        <button class="scroll-btn scroll-right" data-target="engineeringRow">
            <i class="fas fa-chevron-right"></i>
        </button>
</div>
</section>















<!-- others Row -->
<section class="py-5" id="engineering">
    <div class="section-header reveal">
        <h2><i class="fas fa-graduation-cap"></i> Others</h2>
        <small>Swipe or click arrows to navigate</small>
    </div>

    <div class="position-relative reveal">
        
        <!-- LEFT BUTTON -->
        <button class="scroll-btn scroll-left" data-target="othersRow">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- ROW START -->
        <div class="channel-row" id="othersRow" data-autoscroll="true">






<?php include 'db.php'; 
$sql = "SELECT * FROM videos WHERE category='others' ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
while($row = mysqli_fetch_assoc($result)) {
?>

<div class="channel-card" data-category="others">
<img class="thumb" src="<?php echo !empty($row['thumbnail']) ? $row['thumbnail'] : 'https://via.placeholder.com/300x170'; ?>">
    <h3><?php echo $row['title']; ?></h3>

    <p><?php echo $row['description']; ?></p>

    
	<p class="subscribers">
    Subscribers: <?php echo !empty($row['subscribers']) ? $row['subscribers'] : 'Not Available'; ?>
</p>

    <a href="<?php echo $row['youtube_link']; ?>" target="_blank" class="btn btn-outline-primary">
        Visit Channel →
    </a>
	
</div>

<?php 
}
} else {
    echo "<p style='padding:20px;'>No videos available</p>";
}
?>

 </div>
		
<!-- RIGHT BUTTON -->
        <button class="scroll-btn scroll-right" data-target="engineeringRow">
            <i class="fas fa-chevron-right"></i>
        </button>
</div>
</section>

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
<li><a href="videos.php">Videos</a></li>
</ul>
</div>
<div class="footer-links">
<h4>Resources</h4>
<ul>
<li><a href="audios.php">Audios</a></li>
<li><a href="brochure.php">Brochure</a></li>
<li><a href="contact.php">Contact</a></li>
<li><a href="contact.php">Feedback</a></li>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Initialize AOS
    AOS.init({ duration: 800, once: true });

    // REVEAL ANIMATION ON SCROLL
    function reveal() {
        var reveals = document.querySelectorAll('.reveal');
        for (var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            var elementVisible = 100;
            if (elementTop < windowHeight - elementVisible) {
                reveals[i].classList.add('active');
            }
        }
    }
    window.addEventListener('scroll', reveal);
    window.addEventListener('load', reveal);

    // Navbar background change on scroll
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.header-area');
        if (window.scrollY > 50) {
            header.style.boxShadow = "0 2px 20px rgba(0,0,0,0.15)";
        } else {
            header.style.boxShadow = "0 2px 15px rgba(0,0,0,0.1)";
        }
    });

    // Scroll arrow buttons
    document.querySelectorAll('.scroll-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.target;
            const el = document.getElementById(targetId);
            if (!el) return;
            const amount = btn.classList.contains('scroll-left') ? -360 : 360;
            el.scrollBy({ left: amount, behavior: 'smooth' });
        });
    });

    // Autoscroll rows with hover pause
    document.querySelectorAll('[data-autoscroll="true"]').forEach(row => {
        let speed = 3800;
        let step = 320;
        let interval = setInterval(() => {
            const maxScroll = row.scrollWidth - row.clientWidth;
            if (row.scrollLeft + step >= maxScroll - 8) {
                row.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                row.scrollBy({ left: step, behavior: 'smooth' });
            }
        }, speed);
        row.addEventListener('mouseenter', () => clearInterval(interval));
        row.addEventListener('mouseleave', () => {
            interval = setInterval(() => {
                const maxScroll = row.scrollWidth - row.clientWidth;
                if (row.scrollLeft + step >= maxScroll - 8) {
                    row.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    row.scrollBy({ left: step, behavior: 'smooth' });
                }
            }, speed);
        });
    });

    // Search + filter functionality
    const searchInput = document.getElementById('searchInput');
    const filterButtons = document.querySelectorAll('.filter-btn');
	function getCards() {
    return document.querySelectorAll('.channel-card');
}

    function filterChannels(category = 'all', query = '') {
        const q = query.trim().toLowerCase();
        getCards().forEach(card => {
            const catMatch = (category === 'all') || card.dataset.category === category;
            const text = card.innerText.toLowerCase();
            const textMatch = q === '' || text.includes(q);
            card.style.display = (catMatch && textMatch) ? '' : 'none';
        });
    }

    // Search input event
    searchInput.addEventListener('input', () => {
        const active = document.querySelector('.filter-btn.active')?.dataset.category || 'all';
        filterChannels(active, searchInput.value);
    });

        // Filter buttons event
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => {
                b.classList.remove('active', 'btn-primary');
                b.classList.add('btn-outline-primary');
            });
            btn.classList.add('active', 'btn-primary');
            btn.classList.remove('btn-outline-primary');
            filterChannels(btn.dataset.category, searchInput.value);
        });
    });

    // Initial filter
    filterChannels();
</script>

</body>
</html>