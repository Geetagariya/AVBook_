<?php
// ============================================================
// DATABASE CONFIGURATION — AVBook Project
// ============================================================
// ⚠️  BEFORE DEPLOYING: Update these 3 values with your
//     HostITSmart cPanel MySQL credentials.
//
//  DB_HOST : Keep "localhost" (standard on cPanel)
//  DB_USER : cPanel username + "_" + db user, e.g. "gariy_avbook"
//  DB_PASS : The password you set for the MySQL user in cPanel
//  DB_NAME : cPanel username + "_" + db name, e.g. "gariy_avbook_db"
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'gariy_avbook');       // ← Change to your cPanel MySQL user
define('DB_PASS', 'YOUR_DB_PASSWORD');   // ← Change to your MySQL user password
define('DB_NAME', 'gariy_avbook_db');    // ← Change to your cPanel database name

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>