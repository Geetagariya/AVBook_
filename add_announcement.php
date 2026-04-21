<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $is_pinned = isset($_POST['is_pinned']) ? 1 : 0;

    // Default admin name
    $added_by = "Admin";

    // Check duplicate
    $check = mysqli_query($conn, "SELECT * FROM announcements WHERE title='$title' AND description='$description'");
    
    if(mysqli_num_rows($check) > 0){
        header("Location: add_announcement.php?exists=1");
        exit();
    }

    // FINAL INSERT (IMPORTANT FIX)
    $insert = mysqli_query($conn, "INSERT INTO announcements 
    (title, description, category, added_by, is_pinned) 
    VALUES ('$title','$description','$category','$added_by','$is_pinned')");

    if($insert){
        header("Location: add_announcement.php?success=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Announcement</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #ffffff;
        }
        .card {
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .form-control, .form-select {
            border-radius: 6px;
        }
        .btn {
            border-radius: 6px;
        }
    </style>
</head>

<body>

<div class="container mt-5">

    <div class="card p-4 shadow-sm">
        <h3 class="mb-4">Add New Announcement</h3>

        <!-- ALERTS -->
		<?php if(isset($_GET['exists'])): ?>
<script>
Swal.fire({
    title: 'Warning!',
    text: 'Announcement already exists!',
    icon: 'warning'
});
</script>
<?php endif; ?>

        <?php if(isset($_GET['success'])): ?>
<script>
Swal.fire({
    title: 'Success!',
    text: 'Announcement Added Successfully',
    icon: 'success',
    confirmButtonText: 'OK'
});
</script>
<?php endif; ?>

        <!-- FORM -->
        <form method="POST">

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" rows="4" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category" class="form-select" required>
                    <option value="">Select Category</option>
                    <option value="book">Book Added</option>
                    <option value="notes">Notes Added</option>
                    <option value="video">Video Added</option>
                    <option value="audio">Audio Added</option>
                    <option value="exam">Exam</option>
                    <option value="event">Event</option>
                    <option value="result">Result</option>
                </select>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="is_pinned" class="form-check-input" id="pin">
                <label class="form-check-label" for="pin">
                    Pin this announcement
                </label>
            </div>

            <button type="submit" class="btn btn-success">Publish</button>
            <a href="announcement.php" class="btn btn-secondary">Back</a>

        </form>
    </div>

</div>

</body>
</html>