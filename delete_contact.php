<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
$id = $_GET['id'];

$query = "DELETE FROM contact WHERE id='$id'";

mysqli_query($conn,$query);

// redirect back
header("Location: view_contact.php");
?>