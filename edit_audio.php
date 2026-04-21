<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// CHECK ID
if (!isset($_GET['id'])) {
    die("ID missing in URL");
}

$id = (int)$_GET['id'];

// FETCH OLD DATA
$res = mysqli_query($conn, "SELECT * FROM audios WHERE id = $id");

if (!$res) {
    die("Fetch Error: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($res);

if (!$data) {
    die("No data found for this ID");
}

$success = false;


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title = trim($_POST['title']);
    
    
	
	$category = trim($_POST['category']);
$category = ucwords(strtolower($category)); // ðŸ”¥ important

// existing category check
$check = mysqli_query($conn, "SELECT category FROM audios WHERE LOWER(category)=LOWER('$category') LIMIT 1");

if(mysqli_num_rows($check) > 0){
    $row = mysqli_fetch_assoc($check);
    $category = $row['category']; // same existing category use
}

$folder_category = $category;
	
	$file_name = $_FILES['audio']['name'];
    $tmp_name = $_FILES['audio']['tmp_name'];

    if (!empty($file_name)) {

$folder = "audios/" . $folder_category . "/" . $file_name;

if (!is_dir("audios/" . $folder_category)) {
    mkdir("audios/" . $folder_category, 0777, true);
	
}
 // ðŸ”¥ YAHAN ADD KARO (IMPORTANT)
    $old_folder = dirname($data['file_path']);
    $new_folder = "audios/" . $folder_category;

    if ($old_folder != $new_folder) {
        if (is_dir($old_folder)) {
            $files = scandir($old_folder);
            if (count($files) <= 2) {
                rmdir($old_folder);
            }
        }
    }

    // OLD FILE DELETE
    if (!empty($data['file_path']) && file_exists($data['file_path'])) {
        unlink($data['file_path']);
    }

    move_uploaded_file($tmp_name, $folder);
        

   

        $query = "UPDATE audios SET 
                  title='$title', 
                  category='$category', 
                  file_path='$folder' 
                  WHERE id=$id";

    } else {

        $query = "UPDATE audios SET 
                  title='$title', 
                  category='$category' 
                  WHERE id=$id";
    }

    if (mysqli_query($conn, $query)) {
        $success = true;
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
    <title>Edit Audio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .container { max-width: 800px; margin: 0 auto; padding: 0 15px; }

        .form-card {
            background: white;
            border-radius: 24px;
            padding: 3rem;
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

        /* File Upload Area */
        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 20px;
            padding: 3rem 2rem;
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
            top: 0; left: 0;
            width: 100%; height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        .file-name {
            margin-top: 1rem;
            font-size: 0.95rem;
            color: #10b981;
            font-weight: 500;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h1 class="text-center mb-5">
                <i class="fas fa-edit me-2"></i> Edit Audio
            </h1>

            <form method="POST" enctype="multipart/form-data" id="editForm">

                <!-- Title -->
                <div class="mb-4">
                    <label class="form-label">Audio Title</label>
                    <input type="text" name="title" class="form-control" 
                           value="<?= htmlspecialchars($data['title']) ?>" required>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" 
                           value="<?= htmlspecialchars($data['category']) ?>" required>
                    <small class="text-muted">Category will be saved exactly as entered</small>
                </div>

                <!-- Current Audio -->
                <div class="mb-4">
                    <label class="form-label">Current Audio</label>
                    <audio controls class="w-100">
                        <source src="<?= htmlspecialchars($data['file_path']) ?>" type="audio/mpeg">
                    </audio>
                </div>

                <!-- New File Upload -->
                <div class="mb-4">
                    <label class="form-label">Replace Audio File (Optional)</label>
                    <div class="file-upload-area" id="uploadArea">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                        <p class="mb-1 fw-semibold">Click here to upload new audio</p>
                        <small class="text-muted">MP3 or other audio files supported</small>
                        <input type="file" name="audio" accept="audio/*" id="audioInput">
                    </div>
                    <div class="file-name" id="fileName"></div>
                </div>
				<button type="button" onclick="confirmUpdate()" name="update" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Audio
                </button>
            </form>
        </div>
    </div>

    <script>
        // Show selected file name
        document.getElementById('audioInput').addEventListener('change', function() {
            if (this.files.length > 0) {
                document.getElementById('fileName').innerHTML = 
                    `<i class="fas fa-file-audio"></i> ${this.files[0].name}`;
            }
        });

        function confirmUpdate() {
            Swal.fire({
                title: 'Confirm Update?',
                html: `
                    <b>Title:</b> ${document.querySelector('input[name="title"]').value}<br>
                    <b>Category:</b> ${document.querySelector('input[name="category"]').value}
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Update Now'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('editForm').submit();
                }
            });
        }

        // Success Message
        <?php if ($success): ?>
        Swal.fire({
            icon: 'success',
            title: 'ðŸŽ‰ Updated Successfully!',
            text: 'Your audio has been updated successfully.',
            showConfirmButton: true,
            confirmButtonText: 'Go to Audio List',
            timer: 4000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = "view_audios.php";
        });
        <?php endif; ?>
    </script>
</body>
</html>