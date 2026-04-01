<?php
$conn = mysqli_connect("localhost","root","","avbook_db",3307);

// Check connection
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

// Count data
$books = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM books"))['total'] ?? 0;
$notes = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM notes"))['total'] ?? 0;
$audios = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM audios"))['total'] ?? 0;
$videos = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM videos"))['total'] ?? 0;
$contacts = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM contact"))['total'] ?? 0;
$feedbacks = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM feedback"))['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVBook - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #1f2937;
            --dark-light: #374151;
            --light: #f8fafc;
            --white: #ffffff;
            --shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            --shadow-lg: 0 25px 50px -12px rgba(0,0,0,0.25);
        }

        [data-theme="dark"] {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --secondary: #34d399;
            --dark: #f1f5f9;
            --dark-light: #e2e8f0;
            --light: #0f172a;
            --white: #1e293b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            color: var(--dark);
            transition: all 0.3s ease;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(145deg, var(--dark), var(--dark-light));
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h3 {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-header p {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 1rem 2rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu i {
            width: 20px;
            margin-right: 1rem;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .theme-toggle {
            background: var(--primary);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .theme-toggle:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        [data-theme="dark"] .stat-card {
            background: rgba(30,41,59,0.9);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 0.95rem;
            color: var(--dark-light);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .action-btn {
            padding: 1.5rem;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .action-btn:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animations */
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

        .stat-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }
        .stat-card:nth-child(5) { animation-delay: 0.5s; }
        .stat-card:nth-child(6) { animation-delay: 0.6s; }

        /* Chart Container */
        .chart-container {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255,255,255,0.2);
        }

        [data-theme="dark"] .chart-container {
            background: rgba(30,41,59,0.9);
            border: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>
<body data-theme="light">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-book-open me-2"></i>AVBook Admin</h3>
            <p>Dashboard Control</p>
        </div>
        <div class="sidebar-menu">
            <a href="dashboard.php" class="active">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="view_books.php">
                <i class="fas fa-book"></i>
                Books (<?php echo $books; ?>)
            </a>
            <a href="view_notes.php">
                <i class="fas fa-file-alt"></i>
                Notes (<?php echo $notes; ?>)
            </a>
            <a href="view_audios.php">
                <i class="fas fa-headphones"></i>
                Audios (<?php echo $audios; ?>)
            </a>
            <a href="view_videos.php">
                <i class="fas fa-video"></i>
                Videos (<?php echo $videos; ?>)
            </a>
            <a href="view_contact.php">
                <i class="fas fa-envelope"></i>
                Contacts (<?php echo $contacts; ?>)
            </a>
            <a href="view_feedback.php">
                <i class="fas fa-star"></i>
                Feedback (<?php echo $feedbacks; ?>)
            </a>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div>
                <h1 class="h2 mb-0 fw-bold">
                    <i class="fas fa-chart-line me-3 text-primary"></i>
                    Dashboard Overview
                </h1>
                <p class="text-muted mb-0">Welcome back! Here's what's happening with your content.</p>
            </div>
            <button class="theme-toggle" id="themeToggle">
                <i class="fas fa-moon"></i>
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark));">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-number"><?php echo $books; ?></div>
                <div class="stat-label">Total Books</div>
                <a href="view_books.php" class="btn btn-sm btn-primary mt-2">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-number"><?php echo $notes; ?></div>
                <div class="stat-label">Total Notes</div>
                <a href="view_notes.php" class="btn btn-sm btn-primary mt-2">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, var(--secondary), #059669);">
                    <i class="fas fa-headphones"></i>
                </div>
                <div class="stat-number"><?php echo $audios; ?></div>
                <div class="stat-label">Total Audios</div>
                <a href="view_audios.php" class="btn btn-sm btn-success mt-2">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="fas fa-video"></i>
                </div>
                <div class="stat-number"><?php echo $videos; ?></div>
                <div class="stat-label">Total Videos</div>
                <a href="view_videos.php" class="btn btn-sm btn-warning mt-2">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ec4899, #be185d);">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-number"><?php echo $contacts; ?></div>
                <div class="stat-label">Total Contacts</div>
                <a href="view_contact.php" class="btn btn-sm btn-danger mt-2">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f3f4f6, #d1d5db); color: var(--dark);">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number"><?php echo $feedbacks; ?></div>
                <div class="stat-label">Total Feedback</div>
                <a href="view_feedback.php" class="btn btn-sm btn-secondary mt-2">
                    <i class="fas fa-eye me-1"></i>View All
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="chart-container">
            <h3 class="mb-3"><i class="fas fa-bolt me-2 text-primary"></i>Quick Actions</h3>
            <div class="quick-actions">
                <a href="add_book.php" class="action-btn bg-primary text-white">
                    <i class="fas fa-plus-circle fa-2x"></i>
                    Add New Book
                </a>
                <a href="add_notes.php" class="action-btn bg-info text-white">
                    <i class="fas fa-file-circle-plus fa-2x"></i>
                    Add New Note
                </a>
                <a href="upload_audio.php" class="action-btn bg-success text-white">
                    <i class="fas fa-microphone fa-2x"></i>
                    Add New Audio
                </a>
                <a href="upload_videos.php" class="action-btn bg-warning text-dark">
                    <i class="fas fa-video-plus fa-2x"></i>
                    Add New Video
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>
    
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        
        themeToggle.addEventListener('click', () => {
            const currentTheme = body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            body.setAttribute('data-theme', newTheme);
            themeToggle.querySelector('i').className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            
            // Save theme preference
            localStorage.setItem('theme', newTheme);
        });

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        body.setAttribute('data-theme', savedTheme);
        themeToggle.querySelector('i').className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

                // Counter Animation
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current).toLocaleString();
            }, 20);
        }

        // Animate counters on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumber = entry.target.querySelector('.stat-number');
                    const target = parseInt(statNumber.textContent.replace(/,/g, ''));
                    animateCounter(statNumber, target);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe stat cards
        document.querySelectorAll('.stat-card').forEach(card => {
            observer.observe(card);
        });

        // Sidebar active state
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', function(e) {
                document.querySelector('.sidebar-menu a.active').classList.remove('active');
                this.classList.add('active');
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add pulse animation to theme toggle
        setInterval(() => {
            const toggle = document.getElementById('themeToggle');
            toggle.style.animation = 'none';
            toggle.offsetHeight; // trigger reflow
            toggle.style.animation = 'pulse 2s infinite';
        }, 100);

        // Custom CSS for pulse animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
        `;
        document.head.appendChild(style);
    </script>

</body>
</html>

<?php mysqli_close($conn); ?>