<?php include 'db.php'; ?>

$current_branch = isset($_GET['branch']) ? $_GET['branch'] : 'IT';

// Fetch all books
$sql = "SELECT * FROM books ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// Fetch latest announcements (sirf book wale)
$ann_sql = "SELECT * FROM announcements 
            WHERE category='book' 
            ORDER BY is_pinned DESC, created_at DESC 
            LIMIT 5";

$ann_result = mysqli_query($conn, $ann_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Books - Digital Audio Video Book</title>

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

/* ===== ENHANCED BRANCH NAVIGATION ===== */
.branch-nav-container {
    background: linear-gradient(135deg, #1a237e 0%, #283593 50%, #1a237e 100%);
    padding: 15px 0;
    position: sticky;
    top: 85px;
    z-index: 999;
    box-shadow: 0 4px 20px rgba(26, 35, 126, 0.3);
}

.branch-nav-wrapper {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding: 10px 0;
    scrollbar-width: thin;
    scrollbar-color: var(--accent-color) transparent;
    -webkit-overflow-scrolling: touch;
}

.branch-nav-wrapper::-webkit-scrollbar {
    height: 6px;
}

.branch-nav-wrapper::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
}

.branch-nav-wrapper::-webkit-scrollbar-thumb {
    background: var(--accent-color);
    border-radius: 10px;
}

.branch-btn {
    flex: 0 0 auto;
    padding: 12px 24px;
    background: rgba(255,255,255,0.1);
    border: 2px solid rgba(255,255,255,0.2);
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 8px;
}

.branch-btn:hover {
    background: rgba(255,255,255,0.2);
    border-color: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

.branch-btn.active{
    background:#f4b400;
    color:black;
}

.branch-btn i {
    font-size: 16px;
}

/* ===== SEARCH BOX ===== */
.search-container {
    max-width: 600px;
    margin: 30px auto 20px;
    padding: 0 15px;
    position: relative;
}

.search-box {
    display: flex;
    background: #fff;
    border-radius: 50px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
}

.search-box input {
    flex: 1;
    padding: 18px 25px;
    border: none;
    font-size: 16px;
    font-family: 'Poppins', sans-serif;
    outline: none;
}

.search-box button {
    padding: 18px 30px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: none;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
}

.search-box button:hover {
    background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
}

/* ===== BOOKS SECTION ===== */
.books-section {
    padding: 40px 0 60px;
    min-height: 60vh;
}

.section-header {
    text-align: center;
    margin-bottom: 40px;
    padding: 0 15px;
}

.section-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 10px;
    position: relative;
    display: inline-block;
}

.section-header h2::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius: 2px;
}

.section-header p {
    color: var(--light-text);
    font-size: 1.1rem;
    margin-top: 15px;
}

.books-count {
    display: inline-block;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: #fff;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    margin-top: 15px;
}

/* ===== ENHANCED BOOK GRID ===== */
.book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 30px;
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

/* ===== ENHANCED BOOK CARD ===== */
.book-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--card-shadow);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    transform: translateY(0);
}

.book-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--hover-shadow);
}

.book-image-container {
    position: relative;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    overflow: hidden;
}

.book-image-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 90%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
    transition: 0.5s;
}

.book-card:hover .book-image-container::before {
    left: 100%;
}

.book-image-container img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-radius: 15px;
    transition: all 0.4s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.book-card:hover .book-image-container img {
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.book-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, var(--secondary-color), #9c1a1a);
    color: #fff;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.book-content {
    padding: 20px;
    text-align: center;
}

.book-content h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark-text);
    margin-bottom: 15px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 50px;
}

.download-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 25px;
    background: linear-gradient(135deg, var(--primary-color), #283593);
    color: #fff;
    border: none;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    width: 100%;
    justify-content: center;
}

