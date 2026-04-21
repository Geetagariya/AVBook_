<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
$res = mysqli_query($conn, "SELECT * FROM announcements ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding: 2rem 0;
        }
        .container { max-width: 1100px; margin: 0 auto; padding: 0 15px; }
        
        .page-header {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 2.5rem;
        }
        .announcement-card {
            background: white;
            border-radius: 20px;
            padding: 1.8rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }
        .announcement-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }
        .card-title { 
            font-size: 1.35rem; 
            font-weight: 600; 
            color: #1e293b; 
            margin-bottom: 0.8rem; 
        }
        .card-desc { 
            color: #475569; 
            line-height: 1.6; 
            margin-bottom: 1.2rem; 
        }
        .card-date { 
            color: #64748b; 
            font-size: 0.9rem; 
        }
        .btn { 
            border-radius: 12px; 
            padding: 10px 18px; 
            font-weight: 500; 
        }
    </style>
</head>
<body>
<?php if(isset($_GET['deleted'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Deleted Successfully!',
    text: 'Announcement has been deleted.'
});
</script>
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Delete Failed',
    text: 'Something went wrong!'
});
</script>
<?php endif; ?>
    <div class="container">
        
        <!-- Page Header (Add button removed) -->
        <div class="page-header">
            <div>
                <h2><i class="fas fa-bullhorn text-primary"></i> All Announcements</h2>
                <p class="text-muted mb-0">Manage your latest announcements</p>
            </div>
        </div>

        <?php if(mysqli_num_rows($res) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($res)): ?>
                <div class="announcement-card">
                    <div class="card-title"><?= htmlspecialchars($row['title']) ?></div>
                    <div class="card-desc"><?= nl2br(htmlspecialchars($row['description'])) ?></div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-date">
                            <i class="fas fa-clock"></i> 
                            <?= date('d M, Y â€¢ h:i A', strtotime($row['created_at'])) ?>
                        </div>
                        <div>
                            <a href="edit_announcement.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button onclick="deleteAnn(<?= $row['id'] ?>)" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                <h4>No Announcements Found</h4>
                <p class="text-muted">No announcements have been added yet.</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function deleteAnn(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This announcement will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete_announcement.php?id=" + id;
            }
        });
    }
    </script>
</body>
</html>