<?php
$conn = mysqli_connect("localhost","root","","avbook_db",3307);

if(!$conn){
    die("Connection Failed");
}

$success = false;
$error = false;

if(isset($_POST['upload'])){

    $title = $_POST['title'];
    $category = $_POST['category'];

    $file_name = $_FILES['audio']['name'];
    $tmp_name = $_FILES['audio']['tmp_name'];

    $folder = "audios/" . $category . "/" . $file_name;

    if(!is_dir("audios/" . $category)){
        mkdir("audios/" . $category, 0777, true);
    }

    if(move_uploaded_file($tmp_name, $folder)){


        $query = "INSERT INTO audios (title, category, file_path) 
                  VALUES ('$title', '$category', '$folder')";

        mysqli_query($conn, $query);

        $success = true;

    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Audio - Admin Panel</title>

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
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
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

        .page-header p {
            color: #64748b;
            font-size: 1.1rem;
        }

        .upload-card {
            background: #ffffff;
            padding: 60px;
            border-radius: 24px;
            box-shadow: 0 25px 70px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            text-align: center;
        }

        .upload-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #1d4ed8, #1e40af);
            border-radius: 24px 24px 0 0;
        }

        /* 2-Column Compact Layout */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .form-group {
            position: relative;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 18px 22px;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            background: #fafbfc;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #1d4ed8;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.1);
            transform: translateY(-2px);
        }

        /* Audio Upload Section */
        .audio-upload-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px dashed #cbd5e0;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            transition: all 0.3s ease;
            margin: 40px 0;
            position: relative;
            cursor: pointer;
        }

        .audio-upload-section:hover {
            border-color: #1d4ed8;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            box-shadow: 0 15px 40px rgba(29, 78, 216, 0.15);
        }

        .audio-upload-section i {
            font-size: 4rem;
            color: #1d4ed8;
            margin-bottom: 20px;
            display: block;
        }

        .upload-text {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

      
		.file-upload-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    color: white;
    padding: 16px 32px;
    border-radius: 16px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 8px 25px rgba(29, 78, 216, 0.3);
}

.file-upload-btn i {
    color: white !important; /*  White Icon Fixed */
}

        .file-upload-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(29, 78, 216, 0.4);
        }

        .submit-btn {
            width: 100%;
            padding: 22px;
            border: none;
            border-radius: 20px;
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(29, 78, 216, 0.4);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            
            .container {
                padding: 20px 15px;
            }
            
            .upload-card {
                padding: 40px 30px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-microphone-alt"></i> Upload Audio</h1>
            <p>Add new audio lectures to your library</p>
        </div>

        <div class="upload-card">
            <form method="POST" enctype="multipart/form-data">
                
                <!-- 2-Column Compact Layout -->
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-heading"></i> Audio Title *
                        </label>
                        <input type="text" name="title" class="form-input" placeholder="Enter audio title" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-folder"></i> Category *
                        </label>
                        <input type="text" name="category" class="form-input" placeholder="e.g. C Language, Java" required>
                    </div>
                </div>

                <!-- Professional Audio Upload -->
                <div class="audio-upload-section">
                    <i class="fas fa-music"></i>
                    <div class="upload-text">Upload Audio File</div>
                    <p style="color: #64748b; margin-bottom: 25px; font-size: 1rem;">
                        MP3, WAV, M4A - Max 50MB
                    </p>
                    <input type="file" name="audio" accept="audio/*" style="display: none;" id="audio-upload" required>
                    <label for="audio-upload" class="file-upload-btn">
                        <i class="fas fa-cloud-upload-alt"></i>
                        Choose Audio File
                    </label>
                </div>

                <button type="submit" name="upload" class="submit-btn">
                    <i class="fas fa-upload"></i> Upload Audio
                </button>
            </form>
        </div>
    </div>

    <script>
        // File upload feedback
        document.getElementById('audio-upload').addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'No file selected';
            const uploadSection = this.parentElement;
            const uploadText = uploadSection.querySelector('.upload-text');
            
            uploadText.innerHTML = `
                <i class="fas fa-check-circle" style="color: #10b981;"></i>
                ${fileName}
            `;
            uploadText.style.color = '#10b981';
            uploadText.style.fontWeight = '700';
        });

        // Smooth input focus
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>

    <?php if($success): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: '🎧 Uploaded Successfully!',
        text: 'Audio added to library',
        confirmButtonColor: '#1d4ed8',
        timer: 2500,
        timerProgressBar: true
    });
    </script>
    <?php endif; ?>

    <?php if($error): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Upload Failed!',
        text: 'Please try again',
        confirmButtonColor: '#ef4444'
    });
    </script>
    <?php endif; ?>
</body>
</html>