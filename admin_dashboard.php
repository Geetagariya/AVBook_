<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}


// Count Data
$books         = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM books"))['total'] ?? 0;
$notes         = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM notes"))['total'] ?? 0;
$audios        = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM audios"))['total'] ?? 0;
$videos        = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM videos"))['total'] ?? 0;
$contacts      = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM contact"))['total'] ?? 0;
$feedbacks     = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM feedback"))['total'] ?? 0;
$announcements = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as total FROM announcements"))['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVBook - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --success: #059669;
            --warning: #d97706;
            --danger: #dc2626;
            --secondary: #6b7280;
            --light: #f8fafc;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --border: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--white);
            color: #1e2937;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #1e293b 0%, #111827 100%);
            color: #f9fafb;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            overflow-y: auto;
            border-right: 1px solid #374151;
        }

        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-track { background: #1f2937; }
        .sidebar::-webkit-scrollbar-thumb { background: #4b5563; border-radius: 3px; }

        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid #374151;
        }

        .sidebar-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.25rem;
        }

        .sidebar-header p { font-size: 0.875rem; opacity: 0.8; }

        .sidebar-menu {
            padding: 0.5rem 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #d1d5db;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(59, 130, 246, 0.1);
            color: #ffffff;
            border-left-color: var(--primary);
            padding-left: 1.75rem;
        }

        .sidebar-menu i { width: 20px; margin-right: 0.75rem; font-size: 1.1rem; }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 2rem;
            min-height: 100vh;
            background: var(--white);
        }

        /* Header */
        .page-header {
            background: var(--white);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            border: 1px solid var(--border);
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .page-header p { color: #6b7280; font-size: 1rem; margin: 0; }

        /* Stats Grid - SEPARATE DIVS WITH HOVER BORDER */
        .stats-grid { max-width: 1400px; margin: 0 auto 3rem; }

        .stat-section {
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .stat-card:hover { 
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .stat-icon {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin: 0 auto 1.25rem;
            color: var(--white);
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon { 
            transform: scale(1.1) rotate(5deg);
        }

        .counter {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            line-height: 1;
            color: #111827;
            font-feature-settings: 'tnum';
        }

        .counter.animate { 
            animation: countUp 2.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        @keyframes countUp {
            0% { opacity: 0; transform: scale(0.8) translateY(30px); }
            60% { opacity: 1; transform: scale(1.05); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        .stat-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Quick Actions */
        .actions-section { margin-top: 2rem; }

        .actions-section h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 2rem;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1.25rem;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow);
            border: 2px solid var(--border);
            height: 100%;
            color: inherit;
            position: relative;
            overflow: hidden;
        }

        .action-btn:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .action-btn i {
            font-size: 2rem;
            margin-bottom: 1rem;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            color: var(--white);
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .action-btn:hover i { 
            transform: scale(1.15) rotate(360deg);
        }

        .action-btn span {
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.3;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid .col-xl-4 { flex: 0 0 50%; max-width: 50%; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .main-content { margin-left: 0; }
            .stat-card { padding: 2rem 1.5rem; }
            .counter { font-size: 2.25rem; }
        }

        @media (max-width: 576px) {
            .main-content { padding: 1rem; }
            .stats-grid .col-md-6,
            .actions-section .col-md-6 { flex: 0 0 100%; max-width: 100%; }
        }
    </style>
</head>
<body>

    <!-- Sidebar (same) -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-book-open-reader me-2"></i>AVBook Admin</h3>
            <p class="mb-0">Control Panel</p>
        </div>
        <div class="sidebar-menu">
            <a href="admin_dashboard.php" class="active"><i class="fas fa-gauge-high"></i> Dashboard</a>
            <a href="view_books.php"><i class="fas fa-book-bookmark"></i> Books (<?php echo $books; ?>)</a>
            <a href="view_notes.php"><i class="fas fa-file-lines"></i> Notes (<?php echo $notes; ?>)</a>
            <a href="view_audios.php"><i class="fas fa-headphones-simple"></i> Audios (<?php echo $audios; ?>)</a>
            <a href="view_video.php"><i class="fas fa-video"></i> Videos (<?php echo $videos; ?>)</a>
            <a href="view_announcements.php"><i class="fas fa-bullhorn"></i> Announcements (<?php echo $announcements; ?>)</a>
            <a href="view_contact.php"><i class="fas fa-envelope"></i> Contacts (<?php echo $contacts; ?>)</a>
            <a href="view_feedback.php"><i class="fas fa-message"></i> Feedback (<?php echo $feedbacks; ?>)</a>
			<a href="create_admin.php"><i class="fas fa-user-plus"></i> Create Admin</a>
            <a href="logout.php"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="page-header">
            <h1><i class="fas fa-chart-line me-3 text-primary"></i>Dashboard Overview</h1>
            <p>Welcome back! Here's what's happening with your AVBook platform today.</p>
        </div>

        <!-- Stats Cards - SEPARATE SECTIONS WITH INDIVIDUAL HOVER ✅ -->
        <div class="row g-4 g-md-5 stats-grid">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 stat-section">
                <a href="view_books.php" class="stat-card text-decoration-none d-block">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="counter" data-target="<?php echo $books; ?>">0</div>
                    <div class="stat-label">Total Books</div>
                </a>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 stat-section">
                <a href="view_notes.php" class="stat-card text-decoration-none d-block">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-file-lines"></i>
                    </div>
                    <div class="counter" data-target="<?php echo $notes; ?>">0</div>
                    <div class="stat-label">Total Notes</div>
                </a>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 stat-section">
                <a href="view_audios.php" class="stat-card text-decoration-none d-block">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="fas fa-headphones-simple"></i>
                    </div>
                    <div class="counter" data-target="<?php echo $audios; ?>">0</div>
                    <div class="stat-label">Total Audios</div>
                </a>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 stat-section">
                <a href="view_video.php" class="stat-card text-decoration-none d-block">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="counter" data-target="<?php echo $videos; ?>">0</div>
                    <div class="stat-label">Total Videos</div>
                </a>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 stat-section">
                <a href="view_announcements.php" class="stat-card text-decoration-none d-block">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #6b7280, #4b5563);">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="counter" data-target="<?php echo $announcements; ?>">0</div>
                    <div class="stat-label">Announcements</div>
                </a>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 stat-section">
                <a href="view_contact.php" class="stat-card text-decoration-none d-block">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="counter" data-target="<?php echo $contacts; ?>">0</div>
                    <div class="stat-label">Total Contacts</div>
                </a>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 stat-section">
                <a href="view_feedback.php" class="stat-card text-decoration-none d-block">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="counter" data-target="<?php echo $feedbacks; ?>">0</div>
                    <div class="stat-label">Total Feedback</div>
                </a>
            </div>
        </div>

        <!-- Quick Actions - VIDEO ICON PERFECT ✅ -->
        <div class="actions-section">
            <h3><i class="fas fa-bolt me-2 text-primary"></i>Quick Actions</h3>
            <div class="row g-4">
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <a href="add_book.php" class="action-btn" style="background: rgba(37, 99, 235, 0.05); color: var(--primary); border-color: rgba(37, 99, 235, 0.2);">
                        <i class="fas fa-plus-circle" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); font-size: 1.8rem;"></i>
                        <span>Add New Book</span>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <a href="add_notes.php" class="action-btn" style="background: rgba(16, 185, 129, 0.05); color: var(--success); border-color: rgba(16, 185, 129, 0.2);">
                        <i class="fas fa-file-circle-plus" style="background: linear-gradient(135deg, var(--success), #047857); font-size: 1.8rem;"></i>
                        <span>Add New Note</span>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <a href="upload_audio.php" class="action-btn" style="background: rgba(14, 165, 233, 0.05); color: #0ea5e9; border-color: rgba(14, 165, 233, 0.2);">
                        <i class="fas fa-microphone" style="background: linear-gradient(135deg, #0ea5e9, #0284c7); font-size: 1.8rem;"></i>
                        <span>Add New Audio</span>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <a href="upload_video.php" class="action-btn" style="background: rgba(236, 72, 153, 0.05); color: #ec4899; border-color: rgba(236, 72, 153, 0.2);">
                        <i class="fas fa-video" style="background: linear-gradient(135deg, #ec4899, #db2777); font-size: 1.8rem;"></i>  <!-- 🔥 PERFECT VIDEO ICON -->
                        <span>Add New Video</span>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                    <a href="add_announcement.php" class="action-btn" style="background: rgba(107, 114, 128, 0.05); color: var(--secondary); border-color: rgba(107, 114, 128, 0.2);">
                        <i class="fas fa-bullhorn" style="background: linear-gradient(135deg, var(--secondary), #4b5563); font-size: 1.8rem;"></i>
                        <span>Add Announcement</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Counter Animation
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const increment = Math.ceil(target / 120);
                let current = 0;
                
                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.min(Math.ceil(current), target).toLocaleString();
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target.toLocaleString();
                    }
                };
                updateCounter();
            });
        }

        window.addEventListener('load', () => {
            setTimeout(animateCounters, 800);
        });
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>