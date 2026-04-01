<?php
$conn = mysqli_connect("localhost","root","","avbook_db",3307);

if(!$conn){
    die("Connection Failed");
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

        /* Header */
        .header-section {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-bottom: 3rem;
            border: 1px solid #e2e8f0;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            font-weight: 400;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #3b82f6;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #64748b;
            font-weight: 500;
            font-size: 0.95rem;
        }

        /* Category Cards */
        .category-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        }

        .category-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 1.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-title {
            font-size: 1.4rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .category-badge {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

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
            border-left: 4px solid #3b82f6;
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
            border-radius: 12px;
            padding: 1.25rem;
            margin: 1.5rem 0;
            border: 1px solid #e2e8f0;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 500;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 6rem 2rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 2rem;
            color: #cbd5e1;
        }

        @media (max-width: 768px) {
            .app-container {
                padding: 1rem;
            }
            .header-title {
                font-size: 2rem;
            }
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Header -->
        <div class="header-section">
            <h1 class="header-title">
                <i class="fas fa-headphones"></i>
                Audio Library
            </h1>
            <p class="header-subtitle">Professional audio management dashboard</p>
        </div>

        <?php if(empty($data)): ?>
            <div class="empty-state">
                <i class="fas fa-music"></i>
                <h2>No Audios Available</h2>
                <p>Your audio library is empty. Add some tracks to get started.</p>
            </div>
        <?php else: ?>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= $totalAudios ?></div>
                <div class="stat-label">Total Audios</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count($data) ?></div>
                <div class="stat-label">Categories</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= max(array_map('count', $data)) ?></div>
                <div class="stat-label">Max in Category</div>
            </div>
        </div>

        <!-- Categories -->
        <?php foreach($data as $category => $audios): ?>
        <div class="category-card">
            <div class="category-header">
                <div class="category-title">
                    <i class="fas fa-folder-open"></i>
                    <?= htmlspecialchars($category) ?>
                </div>
                <div class="category-badge"><?= count($audios) ?> tracks</div>
            </div>
            
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
        <?php endforeach; ?>

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
    </script>
</body>
</html>