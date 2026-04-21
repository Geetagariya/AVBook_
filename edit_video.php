<?php
session_start();
?>
<?php
include 'db.php';

$updated = false;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch existing data
if ($id > 0) {
    $result = mysqli_query($conn, "SELECT * FROM videos WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = (int)$_GET['id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $youtube_link = trim($_POST['youtube_link']);
    $thumbnail = trim($_POST['thumbnail']);
    $subscribers = trim($_POST['subscribers']);

    $query = "UPDATE videos SET 
              title = '$title',
              description = '$description',
              youtube_link = '$youtube_link',
              thumbnail = '$thumbnail',
              subscribers = '$subscribers'
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $updated = true;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding: 2rem 0;
        }
        .form-box {
            max-width: 700px;
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
        }
        .form-control:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.1);
        }
        .input-group-text {
            background: white;
            border: 2px solid #e2e8f0;
            border-right: none;
            border-radius: 16px 0 0 16px;
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
            text-align: center;
            margin-bottom: 2rem;
            color: #1e293b;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2><i class="fas fa-edit"></i> Edit Video</h2>

        <form method="POST" id="editForm">

            <div class="mb-4">
                <label class="form-label">Video Title</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                    <input type="text" name="title" class="form-control" 
                           value="<?= htmlspecialchars($row['title'] ?? '') ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Description</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
					<textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($row['description'] ?? '') ?></textarea>
                   
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">YouTube Link</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                    <input type="text" name="youtube_link" class="form-control" 
                           value="<?= htmlspecialchars($row['youtube_link'] ?? '') ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Thumbnail URL</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                    <input type="text" name="thumbnail" class="form-control" 
                           value="<?= htmlspecialchars($row['thumbnail'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Subscribers</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                    <input type="text" name="subscribers" class="form-control" 
                           value="<?= htmlspecialchars($row['subscribers'] ?? '') ?>">
                </div>
            </div>

           
			<button type="button" onclick="confirmUpdate()" name="update" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Video
            </button>

            <a href="view_video.php" class="btn btn-secondary w-100 mt-3">
                <i class="fas fa-arrow-left"></i> Back to Videos
            </a>
        </form>
    </div>

    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'Confirm Update?',
                html: `
                    <b>Title:</b> ${document.querySelector('input[name="title"]').value}<br>
                    <b>Link:</b> ${document.querySelector('input[name="youtube_link"]').value}
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

        // Success Message
        <?php if ($updated): ?>
        Swal.fire({
            icon: 'success',
            title: 'ðŸŽ‰ Updated Successfully!',
            text: 'Video details have been updated successfully.',
            showConfirmButton: true,
            confirmButtonText: 'Go to Video List',
            timer: 4000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = "view_video.php";
        });
        <?php endif; ?>
    </script>
</body>
</html>