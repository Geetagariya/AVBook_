<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch Current Note
$result = mysqli_query($conn, "SELECT * FROM notes WHERE id = $id");
$row = mysqli_fetch_assoc($result);

$update_status = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title     = trim($_POST['title']);
    $branch    = trim($_POST['branch']);
    $semester  = trim($_POST['semester']);
    $type      = trim($_POST['type']);

    if(!empty($_FILES['file']['name'])){
        $file = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $folder = "notes_uploads/";
        
        if(!file_exists($folder)){
            mkdir($folder, 0777, true);
        }

        if(!empty($row['file_path']) && file_exists($row['file_path'])){
            unlink($row['file_path']);
        }

        move_uploaded_file($temp, $folder.$file);
        $file_path = $folder . $file;

    } else {
        $file_path = $row['file_path'];
    }

    $query = "UPDATE notes SET
        title = '$title',
        branch = '$branch',
        semester = '$semester',
        type = '$type',
        file_path = '$file_path'
        WHERE id = $id";

    if(mysqli_query($conn, $query)){
        $update_status = 'success';
    } else {
        $update_status = 'error';
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note</title>
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
            max-width: 800px;
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
            box-shadow: 0 0 0 0.2rem rgba(59,130,246,0.1);
        }
        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 3rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .file-upload-area:hover {
            border-color: #3b82f6;
            background: #f0f9ff;
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            padding: 1.25rem;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            margin-top: 2rem;
        }
        .preview-box {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            text-align: center;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h2 class="text-center mb-5"><i class="fas fa-edit"></i> Edit Note</h2>

            <form method="POST" enctype="multipart/form-data" id="editForm">

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="form-label">Note Title *</label>
                        <input type="text" name="title" class="form-control" 
                               value="<?= htmlspecialchars($row['title']) ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Branch *</label>
                        <input type="text" name="branch" class="form-control" 
                               value="<?= htmlspecialchars($row['branch']) ?>" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Semester *</label>
                        <input type="text" name="semester" class="form-control" 
                               value="<?= htmlspecialchars($row['semester']) ?>" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Type *</label>
                        <input type="text" name="type" class="form-control" 
                               value="<?= htmlspecialchars($row['type']) ?>" required>
                    </div>
                </div>

                <!-- Current File Preview -->
                <div class="preview-box">
                    <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                    <strong>Current File:</strong><br>
                    <small><?= htmlspecialchars(basename($row['file_path'])) ?></small>
                </div>

                <!-- New File Upload -->
                <div class="mb-4">
                    <label class="form-label">Replace File (Optional)</label>
                    <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                        <p><strong>Click to upload new PDF</strong></p>
                        <small class="text-muted">Only PDF files supported</small>
                        <input type="file" name="file" id="fileInput" accept=".pdf" style="display:none;">
                    </div>
                </div>
<button type="button" onclick="confirmUpdate()" name="update" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Note
                </button>
            </form>
        </div>
    </div>

    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'Confirm Update?',
                html: `
                    <b>Title:</b> ${document.querySelector('input[name="title"]').value}<br>
                    <b>Branch:</b> ${document.querySelector('input[name="branch"]').value}
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
        <?php if($update_status == 'success'): ?>
        Swal.fire({
            icon: 'success',
            title: 'ðŸŽ‰ Updated Successfully!',
            text: 'Note has been updated successfully.',
            timer: 4000,
            timerProgressBar: true,
            confirmButtonText: 'Go to Notes List'
        }).then(() => {
            window.location.href = 'view_notes.php';
        });
        <?php elseif($update_status == 'error'): ?>
        Swal.fire({
            icon: 'error',
            title: 'Update Failed',
            text: 'Something went wrong. Please try again.'
        });
        <?php endif; ?>
    </script>
</body>
</html>