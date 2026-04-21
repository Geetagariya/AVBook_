<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
$upload_status = '';
if(isset($_POST['upload'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
	$semester = isset($_POST['semester']) ? mysqli_real_escape_string($conn, $_POST['semester']) : '';
	$year = mysqli_real_escape_string($conn, $_POST['year']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    // ===== PDF FILE =====
    $file = $_FILES['file']['name'];
    $temp = $_FILES['file']['tmp_name'];
    
    // Folder logic
    if($type == "notes"){
        $target_dir = "pdf/notes_pdf/".$branch."/";
    } else if($type == "paper"){
        $target_dir = "pdf/exam_pdf/".$branch."/";
    } else {
        $target_dir = "pdf/syllabus_pdf/".$branch."/";
    }
    
    if(!file_exists($target_dir)) mkdir($target_dir, 0777, true);
    
    $pdf_path = $target_dir.$file;
    if(move_uploaded_file($temp, $pdf_path)){
        
       // ===== INSERT QUERY =====
$query = "INSERT INTO notes (title, branch, semester, year, type, file_name, file_path)
          VALUES ('$title','$branch','$semester','$year','$type','$file','$pdf_path')";

if(mysqli_query($conn, $query)){
    $upload_status = 'success';

    // ===== ANNOUNCEMENT START =====
    if($type == "notes"){
        $ann_title = "New Notes Added";
        $ann_desc  = "A new notes '$title' has been uploaded for $branch branch.";   
    } 
    elseif($type == "paper"){
        $ann_title = "New Paper Added";
        $ann_desc  = "A Previous Year Paper '$title' has been uploaded for $branch branch.";
    } 
    else{
        $ann_title = "New Syllabus Added";
        $ann_desc  = "A Syllabus '$title' has been uploaded for $branch branch.";
    }

    // ðŸ” Escape (VERY IMPORTANT)
    $ann_title = mysqli_real_escape_string($conn, $ann_title);
    $ann_desc  = mysqli_real_escape_string($conn, $ann_desc);

    // ===== DUPLICATE CHECK =====
    $check = mysqli_query($conn, "SELECT * FROM announcements 
                                  WHERE title='$ann_title' AND description='$ann_desc'");

    if(mysqli_num_rows($check) == 0){
        // ===== ANNOUNCEMENT INSERT =====
        mysqli_query($conn, "INSERT INTO announcements 
            (title, description, category, added_by, is_pinned) 
            VALUES ('$ann_title', '$ann_desc', '$type', 'Administrator', 0)");
			
    }

} else {
    $upload_status = 'error';
}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ðŸ“š Add Notes/Papers</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family:'Poppins',sans-serif;
            /* âœ… SAME WHITE BACKGROUND AS BOOKS PAGE */
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
        
        /* SAME Glassmorphism Form */
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
        
        /* SAME File Upload Style */
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
        
        /* SAME Submit Button */
        .submit-btn{
            width:100%;padding:20px;border:none;border-radius:25px;
            background:linear-gradient(135deg,#1e3c72,#2a5298);
            color:white;font-size:18px;font-weight:600;cursor:pointer;transition:all 0.3s;
            box-shadow:0 10px 30px rgba(30,60,114,0.3);
        }
        .submit-btn:hover{transform:translateY(-3px);box-shadow:0 20px 40px rgba(30,60,114,0.4);}
        .submit-btn:active{transform:translateY(-1px);}
        
        /* SAME Loading Spinner */
        .loading{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);z-index:3000;align-items:center;justify-content:center;}
        .spinner{width:60px;height:60px;border:4px solid rgba(255,255,255,0.3);border-top:4px solid #1e3c72;border-radius:50%;animation:spin 1s linear infinite;}
        @keyframes spin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
        
        /* SAME Modals */
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
    <!-- SAME Loading Spinner -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <!-- SAME Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-check-circle success-icon"></i>
            <h3>âœ… Notes Added Successfully!</h3>
            <p>Your notes/papers/syllabus uploaded successfully</p>
        </div>
    </div>

    <!-- SAME Error Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <h3>âŒ Upload Failed!</h3>
            <p>Please check files and try again</p>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1><i class="fas fa-file-upload"></i> Add Notes</h1>
            <p>Upload Notes, Papers & Syllabus</p>
        </div>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data" id="notesForm">
                <div class="form-group">
                    <label><i class="fas fa-heading"></i> Title</label>
                    <input type="text" name="title" placeholder="Enter notes title" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-building"></i> Branch</label>
                    <select name="branch" required>
                        <option value="">Select Branch</option>
                        <option value="IT">ðŸ’» IT</option>
                        <option value="Civil">ðŸ—ï¸ Civil</option>
                        <option value="Mechanical">ðŸ”§ Mechanical</option>
                        <option value="Electrical">âš¡ Electrical</option>
                        <option value="Electronic">ðŸ“¡ Electronics</option>
                        <option value="Pharmacy">ðŸ’Š Pharmacy</option>
                        <option value="first_year">ðŸŽ“ First Year</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Semester</label>
                    <select name="semester">
                        <option value="">Select Semester</option>
                        <option value="1">Sem 1</option>
                        <option value="2">Sem 2</option>
                        <option value="3">Sem 3</option>
                        <option value="4">Sem 4</option>
                        <option value="5">Sem 5</option>
                        <option value="6">Sem 6</option>
                    </select>
                </div>
				
				<div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Year</label>
                    <select name="year">
                        <option value="">Select Year</option>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-layer-group"></i> Type</label>
                    <select name="type" required>
                        <option value="">Select Type</option>
                        <option value="notes">ðŸ“š Notes</option>
                        <option value="paper">ðŸ“„ Previous Paper</option>
                        <option value="syllabus">ðŸ“– Syllabus</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="file-upload" for="pdfFile">
                        <i class="fas fa-file-pdf"></i>
                        <div>
                            <div class="file-info">ðŸ“„ PDF File (Required)</div>
                            <small>Notes/Paper/Syllabus PDF</small>
                        </div>
                        <input type="file" name="file" id="pdfFile" accept=".pdf" required>
                    </label>
                </div>

                <button type="submit" name="upload" class="submit-btn">
                    <i class="fas fa-cloud-upload-alt"></i> Upload Notes
                </button>
            </form>
        </div>
    </div>

    <script>
        // SAME Modal Logic
        <?php if($upload_status=='success'): ?>
            setTimeout(() => document.getElementById('successModal').style.display='flex', 500);
        <?php elseif($upload_status=='error'): ?>
            setTimeout(() => document.getElementById('errorModal').style.display='flex', 500);
        <?php endif; ?>

        // SAME Loading
        document.getElementById('notesForm').onsubmit = () => {
            document.getElementById('loading').style.display = 'flex';
        };

        // SAME Close modals
        document.querySelectorAll('.modal').forEach(modal => {
            modal.onclick = e => { if(e.target.classList.contains('modal')) modal.style.display='none'; }
        });

        // SAME File preview
        document.getElementById('pdfFile').onchange = e => {
            const fileName = e.target.files[0]?.name || 'No file';
            e.target.parentElement.querySelector('.file-info').textContent = fileName;
        };

        // SAME Form focus effects
        document.querySelectorAll('input,select').forEach(input => {
            input.onfocus = () => input.parentElement.style.transform = 'translateY(-2px)';
            input.onblur = () => input.parentElement.style.transform = 'none';
        });
    </script>
</body>
</html>