<?php
$conn = mysqli_connect("localhost", "root", "", "avbook_db", 3307);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// function to get data
function getData($conn, $branch, $semester, $type){
    $query = "SELECT * FROM notes 
              WHERE branch='$branch' 
              AND semester='$semester' 
              AND type='$type'";
              
    return mysqli_query($conn, $query);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes - Digital Audio Video Book</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">

    <style>
        /* ===== BASE STYLES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
            line-height: 1.6
        }

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
            font-size: 14px
        }

        .topbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px
        }

        .topbar-left i {
            margin-right: 8px;
            color: #ffd700
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px
        }

        .topbar-right a {
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            transition: 0.3s
        }

        .topbar-right a:hover {
            color: #ffd700
        }

        /* ===== HEADER ===== */
        .header-area {
            background: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 18px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: box-shadow 0.3s ease
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .logo-box {
            background: transparent;
            padding: 0
        }

        .logo-box img {
            width: 90px;
            height: auto;
            display: block
        }

        .logo-text h4 {
            margin: 0;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 15px;
            line-height: 1.2;
            white-space: nowrap
        }

        .logo-text span {
            color: var(--secondary-color);
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap
        }

        /* ===== NAVIGATION ===== */
        .main-nav {
            display: flex;
            align-items: center;
            gap: 2px;
            flex-wrap: nowrap;
            justify-content: flex-end
        }

        .main-nav a {
            color: var(--dark-text);
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s;
            white-space: nowrap
        }

        .main-nav a:hover {
            background: var(--primary-color);
            color: #fff
        }

        .main-nav a.active {
            background: var(--primary-color);
            color: #fff
        }

        .main-nav a.highlight {
            background: var(--secondary-color);
            color: #fff
        }



/* NEW BUTTON */
.new-btn{background:#ff0000;color:#ffffff;padding:6px 14px;border-radius:20px;font-weight:700;font-size:12px;display:inline-block;animation:blink 0.3s infinite;text-decoration:none;transition:0.3s;border:none;cursor:pointer}
.new-btn:hover{background:#cc0000;transform:scale(1.1);color:#ffffff}
.new-btn i{margin-right:5px}
@keyframes blink{
0%,100%{opacity:1;transform:scale(1);}
50%{opacity:0.5;transform:scale(0.95);}
}



        /* ===== MARQUEE SECTION ===== */
        .marquee-section {
            background: linear-gradient(90deg, var(--secondary-color), #9c1a1a, var(--secondary-color));
            padding: 12px 0;
            overflow: hidden
        }

        .marquee-container {
            overflow: hidden;
            white-space: nowrap
        }

        .marquee-content {
            display: inline-block;
            animation: marquee 20s linear infinite
        }

        .marquee-content span {
            margin-right: 60px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 10px
        }

        .marquee-content span i {
            color: var(--accent-color)
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
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

        .page-header-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .page-header h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 15px;
            font-family: 'Playfair Display', serif;
        }

        .page-header h1 i {
            margin-right: 15px;
            color: var(--accent-color);
        }

        .page-header p {
            font-size: 18px;
            opacity: 0.95;
            line-height: 1.8;
        }

        /* ===== CONTENT SECTION ===== */
        .content-section {
            padding: 60px 0;
            background: #fff;
        }

        .content-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* ===== ACCORDION STYLES ===== */
        .accordion {
            background: #fff;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .accordion-header {
            padding: 15px 20px;
            cursor: pointer;
            background: var(--primary-color);
            color: #fff;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .accordion-header:hover {
            background: #283593;
        }

        .accordion-header span {
            font-weight: bold;
        }

        .accordion-content {
            display: none;
            background: #f9fcff;
            padding: 20px;
        }

        .accordion-content h1 {
            text-align: center;
            color: var(--primary-color);
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .accordion-content h2 {
            color: var(--secondary-color);
            font-size: 20px;
            margin: 20px 0 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--accent-color);
        }

        .accordion-content h3 {
            margin-top: 15px;
            color: var(--primary-color);
            font-size: 18px;
        }

        .accordion-content ul {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .accordion-content ul li {
            margin: 8px 0;
        }

        .accordion-content ul li a {
            text-decoration: none;
            color: #0077cc;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }

        .accordion-content ul li a:hover {
            color: #ff6600;
            background: rgba(255, 255, 255, 0.8);
            transform: translateX(5px);
        }

        .accordion-content ul li a::before {
            content: '\f1c1';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--secondary-color);
        }

        /* ===== DETAILS/SUMMARY STYLES ===== */
        details {
            margin: 15px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 0;
            background: #f1f1f1;
            overflow: hidden;
        }

        summary {
            list-style: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            color: var(--primary-color);
            position: relative;
            padding: 12px 15px;
            padding-left: 40px;
            background: #fff;
            transition: all 0.3s ease;
        }

        summary:hover {
            background: #f8f9fa;
            color: var(--secondary-color);
        }

        summary::-webkit-details-marker {
            display: none;
        }

        summary::before {
            content: "📂";
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }

        details[open] summary::before {
            content: "📖";
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

        .footer-social a.facebook:hover {
            background: #1877f2;
            transform: translateY(-3px);
        }

        .footer-social a.instagram:hover {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            transform: translateY(-3px);
        }

        .footer-social a.twitter:hover {
            background: #1da1f2;
            transform: translateY(-3px);
        }

        .footer-social a.youtube:hover {
            background: #ff0000;
            transform: translateY(-3px);
        }

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

        .footer-links ul li a i {
            font-size: 12px;
            color: var(--secondary-color);
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

        .contact-info li a i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .contact-info li a.phone:hover {
            color: #25D366;
        }

        .contact-info li a.email:hover {
            color: #EA4335;
        }

        .contact-info li a.location:hover {
            color: #4285F4;
        }

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

        .footer-bottom {
            background: rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 50px;
            text-align: center;
            border-top: 2px solid #ffd700;
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

        /* ===== REVEAL ANIMATION ===== */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
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

            .page-header h1 {
                font-size: 32px;
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

            .page-header {
                padding: 60px 20px;
            }

            .page-header h1 {
                font-size: 26px;
            }

            .accordion-header {
                font-size: 16px;
                padding: 12px 15px;
            }

            .accordion-content h1 {
                font-size: 22px;
            }

            .accordion-content h2 {
                font-size: 18px;
            }

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
                flex-wrap: wrap;
            }

            .main-nav a {
                padding: 6px 8px;
                font-size: 11px;
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

            .content-container {
                padding: 0 10px;
            }
        }

        @media (max-width: 576px) {
            .accordion-content {
                padding: 15px;
            }

            .accordion-content ul li a {
                font-size: 13px;
                padding: 6px 10px;
            }

            summary {
                font-size: 14px;
                padding: 10px 12px;
                padding-left: 35px;
            }

            .footer-bottom {
                padding: 15px 20px;
            }
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
                    <a href="book.html"><i class="fas fa-book"></i> Books</a>
                    <a href="notes.html" class="active"><i class="fas fa-sticky-note"></i> Notes</a>
                    <a href="videos.html"><i class="fas fa-video"></i> Videos</a>
                    <a href="audios.html"><i class="fas fa-headphones"></i> Audios</a>
                    <a href="brochure.html"><i class="fas fa-users"></i> Brochure</a>
                    <a href="contact.html"><i class="fas fa-envelope"></i> Contact</a>
                    <a href="announcement.html" class="new-btn"><i class="fas fa-bullhorn"></i> NEW</a>
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
            <h1><i class="fas fa-sticky-note"></i> Notes & Previous Year Papers</h1>
            <p>Download branch-wise notes and previous year question papers (PDF)</p>
        </div>
    </section>
	
	
	
	
	
	
	
	 <!-- CONTENT SECTION -->
    <section class="content-section">
        <div class="content-container">

            <!-- First Year -->
            <div class="accordion">
                <div class="accordion-header">
                    <span><i class="fas fa-book-reader"></i>  First Year</span>
                    <span>+</span>
                </div>
	<div class="accordion-content">

<h1 style="text-align:center;">1st Year Notes</h1>

<!-- SEM 1 -->
<h2>SEMESTER-I</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'first_year', '1', 'notes');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['title']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'first_year', '1', 'paper');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'first_year', '1', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<!-- SEM 2 -->
<h2>SEMESTER-II</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'first_year', '2', 'notes');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['title']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'first_year', '2', 'paper');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'first_year', '2', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

</div>
</div>



<!-- Information Technology -->
            <div class="accordion">
                <div class="accordion-header">
                    <span><i class="fas fa-laptop-code"></i>  Information Technology</span>
                    <span>+</span>
                </div>


<div class="accordion-content">

<h1 style="text-align:center;">2nd Year Notes</h1>

<!-- SEM 3 -->
<h2>SEMESTER-III</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'IT', '3', 'notes');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'IT', '3', 'paper');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'IT', '3', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<!-- SEM 4 -->
<h2>SEMESTER-IV</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'IT', '4', 'notes');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'IT', '4', 'paper');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'IT', '4', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h1 style="text-align:center;">3rd Year Notes</h1>

<!-- SEM 5 -->
<h2>SEMESTER-V</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'IT', '5', 'notes');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'IT', '5', 'paper');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'IT', '5', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<!-- SEM 6 -->
<h2>SEMESTER-VI</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'IT', '6', 'notes');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'IT', '6', 'paper');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'IT', '6', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

