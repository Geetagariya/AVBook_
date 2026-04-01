<?php
$conn = mysqli_connect("localhost","root","","avbook_db",3307);

if(!$conn){
    die("Database connection failed: " . mysqli_connect_error());
}

// Form submit check
if(isset($_POST['submit'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $youtube_link = mysqli_real_escape_string($conn, $_POST['youtube_link']);
    $thumbnail = mysqli_real_escape_string($conn, $_POST['thumbnail']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $sql = "INSERT INTO videos (title, description, youtube_link, thumbnail, category) 
            VALUES ('$title', '$description', '$youtube_link', '$thumbnail', '$category')";

    if(mysqli_query($conn, $sql)){
        // Success SweetAlert
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Video Uploaded!',
            text: 'Your video has been added successfully!',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href='upload_video.php';
        });
        </script>";
    } else {
        // Error SweetAlert
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Video upload failed!',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href='upload_video.php';
        });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Upload Video</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Video Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">YouTube Video Link</label>
            <input type="text" name="youtube_link" class="form-control" placeholder="https://www.youtube.com/embed/..." required>
        </div>
        <div class="mb-3">
            <label class="form-label">Thumbnail Image URL</label>
            <input type="text" name="thumbnail" class="form-control" placeholder="Paste image link from YouTube or anywhere" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" placeholder="Example: Science, Math..." required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Upload Video</button>
    </form>
</div>
</body>
</html>