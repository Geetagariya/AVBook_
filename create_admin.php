<?php
session_start();
include 'db.php';

// Allow access ONLY if no admin exists yet (first-time setup)
// OR if already logged in as admin
$admin_count = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM admin");
$row = mysqli_fetch_assoc($admin_count);
if($row['cnt'] > 0 && !isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}


$message = "";

if(isset($_POST['create'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // password hash
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // check duplicate user
    $check = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

    if(mysqli_num_rows($check) > 0){
        $message = "âŒ Username already exists!";
    } else {

        $query = "INSERT INTO admin (username, password, role)
                  VALUES ('$username', '$hashedPassword', '$role')";

        if(mysqli_query($conn, $query)){
            $message = "âœ… Admin Created Successfully!";
        } else {
            $message = "âŒ Error creating admin!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Admin</title>
    <style>
        body{
            font-family: Arial;
            background:#f5f6fa;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }
        .box{
            background:white;
            padding:30px;
            border-radius:10px;
            width:350px;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
        }
        input,select{
            width:100%;
            padding:10px;
            margin:10px 0;
        }
        button{
            width:100%;
            padding:10px;
            background:#2563eb;
            color:white;
            border:none;
            cursor:pointer;
        }
        .msg{
            text-align:center;
            margin-bottom:10px;
        }
    </style>
</head>
<body>

<div class="box">

    <h2>Create Admin</h2>

    <div class="msg"><?php echo $message; ?></div>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <select name="role">
            <option value="admin">Admin</option>
            <option value="faculty">Faculty</option>
        </select>

        <button type="submit" name="create">Create</button>

    </form>

</div>

</body>
</html>