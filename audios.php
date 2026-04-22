<?php include 'db.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all distinct categories from DB (admin-driven)
function getCategories($conn) {
    $result = mysqli_query($conn, "SELECT DISTINCT category FROM audios ORDER BY category ASC");
    $cats = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cats[] = $row['category'];
    }
    return $cats;
}

// Fetch audios for a given category
function getAudios($conn, $category) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM audios WHERE category=? ORDER BY created_at DESC");
    mysqli_stmt_bind_param($stmt, "s", $category);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

$categories = getCategories($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Lectures | Government Polytechnic Nainital</title>
    <meta name="description" content="Listen to subject-wise audio lectures uploaded by faculty at Government Polytechnic Nainital.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
    /* ===== BASE ===== */
    *{margin:0;padding:0;box-sizing:border-box}
    html{scroll-behavior:smooth}
    body{font-family:'Poppins',sans-serif;background:#f5f7fa;overflow-x:hidden;line-height:1.6}

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

    /* ===== NAV ===== */
    .main-nav{display:flex;align-items:center;gap:2px;flex-wrap:nowrap;justify-content:flex-end}
    .main-nav a{color:var(--dark-text);text-decoration:none;font-weight:600;font-size:13px;padding:8px 12px;border-radius:5px;transition:all 0.3s;white-space:nowrap}
    .main-nav a:hover{background:var(--primary-color);color:#fff}
    .main-nav a.active{background:var(--primary-color);color:#fff}

    /* NEW BUTTON */
    .new-btn{background:#ff0000;color:#fff;padding:6px 14px;border-radius:20px;font-weight:700;font-size:12px;display:inline-block;animation:blink 0.3s infinite;text-decoration:none;transition:0.3s}
    .new-btn:hover{background:#cc0000;transform:scale(1.1);color:#fff}
    .new-btn i{margin-right:5px}
    @keyframes blink{0%,100%{opacity:1;transform:scale(1);}50%{opacity:0.5;transform:scale(0.95);}}

    /* ===== SEARCH ===== */
    .search-section{padding:35px 0;background:#fff;box-shadow:0 4px 15px rgba(0,0,0,0.07)}
    .search-container{max-width:1100px;margin:0 auto;padding:0 15px;position:relative}
    .search-input{width:100%;padding:16px 20px 16px 55px;font-size:1.05rem;border:2px solid #ddd;border-radius:50px;outline:none;transition:all 0.3s ease;font-family:'Poppins',sans-serif}
    .search-input:focus{border-color:var(--primary-color);box-shadow:0 0 0 4px rgba(26,35,126,0.15)}
    .search-icon{position:absolute;left:25px;top:50%;transform:translateY(-50%);color:var(--primary-color);font-size:1.3rem}

    /* ===== CONTENT ===== */
    .content-section{padding:60px 0;background:#fff}
    .content-container{max-width:1100px;margin:0 auto;padding:0 15px}

    /* ===== ACCORDION ===== */
    .accordion{background:#fff;border-radius:8px;margin-bottom:15px;box-shadow:0 2px 6px rgba(0,0,0,0.1);overflow:hidden;border:1px solid #e0e0e0}
    .accordion-header{padding:15px 20px;cursor:pointer;background:var(--primary-color);color:#fff;font-size:18px;display:flex;justify-content:space-between;align-items:center;transition:all 0.3s ease;user-select:none}
    .accordion-header:hover{background:#283593}
    .accordion-header span{font-weight:bold}
    .accordion-content{display:none;background:#f9fcff;padding:20px}

    /* ===== AUDIO ITEMS ===== */
    .audio-item{background:#fff;padding:15px 20px;border-radius:8px;margin-bottom:12px;border-left:4px solid var(--primary-color);transition:all 0.3s;box-shadow:0 2px 8px rgba(0,0,0,0.06)}
    .audio-item:hover{border-left-color:var(--secondary-color);box-shadow:0 5px 15px rgba(0,0,0,0.12);transform:translateX(4px)}
    .audio-item:last-child{margin-bottom:0}
    .audio-item h4{color:var(--primary-color);font-size:15px;font-weight:600;margin-bottom:10px;display:flex;align-items:center;gap:8px}
    .audio-item h4 i{color:var(--secondary-color);font-size:16px}
    .audio-item audio{width:100%;outline:none;border-radius:25px}
    .no-audio{text-align:center;padding:30px 20px;color:#888;font-style:italic;font-size:15px}
    .no-audio i{font-size:2rem;color:#ccc;display:block;margin-bottom:10px}

    /* ===== AUDIO COUNT BADGE ===== */
    .audio-count{background:rgba(255,255,255,0.2);padding:3px 12px;border-radius:20px;font-size:13px;font-weight:600;margin-left:10px}

    /* ===== EMPTY STATE ===== */
    .empty-state{text-align:center;padding:80px 20px;color:#999}
    .empty-state i{font-size:4rem;color:#ddd;margin-bottom:20px;display:block}
    .empty-state h3{font-size:1.4rem;color:#bbb;margin-bottom:10px}
    .empty-state p{font-size:14px}

    /* ===== FOOTER ===== */
    .footer-main{background:linear-gradient(135deg,#0d1b2a 0%,#1a237e 50%,#0d1b2a 100%);color:#fff;padding:60px 0 0}
    .footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1.5fr;gap:40px;margin-bottom:40px}
    .footer-about h3{color:var(--accent-color);margin-bottom:20px;font-size:22px;font-weight:700}
    .footer-about p{line-height:1.8;opacity:0.9;font-size:14px;color:#ccc}
    .footer-social{margin-top:20px;display:flex;gap:10px}
    .footer-social a{display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.1);color:#fff;font-size:18px;text-decoration:none;transition:all 0.3s ease}
    .footer-social a.facebook:hover{background:#1877f2;transform:translateY(-3px)}
    .footer-social a.instagram:hover{background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);transform:translateY(-3px)}
    .footer-social a.twitter:hover{background:#1da1f2;transform:translateY(-3px)}
    .footer-social a.youtube:hover{background:#ff0000;transform:translateY(-3px)}
    .footer-links h4{color:var(--accent-color);margin-bottom:20px;font-size:18px;font-weight:700}
    .footer-links ul{list-style:none;padding:0;margin:0}
    .footer-links ul li{margin-bottom:12px}
    .footer-links ul li a{color:#ccc;text-decoration:none;font-size:14px;transition:all 0.3s ease;display:flex;align-items:center;gap:8px}
    .footer-links ul li a:hover{color:var(--accent-color);padding-left:5px}
    .contact-info{list-style:none;padding:0;margin:0}
    .contact-info li{margin-bottom:15px}
    .contact-info li a{color:#ccc;text-decoration:none;font-size:14px;transition:all 0.3s ease;display:flex;align-items:center;gap:12px;padding:8px 12px;border-radius:8px;background:rgba(255,255,255,0.05)}
    .contact-info li a:hover{color:#fff;background:rgba(255,255,255,0.1);transform:translateX(5px)}
    .contact-info li a i{width:20px;text-align:center;font-size:16px}
    .contact-info li a.phone:hover{color:#25D366}
    .contact-info li a.email:hover{color:#EA4335}
    .contact-info li a.location:hover{color:#4285F4}
    .footer-gallery h4{color:var(--accent-color);margin-bottom:20px;font-size:18px;font-weight:700}
    .gallery-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
    .gallery-grid a{display:block;overflow:hidden;border-radius:8px;position:relative}
    .gallery-grid a img{width:100%;height:70px;object-fit:cover;transition:all 0.3s ease}
    .gallery-grid a:hover img{transform:scale(1.1);filter:brightness(1.1)}
    .gallery-grid a::after{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(26,35,126,0.3);opacity:0;transition:all 0.3s ease}
    .gallery-grid a:hover::after{opacity:1}
    .footer-bottom{background:rgba(0,0,0,0.3);border-top:2px solid #ffd700;padding:20px 50px;text-align:center}
    .footer-bottom p{margin:0;font-size:14px;color:#aaa}
    .footer-bottom p i{color:#ebe4e4;margin:0 5px}

    /* ===== REVEAL ===== */
    .reveal{opacity:0;transform:translateY(50px);transition:all 0.8s ease-out}
    .reveal.active{opacity:1;transform:translateY(0)}

    /* ===== RESPONSIVE ===== */
    @media(max-width:1200px){.main-nav a{padding:7px 10px;font-size:12px}.logo-text h4{font-size:14px}}
    @media(max-width:992px){
        .footer-grid{grid-template-columns:1fr 1fr;gap:30px}
        .footer-gallery{grid-column:1/-1}
        .footer-about{grid-column:1/-1;text-align:center}
        .footer-social{justify-content:center}
        .footer-links{text-align:center}
        .gallery-grid{grid-template-columns:repeat(6,1fr);max-width:400px;margin:0 auto}
        .header-area .container .d-flex{flex-direction:column;gap:15px}
        .logo-section{justify-content:center}
        .main-nav{justify-content:center;flex-wrap:wrap}
    }
    @media(max-width:768px){
        .topbar .container{flex-direction:column;gap:8px;text-align:center}
        .logo-section{justify-content:center;flex-direction:column;gap:8px}
        .main-nav{justify-content:center;gap:2px}
        .main-nav a{padding:6px 8px;font-size:11px}
        .logo-box img{width:60px}
        .logo-text h4{font-size:13px}
        .logo-text span{font-size:11px}
        .footer-grid{grid-template-columns:1fr;gap:25px}
        .footer-main{padding:40px 0 0}
        .gallery-grid{grid-template-columns:repeat(3,1fr)}
        .accordion-header{font-size:16px;padding:12px 15px}
        .audio-item{padding:12px}
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
<a href="audios.php" class="active"><i class="fas fa-headphones"></i> Audios</a>
<a href="brochure.php"><i class="fas fa-users"></i> Brochure</a>
<a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
<a href="announcement.php" class="new-btn"><i class="fas fa-bullhorn"></i> NEW</a>
</nav>
</div>
</div>
</header>

<!-- SEARCH BAR -->
<div class="search-section">
<div class="search-container">
<i class="fas fa-search search-icon"></i>
<input type="text" id="audioSearch" class="search-input"
       placeholder="🔍 Search audio lectures by title or category...">
</div>
</div>

<!-- CONTENT SECTION -->
<section class="content-section">
<div class="content-container">

<?php if (empty($categories)): ?>
<div class="empty-state reveal">
    <i class="fas fa-headphones-alt"></i>
    <h3>No Audio Lectures Yet</h3>
    <p>Admin can upload audio lectures from the Admin Panel → Upload Audio.</p>
</div>

<?php else: ?>

<?php foreach($categories as $category):
    $audios = getAudios($conn, $category);
    $count  = mysqli_num_rows($audios);
?>

<div class="accordion" data-category="<?php echo htmlspecialchars(strtolower($category)); ?>">
    <div class="accordion-header" onclick="toggleAcc(this)">
        <span>
            <i class="fas fa-headphones"></i>&nbsp;
            <?php echo htmlspecialchars($category); ?>
            <span class="audio-count"><?php echo $count; ?> Audio<?php echo $count != 1 ? 's' : ''; ?></span>
        </span>
        <span class="toggle-icon">+</span>
    </div>
    <div class="accordion-content">

        <?php if ($count > 0): ?>
            <?php while ($audio = mysqli_fetch_assoc($audios)): ?>
            <div class="audio-item" data-title="<?php echo htmlspecialchars(strtolower($audio['title'])); ?>">
                <h4>
                    <i class="fas fa-volume-up"></i>
                    <?php echo htmlspecialchars($audio['title']); ?>
                </h4>
                <audio controls>
                    <source src="<?php echo htmlspecialchars($audio['file_path']); ?>" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-audio">
                <i class="fas fa-microphone-slash"></i>
                No audio uploaded yet in this category.
            </p>
        <?php endif; ?>

    </div>
</div>

<?php endforeach; ?>

<?php endif; ?>

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
<li><a href="feedback.php">Feedback</a></li>
<li><a href="announcement.php">Announcements</a></li>
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
// ===== ACCORDION TOGGLE =====
function toggleAcc(header) {
    const content = header.nextElementSibling;
    const icon    = header.querySelector('.toggle-icon');
    const isOpen  = content.style.display === 'block';
    // Close all first
    document.querySelectorAll('.accordion-content').forEach(c => c.style.display = 'none');
    document.querySelectorAll('.toggle-icon').forEach(i => i.textContent = '+');
    // Open clicked (if it was closed)
    if (!isOpen) {
        content.style.display = 'block';
        icon.textContent = '−';
    }
}

// ===== SEARCH =====
document.getElementById('audioSearch').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();

    document.querySelectorAll('.accordion').forEach(function (acc) {
        const catName  = acc.getAttribute('data-category') || '';
        const items    = acc.querySelectorAll('.audio-item');
        let   hasMatch = false;

        items.forEach(function (item) {
            const title = item.getAttribute('data-title') || '';
            const match = title.includes(q) || catName.includes(q);
            item.style.display = (q === '' || match) ? 'block' : 'none';
            if (match) hasMatch = true;
        });

        // Show/hide entire accordion
        if (q === '') {
            acc.style.display = 'block';
            acc.querySelector('.accordion-content').style.display = 'none';
            acc.querySelector('.toggle-icon').textContent = '+';
        } else {
            acc.style.display = hasMatch ? 'block' : 'none';
            if (hasMatch) {
                acc.querySelector('.accordion-content').style.display = 'block';
                acc.querySelector('.toggle-icon').textContent = '−';
            }
        }
    });
});

// ===== REVEAL ON SCROLL =====
function revealOnScroll() {
    document.querySelectorAll('.reveal').forEach(el => {
        if (el.getBoundingClientRect().top < window.innerHeight - 100) {
            el.classList.add('active');
        }
    });
}
window.addEventListener('scroll', revealOnScroll);
window.addEventListener('load', revealOnScroll);
</script>
</body>
</html>