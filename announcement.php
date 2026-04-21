
<?php
// announcement.php
include 'db.php';


$category_filter = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : 'all';

// Pinned Announcements
$pinned_query = "SELECT * FROM announcements 
WHERE is_pinned = 1 
AND created_at >= NOW() - INTERVAL 2 DAY 
ORDER BY created_at DESC";
$pinned_result = mysqli_query($conn, $pinned_query);

// All Announcements (with filter)
$where = "";
if ($category_filter !== 'all') {
    $where = "WHERE category = '$category_filter'";
}


$query = "SELECT * FROM announcements 
WHERE is_pinned = 0 
AND created_at >= NOW() - INTERVAL 2 DAY 
" . ($category_filter !== 'all' ? "AND category = '$category_filter'" : "") . "
ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Announcements | Government Polytechnic Nainital</title>

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
    --card-shadow:0 10px 40px rgba(0,0,0,0.1);
    --hover-shadow:0 20px 60px rgba(0,0,0,0.15);
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

/* ===== PAGE HEADER SECTION ===== */
.page-header{background:linear-gradient(135deg,rgba(26,35,126,0.95),rgba(40,53,147,0.9)),url('https://images.unsplash.com/photo-1562774053-701939374585?w=1920');background-size:cover;background-position:center;padding:80px 20px;text-align:center;color:#fff;position:relative;background-attachment:fixed}
.page-header::before{content:'';position:absolute;top:0;left:0;width:100%;height:5px;background:linear-gradient(90deg,var(--secondary-color),var(--accent-color),var(--secondary-color))}
.page-header-content{position:relative;z-index:2;max-width:800px;margin:0 auto}
.page-header h1{font-size:42px;font-weight:700;margin-bottom:15px;font-family:'Playfair Display',serif}
.page-header h1 i{margin-right:15px;color:var(--accent-color)}
.page-header p{font-size:18px;opacity:0.95;line-height:1.8}

/* ===== ANNOUNCEMENTS SECTION ===== */
.announcements-section{padding:60px 0;background:var(--light-bg)}
.section-title{text-align:center;margin-bottom:40px}
.section-title h2{color:var(--primary-color);font-size:36px;font-weight:700;font-family:'Playfair Display',serif;margin-bottom:15px;position:relative;display:inline-block}
.section-title h2::after{content:'';position:absolute;bottom:-10px;left:50%;transform:translateX(-50%);width:60px;height:4px;background:var(--secondary-color)}
.section-title p{color:var(--light-text);font-size:16px;max-width:600px;margin:20px auto 0}

/* ===== IMPORTANT NOTICE BOX ===== */
.important-notice{background:linear-gradient(135deg,var(--secondary-color),#9c1a1a);color:#fff;padding:25px 30px;border-radius:10px;margin-bottom:30px;display:flex;align-items:center;gap:20px;box-shadow:0 10px 30px rgba(128,0,0,0.3)}
.important-notice i{font-size:40px;color:var(--accent-color);flex-shrink:0}
.important-notice-content h4{margin:0 0 8px;font-size:20px;font-weight:700}
.important-notice-content p{margin:0;font-size:15px;opacity:0.95}

/* ===== FILTER BUTTONS ===== */
.filter-container{display:flex;justify-content:center;gap:12px;flex-wrap:wrap;margin-bottom:40px}
.filter-btn{padding:10px 25px;border:2px solid var(--primary-color);background:transparent;color:var(--primary-color);border-radius:25px;font-weight:600;font-size:14px;cursor:pointer;transition:all 0.3s ease}
.filter-btn:hover,.filter-btn.active{background:var(--primary-color);color:#fff}
.filter-btn i{margin-right:8px}

/* ===== ANNOUNCEMENT CARDS ===== */
.announcement-card{background:#fff;border-radius:10px;padding:25px;margin-bottom:25px;box-shadow:0 5px 20px rgba(0,0,0,0.08);transition:all 0.3s ease;border-left:5px solid var(--primary-color);position:relative;overflow:hidden}
.announcement-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:3px;background:linear-gradient(90deg,var(--secondary-color),var(--accent-color));transform:scaleX(0);transform-origin:left;transition:transform 0.3s ease}
.announcement-card:hover{transform:translateY(-5px);box-shadow:0 15px 35px rgba(0,0,0,0.15)}
.announcement-card:hover::before{transform:scaleX(1)}
.announcement-card.new-announcement{border-left-color:#ff0000}

/* NEW Badge */
.new-badge{position:absolute;top:15px;right:15px;background:#ff0000;color:#fff;padding:5px 12px;border-radius:20px;font-size:11px;font-weight:700;animation:blink 1s infinite;text-transform:uppercase}

/* Category Badge */
.announcement-category{display:inline-block;padding:5px 14px;border-radius:15px;font-size:11px;font-weight:600;text-transform:uppercase;margin-bottom:12px}
.category-exam{background:#e3f2fd;color:#1976d2}
.category-event{background:#f3e5f5;color:#7b1fa2}
.category-notice{background:#fff3e0;color:#f57c00}
.category-result{background:#e8f5e9;color:#388e3c}
.category-holiday{background:#ffebee;color:#c62828}
.category-admission{background:#e0f7fa;color:#00838f}

/* Date Badge */
.announcement-date{display:inline-flex;align-items:center;gap:8px;background:var(--primary-color);color:#fff;padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;margin-bottom:15px}
.announcement-date i{font-size:14px}

.announcement-card h3{color:var(--primary-color);font-size:20px;font-weight:700;margin-bottom:12px;line-height:1.4}
.announcement-card p{color:var(--light-text);line-height:1.8;margin-bottom:15px}
.announcement-meta{display:flex;gap:20px;flex-wrap:wrap;padding-top:15px;border-top:1px solid #eee}
.announcement-meta span{display:flex;align-items:center;gap:6px;font-size:13px;color:var(--light-text)}
.announcement-meta i{color:var(--secondary-color)}

/* ===== PINNED ANNOUNCEMENT ===== */
.pinned-announcement{border-left-color:var(--accent-color);background:linear-gradient(to right,#fff9e6,#fff)}
.pinned-badge{position:absolute;top:15px;right:15px;background:var(--accent-color);color:var(--primary-color);padding:5px 12px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase}

/* ===== FOOTER ===== */
.footer-main{background:linear-gradient(135deg,#0d1b2a 0%,#1a237e 50%,#0d1b2a 100%);color:#fff;padding:60px 0 0}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1.5fr;gap:40px;margin-bottom:40px}
.footer-about h3{color:var(--accent-color);margin-bottom:20px;font-size:22px;font-weight:700}
.footer-about p{line-height:1.8;opacity:0.9;font-size:14px;color:#ccc}

/* ===== FOOTER SOCIAL ICONS ===== */
.footer-social{margin-top:20px;display:flex;gap:10px}
.footer-social a{display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.1);color:#fff;font-size:18px;text-decoration:none;transition:all 0.3s ease}
.footer-social a.facebook:hover{background:#1877f2;transform:translateY(-3px)}
.footer-social a.instagram:hover{background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);transform:translateY(-3px)}
.footer-social a.twitter:hover{background:#1da1f2;transform:translateY(-3px)}
.footer-social a.youtube:hover{background:#ff0000;transform:translateY(-3px)}

/* ===== FOOTER LINKS ===== */
.footer-links h4{color:var(--accent-color);margin-bottom:20px;font-size:18px;font-weight:700}
.footer-links ul{list-style:none;padding:0;margin:0}
.footer-links ul li{margin-bottom:12px}
.footer-links ul li a{color:#ccc;text-decoration:none;font-size:14px;transition:all 0.3s ease;display:flex;align-items:center;gap:8px}
.footer-links ul li a:hover{color:var(--accent-color);padding-left:5px}

/* ===== CONTACT INFO ===== */
.contact-info{list-style:none;padding:0;margin:0}
.contact-info li{margin-bottom:15px}
.contact-info li a{color:#ccc;text-decoration:none;font-size:14px;transition:all 0.3s ease;display:flex;align-items:center;gap:12px;padding:8px 12px;border-radius:8px;background:rgba(255,255,255,0.05)}
.contact-info li a:hover{color:#fff;background:rgba(255,255,255,0.1);transform:translateX(5px)}
.contact-info li a i{width:20px;text-align:center;font-size:16px}
.contact-info li a.phone:hover{color:#25D366}
.contact-info li a.email:hover{color:#EA4335}
.contact-info li a.location:hover{color:#4285F4}

/* ===== FOOTER GALLERY ===== */
.footer-gallery h4{color:var(--accent-color);margin-bottom:20px;font-size:18px;font-weight:700}
.gallery-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.gallery-grid a{display:block;overflow:hidden;border-radius:8px;position:relative}
.gallery-grid a img{width:100%;height:70px;object-fit:cover;transition:all 0.3s ease}
.gallery-grid a:hover img{transform:scale(1.1);filter:brightness(1.1)}
.gallery-grid a::after{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(26,35,126,0.3);opacity:0;transition:all 0.3s ease}
.gallery-grid a:hover::after{opacity:1}

/* ===== FOOTER BOTTOM ===== */
.footer-bottom{background:rgba(0,0,0,0.3);border-top:1px solid rgba(255,255,255,0.1);padding:20px 50px;text-align:center;border-top:2px solid #ffd700}
.footer-bottom p{margin:0;font-size:14px;color:#aaa}
.footer-bottom p i{color:#ebe4e4;margin:0 5px}

/* ===== REVEAL ANIMATION ===== */
.reveal{opacity:0;transform:translateY(50px);transition:all 0.8s ease-out}
.reveal.active{opacity:1;transform:translateY(0)}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px){
    .footer-grid{grid-template-columns:1fr 1fr;gap:30px}
    .footer-gallery{grid-column:1/-1}
    .footer-about{grid-column:1/-1;text-align:center}
    .footer-social{justify-content:center}
    .footer-links{text-align:center}
    .gallery-grid{grid-template-columns:repeat(6,1fr);max-width:400px;margin:0 auto}
    .page-header h1{font-size:32px}
}

@media (max-width: 768px){
    .footer-grid{grid-template-columns:1fr;gap:25px}
    .footer-main{padding:40px 0 0}
    .gallery-grid{grid-template-columns:repeat(3,1fr)}
    .page-header{padding:60px 20px}
    .page-header h1{font-size:26px}
    .page-header p{font-size:15px}
    .announcement-card{padding:20px}
    .announcement-card h3{font-size:18px}
    .filter-btn{padding:8px 18px;font-size:13px}
    .topbar .container{flex-direction:column;gap:8px;text-align:center}
    .logo-section{justify-content:center;flex-direction:column;gap:8px}
    .main-nav{justify-content:center;gap:2px;flex-wrap:wrap}
    .main-nav a{padding:6px 8px;font-size:11px}
    .important-notice{flex-direction:column;text-align:center}
}

@media(max-width:1200px){
    .main-nav a{padding:7px 10px;font-size:12px}
    .logo-text h4{font-size:14px}
}

@media(max-width:992px){
    .header-area .container .d-flex{flex-direction:column;gap:15px}
    .logo-section{justify-content:center}
    .main-nav{justify-content:center;flex-wrap:wrap}
}


@media (max-width: 1200px) {
    .main-nav a {
        padding: 7px 10px;
        font-size: 12px;
    }
    .logo-text h4 {
        font-size: 14px;
    }
    
    
}

@media (max-width: 992px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .footer-grid {
        grid-template-columns: 1fr 1fr;
    }
    .header-area .container .d-flex {
        flex-direction: column;
        gap: 15px;
    }
    .logo-section {
        justify-content: center;
    }
    .main-nav {
        justify-content: center;
        flex-wrap: wrap;
    }
    
  
    
    .section-header h2 {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .topbar .container {
        flex-direction: column;
        gap: 8px;
        text-align: center;
    }
    .logo-section {
        justify-content: center;
        flex-direction: column;
        gap: 8px;
    }
    .main-nav {
        justify-content: center;
        gap: 2px;
    }
    .main-nav a {
        padding: 6px 8px;
        font-size: 11px;
    }
    
    
    .footer-grid {
        grid-template-columns: 1fr;
    }
    .gallery-slider img {
        height: 250px;
    }
    .logo-box img {
        width: 60px;
    }
    .logo-text h4 {
        font-size: 13px;
    }
    .logo-text span {
        font-size: 11px;
    }
    .marquee-content span {
        font-size: 14px;
        margin-right: 40px;
    }
    
}
    
   

@media (max-width: 480px) {
    .topbar-left span {
        font-size: 12px;
    }
    
    .topbar-right a {
        font-size: 11px;
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







/* ===== SMOOTH SCROLL ===== */
html {
    scroll-behavior: smooth;
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
<a href="announcement.php" class="new-btn active"><i class="fas fa-bullhorn"></i> NEW</a>
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

<!-- PAGE HEADER -->
<section class="page-header">
<div class="page-header-content reveal">
<h1><i class="fas fa-bullhorn"></i> College Announcements</h1>
<p>Stay updated with the latest news, events, exam schedules, and important notices from Government Polytechnic Nainital</p>
</div>
</section>






   <!-- ANNOUNCEMENTS SECTION -->
    <section class="announcements-section">
        <div class="container">
            <div class="section-title reveal">
                <h2>Latest Announcements</h2>
                <p>Important updates and notices for students, faculty, and staff</p>
            </div>

            <!-- IMPORTANT NOTICE BOX -->
            <div class="important-notice reveal">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="important-notice-content">
                    <h4><i class="fas fa-bell"></i> Important Notice</h4>
                    <p>All students are requested to regularly check this page for the latest updates and announcements from the college administration.</p>
                </div>
            </div>

            <!-- FILTER BUTTONS -->
            <div class="filter-container reveal">
                <a href="announcement.php" class="filter-btn <?= $category_filter == 'all' ? 'active' : '' ?>"><i class="fas fa-list"></i> All</a>
                <a href="?category=exam" class="filter-btn <?= $category_filter == 'exam' ? 'active' : '' ?>"><i class="fas fa-clipboard-check"></i> Exams</a>
                
                <a href="?category=result" class="filter-btn <?= $category_filter == 'result' ? 'active' : '' ?>"><i class="fas fa-chart-bar"></i> Results</a>
               <a href="?category=notice" class="filter-btn <?= $category_filter == 'notice' ? 'active' : '' ?>"><i class="fas fa-bullhorn"></i> Notice</a>
                <a href="book.php" class="filter-btn <?= $category_filter == 'book' ? 'active' : '' ?>"><i class="fas fa-book"></i> Books</a>
                <a href="notes.php" class="filter-btn <?= $category_filter == 'notes' ? 'active' : '' ?>"><i class="fas fa-sticky-note"></i> Notes</a>
                <a href="videos.php" class="filter-btn <?= $category_filter == 'video' ? 'active' : '' ?>"><i class="fas fa-video"></i> Videos</a>
                <a href="audios.php" class="filter-btn <?= $category_filter == 'audio' ? 'active' : '' ?>"><i class="fas fa-headphones"></i> Audios</a>
            </div>

            <!-- ANNOUNCEMENTS LIST -->
            <div id="announcements-container">

                <?php 
                // Pinned Announcements
                while($row = mysqli_fetch_assoc($pinned_result)): 
                ?>
                <div class="announcement-card pinned-announcement reveal" data-category="<?= htmlspecialchars($row['category']) ?>">
                    <span class="pinned-badge"><i class="fas fa-thumbtack"></i> Pinned</span>
                    <span class="announcement-category category-<?= htmlspecialchars($row['category']) ?>">
                        <?= ucfirst(htmlspecialchars($row['category'])) ?>
                    </span>
                    <span class="announcement-date">
                        <i class="fas fa-calendar-alt"></i> 
                        <?= date('F d, Y', strtotime($row['created_at'])) ?>
                    </span>
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                    
                    <div class="announcement-meta">
                        <span><i class="fas fa-user"></i> <?= htmlspecialchars($row['added_by']) ?></span>
                        <span><i class="fas fa-eye"></i> <?= $row['views'] ?> Views</span>
                        <span><i class="fas fa-clock"></i> <?= date('d M Y â€¢ h:i A', strtotime($row['created_at'])) ?></span>
                        <?php if($row['download_link']): ?>
                        <span><i class="fas fa-download"></i> <a href="<?= htmlspecialchars($row['download_link']) ?>" style="color:var(--secondary-color);">Download</a></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>

                <?php 
                // Normal Announcements
                
                while($row = mysqli_fetch_assoc($result)): 
                  
                    $is_new = (strtotime($row['created_at']) > strtotime('-2 days')) ? true : false;
                ?>
                <div class="announcement-card <?= $is_new ? 'new-announcement' : '' ?> reveal" data-category="<?= htmlspecialchars($row['category']) ?>">
                    
                    <?php if($is_new): ?>
                    <span class="new-badge"><i class="fas fa-star"></i> New</span>
                    <?php endif; ?>
					
					 <span class="announcement-category category-<?= htmlspecialchars($row['category']) ?>">
                        <?= ucfirst(htmlspecialchars(str_replace('_', ' ', $row['category']))) ?>
                    </span>
                    <span class="announcement-date">
                        <i class="fas fa-calendar-alt"></i> 
                        <?= date('F d, Y', strtotime($row['created_at'])) ?>
                    </span>
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                    
                    <div class="announcement-meta">
                        <span><i class="fas fa-user"></i> <?= htmlspecialchars($row['added_by']) ?></span>
                        <span><i class="fas fa-eye"></i> <?= $row['views'] ?> Views</span>
                        <span><i class="fas fa-clock"></i> Added: <?= date('d M Y â€¢ h:i A', strtotime($row['created_at'])) ?></span>
                        <?php if($row['download_link']): ?>
                        <span><i class="fas fa-download"></i> <a href="<?= htmlspecialchars($row['download_link']) ?>" style="color:var(--secondary-color);">Download</a></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>

                <?php if(mysqli_num_rows($result) == 0 && mysqli_num_rows($pinned_result) == 0): ?>
                <p class="text-center">No announcements found.</p>
                <?php endif; ?>

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
<li><a href="tel:+915942235123" class="phone"><i class="fas fa-phone"></i> +91 9411158375</a></li>
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
// ===== FILTER FUNCTIONALITY =====
function filterAnnouncements(category) {

    // Update active button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Find clicked button and activate it
    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(btn => {
        if (btn.getAttribute("onclick").includes(category)) {
            btn.classList.add('active');
        }
    });

    // Filter cards
    const cards = document.querySelectorAll('.announcement-card');

    cards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');

        if (category === 'all' || cardCategory === category) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}


// ===== SCROLL REVEAL ANIMATION =====
function revealOnScroll() {
    const reveals = document.querySelectorAll('.reveal');

    reveals.forEach(element => {
        const windowHeight = window.innerHeight;
        const elementTop = element.getBoundingClientRect().top;

        if (elementTop < windowHeight - 100) {
            element.classList.add('active');
        }
    });
}

window.addEventListener('scroll', revealOnScroll);
window.addEventListener('load', revealOnScroll);
</script>