.download-btn:hover {
    background: linear-gradient(135deg, var(--secondary-color), #9c1a1a);
    transform: scale(1.02);
    box-shadow: 0 5px 20px rgba(26, 35, 126, 0.4);
}

.download-btn i {
    transition: transform 0.3s ease;
}

.download-btn:hover i {
    transform: translateY(2px);
}

/* ===== BOOK SECTION ANIMATION ===== */
.book-section {
    display: none;
    animation: fadeInUp 0.5s ease forwards;
}

.book-section.active {
    display: block;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== LOADING ANIMATION ===== */
.loading-spinner {
    display: none;
    text-align: center;
    padding: 60px 20px;
}

.loading-spinner.active {
    display: block;
}

.spinner {
    width: 60px;
    height: 60px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* ===== NO RESULTS FOUND ===== */
.no-results {
    display: none;
    text-align: center;
    padding: 60px 20px;
    color: var(--light-text);
}

.no-results.active {
    display: block;
}

.no-results i {
    font-size: 60px;
    color: #ddd;
    margin-bottom: 20px;
}

.no-results h3 {
    font-size: 1.5rem;
    color: var(--dark-text);
    margin-bottom: 10px;
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

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1200px) {
    .main-nav a {
        padding: 7px 10px;
        font-size: 12px;
    }
    .logo-text h4 {
        font-size: 14px;
    }
    .book-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
    }
}

@media (max-width: 992px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .about-content {
        grid-template-columns: 1fr;
    }
    .features-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .team-grid {
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
    
    .branch-nav-container {
        top: 140px;
    }
    
    .branch-btn {
        padding: 10px 18px;
        font-size: 13px;
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
    .hero h1 {
        font-size: 28px;
    }
    .hero p {
        font-size: 15px;
    }
    .stats-grid {
        grid-template-columns: 1fr;
    }
    .features-grid {
        grid-template-columns: 1fr;
    }
    .team-grid {
        grid-template-columns: 1fr;
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
    
    .branch-nav-container {
        top: 200px;
        padding: 10px 0;
    }
    
    .branch-btn {
        padding: 8px 15px;
        font-size: 12px;
    }
    
    .branch-btn i {
        font-size: 14px;
    }
    
    .search-container {
        margin: 20px auto 15px;
    }
    
    .search-box input {
        padding: 14px 18px;
        font-size: 14px;
    }
    
    .search-box button {
        padding: 14px 20px;
        font-size: 14px;
    }
    
    .section-header h2 {
        font-size: 1.6rem;
    }
    
    .section-header p {
        font-size: 0.95rem;
    }
    
    .book-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 15px;
        padding: 10px;
    }
    
    .book-image-container {
        padding: 10px;
    }
    
    .book-image-container img {
        height: 180px;
    }
    
    .book-content {
        padding: 12px;
    }
    
    .book-content h3 {
        font-size: 0.9rem;
        min-height: 35px;
    }
    
    .download-btn {
        padding: 10px 15px;
        font-size: 12px;
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
    
    .gallery-grid {
        grid-template-columns: repeat(6, 1fr);
        max-width: 400px;
        margin: 0 auto;
    }
    
    .book-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    
    .book-image-container img {
        height: 140px;
    }
    
    .book-content h3 {
        font-size: 0.8rem;
    }
    
    .download-btn {
        padding: 8px 12px;
        font-size: 11px;
        gap: 5px;
    }
}

/* ===== FLOATING SEARCH BUTTON (Mobile) ===== */
.floating-search-btn {
    display: none;
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    color: #fff;
    font-size: 24px;
    border: none;
    cursor: pointer;
    box-shadow: 0 5px 25px rgba(0,0,0,0.3);
    z-index: 1001;
    transition: all 0.3s ease;
}

.floating-search-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 35px rgba(0,0,0,0.4);
}

@media (max-width: 768px) {
    .floating-search-btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .search-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.9);
        z-index: 1002;
        margin: 0;
        padding: 20px;
        align-items: center;
    }
    
    .search-container.active {
        display: flex;
    }
    
    .search-container .search-box {
        width: 100%;
        max-width: 400px;
    }
    
    .close-search {
        position: absolute;
        top: 20px;
        right: 20px;
        color: #fff;
        font-size: 30px;
        cursor: pointer;
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

/* ===== BACK TO TOP BUTTON ===== */
.back-to-top {
    position: fixed;
    bottom: 30px;
    left: 30px;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
    border-radius: 50%;
    color: #fff;
    font-size: 20px;
    border: none;
    cursor: pointer;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.4);
}
  </style>
</head>
<body>




<!-- Header -->
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
          <a href="book.php" class="active"><i class="fas fa-book"></i> Books</a>
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

  <!-- ENHANCED BRANCH NAVIGATION -->
  <div class="branch-nav-container">
    <div class="container">
      <div class="branch-nav-wrapper">
        <button class="branch-btn active" onclick="showBranch(event,'IT')">
		<i class="fas fa-laptop-code"></i>IT</button>

<button class="branch-btn" onclick="showBranch(event,'Civil')">
<i class="fas fa-building"></i>Civil</button>

<button class="branch-btn" onclick="showBranch(event,'Mechanical')">
 <i class="fas fa-cogs"></i>Mechanical</button>

<button class="branch-btn" onclick="showBranch(event,'Electrical')">
<i class="fas fa-bolt"></i>Electrical</button>

<button class="branch-btn" onclick="showBranch(event,'Electronic')">
 <i class="fas fa-microchip"></i>Electronics</button>

<button class="branch-btn" onclick="showBranch(event,'Pharmacy')">
  <i class="fas fa-pills"></i>Pharmacy</button>
      </div>
    </div>
  </div>

  <!-- SEARCH BOX -->
  <div class="search-container" id="searchContainer">
    <span class="close-search" onclick="toggleSearch()">&times;</span>
    <div class="search-box">
      <input type="text" id="bookSearch" placeholder="ðŸ” Search books by name..." onkeyup="searchBooks()">
      <button onclick="searchBooks()"><i class="fas fa-search"></i></button>
    </div>
  </div>

  <!-- FLOATING SEARCH BUTTON -->
  <button class="floating-search-btn" onclick="toggleSearch()">
    <i class="fas fa-search"></i>
  </button>

  








<!-- Replace your entire BOOKS SECTION (from <div class="books-section"> to </div>) -->
<div class="books-section">
  <div class="section-header">
    <h2>ðŸ“š Books Available for Download</h2>
    <p>Access free study materials, textbooks, and references for all branches</p>
    <span class="books-count" id="booksCount">Loading...</span>
  </div>
  
  
  
  
 
  
  
  

  <!-- IT Branch -->
  
  <div id="IT" class="book-section <?php echo $current_branch=='IT' ? 'active' : ''; ?>">
  <div class="book-grid">

  <?php 
  mysqli_data_seek($result, 0);
  $count = 0;

  while($row = mysqli_fetch_assoc($result)): 
    if(strtolower($row['branch'])=='it'):
      $count++;
  ?>

   
	<div class="book-card">
          <div class="book-image-container">
            <span class="book-badge">PDF</span>
            
			<img src="images/books/IT/<?php echo !empty($row['image']) ? $row['image'] : 'default.jpg'; ?>">
          </div>
          <div class="book-content">
            <h3><?php echo $row['title']; ?></h3>
			<?php
// Optional: increase views
mysqli_query($conn, "UPDATE announcements SET views = views + 1 WHERE category='book'");
?>
            <a href="PDF/book_pdf/IT/<?php echo $row['file']; ?>" class="download-btn" download>
              <i class="fas fa-download"></i> Download
            </a>
          </div>
        </div>
		
	
  <?php endif; endwhile; ?>

  <?php if($count == 0): ?>
    <div style="grid-column: 1/-1; text-align:center; padding:50px; color:#666;">
      <i class="fas fa-book" style="font-size:60px; margin-bottom:20px;"></i>
      <h3>No Books Available</h3>
      <p>Add books from admin panel</p>
    </div>
  <?php endif; ?>

  </div>
</div>
  
  

  
  

  <!-- Civil Branch -->
  <div id="Civil" class="book-section <?php echo $current_branch=='Civil' ? 'active' : ''; ?>">
    <div class="book-grid">
      <?php 
      mysqli_data_seek($result, 0);
      $Civil_count = 0;
      while($row = mysqli_fetch_assoc($result)): 
        if(strtolower($row['branch'])=='civil'):
          $Civil_count++;
      ?>
        <div class="book-card">
          <div class="book-image-container">
            <span class="book-badge">PDF</span>
            <img src="images/books/Civil/<?php echo !empty($row['image']) ? $row['image'] : 'default.jpg'; ?>">
          </div>
          <div class="book-content">
            <h3><?php echo $row['title']; ?></h3>
			<?php
// Optional: increase views
mysqli_query($conn, "UPDATE announcements SET views = views + 1 WHERE category='book'");
?>
            <a href="PDF/book_pdf/Civil/<?php echo $row['file']; ?>" class="download-btn" download>
              <i class="fas fa-download"></i> Download
            </a>
          </div>
        </div>
      <?php endif; endwhile; ?>
      <?php if($Civil_count==0): ?>
        <div style="grid-column: 1/-1; text-align:center; padding:50px; color:#666;">
          <i class="fas fa-book" style="font-size:60px; margin-bottom:20px;"></i>
          <h3>No Civil Books</h3>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Mechanical Branch -->
  <div id="Mechanical" class="book-section <?php echo $current_branch=='Mechanical' ? 'active' : ''; ?>">
    <div class="book-grid">
      <?php 
      mysqli_data_seek($result, 0);
      $Mechanical_count = 0;
      while($row = mysqli_fetch_assoc($result)): 
 if(trim(strtolower($row['branch'])) == 'mechanical'):
          $Mechanical_count++;
      ?>
        <div class="book-card">
          <div class="book-image-container">
            <span class="book-badge">PDF</span>
            <img src="images/books/Mechanical/<?php echo !empty($row['image']) ? $row['image'] : 'default.jpg'; ?>">
          </div>
          <div class="book-content">
            <h3><?php echo $row['title']; ?></h3>
			<?php
// Optional: increase views
mysqli_query($conn, "UPDATE announcements SET views = views + 1 WHERE category='book'");
?>
            <a href="PDF/book_pdf/Mechanical/<?php echo $row['file']; ?>" class="download-btn" download>
              <i class="fas fa-download"></i> Download
            </a>
          </div>
        </div>
      <?php endif; endwhile; ?>
      <?php if($Mechanical_count==0): ?>
        <div style="grid-column: 1/-1; text-align:center; padding:50px; color:#666;">
          <i class="fas fa-book" style="font-size:60px; margin-bottom:20px;"></i>
          <h3>No Mechanical Books</h3>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Electrical Branch -->
  <div id="Electrical" class="book-section <?php echo $current_branch=='Electrical' ? 'active' : ''; ?>">
    <div class="book-grid">
      <?php 
      mysqli_data_seek($result, 0);
      $Electrical_count = 0;
      while($row = mysqli_fetch_assoc($result)): 
        if(strtolower($row['branch'])=='electrical'):
          $Electrical_count++;
      ?>
        <div class="book-card">
          <div class="book-image-container">
            <span class="book-badge">PDF</span>
            <img src="images/books/Electrical/<?php echo !empty($row['image']) ? $row['image'] : 'default.jpg'; ?>">
          </div>
          <div class="book-content">
            <h3><?php echo $row['title']; ?></h3>
			<?php
// Optional: increase views
mysqli_query($conn, "UPDATE announcements SET views = views + 1 WHERE category='book'");
?>
            <a href="PDF/book_pdf/Electrical/<?php echo $row['file']; ?>" class="download-btn" download>
              <i class="fas fa-download"></i> Download
            </a>
          </div>
        </div>
      <?php endif; endwhile; ?>
      <?php if($Electrical_count==0): ?>
        <div style="grid-column: 1/-1; text-align:center; padding:50px; color:#666;">
          <i class="fas fa-book" style="font-size:60px; margin-bottom:20px;"></i>
          <h3>No Electrical Books</h3>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Electronics Branch -->
  <div id="Electronic" class="book-section <?php echo $current_branch=='Electronic' ? 'active' : ''; ?>">
    <div class="book-grid">
      <?php 
      mysqli_data_seek($result, 0);
      $Electronic_count = 0;
      while($row = mysqli_fetch_assoc($result)): 
        if(strtolower($row['branch'])=='electronic'):
          $Electronic_count++;
      ?>
        <div class="book-card">
          <div class="book-image-container">
            <span class="book-badge">PDF</span>
            <img src="images/books/Electronic/<?php echo !empty($row['image']) ? $row['image'] : 'default.jpg'; ?>">
          </div>
          <div class="book-content">
            <h3><?php echo $row['title']; ?></h3>
			<?php
// Optional: increase views
mysqli_query($conn, "UPDATE announcements SET views = views + 1 WHERE category='book'");
?>
            <a href="PDF/book_pdf/Electronic/<?php echo $row['file']; ?>" class="download-btn" download>
              <i class="fas fa-download"></i> Download
            </a>
          </div>
        </div>
      <?php endif; endwhile; ?>
      <?php if($Electronic_count==0): ?>
        <div style="grid-column: 1/-1; text-align:center; padding:50px; color:#666;">
          <i class="fas fa-book" style="font-size:60px; margin-bottom:20px;"></i>
          <h3>No Electronics Books</h3>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Pharmacy Branch -->
  <div id="Pharmacy" class="book-section <?php echo $current_branch=='Pharmacy' ? 'active' : ''; ?>">
    <div class="book-grid">
      <?php 
      mysqli_data_seek($result, 0);
      $Pharmacy_count = 0;
      while($row = mysqli_fetch_assoc($result)): 
        if(strtolower($row['branch'])=='pharmacy'):
          $Pharmacy_count++;
      ?>
        <div class="book-card">
          <div class="book-image-container">
            <span class="book-badge">PDF</span>
            <img src="images/books/Pharmacy/<?php echo !empty($row['image']) ? $row['image'] : 'default.jpg'; ?>">
          </div>
          <div class="book-content">
            <h3><?php echo $row['title']; ?></h3>
			<?php
// Optional: increase views
mysqli_query($conn, "UPDATE announcements SET views = views + 1 WHERE category='book'");
?>
            <a href="PDF/book_pdf/Pharmacy/<?php echo $row['file']; ?>" class="download-btn" download>
              <i class="fas fa-download"></i> Download
            </a>
          </div>
        </div>
      <?php endif; endwhile; ?>
      <?php if($Pharmacy_count==0): ?>
        <div style="grid-column: 1/-1; text-align:center; padding:50px; color:#666;">
          <i class="fas fa-book" style="font-size:60px; margin-bottom:20px;"></i>
          <h3>No Pharmacy Books</h3>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>






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

  <!-- BACK TO TOP BUTTON -->
  <button class="back-to-top" onclick="scrollToTop()">
    <i class="fas fa-arrow-up"></i>
  </button>

  <script>
   // â­ BRANCH TAB SWITCHING
function showBranch(e, branch){

    // sab sections hide
    document.querySelectorAll('.book-section').forEach(sec=>{
        sec.classList.remove('active');
    });

    // selected section show
    let activeSection = document.getElementById(branch);
    if(activeSection){
        activeSection.classList.add('active');
    }

    // sab buttons se yellow remove
    document.querySelectorAll('.branch-btn').forEach(btn=>{
        btn.classList.remove('active');
    });

    // clicked button yellow
    e.currentTarget.classList.add('active');

    // books count update
    updateBooksCount(branch);

    // smooth scroll
    document.querySelector('.books-section').scrollIntoView({
        behavior:'smooth'
    });
}


// â­ BOOK COUNT UPDATE
function updateBooksCount(branch){
    let section = document.getElementById(branch);
    if(section){
        let count = section.querySelectorAll('.book-card').length;
        document.getElementById('booksCount').innerText =
            "Showing " + count + " Books";
    }
}


// â­ PAGE LOAD DEFAULT IT
document.addEventListener("DOMContentLoaded", function(){
    updateBooksCount("IT");
});


  </script>

</body>
</html>




