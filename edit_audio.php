<?php
$conn = mysqli_connect("localhost","root","","avbook_db",3307);

if(!$conn){
    die("Connection Failed");
}

$id = $_GET['id'];

// FETCH OLD DATA
$res = mysqli_query($conn,"SELECT * FROM audios WHERE id=$id");
$data = mysqli_fetch_assoc($res);

$success = false;

if(isset($_POST['update'])){

    $title = $_POST['title'];
    $category = trim($_POST['category']);
    $category = str_replace(" ", "_", $category);

    $file_name = $_FILES['audio']['name'];
    $tmp_name = $_FILES['audio']['tmp_name'];

    // NEW FILE UPLOAD
    if(!empty($file_name)){

        $folder = "audios/" . $category . "/" . $file_name;

        if(!is_dir("audios/" . $category)){
            mkdir("audios/" . $category, 0777, true);
        }

        // delete old file
        if(file_exists($data['file_path'])){
            unlink($data['file_path']);
        }

        move_uploaded_file($tmp_name, $folder);

        $query = "UPDATE audios SET 
                  title='$title',
                  category='$category',
                  file_path='$folder'
                  WHERE id=$id";

    } else {
        // only update text
        $query = "UPDATE audios SET 
                  title='$title',
                  category='$category'
                  WHERE id=$id";
    }

    mysqli_query($conn,$query);
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Audio - Audio Library</title>
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
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Page Header */
        .page-header {
            background: white;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
            text-align: center;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            font-weight: 400;
        }

        /* Main Form Card */
        .form-card {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            margin-bottom: 2rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.75rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control, .form-select {
            padding: 1rem 1.25rem;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.1);
            background: white;
            transform: translateY(-1px);
        }

        /* Audio Preview */
        .audio-preview {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 20px;
            padding: 2rem;
            border: 2px dashed #cbd5e1;
            text-align: center;
            margin: 2rem 0;
            transition: all 0.3s ease;
        }

        .audio-preview:hover {
            border-color: #3b82f6;
            background: #f0f9ff;
        }

        .current-audio {
            margin-top: 1.5rem;
        }

        .current-audio audio {
            width: 100%;
            margin-top: 1rem;
        }

        /* File Upload */
        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            background: #f8fafc;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .file-upload-area:hover {
            border-color: #3b82f6;
            background: #f0f9ff;
        }

        .file-upload-area input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            padding: 1.25rem 3rem;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            .page-title {
                font-size: 2rem;
            }
            .form-card {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-edit"></i>
                Edit Audio
            </h1>
            <p class="page-subtitle">Update audio details and replace file if needed</p>
        </div>

        <!-- Main Form -->
        <form method="POST" enctype="multipart/form-data" id="editForm">
            <div class="form-card">
                
                <!-- Title -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-heading"></i>
                        Audio Title
                    </label>
                    <input type="text" name="title" class="form-control" 
                           value="<?= htmlspecialchars($data['title']) ?>" required>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-folder"></i>
                        Category
                    </label>
                    <input type="text" name="category" class="form-control" 
                           value="<?= htmlspecialchars($data['category']) ?>" required>
                    <small class="form-text text-muted">Spaces will be replaced with underscores</small>
                </div>

                <!-- Current Audio Preview -->
                <div class="audio-preview">
                    <div style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin-bottom: 1rem;">
                        <i class="fas fa-play-circle me-2"></i>
                        Current Audio
                    </div>
                    <div class="current-audio">
                        <audio controls>
                            <source src="<?= htmlspecialchars($data['file_path']) ?>" type="audio/mpeg">
                            Your browser does not support audio playback.
                        </audio>
                    </div>
                </div>

                <!-- New File Upload -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-upload"></i>
                        Replace Audio File (Optional)
                    </label>
                    <div class="file-upload-area">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 3rem; color: #94a3b8; margin-bottom: 1rem;"></i>
                        <div style="font-weight: 600; color: #475569; margin-bottom: 0.5rem;">
                            Click to replace audio
                        </div>
                        <div style="color: #64748b;">
                            Current file will be replaced (MP3 supported)
                        </div>
                        <input type="file" name="audio" accept="audio/*" class="form-control">
                    </div>
                </div>

                <!-- Update Button -->
                <button type="button" onclick="confirmUpdate()" class="btn-primary">
                    <i class="fas fa-save"></i>
                    Update Audio
                </button>

            </div>
        </form>
    </div>

    <script>
        function confirmUpdate(){
            Swal.fire({
                title: 'Confirm Update',
                html: `
                    <div style="text-align: left;">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3" style="color: #f59e0b;"></i>
                        <p><strong>Review your changes:</strong></p>
                        <ul style="color: #374151;">
                            <li>Title: <strong>${document.querySelector('input[name="title"]').value}</strong></li>
                            <li>Category: <strong>${document.querySelector('input[name="category"]').value}</strong></li>
                        </ul>
                        <p class="mt-3">This will <strong>overwrite</strong> the current audio if a new file is selected.</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-check me-1"></i> Yes, update now!',
                cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel'
            }).then((result) => {
                if(result.isConfirmed){
                    document.getElementById('editForm').submit();
                }
            });
        }

        <?php if($success): ?>
        Swal.fire({
            icon: 'success',
            title: 'Updated Successfully!',
            html: `
                <i class="fas fa-check-circle fa-2x mb-3" style="color: #10b981;"></i>
                <div>Your audio has been updated and is now live!</div>
            `,
            confirmButtonColor: '#3b82f6',
            timer: 3000
        }).then(() => {
            window.location.href = "view_audios.php";
        });
        <?php endif; ?>
    </script>
</body>
</html>