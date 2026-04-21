<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$upload_status = '';

if(isset($_POST['submit'])){

    // Secure inputs
    $title  = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);

    // PDF FILE
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    $target_dir = "PDF/book_pdf/".$branch."/";

    if(!file_exists($target_dir)){
        mkdir($target_dir, 0777, true);
    }

    $pdf_path = $target_dir.$file;

    if(move_uploaded_file($temp, $pdf_path)){

        // IMAGE FILE (optional)
        $image = "";
        if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
            $image_name = $_FILES['image']['name'];
            $img_tmp    = $_FILES['image']['tmp_name'];
            $img_folder = "images/books/$branch/";

            if(!file_exists($img_folder)){
                mkdir($img_folder, 0777, true);
            }

            $image_path = $img_folder.$image_name;
            if(move_uploaded_file($img_tmp, $image_path)){
                $image = $img_folder.$image_name;
            }
        }

        // INSERT BOOK
        $query = "INSERT INTO books (title, author, branch, file, image)
                  VALUES ('$title','$author','$branch','$file','$image')";

        if(mysqli_query($conn, $query)){
            $upload_status = 'success';

            // AUTO ANNOUNCEMENT
            $ann_title = mysqli_real_escape_string($conn, "New Book Added");
            $ann_desc  = mysqli_real_escape_string($conn, "A new book titled '$title' has been uploaded for $branch branch.");
            $check = mysqli_query($conn, "SELECT id FROM announcements WHERE title='$ann_title' AND description='$ann_desc'");
            if(mysqli_num_rows($check) == 0){
                mysqli_query($conn, "INSERT INTO announcements (title, description, category, added_by, is_pinned)
                VALUES ('$ann_title', '$ann_desc', 'book', 'Administrator', 0)");
            }
        } else {
            $upload_status = 'error';
        }

    } else {
        $upload_status = 'file_error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ã°Å¸â€œÅ¡ Add New Book</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family:'Poppins',sans-serif;
            /* Ã¢Å“â€¦ WHITE BACKGROUND */
            background: #f8fafc;
            min-height:100vh;
            padding:20px;
        }
        
        .container{max-width:800px;margin:0 auto;}
        .header{text-align:center;margin-bottom:40px;color:#1e293b;}
        .header h1{
            font-size:2.5rem;margin-bottom:10px;
            background:linear-gradient(45deg,#1e3c72,#2a5298);
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;
        }
        .header p{font-size:1.1rem;color:#64748b;}
        
        /* Glassmorphism Form - Light version */
        .form-container{
            background:rgba(255,255,255,0.8);backdrop-filter:blur(20px);border-radius:25px;
            padding:40px;border:1px solid rgba(226,232,240,0.8);
            box-shadow:0 20px 60px rgba(0,0,0,0.1);
        }
        
        .form-group{position:relative;margin-bottom:30px;}
        .form-group label{
            display:block;margin-bottom:8px;color:#1e293b;font-weight:500;font-size:15px;
            display:flex;align-items:center;gap:8px;
        }
        .form-group input,.form-group select{
            width:100%;padding:18px 20px;border:2px solid #e2e8f0;border-radius:20px;
            font-size:16px;background:white;box-shadow:0 4px 15px rgba(0,0,0,0.05);
            transition:all 0.3s;font-family:inherit;color:#1e293b;
        }
        .form-group input:focus,.form-group select:focus{
            outline:none;border-color:#1e3c72;transform:translateY(-2px);
            box-shadow:0 10px 25px rgba(30,60,114,0.15);
        }
        .form-group input::placeholder{color:#94a3b8;}
        
        /* File Upload - Clean white */
        .file-upload{
            position:relative;display:flex;align-items:center;gap:15px;padding:25px;
            background:#f1f5f9;border:2px dashed #cbd5e1;border-radius:20px;
            transition:all 0.3s;cursor:pointer;
        }
        .file-upload:hover{background:#e2e8f0;border-color:#1e3c72;}
        .file-upload input[type="file"]{position:absolute;left:0;top:0;width:100%;height:100%;opacity:0;cursor:pointer;}
        .file-upload i{font-size:2.5rem;color:#1e3c72;}
        .file-info{color:#1e293b;font-weight:500;}
        .file-info small{display:block;color:#64748b;font-size:14px;}
        
        /* Submit Button */
        .submit-btn{
            width:100%;padding:20px;border:none;border-radius:25px;
            background:linear-gradient(135deg,#1e3c72,#2a5298);
            color:white;font-size:18px;font-weight:600;cursor:pointer;transition:all 0.3s;
            box-shadow:0 10px 30px rgba(30,60,114,0.3);
        }
        .submit-btn:hover{transform:translateY(-3px);box-shadow:0 20px 40px rgba(30,60,114,0.4);}
        .submit-btn:active{transform:translateY(-1px);}
        
        /* Loading Spinner */
        .loading{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);z-index:3000;align-items:center;justify-content:center;}
        .spinner{width:60px;height:60px;border:4px solid rgba(255,255,255,0.3);border-top:4px solid #1e3c72;border-radius:50%;animation:spin 1s linear infinite;}
        @keyframes spin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
        
        /* Success/Error Modal */
        .modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);backdrop-filter:blur(10px);z-index:2000;align-items:center;justify-content:center;}
        .modal-content{background:white;padding:40px;border-radius:25px;text-align:center;box-shadow:0 25px 70px rgba(0,0,0,0.3);max-width:450px;width:90%;transform:scale(0.7);animation:modalPop 0.4s ease forwards;}
        @keyframes modalPop{to{transform:scale(1);}}
        .success-icon{font-size:4rem;color:#10b981;margin-bottom:20px;}
        .error-icon{font-size:4rem;color:#ef4444;margin-bottom:20px;}
        .modal h3{color:#1e293b;margin-bottom:15px;font-size:1.5rem;}
        .modal p{color:#64748b;font-size:16px;}
        
        /* Responsive */
        @media(max-width:768px){
            .container{padding:10px;}
            .form-container{padding:30px 20px;}
            .header h1{font-size:2rem;}
            .file-upload{flex-direction:column;text-align:center;}
        }
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-check-circle success-icon"></i>
            <h3>Ã¢Å“â€¦ Book Added Successfully!</h3>
            <p>Your book has been uploaded to library</p>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <h3>Ã¢ÂÅ’ Upload Failed!</h3>
            <p>Please check files and try again</p>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1><i class="fas fa-plus-circle"></i> Add New Book</h1>
            <p>Upload books to your digital library</p>
        </div>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data" id="bookForm">
                <div class="form-group">
                    <label><i class="fas fa-book"></i> Book Title</label>
                    <input type="text" name="title" placeholder="Enter book title" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Author Name</label>
                    <input type="text" name="author" placeholder="Enter author name">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-building"></i> Branch</label>
                    <select name="branch" required>
                        <option value="">Select Branch</option>
                        <option value="Civil">Ã°Å¸Ââ€”Ã¯Â¸Â Civil Engineering</option>
                        <option value="Electrical">Ã¢Å¡Â¡ Electrical Engineering</option>
                        <option value="Electronic">Ã°Å¸â€œÂ¡ Electronics Engineering</option>
                        <option value="IT">Ã°Å¸â€™Â» IT & Computer Science</option>
                        <option value="Mechanical">Ã°Å¸â€Â§ Mechanical Engineering</option>
                        <option value="Pharmacy">Ã°Å¸â€™Å  Pharmacy</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="file-upload" for="pdfFile">
                        <i class="fas fa-file-pdf"></i>
                        <div>
                            <div class="file-info">Ã°Å¸â€œâ€ž PDF File (Required)</div>
                            <small>Click to select PDF file</small>
                        </div>
                        <input type="file" name="file" id="pdfFile" accept=".pdf" required>
                    </label>
                </div>

                <div class="form-group">
                    <label class="file-upload" for="imageFile">
                        <i class="fas fa-image"></i>
                        <div>
                            <div class="file-info">Ã°Å¸â€œÂ¸ Book Cover (Optional)</div>
                            <small>JPG, PNG images</small>
                        </div>
                        <input type="file" name="image" id="imageFile" accept="image/*">
                    </label>
                </div>

                <button type="submit" name="submit" class="submit-btn">
                    <i class="fas fa-upload"></i> Upload Book Now
                </button>
            </form>
        </div>
    </div>

    <script>
        // Show status modal
        <?php if($upload_status=='success'): ?>
            setTimeout(() => document.getElementById('successModal').style.display='flex', 500);
        <?php elseif($upload_status=='error'): ?>
            setTimeout(() => document.getElementById('errorModal').style.display='flex', 500);
        <?php endif; ?>

        // Loading on submit
        document.getElementById('bookForm').onsubmit = () => {
            document.getElementById('loading').style.display = 'flex';
        };

        // Close modals
        document.querySelectorAll('.modal').forEach(modal => {
            modal.onclick = e => { if(e.target.classList.contains('modal')) modal.style.display='none'; }
        });

        // File preview
        ['pdfFile','imageFile'].forEach(id => {
            document.getElementById(id).onchange = e => {
                const fileName = e.target.files[0]?.name || 'No file';
                e.target.parentElement.querySelector('.file-info').textContent = fileName;
            };
        });

        // Form focus effects
        document.querySelectorAll('input,select').forEach(input => {
            input.onfocus = () => input.parentElement.style.transform = 'translateY(-2px)';
            input.onblur = () => input.parentElement.style.transform = 'none';
        });
    </script>
</body>
</html>