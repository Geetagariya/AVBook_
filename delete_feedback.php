<?php
$conn = mysqli_connect("localhost","root","","avbook_db",3307);

$id = $_GET['id'];

$query = "DELETE FROM feedback WHERE id='$id'";

mysqli_query($conn,$query);

// redirect back
header("Location: view_feedback.php");
?>