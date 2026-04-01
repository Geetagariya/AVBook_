<?
$conn = mysqli_connect("localhost","root","","avbook_db",3307);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Digital Audio Video Book - Government Polytechnic Nainital</title>
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
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
            line-height: 1.6;
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
            font-size: 14px;
        }

        .topbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-left i {
            margin-right: 8px;
            color: #ffd700;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar-right a {
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            transition: 0.3s;
        }

        .topbar-right a:hover {
            color: #ffd700;
        }

        /* ===== HEADER ===== */
        .header-area {
            background: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 18px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-box {
            background: transparent;
            padding: 0;
        }

        .logo-box img {
            width: 90px;
            height: auto;
            display: block;
        }

        .logo-text h4 {
            margin: 0;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 15px;
            line-height: 1.2;
            white-space: nowrap;
        }

        .logo-text span {
            color: var(--secondary-color);
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        /* ===== NAVIGATION ===== */
        .main-nav {
            display: flex;
            align-items: center;
            gap: 2px;
            flex-wrap: nowrap;
            justify-content: flex-end;
        }

        .main-nav a {
            color: var(--dark-text);
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .main-nav a:hover {
            background: var(--primary-color);
            color: #fff;
        }

        .main-nav a.active {
            background: var(--primary-color);
            color: #fff;
        }

        .main-nav a.highlight {
            background: var(--secondary-color);
            color: #fff;
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

        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
        }

        .marquee-content {
            display: inline-block;
            animation: marquee 20s linear infinite;
        }

        .marquee-content span {
            margin-right: 60px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .marquee-content span i {
            color: var(--accent-color);
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

        /* ===== ABOUT INTRO SECTION ===== */
        .about-intro {
            padding: 80px 0;
            background: #fff;
        }

        .about-intro-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .about-intro-text h2 {
            color: var(--primary-color);
            font-size: 36px;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            margin-bottom: 20px;
            position: relative;
        }

        .about-intro-text h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--secondary-color);
        }

        .about-intro-text p {
            color: var(--light-text);
            line-height: 1.9;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .about-intro-text .highlight {
            color: var(--primary-color);
            font-weight: 600;
        }

        .about-intro-image {
            position: relative;
        }

        .about-intro-image img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .about-intro-image::before {
            content: '';
            position: absolute;
            top: -15px;
            left: -15px;
            width: 100%;
            height: 100%;
            border: 4px solid var(--secondary-color);
            border-radius: 10px;
            z-index: -1;
        }

        /* ===== OBJECTIVES SECTION ===== */
        .objectives-section {
            padding: 80px 0;
            background: var(--light-bg);
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            color: var(--primary-color);
            font-size: 36px;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--secondary-color);
        }

        .section-title p {
            color: var(--light-text);
            font-size: 16px;
            max-width: 700px;
            margin: 20px auto 0;
        }

        .objectives-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        .objective-card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            text-align: left;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border-left: 5px solid var(--primary-color);
        }

        .objective-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px35px rgba(0, 0, 0, 0.15);
            border-left-color: var(--secondary-color);
        }

        .objective-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s;
        }

        .objective-card:hover::before {
            transform: scaleX(1);
        }

        .objective-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), #283593);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            float: left;
            margin-right: 20px;
        }

        .objective-icon i {
            font-size: 24px;
            color: #fff;
        }

        .objective-card h4 {
            color: var(--primary-color);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.4;
            display: flex;
            align-items: center;
        }

        .objective-card p {
            color: var(--light-text);
            line-height: 1.7;
            font-size: 14px;
            clear: both;
        }

        /* ===== FEATURES SECTION ===== */
        .features-section {
            background: #fff;
            padding: 80px 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .feature-item {
            background: var(--light-bg);
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s;
        }

        .feature-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px35px rgba(0, 0, 0, 0.15);
        }

        .feature-item i {
            font-size: 36px;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }

        .feature-item h5 {
            color: var(--primary-color);
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .feature-item p {
            color: var(--light-text);
            font-size: 13px;
            line-height: 1.6;
        }

        /* ===== WHY CHOOSE SECTION ===== */
        .why-choose {
            background: linear-gradient(135deg, var(--primary-color), #283593);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
            background-attachment: fixed;
        }

        .why-choose::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="white" opacity="0.05"/></svg>');
            background-size: 30px 30px;
        }

        .why-choose-content {
            position: relative;
            z-index: 2;
        }

        .why-choose h2 {
            color: #fff;
            font-size: 36px;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            text-align: center;
            margin-bottom: 40px;
        }

        .why-choose-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        .why-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .why-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }

        .why-card i {
            font-size: 40px;
            color: var(--accent-color);
            margin-bottom: 15px;
        }

        .why-card h4 {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .why-card p {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.7;
            font-size: 14px;
        }

        /* ===== STATS SECTION ===== */
        .stats-section {
            background: var(--primary-color);
            padding: 50px 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            text-align: center;
        }

        .stat-item {
            color: #fff;
        }

        .stat-item i {
            font-size: 36px;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .stat-item h3 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }

        .stat-item p {
            font-size: 14px;
            opacity: 0.9;
            margin: 5px 0 0;
        }

        /* ===== TEAM SECTION ===== */
        .team-section {
            background: var(--light-bg);
            padding: 80px 0;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            text-align: center;
        }

        .team-card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px30px rgba(0, 0, 0, 0.1);
        }

        .team-card i {
            font-size: 48px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .team-card h4 {
            color: var(--primary-color);
            margin: 10px 0 5px;
            font-size: 18px;
        }

        .team-card p {
            color: var(--light-text);
            font-size: 14px;
            margin: 0;
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
                grid-column: 1/-1;
            }

            .footer-about {
                grid-column: 1/-1;
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

            .about-intro-content {
                grid-template-columns: 1fr;
            }

            .objectives-grid {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .why-choose-grid {
                grid-template-columns: 1fr;
            }

            .team-grid {
                grid-template-columns: repeat(2, 1fr);
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

            .features-grid {
                grid-template-columns: 1fr 1fr;
            }

            .team-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .page-header {
                padding: 60px 20px;
            }

            .page-header h1 {
                font-size: 26px;
            }

            .about-intro-text h2 {
                font-size: 28px;
            }

            .objective-card {
                padding: 25px 20px;
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
        }

        @media(max-width:1200px) {
            .main-nav a {
                padding: 7px 10px;
                font-size: 12px;
            }

            .logo-text h4 {
                font-size: 14px;
            }
        }

        @media(max-width:992px) {
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

<body> <!-- TOPBAR -->
    <div class="topbar">
        <div class="container">
            <div class="topbar-left"> <i class="fas fa-graduation-cap"></i> <span>Welcome to Government Polytechnic
                    Nainital</span> </div>
            <div class="topbar-right"> <a href="tel:+919411158375"><i class="fas fa-phone"></i> +91 9411158375</a> <a
                    href="mailto:info@gpnainital.ac.in"><i class="fas fa-envelope"></i> info@gpnainital.ac.in</a> </div>
        </div>
    </div> <!-- HEADER -->
    <header class="header-area">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="logo-section">
                    <div class="logo-box"> <img src="Government_Polytechnic_Nainital_logo.png" alt="College Logo">
                    </div>
                    <div class="logo-text">
                        <h4>Uttarakhand Government Institute Of Polytechnic</h4> <span>Nainital | Established
                            1956</span>
                    </div>
                </div>
                <nav class="main-nav"> <a href="index.php"><i class="fas fa-home"></i> Home</a> <a href="aboutUs.php"
                        class="active"><i class="fas fa-info-circle"></i> About</a> <a href="book.php"><i
                            class="fas fa-book"></i> Books</a> <a href="notes.html"><i class="fas fa-sticky-note"></i>
                        Notes</a> <a href="videos.html"><i class="fas fa-video"></i> Videos</a> <a href="audios.php"><i
                            class="fas fa-headphones"></i> Audios</a> <a href="brochure.html"><i
                            class="fas fa-users"></i> Brochure</a> <a href="contact.php"><i
                            class="fas fa-envelope"></i> Contact</a> <a href="announcement.html" class="new-btn"><i
                            class="fas fa-bullhorn"></i> NEW</a> </nav>
            </div>
        </div>
    </header> <!-- MARQUEE SECTION -->
    <div class="marquee-section">
        <div class="marquee-container">
            <div class="marquee-content"> <span><i class="fas fa-graduation-cap"></i> Welcome to Digital Audio Video
                    Book Platform</span> <span><i class="fas fa-book"></i> Access Books, Notes & Study Materials</span>
                <span><i class="fas fa-video"></i> Watch Video Lectures Anytime</span> <span><i
                        class="fas fa-headphones"></i> Listen to Audio Lectures</span> <span><i
                        class="fas fa-university"></i> Government Polytechnic Nainital</span> <span><i
                        class="fas fa-graduation-cap"></i> Welcome to Digital Audio Video Book Platform</span> <span><i
                        class="fas fa-book"></i> Access Books, Notes & Study Materials</span> <span><i
                        class="fas fa-video"></i> Watch Video Lectures Anytime</span> <span><i
                        class="fas fa-headphones"></i> Listen to Audio Lectures</span> <span><i
                        class="fas fa-university"></i> Government Polytechnic Nainital</span> </div>
        </div>
    </div> <!-- PAGE HEADER -->
    <section class="page-header">
        <div class="page-header-content reveal">
            <h1><i class="fas fa-info-circle"></i> About Our Project</h1>
            <p>Learn about our Digital Audio Video Book platform - A modern learning solution for students of Government
                Polytechnic Nainital</p>
        </div>
    </section> <!-- ABOUT INTRO SECTION -->
    <section class="about-intro">
        <div class="container">
            <div class="about-intro-content">
                <div class="about-intro-text reveal">
                    <h2>Digital Audio Video Book</h2>
                    <p>Welcome to the <span class="highlight">Digital Audio Video Book</span> platform - an innovative
                        initiative by the students of Government Polytechnic Nainital. This project aims to transform
                        traditional learning into a modern, accessible, and interactive digital experience.</p>
                    <p>Our platform combines text, audio, and video resources into a single digital book that supports
                        effective and efficient learning for all students. We believe that education should be
                        accessible to everyone, anywhere and anytime.</p>
                    <p>Through this platform, we strive to bridge the gap between traditional classroom learning and
                        digital education, making quality study materials available to every student at their
                        fingertips.</p>
                </div>
                <div class="about-intro-image reveal"> <img src="images/college/cp1.jpg" alt="Digital Learning"> </div>
            </div>
        </div>
    </section> <!-- OBJECTIVES SECTION -->
    <section class="objectives-section">
        <div class="container">
            <div class="section-title reveal">
                <h2>Our Objectives</h2>
                <p>The main objective of the Audio-Video Digital Book is to create a modern, accessible, and interactive
                    learning platform for students.</p>
            </div>
            <div class="objectives-grid"> <!-- Objective 1 -->
                <div class="objective-card reveal">
                    <div class="objective-icon"> <i class="fas fa-database"></i> </div>
                    <h4>To Provide a Centralized Digital Platform</h4>
                    <p>To bring previous-year papers, notes, faculty details, books list, and study materials together
                        in one easily accessible digital source.</p>
                </div> <!-- Objective 2 -->
                <div class="objective-card reveal">
                    <div class="objective-icon"> <i class="fas fa-headphones-alt"></i> </div>
                    <h4>To Support Audio and Video-Based Learning</h4>
                    <p>To help students understand concepts better through audio explanations, motivational recordings,
                        and video lectures.</p>
                </div> <!-- Objective 3 -->
                <div class="objective-card reveal">
                    <div class="objective-icon"> <i class="fas fa-globe"></i> </div>
                    <h4>To Improve Learning Accessibility</h4>
                    <p>To make study resources available anytime and anywhere, reducing dependency on physical notes and
                        classroom-only learning.</p>
                </div> <!-- Objective 4 -->
                <div class="objective-card reveal">
                    <div class="objective-icon"> <i class="fas fa-clock"></i> </div>
                    <h4>To Save Students' Time & Reduce Study Burden</h4>
                    <p>To allow quick revision, easy access to materials, and faster search for required content.</p>
                </div> <!-- Objective 5 -->
                <div class="objective-card reveal">
                    <div class="objective-icon"> <i class="fas fa-users"></i> </div>
                    <h4>To Enhance Student Engagement</h4>
                    <p>To make learning more interactive through multi-format content—text, audio, and visuals.</p>
                </div> <!-- Objective 6 -->
                <div class="objective-card reveal">
                    <div class="objective-icon"> <i class="fas fa-award"></i> </div>
                    <h4>To Provide Quality Study Material</h4>
                    <p>To ensure students receive well-organized, updated, and authentic academic content for exam
                        preparation.</p>
                </div>
            </div>
        </div>
    </section> <!-- FEATURES SECTION -->
    <section class="features-section">
        <div class="container">
            <div class="section-title reveal">
                <h2>Platform Features</h2>
                <p>Everything you need for your studies in one place</p>
            </div>
            <div class="features-grid">
                <div class="feature-item reveal"> <i class="fas fa-book"></i>
                    <h5>Books & Notes</h5>
                    <p>Access comprehensive study materials</p>
                </div>
                <div class="feature-item reveal"> <i class="fas fa-video"></i>
                    <h5>Video Lectures</h5>
                    <p>Watch recorded classroom sessions</p>
                </div>
                <div class="feature-item reveal"> <i class="fas fa-headphones"></i>
                    <h5>Audio Lectures</h5>
                    <p>Listen to audio explanations</p>
                </div>
                <div class="feature-item reveal"> <i class="fas fa-file-alt"></i>
                    <h5>Previous Papers</h5>
                    <p>Practice with past exam papers</p>
                </div>
                <div class="feature-item reveal"> <i class="fas fa-search"></i>
                    <h5>Quick Search</h5>
                    <p>Find content instantly</p>
                </div>
                <div class="feature-item reveal"> <i class="fas fa-mobile-alt"></i>
                    <h5>Mobile Friendly</h5>
                    <p>Learn on any device</p>
                </div>
                <div class="feature-item reveal"> <i class="fas fa-cloud-download-alt"></i>
                    <h5>Downloadable</h5>
                    <p>Save materials offline</p>
                </div>
                <div class="feature-item reveal"> <i class="fas fa-clock"></i>
                    <h5>24/7 Access</h5>
                    <p>Learn anytime, anywhere</p>
                </div>
            </div>
        </div>
    </section> <!-- WHY CHOOSE SECTION -->
    <section class="why-choose">
        <div class="container">
            <div class="why-choose-content">
                <h2 class="reveal">Why Choose Our Platform?</h2>
                <div class="why-choose-grid">
                    <div class="why-card reveal"> <i class="fas fa-universal-access"></i>
                        <h4>Accessible to All</h4>
                        <p>Our platform is designed to be accessible to every student, regardless of their location or
                            device. All content is freely available.</p>
                    </div>
                    <div class="why-card reveal"> <i class="fas fa-hand-holding-heart"></i>
                        <h4>Student-Centered</h4>
                        <p>We understand student needs and continuously work to improve the platform based on their
                            feedback and requirements.</p>
                    </div>
                    <div class="why-card reveal"> <i class="fas fa-lightbulb"></i>
                        <h4>Innovative Learning</h4>
                        <p>We use modern technology to create engaging learning experiences that make education more
                            effective and enjoyable.</p>
                    </div>
                    <div class="why-card reveal"> <i class="fas fa-seedling"></i>
                        <h4>Continuous Updates</h4>
                        <p>Our content is regularly updated to ensure students have access to the latest study materials
                            and resources.</p>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- STATS SECTION -->
    <section class="stats-section">
        <div class="container reveal">
            <div class="stats-grid">
                <div class="stat-item"> <i class="fas fa-book"></i>
                    <h3>500+</h3>
                    <p>Books & Notes</p>
                </div>
                <div class="stat-item"> <i class="fas fa-video"></i>
                    <h3>200+</h3>
                    <p>Videos</p>
                </div>
                            <div class="stat-item">
                <i class="fas fa-headphones"></i>
                <h3>300+</h3>
                <p>Audio Lectures</p>
            </div>
            <div class="stat-item">
                <i class="fas fa-users"></i>
                <h3>1000+</h3>
                <p>Students</p>
            </div>
        </div>
    </div>
</section>

<!-- TEAM SECTION -->
<section class="team-section">
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
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
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
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="contact.html">Feedback</a></li>
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