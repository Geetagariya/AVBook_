<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
if(isset($_GET['id'])){
    $id = (int)$_GET['id'];

    $query = "DELETE FROM announcements WHERE id=$id";

    if(mysqli_query($conn, $query)){
        header("Location: view_announcements.php?deleted=1");
        exit();
    } else {
        header("Location: view_announcements.php?error=1");
        exit();
    }
} else {
    header("Location: view_announcements.php");
    exit();
}
?>