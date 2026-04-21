<?php
// ============================================================
// DATABASE CONFIGURATION — AVBook Project
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'vjxrlbys_av_book_us');
define('DB_PASS', 'AVBook@2024');
define('DB_NAME', 'vjxrlbys_avbook_db');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>