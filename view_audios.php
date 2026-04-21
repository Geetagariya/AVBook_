<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
// DELETE
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $res = mysqli_query($conn,"SELECT * FROM audios WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    unlink($row['file_path']);
    mysqli_query($conn,"DELETE FROM audios WHERE id=$id");
    header("Location: view_audios.php?deleted=1");
}
// FETCH
$query = "SELECT * FROM audios ORDER BY category ASC";
$result = mysqli_query($conn,$query);
$data = [];
while($row = mysqli_fetch_assoc($result)){
    $data[$row['category']][] = $row;
}
$totalAudios = array_sum(array_map('count', $data));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Library - Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
            min-height: 100vh;
        }
        .app-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        /* Top Section - Exactly like your reference screenshot */
        .top-section {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            margin-bottom: 2rem;
        }
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }
        .title-area {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .title-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }
        .title-text {
            font-size: 2.4rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0;
        }
        .subtitle-text {
            color: #64748b;
            font-size: 1.1rem;
            font-weight: 400;
        }
        .stats-area {
            display: flex;
            gap: 1.5rem;
        }
        .stat-card {
            background: #f8fafc;
            border-radius: 16px;
            padding: 1.5rem 2rem;
            min-width: 180px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 2.8rem;
            font-weight: 700;
            color: #3b82f6;
            line-height: 1;
        }
        .stat-label {
            color: #64748b;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        /* Search Bar - Same style as your reference */
        .search-bar {
            background: #f8fafc;
            border-radius: 50px;
            padding: 0.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }
        .search-bar input {
            border: none;
            background: transparent;
            font-size: 1.1rem;
            padding: 0.75rem 1rem;
            width: 100%;
            outline: none;
        }
        .search-bar input::placeholder {
            color: #64748b;
        }

        /* Accordion (Dropdown) - So page stays short */
        .accordion-item {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        .accordion-button {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
            color: white !important;
            font-size: 1.3rem;
            font-weight: 600;
            padding: 1.75rem 2rem;
            border-radius: 20px !important;
        }
        .accordion-button:not(.collapsed) {
            box-shadow: none !important;
        }
        .accordion-button::after {
            color: white;
        }
        .category-badge {
            background: rgba(255,255,255,0.25);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        /* Audio Items - Clean & modern */
        .audio-list {
            padding: 0;
        }
        .audio-item {
            padding: 2rem;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }
        .audio-item:hover {
            background: #f8fafc;
            border-left: 5px solid #3b82f6;
        }
        .audio-item:last-child {
            border-bottom: none;
        }
        .audio-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1.25rem;
        }
        .audio-player-container {
            background: #f8fafc;
            border-radius: 16px;
            padding: 1.25rem;
            border: 1px solid #e2e8f0;
        }
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .btn {
            padding: 0.85rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }
        .btn-edit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(245, 158, 11, 0.35);
        }
        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .btn-delete:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(239, 68, 68, 0.35);
        }

        .empty-state {
            text-align: center;
            padding: 6rem 2rem;
            color: #64748b;
        }
        .empty-state i {
            font-size: 4.5rem;
            margin-bottom: 2rem;
            color: #cbd5e1;
        }

        @media (max-width: 768px) {
            .app-container { padding: 1rem; }
            .title-text { font-size: 2rem; }
            .stats-area { flex-direction: column; gap: 1rem; }
            .action-buttons { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="app-container">

        <!-- Top Section - Exactly like your reference photo (All Notes style) -->
        <div class="top-section">
            <div class="top-header">
                <!-- Title (left side) -->
                <div class="title-area">
                    <div class="title-icon">
                        <i class="fas fa-headphones"></i>
                    </div>
                    <div>
                        <h1 class="title-text">All Audios</h1>
                        <p class="subtitle-text">Professional audio management dashboard</p>
                    </div>
                </div>

                <!-- Stats (right side) - Total Audios & Categories -->
                <div class="stats-area">
                    <div class="stat-card">
                        <div class="stat-number"><?= $totalAudios ?></div>
                        <div class="stat-label">Total Audios</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= count($data) ?></div>
                        <div class="stat-label">Categories</div>
                    </div>
                </div>
            </div>

            <!-- Search Bar - Same look & feel as reference -->
            <div class="search-bar">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-0 ps-4">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control form-control-lg shadow-none" 
                           placeholder="Search by title, category..." 
                           style="border-radius: 50px; background: transparent;">
                </div>
            </div>
        </div>

        <?php if(empty($data)): ?>
            <div class="empty-state">
                <i class="fas fa-music"></i>
                <h2>No Audios Available</h2>
                <p>Your audio library is empty. Add some tracks to get started.</p>
            </div>
        <?php else: ?>

            <!-- Dropdown / Accordion Feature (so page never becomes too long) -->
            <div class="accordion" id="audioAccordion">
                <?php 
                $counter = 0;
                foreach($data as $category => $audios): 
                    $counter++;
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse<?= $counter ?>" 
                                aria-expanded="false" 
                                aria-controls="collapse<?= $counter ?>">
                            <div style="width: 100%; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <i class="fas fa-headphones me-3"></i>
                                    <?= htmlspecialchars($category) ?>
                                </div>
                                <span class="category-badge"><?= count($audios) ?> tracks</span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse<?= $counter ?>" class="accordion-collapse collapse" 
                         data-bs-parent="#audioAccordion">
                        <div class="accordion-body p-0">
                            <div class="audio-list">
                                <?php foreach($audios as $audio): ?>
                                <div class="audio-item">
                                    <div class="audio-title">
                                        <i class="fas fa-music me-2"></i>
                                        <?= htmlspecialchars($audio['title']) ?>
                                    </div>
                                   
                                    <div class="audio-player-container">
                                        <audio controls style="width: 100%;">
                                            <source src="<?= htmlspecialchars($audio['file_path']) ?>" type="audio/mpeg">
                                            Audio playback not supported.
                                        </audio>
                                    </div>
                                   
                                    <div class="action-buttons">
                                        <a href="edit_audio.php?id=<?= $audio['id'] ?>" class="btn btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button onclick="deleteAudio(<?= $audio['id'] ?>)" class="btn btn-delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteAudio(id) {
            Swal.fire({
                title: 'Delete Audio?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `view_audios.php?delete=${id}`;
                }
            });
        }

        <?php if(isset($_GET['deleted'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Audio deleted successfully',
            timer: 2500,
            showConfirmButton: false
        });
        <?php endif; ?>

        // Optional: Simple live search (filters titles & categories instantly)
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const items = document.querySelectorAll('.audio-item');
            
            items.forEach(item => {
                const title = item.querySelector('.audio-title').textContent.toLowerCase();
                const categoryHeader = item.closest('.accordion-item').querySelector('.accordion-button').textContent.toLowerCase();
                
                if (title.includes(filter) || categoryHeader.includes(filter)) {
                    item.style.display = '';
                    // Auto-expand the category if it contains matching item
                    const accordionCollapse = item.closest('.accordion-collapse');
                    if (accordionCollapse && !accordionCollapse.classList.contains('show')) {
                        new bootstrap.Collapse(accordionCollapse, { toggle: true });
                    }
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>