<?php
session_start();
?>
<?php
include 'db.php';

$msg = "";

if(isset($_POST['submit'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $youtube_link = mysqli_real_escape_string($conn, $_POST['youtube_link']);
    $thumbnail = mysqli_real_escape_string($conn, $_POST['thumbnail']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $subscribers = mysqli_real_escape_string($conn, $_POST['subscribers']);

    // Validation
    if(empty($title) || empty($description) || empty($youtube_link) || empty($thumbnail) || empty($category)){
        $msg = "empty";
    } else {

        // INSERT VIDEO
        $sql = "INSERT INTO videos (title, description, youtube_link, thumbnail, category, subscribers)
                VALUES ('$title','$description','$youtube_link','$thumbnail','$category','$subscribers')";

        if(mysqli_query($conn, $sql)){

            // ðŸ”¥ AUTO ANNOUNCEMENT CODE START
            $announcement_title = "New Video Uploaded!";
            $announcement_desc = "A new video titled \"$title\" has been added in $category category.";

            $announcement_query = "INSERT INTO announcements 
            (title, description, category, added_by, views, is_pinned, created_at) 
            VALUES 
            ('$announcement_title', '$announcement_desc', 'video', 'Admin', 0, 0, NOW())";

            mysqli_query($conn, $announcement_query);
            // ðŸ”¥ AUTO ANNOUNCEMENT CODE END

            $msg = "success";

        } else {
            $msg = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Video</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h3 class="mb-4 text-center">Upload Video</h3>

        <form method="POST">

            <input type="text" name="title" class="form-control mb-3" placeholder="Title">

            <textarea name="description" class="form-control mb-3" placeholder="Description"></textarea>

            <input type="text" name="youtube_link" class="form-control mb-3" placeholder="YouTube Link">

            <input type="text" name="thumbnail" class="form-control mb-3" placeholder="Thumbnail URL">

            <input type="text" name="subscribers" class="form-control mb-3" placeholder="Subscribers (optional)">

            <select name="category" class="form-control mb-3">
                <option value="">Select Category</option>
                <option value="engineering">Engineering</option>
                <option value="diploma">Diploma</option>
                <option value="others">Others</option>
            </select>

            <button type="submit" name="submit" class="btn btn-primary w-100">
                Upload Video
            </button>

        </form>
    </div>
</div>

<!-- SweetAlert Messages -->
<script>
<?php if($msg=="success"){ ?>
    Swal.fire({
        icon: 'success',
        title: 'Video Uploaded!',
        text: 'Successfully added',
    }).then(()=>{
        window.location='upload_video.php';
    });
<?php } ?>

<?php if($msg=="empty"){ ?>
    Swal.fire({
        icon: 'warning',
        title: 'All fields required'
    });
<?php } ?>

<?php if($msg=="error"){ ?>
    Swal.fire({
        icon: 'error',
        title: 'Database Error'
    });
<?php } ?>
</script>

</body>
</html>