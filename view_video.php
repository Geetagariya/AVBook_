<?php
session_start();
?>
<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Videos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff !important; /* Pure white background */
            min-height: 100vh;
            padding: 40px 20px;
        }
        .admin-container { max-width: 1400px; margin: 0 auto; }
        .admin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
            padding-bottom: 25px;
            border-bottom: 3px solid #f8fafc;
        }
        .admin-title {
            font-size: 36px; font-weight: 700;
            color: #111827; letter-spacing: -0.02em;
            display: flex; align-items: center; gap: 15px;
        }
        .admin-stats {
            display: flex; gap: 20px; align-items: center;
        }
        .video-count {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white; padding: 12px 24px;
            border-radius: 16px; font-weight: 600;
            font-size: 16px; box-shadow: 0 8px 24px rgba(59,130,246,0.3);
        }
        .table-container {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid #f8fafc;
        }
        .table { 
            margin: 0 !important; 
            font-size: 15px;
            border-radius: 24px;
        }
        .table th {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9) !important;
            border: none !important;
            font-weight: 600 !important;
            color: #374151 !important;
            padding: 24px 20px !important;
            font-size: 15px !important;
            position: sticky; top: 0; z-index: 10;
        }
        .table td {
            padding: 20px !important;
            vertical-align: middle;
            border-color: #f8fafc !important;
        }
        .table tr:hover {
            background: #fdfdfd !important;
            transform: scale(1.01);
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        }
        .video-title {
            color: #1e293b !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            max-width: 300px;
            display: block;
            line-height: 1.5;
        }
        .video-title:hover { color: #3b82f6 !important; }
        .category-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: white;
        }
        .category-all { background: #6b7280; }
        .category-engineering { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .category-diploma { background: linear-gradient(135deg, #10b981, #059669); }
        .category-others { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .video-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #3b82f6 !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            padding: 10px 20px;
            border-radius: 12px;
            background: #eff6ff;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .video-link:hover {
            background: #dbeafe;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59,130,246,0.2);
            color: #1d4ed8 !important;
        }
        .btn-action {
            padding: 10px 20px !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            border: none !important;
            transition: all 0.3s ease !important;
            min-width: 90px;
        }
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706) !important;
            color: white !important;
            box-shadow: 0 6px 20px rgba(245,158,11,0.3) !important;
        }
        .btn-warning:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 12px 30px rgba(245,158,11,0.4) !important;
            color: white !important;
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            color: white !important;
            box-shadow: 0 6px 20px rgba(239,68,68,0.3) !important;
        }
        .btn-danger:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 12px 30px rgba(239,68,68,0.4) !important;
            color: white !important;
        }
        .table-responsive { border-radius: 24px; overflow: hidden; }
        .no-videos {
            text-align: center;
            padding: 80px 40px;
            color: #6b7280;
        }
        .no-videos i { font-size: 64px; opacity: 0.3; margin-bottom: 20px; }
        @media (max-width: 768px) {
            body { padding: 30px 15px; }
            .admin-header { flex-direction: column; gap: 20px; text-align: center; }
            .table { font-size: 14px; }
            .table th, .table td { padding: 16px 12px !important; }
        }
    </style>
</head>

<body>
<?php if(isset($_GET['msg']) && $_GET['msg']=="deleted") { ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Deleted!',
    text: 'Video successfully deleted!',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php } ?>

<div class="admin-container">
    <div class="admin-header">
        <h1 class="admin-title">
            <i class="fas fa-video"></i>
            Manage Videos
        </h1>
        <div class="admin-stats">
            <?php
            $total_videos = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM videos"));
            ?>
            <div class="video-count">
                <i class="fas fa-list me-2"></i>
                <?php echo $total_videos['count']; ?> Videos
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <div class="table-container">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-2"></i>#</th>
                        <th><i class="fas fa-heading me-2"></i>Title</th>
                        <th><i class="fas fa-tags me-2"></i>Category</th>
                        <th><i class="fab fa-youtube me-2"></i>YouTube</th>
                        <th><i class="fas fa-cogs me-2"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC");
                    $count = 1;
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td>
                            <span class="badge bg-light text-dark fs-6"><?php echo $count++; ?></span>
                        </td>
                        <td>
                            <div class="video-title" title="<?php echo htmlspecialchars($row['title']); ?>">
                                <?php echo htmlspecialchars(substr($row['title'], 0, 60)); ?>
                                <?php if(strlen($row['title']) > 60) echo '...'; ?>
                            </div>
                        </td>
                        <td>
                            <span class="category-badge category-<?php echo $row['category']; ?>">
                                <?php 
                                $categories = [
                                    'all' => 'All',
                                    'engineering' => 'Engineering',
                                    'diploma' => 'Diploma',
                                    'others' => 'Others'
                                ];
                                echo $categories[$row['category']] ?? ucfirst($row['category']);
                                ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?php echo htmlspecialchars($row['youtube_link']); ?>" target="_blank" class="video-link">
                                <i class="fab fa-youtube"></i>
                                Watch Video
                            </a>
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="edit_video.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-action">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <button class="btn btn-danger btn-action deleteBtn" data-id="<?php echo $row['id']; ?>">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="5" class="no-videos">
                            <i class="fas fa-video-slash"></i>
                            <h3>No Videos Found</h3>
                            <p class="mb-0">Start by uploading your first video!</p>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.deleteBtn').forEach(button => {
    button.addEventListener('click', function(){
        let id = this.getAttribute('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Yes, delete!',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Cancel',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-danger px-4 py-2 mx-2',
                cancelButton: 'btn btn-secondary px-4 py-2 mx-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete_video.php?id=" + id;
            }
        });
    });
});
</script>

<?php if(isset($_GET['deleted'])){ ?>
<script>
Swal.fire({
    title: 'Deleted!',
    text: 'Video successfully deleted!',
    icon: 'success',
    confirmButtonColor: '#10b981',
    timer: 2500,
    showConfirmButton: false
});
</script>
<?php } ?>
</body>
</html>