</div>
</div>






<!-- Civil Branch -->
            <div class="accordion">
                <div class="accordion-header">
                    <span><i class="fas fa-hard-hat"></i>  Civil Engineering</span>
                    <span>+</span>
                </div>
				
				
				<div class="accordion-content">

<h1 style="text-align:center;">2nd Year Notes</h1>

<h2>SEMESTER-III</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '3', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '3', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>

<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '3', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h2>SEMESTER-IV</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '4', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '4', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '4', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h1 style="text-align:center;">3rd Year Notes</h1>

<h2>SEMESTER-V</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '5', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '5', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '5', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h2>SEMESTER-VI</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '6', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '6', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Civil', '6', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

</div>
</div>



				

<!-- Electrical Branch -->
            <div class="accordion">
                <div class="accordion-header">
                    <span><i class="fas fa-bolt"></i>  Electrical Engineering</span>
                    <span>+</span>
                </div>
				
				
				<div class="accordion-content">

<h1 style="text-align:center;">2nd Year Notes</h1>

<h2>SEMESTER-III</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '3', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '3', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '3', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h2>SEMESTER-IV</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '4', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '4', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '4', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h1 style="text-align:center;">3rd Year Notes</h1>

<h2>SEMESTER-V</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '5', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '5', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '5', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h2>SEMESTER-VI</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '6', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '6', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Electrical', '6', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

