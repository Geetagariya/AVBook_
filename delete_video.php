<?php
session_start();
?>
<?php
include 'db.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    mysqli_query($conn, "DELETE FROM videos WHERE id=$id");

    // Redirect with success
    header("Location: view_video.php?msg=deleted");
}
?>