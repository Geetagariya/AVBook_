<?php
$conn = mysqli_connect("localhost","root","","avbook_db",3307);

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM books WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

    $title = $_POST['title'];
    $author = $_POST['author'] ?? ''; // Optional field
    $branch = $_POST['branch'];

    // PDF
    if($_FILES['file']['name'] != ""){
        $file = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $target_dir = "PDF/book_pdf/".$branch."/";
        if(!file_exists($target_dir)) mkdir($target_dir,0777,true);
        move_uploaded_file($temp, $target_dir.$file);
    } else {
        $file = $row['file'];
    }

    // IMAGE
    if($_FILES['image']['name'] != ""){
        $image = $_FILES['image']['name'];
        $img_tmp = $_FILES['image']['tmp_name'];
        $img_folder = "images/books/";
        if(!file_exists($img_folder)) mkdir($img_folder,0777,true);
        move_uploaded_file($img_tmp, $img_folder.$image);
    } else {
        $image = $row['image'];
    }

    $query = "UPDATE books SET 
        title='$title',
        author='$author',
        branch='$branch',
        file='$file',
        image='$image'
        WHERE id=$id";

  if(mysqli_query($conn,$query)){
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
    <title>Edit Book - Admin Panel</title>

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

        /* Compact form row - Title & Author side by side */
        .form-row-compact {
            display: grid;
            grid-template-columns: 2fr 1.5fr; /* Title bigger, Author smaller */
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

        .form-label.optional {
            color: #64748b;
            font-weight: 500;
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

        /* File uploads side by side */
        .file-upload-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Side by side */
            gap: 30px;
            margin: 40px 0;
        }

        .file-upload-section {
            background: #f8fafc;
            border: 2px dashed #cbd5e0;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
        }

        .file-upload-section:hover {
            border-color: #1d4ed8;
            background: #f1f5f9;
            box-shadow: 0 10px 30px rgba(29, 78, 216, 0.1);
        }

        .file-upload-section i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            display: block;
        }

        .file-upload-section.pdf i { color: #dc2626; }
        .file-upload-section.image i { color: #dc2626;  }

        .file-current {
            background: #1e293b;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 18px;
            font-weight: 500;
            word-break: break-all;
        }

        .file-upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(29, 78, 216, 0.3);
        }

        .file-upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(29, 78, 216, 0.4);
        }

        /* Preview above files - Compact */
        .preview-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .preview-item {
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            text-align: center;
            transition: all 0.3s ease;
        }

        .preview-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .preview-icon {
            font-size: 2.8rem;
            margin-bottom: 12px;
        }

        .preview-icon.pdf { color: #dc2626; }
        .preview-icon.image { color: #1d4ed8; }

        .preview-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .preview-file {
            color: #64748b;
            font-size: 0.85rem;
            word-break: break-all;
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
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(29, 78, 216, 0.4);
        }

        @media (max-width: 1024px) {
            .file-upload-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .form-row-compact {
                grid-template-columns: 1fr;
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
            <h1><i class="fas fa-edit"></i> Edit Book</h1>
            <p>Update book information professionally</p>
        </div>

        <div class="form-card">
            <form method="POST" enctype="multipart/form-data">
                
                <!-- Compact: Title + Author side by side -->
                <div class="form-row-compact">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-book"></i> Book Title *
                        </label>
                        <input type="text" name="title" value="<?php echo $row['title']; ?>" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label optional">
                            <i class="fas fa-user"></i> Author (Optional)
                        </label>
                        <input type="text" name="author" value="<?php echo $row['author']; ?>" class="form-input" placeholder="Enter author (optional)">
                    </div>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">
                        <i class="fas fa-building"></i> Branch *
                    </label>
                    <input type="text" name="branch" value="<?php echo $row['branch']; ?>" class="form-input" required>
                </div>

                <!-- Previews side by side -->
                <div class="preview-grid">
                    <div class="preview-item">
                        <i class="fas fa-file-pdf preview-icon pdf"></i>
                        <div class="preview-title">Current PDF</div>
                        <div class="preview-file"><?php echo $row['file']; ?></div>
                    </div>
                    
                    <div class="preview-item">
                        <?php if($row['image']): ?>
                            <img src="images/books/<?php echo $row['image']; ?>" alt="Cover" style="width: 70px; height: 90px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;">
                        <?php else: ?>
                            <i class="fas fa-image preview-icon image"></i>
                        <?php endif; ?>
                        <div class="preview-title">Current Image</div>
                        <div class="preview-file"><?php echo $row['image']; ?></div>
                    </div>
                </div>

                <!-- File uploads side by side -->
                <div class="file-upload-grid">
                    <div class="file-upload-section pdf">
                        <i class="fas fa-file-pdf"></i>
                        <div style="font-weight: 600; color: #1e293b; margin-bottom: 12px; font-size: 1rem;">Update PDF</div>
                        <div class="file-current">📄 <?php echo $row['file']; ?></div>
                        <input type="file" name="file" accept=".pdf" style="display: none;" id="pdf-upload">
                        <label for="pdf-upload" class="file-upload-btn">
                            <i class="fas fa-cloud-upload-alt"></i> Choose PDF
                        </label>
                    </div>

                    <div class="file-upload-section image">
                        <i class="fas fa-image"></i>
                        <div style="font-weight: 600; color: #1e293b; margin-bottom: 12px; font-size: 1rem;">Update Image</div>
                        <div class="file-current">📸 <?php echo $row['image']; ?></div>
                        <input type="file" name="image" accept="image/*" style="display: none;" id="image-upload">
                        <label for="image-upload" class="file-upload-btn">
                            <i class="fas fa-cloud-upload-alt"></i> Choose Image
                        </label>
                    </div>
                </div>

                <button type="submit" name="update" class="submit-btn">
                    <i class="fas fa-save"></i> Update Book
                </button>
            </form>
        </div>
    </div>

    <script>
	
<?php if($update_status == 'success'): ?>
Swal.fire({
    title: 'Updated!',
    text: 'Book updated successfully 🎉',
    icon: 'success',
    confirmButtonColor: '#1d4ed8'
}).then(() => {
    window.location.href='view_books.php';
});
<?php elseif($update_status == 'error'): ?>
Swal.fire({
    title: 'Error!',
    text: 'Update failed ❌',
    icon: 'error'
});
<?php endif; ?>

	 // File feedback
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0]?.name || 'No file selected';
                const currentFile = this.parentElement.querySelector('.file-current');
                currentFile.textContent = `📄 ${fileName}`;
                currentFile.style.background = '#059669';
            });
        });
    </script>
</body>
</html>