</div>
</div>






<!-- Electronic Branch -->
            <div class="accordion">
                <div class="accordion-header">
                    <span><i class="fas fa-microchip"></i>  Electronic Engineering</span>
                    <span>+</span>
                </div>
				<div class="accordion-content">

<h1 style="text-align:center;">2nd Year Notes</h1>

<h2>SEMESTER-III</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '3', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '3', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '3', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h2>SEMESTER-IV</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '4', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '4', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '4', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h1 style="text-align:center;">3rd Year Notes</h1>

<h2>SEMESTER-V</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '5', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '5', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '5', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h2>SEMESTER-VI</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '6', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '6', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Electronic', '6', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

</div>
</div>



			

<!--  Mechanical Branch -->
            <div class="accordion">
                <div class="accordion-header">
                    <span><i class="fas fa-cogs"></i>  Mechanical Engineering </span>
                    <span>+</span>
                </div>
				
<div class="accordion-content">

<h1 style="text-align:center;">2nd Year Notes</h1>

<h2>SEMESTER-III</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '3', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '3', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '3', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h2>SEMESTER-IV</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '4', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '4', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '4', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h1 style="text-align:center;">3rd Year Notes</h1>

<h2>SEMESTER-V</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '5', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '5', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '5', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h2>SEMESTER-VI</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '6', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '6', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Mechanical', '6', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

</div>
</div>





<!-- Pharmacy Branch -->
            <div class="accordion">
                <div class="accordion-header">
                    <span><i class="fas fa-book-reader"></i>  Pharmacy</span>
                    <span>+</span>
                </div>
				
	<div class="accordion-content">

<h1 style="text-align:center;">2nd Year Notes</h1>

<h2>SEMESTER-III</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '3', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '3', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '3', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h2>SEMESTER-IV</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '4', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '4', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '4', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h1 style="text-align:center;">3rd Year Notes</h1>

<h2>SEMESTER-V</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '5', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '5', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '5', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>


<h2>SEMESTER-VI</h2>

<details>
<summary>Notes</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '6', 'notes');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Previous Year Papers</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '6', 'paper');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

<details>
<summary>Syllabus</summary>
<ul>
<?php
$result = getData($conn, 'Pharmacy', '6', 'syllabus');
while($row = mysqli_fetch_assoc($result)){
echo "<li><a href='{$row['file_path']}' download>{$row['file_name']}</a></li>";
}
?>
</ul>
</details>

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
<li><a href="index.html">Home</a></li>
<li><a href="book.html">Books</a></li>
<li><a href="notes.html">Notes</a></li>
<li><a href="videos.html">Videos</a></li>
</ul>
</div>
<div class="footer-links">
<h4>Resources</h4>
<ul>
<li><a href="audios.html">Audios</a></li>
<li><a href="brochure.html">Brochure</a></li>
<li><a href="contact.php">Contact</a></li>
<li><a href="contact.php">Feedback</a></li>
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
    // Accordion Functionality
    const accordions = document.querySelectorAll(".accordion");

    accordions.forEach(acc => {
        const header = acc.querySelector(".accordion-header");
        header.addEventListener("click", () => {
            const content = acc.querySelector(".accordion-content");
            const symbol = header.querySelector("span:last-child");

            if (content.style.display === "block") {
                content.style.display = "none";
                symbol.textContent = "+";
            } else {
                content.style.display = "block";
                symbol.textContent = "-";
            }
        });
    });

    // REVEAL ANIMATION ON SCROLL
    function reveal() {
        var reveals = document.querySelectorAll('.reveal');
        for(var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            var elementVisible = 100;
            if(elementTop < windowHeight - elementVisible) {
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
</script>

</body>
</html>











