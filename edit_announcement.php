<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch Data
$res = mysqli_query($conn, "SELECT * FROM announcements WHERE id = $id");
$row = mysqli_fetch_assoc($res);

$updated = false;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = mysqli_real_escape_string($conn, trim($_POST['title']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));

    $query = "UPDATE announcements SET 
              title = '$title', 
              description = '$description' 
              WHERE id = $id";

    if(mysqli_query($conn, $query)){
        $updated = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Announcement</title>
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
        .form-card {
            max-width: 750px;
            margin: 0 auto;
            background: white;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.75rem;
        }
        .form-control {
            padding: 1rem 1.25rem;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            background: #f8fafc;
            font-size: 1.05rem;
        }
        .form-control:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            padding: 1.25rem;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            margin-top: 1.5rem;
        }
        h2 {
            color: #1e293b;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h2 class="text-center mb-5">
                <i class="fas fa-edit"></i> Edit Announcement
            </h2>

            <form method="POST" id="editForm">
                <div class="mb-4">
                    <label class="form-label">Announcement Title</label>
                    <input type="text" name="title" class="form-control" 
                           value="<?= htmlspecialchars($row['title'] ?? '') ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Description</label>
					<textarea name="description" class="form-control" rows="6" required><?= htmlspecialchars($row['description'] ?? '') ?></textarea>
                     </div>

<input type="hidden" name="update" value="1">
                <button type="button" onclick="confirmUpdate()" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Announcement
                </button>

                <a href="view_announcements.php" class="btn btn-secondary w-100 mt-3">
                    <i class="fas fa-arrow-left"></i> Back to Announcements
                </a>
            </form>
        </div>
    </div>

    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'Confirm Update?',
                html: `
                    <b>Title:</b> ${document.querySelector('input[name="title"]').value}<br><br>
                    <b>Description:</b> ${document.querySelector('textarea[name="description"]').value.substring(0, 100)}...
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Update Now',
                confirmButtonColor: '#3b82f6'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('editForm').submit();
                }
            });
        }
</script>

<?php if($updated): ?>
<script>
document.addEventListener("DOMContentLoaded", function(){
    Swal.fire({
        icon: 'success',
        title: 'ðŸŽ‰ Updated Successfully!',
        text: 'Announcement has been updated successfully.',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: 'Go Back to List'
    }).then(() => {
        window.location.href = "view_announcements.php";
    });
});
</script>
<?php endif; ?>
</body>
</html>