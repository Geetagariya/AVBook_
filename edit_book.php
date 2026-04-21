<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch Current Book Data
$result = mysqli_query($conn, "SELECT * FROM books WHERE id = $id");
$row = mysqli_fetch_assoc($result);

$update_status = '';

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title   = trim($_POST['title']);
    $author  = trim($_POST['author'] ?? '');
    $branch  = trim($_POST['branch']);

    // PDF Upload
    if(!empty($_FILES['file']['name'])){
        $file = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $target_dir = "PDF/book_pdf/".$branch."/";
        
        if(!file_exists($target_dir)){
            mkdir($target_dir, 0777, true);
        }
        
        // Delete old PDF
		if(!empty($row['file']) && file_exists($row['file'])){
    unlink($row['file']);
}
		
        
        
        move_uploaded_file($temp, $target_dir.$file);
        $file_path = $target_dir . $file;
    } else {
        $file_path = $row['file'];
    }

    // Image Upload
  if(!empty($_FILES['file']['name'])){
    $file_name = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];

    $target_dir = "PDF/book_pdf/$branch/";

    if(!file_exists($target_dir)){
        mkdir($target_dir, 0777, true);
    }

    // delete old pdf
    if(!empty($row['file']) && file_exists($row['file'])){
        unlink($row['file']);
    }

    if(move_uploaded_file($temp, $target_dir.$file_name)){
        $file_path = $target_dir . $file_name; // FULL PATH
    } else {
        $file_path = $row['file'];
    }

} else {
    $file_path = $row['file'];
}


    $query = "UPDATE books SET
        title = '$title',
        author = '$author',
        branch = '$branch',
        file = '$file_path',
        image = '$image_path'
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
    <title>Edit Book</title>
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
            max-width: 900px;
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
        .form-control, .form-select {
            padding: 1rem 1.25rem;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            background: #f8fafc;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(59,130,246,0.1);
        }
        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s;
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
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h2 class="text-center mb-5"><i class="fas fa-edit"></i> Edit Book</h2>

            <form method="POST" enctype="multipart/form-data" id="editForm">

                <div class="row">
                    <div class="col-md-8 mb-4">
                        <label class="form-label">Book Title *</label>
                        <input type="text" name="title" class="form-control" 
                               value="<?= htmlspecialchars($row['title']) ?>" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Author (Optional)</label>
                        <input type="text" name="author" class="form-control" 
                               value="<?= htmlspecialchars($row['author'] ?? '') ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Branch *</label>
                    <input type="text" name="branch" class="form-control" 
                           value="<?= htmlspecialchars($row['branch']) ?>" required>
                </div>

                <!-- Current Previews -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="preview-box">
                            <strong>Current PDF:</strong><br>
                            <small><?= htmlspecialchars($row['file']) ?></small>
							
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="preview-box">
                            <strong>Current Image:</strong><br>
                            <?php if($row['image']): ?>
							<img src="<?= htmlspecialchars($row['image']) ?>" 
                                     style="max-height: 120px; border-radius: 8px;" alt="Cover">
                            <?php else: ?>
                                <small>No Image</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- File Uploads -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Replace PDF (Optional)</label>
                        <div class="file-upload-area" onclick="document.getElementById('pdfInput').click()">
                            <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                            <p><strong>Click to upload new PDF</strong></p>
                            <input type="file" name="file" id="pdfInput" accept=".pdf" style="display:none;">
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Replace Cover Image (Optional)</label>
                        <div class="file-upload-area" onclick="document.getElementById('imageInput').click()">
                            <i class="fas fa-image fa-3x text-primary mb-3"></i>
                            <p><strong>Click to upload new Image</strong></p>
                            <input type="file" name="image" id="imageInput" accept="image/*" style="display:none;">
                        </div>
                    </div>
                </div>
<button type="button" onclick="confirmUpdate()" name="update" class="btn btn-primary">
                
                    <i class="fas fa-save"></i> Update Book
                </button>
            </form>
        </div>
    </div>

    <script>
        // Confirm before update
        function confirmUpdate() {
            Swal.fire({
                title: 'Confirm Update?',
                html: `<b>Title:</b> ${document.querySelector('input[name="title"]').value}<br>
                       <b>Branch:</b> ${document.querySelector('input[name="branch"]').value}`,
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

        // Success / Error Message
        <?php if($update_status == 'success'): ?>
        Swal.fire({
            icon: 'success',
            title: 'ðŸŽ‰ Updated Successfully!',
            text: 'Book information has been updated.',
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonText: 'Go to Books List'
        }).then(() => {
            window.location.href = 'view_books.php';
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