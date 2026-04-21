<?php
// ============================================================
// AVBook Server Diagnostic Tool
// ⚠️ DELETE THIS FILE AFTER DEBUGGING!
// ============================================================
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<style>body{font-family:Arial;padding:20px;background:#f5f5f5} .ok{color:green;font-weight:bold} .fail{color:red;font-weight:bold} .section{background:#fff;padding:15px;margin:15px 0;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1)} h2{color:#1a237e}</style>";
echo "<h1>🔍 AVBook Server Diagnostic</h1>";

// 1. PHP Version
echo "<div class='section'><h2>1. PHP Version</h2>";
$phpVersion = phpversion();
$ok = version_compare($phpVersion, '7.4', '>=');
echo "PHP Version: <b>$phpVersion</b> " . ($ok ? "<span class='ok'>✅ OK</span>" : "<span class='fail'>❌ Needs 7.4+</span>");
echo "</div>";

// 2. Required Extensions
echo "<div class='section'><h2>2. PHP Extensions</h2>";
$extensions = ['mysqli', 'mbstring', 'fileinfo', 'gd'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "- $ext: " . ($loaded ? "<span class='ok'>✅ Loaded</span>" : "<span class='fail'>❌ Missing!</span>") . "<br>";
}
echo "</div>";

// 3. Database Connection
echo "<div class='section'><h2>3. Database Connection</h2>";
$host = 'localhost';
$user = 'vjxrlbys_av_book_us';
$pass = 'AVBook@2024';
$db   = 'vjxrlbys_avbook_db';

$conn = @mysqli_connect($host, $user, $pass, $db);
if ($conn) {
    echo "<span class='ok'>✅ Database connected successfully!</span><br>";
    mysqli_set_charset($conn, 'utf8mb4');

    // Check tables
    $tables = ['admin', 'books', 'notes', 'audios', 'videos', 'announcements', 'contact', 'feedback'];
    echo "<br><b>Table Check:</b><br>";
    foreach ($tables as $table) {
        $r = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        $exists = mysqli_num_rows($r) > 0;
        $count = '';
        if ($exists) {
            $cr = mysqli_query($conn, "SELECT COUNT(*) as c FROM `$table`");
            $row = mysqli_fetch_assoc($cr);
            $count = " ({$row['c']} rows)";
        }
        echo "- $table: " . ($exists ? "<span class='ok'>✅ Exists$count</span>" : "<span class='fail'>❌ MISSING! Run avbook_db.sql import!</span>") . "<br>";
    }
} else {
    echo "<span class='fail'>❌ Connection FAILED: " . mysqli_connect_error() . "</span>";
}
echo "</div>";

// 4. File Permissions
echo "<div class='section'><h2>4. Upload Directories</h2>";
$dirs = ['PDF/', 'audios/', 'images/college/', 'images/books/'];
foreach ($dirs as $dir) {
    $exists = is_dir($dir);
    $writable = $exists && is_writable($dir);
    echo "- $dir: ";
    if (!$exists) echo "<span class='fail'>❌ Not Found</span>";
    elseif (!$writable) echo "<span class='fail'>⚠️ Not Writable (chmod 755)</span>";
    else echo "<span class='ok'>✅ OK</span>";
    echo "<br>";
}
echo "</div>";

// 5. .htaccess Test
echo "<div class='section'><h2>5. .htaccess</h2>";
echo file_exists('.htaccess') ? "<span class='ok'>✅ .htaccess exists</span>" : "<span class='fail'>❌ .htaccess missing</span>";
echo "</div>";

echo "<br><p style='color:#888'>⚠️ <b>Delete this file (test_server.php) from cPanel after debugging!</b></p>";
?>
