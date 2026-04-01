<?php
$conn = mysqli_connect("localhost","root","","avbook_db",3307);

$alert = ""; // ✅ IMPORTANT

// ID check
if(!isset($_GET['id'])){
    echo "Invalid Request";
    exit;
}

$id = $_GET['id'];

// Fetch note
$result = mysqli_query($conn, "SELECT * FROM notes WHERE id=$id");
$row = mysqli_fetch_assoc($result);

// UPDATE
if(isset($_POST['update'])){

    $title = $_POST['title'];
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $type = $_POST['type'];

    // FILE UPDATE
    if($_FILES['file']['name'] != ""){
        $file = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];

        $folder = "notes_uploads/";
        if(!file_exists($folder)) mkdir($folder,0777,true);

        move_uploaded_file($temp, $folder.$file);
        $file_path = $folder.$file;
    } else {
        $file_path = $row['file_path'];
    }

    // UPDATE QUERY
    $query = "UPDATE notes SET 
        title='$title',
        branch='$branch',
        semester='$semester',
        type='$type',
        file_path='$file_path'
        WHERE id=$id";

    if(mysqli_query($conn,$query)){
        $alert = "
        Swal.fire({
            title: 'Updated!',
            text: 'Note updated successfully 🎉',
            icon: 'success',
            confirmButtonColor: '#1d4ed8'
        }).then(() => {
            window.location.href='view_notes.php';
        });
        ";
    } else {
        $alert = "
        Swal.fire({
            title: 'Error!',
            text: 'Update failed ❌',
            icon: 'error',
            confirmButtonColor: '#ef4444'
        });
        ";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note - Admin Panel</title>

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
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            color: #1e293b;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px; /* Width increased */
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 50px;
            padding-bottom: 30px;
            border-bottom: 3px solid #0f172a;
            position: relative;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #1e40af, #1d4ed8, #1e3a8a);
            border-radius: 2px;
        }

        .page-header h1 {
            font-size: 2.8rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .form-card {
            background: #ffffff;
            padding: 60px;
            border-radius: 24px;
            box-shadow: 0 25px 70px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }

        /* Compact 2x2 Grid for Title+Branch & Semester+Type */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1e293b;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            background: #fafbfc;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input:focus, .form-select:focus {
            border-color: #1d4ed8;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.1);
            transform: translateY(-1px);
        }

        /* File upload section */
        .file-upload-section {
            background: #f8fafc;
            border: 2px dashed #cbd5e0;
            border-radius: 16px;
            padding: 35px;
            text-align: center;
            transition: all 0.3s ease;
            margin: 40px 0;
            position: relative;
        }

        .file-upload-section:hover {
            border-color: #1d4ed8;
            background: #f1f5f9;
            box-shadow: 0 10px 30px rgba(29, 78, 216, 0.1);
        }

        .file-upload-section i {
            font-size: 3rem;
            color:  #dc2626;
            margin-bottom: 20px;
            display: block;
        }

        .file-current {
            background: #1e293b;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            font-weight: 500;
            word-break: break-all;
        }

        /* Preview section */
        .preview-section {
            background: #f8fafc;
            padding: 25px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            text-align: center;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .preview-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        }

        .preview-icon {
            font-size: 3.5rem;
            color: #dc2626;
            margin-bottom: 15px;
        }

        .preview-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .preview-file {
            color: #64748b;
            font-size: 0.9rem;
            word-break: break-all;
        }

        .file-upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(29, 78, 216, 0.3);
        }

        .file-upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(29, 78, 216, 0.4);
        }

        .submit-btn {
            width: 100%;
            padding: 20px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: white;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(29, 78, 216, 0.4);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .container {
                padding: 20px 15px;
            }
            
            .form-card {
                padding: 40px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-edit"></i> Edit Note</h1>
            <p>Update note information professionally</p>
        </div>

        <div class="form-card">
            <form method="POST" enctype="multipart/form-data">
                
                <!-- 2x2 Compact Grid -->
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-book"></i> Note Title *
                        </label>
                        <input type="text" name="title" value="<?php echo $row['title']; ?>" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-building"></i> Branch *
                        </label>
                        <input type="text" name="branch" value="<?php echo $row['branch']; ?>" class="form-input" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar"></i> Semester *
                        </label>
                        <input type="text" name="semester" value="<?php echo $row['semester']; ?>" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tag"></i> Type *
                        </label>
                        <input type="text" name="type" value="<?php echo $row['type']; ?>" class="form-input" required>
                    </div>
                </div>

                <!-- Current File Preview -->
                <div class="preview-section">
                    <i class="fas fa-file-pdf preview-icon"></i>
                    <div class="preview-title">Current File</div>
                    <div class="preview-file"><?php echo basename($row['file_path']); ?></div>
                    <div style="color: #94a3b8; font-size: 0.85rem; margin-top: 5px;">
                        <?php echo $row['file_path']; ?>
                    </div>
                </div>

                <!-- File Upload (Optional & Professional) -->
                <div class="file-upload-section">
                    <i class="fas fa-file-pdf"></i>
                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 15px; font-size: 1.1rem;">Update File (Optional)</div>
                    <div class="file-current">📄 <?php echo basename($row['file_path']); ?></div>
                    <input type="file" name="file" accept=".pdf" style="display: none;" id="file-upload">
                    <label for="file-upload" class="file-upload-btn">
                        <i class="fas fa-cloud-upload-alt"></i>
                        Choose New File
                    </label>
                </div>

                <button type="submit" name="update" class="submit-btn">
                    <i class="fas fa-save"></i> Update Note
                </button>
            </form>
        </div>
    </div>
<?php if($alert != ""): ?>
    <script>
        // File upload feedback
        document.getElementById('file-upload').addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'No file selected';
            const currentFile = this.parentElement.querySelector('.file-current');
            currentFile.textContent = `📄 ${fileName}`;
            currentFile.style.background = '#059669';
        });

        // Smooth focus effects
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-2px)';
            });
            input.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
        });
		<?php echo $alert; ?>
    </script>
	<?php endif; ?>
</body>
</html>