<?php
session_start();
include 'db.php';

// LOGIN LOGIC - IMPROVED
$show_error_modal = false;

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if($row = mysqli_fetch_assoc($result)){

        if(password_verify($password, $row['password'])){

            session_regenerate_id(true);

            $_SESSION['admin'] = $row['username'];
            $_SESSION['role'] = $row['role'];   // ✔ ROLE ADDED

            header("Location: admin_dashboard.php");
            exit();

        } else {
            $show_error_modal = true;
        }

    } else {
        $show_error_modal = true;
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔐 Admin Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* SAME WHITE CLEAN STYLES - Copy previous wale */
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Poppins',sans-serif;background:#f8fafc;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;}
        .login-container{background:white;padding:50px 40px;border-radius:25px;box-shadow:0 25px 80px rgba(0,0,0,0.15);border:1px solid #e2e8f0;width:100%;max-width:420px;}
        .login-container::before{content:'';position:absolute;top:0;left:0;right:0;height:5px;background:linear-gradient(90deg,#1e3c72,#2a5298,#1e3c72);}
        .logo{text-align:center;margin-bottom:30px;}
        .logo i{font-size:3.5rem;color:#1e3c72;margin-bottom:15px;}
        .logo h1{font-size:1.8rem;color:#1e293b;font-weight:700;background:linear-gradient(45deg,#1e3c72,#2a5298);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
        .logo p{color:#64748b;font-size:15px;margin-bottom:10px;}
        .form-group{position:relative;margin-bottom:25px;}
        .form-group input{width:100%;padding:20px 20px 10px;font-size:16px;border:2px solid #e2e8f0;border-radius:15px;background:white;transition:all 0.3s;color:#1e293b;box-shadow:0 4px 15px rgba(0,0,0,0.05);}
        .form-group input:focus{outline:none;border-color:#1e3c72;box-shadow:0 10px 30px rgba(30,60,114,0.15);transform:translateY(-2px);}
        .password-group{position:relative;}
        .password-toggle{position:absolute;right:20px;top:50%;transform:translateY(-50%);background:none;border:none;color:#64748b;font-size:18px;cursor:pointer;transition:all 0.3s;}
        .password-toggle:hover{color:#1e3c72;}
        .remember-me{display:flex;align-items:center;gap:10px;margin:20px 0;color:#64748b;font-size:14px;}
        .login-btn{width:100%;padding:18px;border:none;border-radius:15px;background:linear-gradient(135deg,#1e3c72,#2a5298);color:white;font-size:17px;font-weight:600;cursor:pointer;transition:all 0.3s;box-shadow:0 10px 30px rgba(30,60,114,0.3);}
        .login-btn:hover{transform:translateY(-3px);box-shadow:0 20px 40px rgba(30,60,114,0.4);}
        .login-btn:active{transform:translateY(-1px);}
        .loading-overlay{display:none;position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(255,255,255,0.9);z-index:10;align-items:center;justify-content:center;}
        .login-spinner{width:30px;height:30px;border:3px solid rgba(255,255,255,0.3);border-top:3px solid white;border-radius:50%;animation:spin 1s linear infinite;}
        @keyframes spin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
        .modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);backdrop-filter:blur(10px);z-index:2000;align-items:center;justify-content:center;}
        .modal-content{background:white;padding:40px;border-radius:25px;text-align:center;box-shadow:0 25px 70px rgba(0,0,0,0.3);max-width:400px;width:90%;transform:scale(0.7);animation:modalPop 0.4s ease forwards;}
        @keyframes modalPop{to{transform:scale(1);}}
        .error-icon{font-size:4rem;color:#ef4444;margin-bottom:20px;}
        .modal h3{color:#1e293b;margin-bottom:15px;font-size:1.5rem;}
        .modal p{color:#64748b;font-size:16px;}
        @media(max-width:480px){.login-container{padding:40px 25px;margin:10px;}}
    </style>
</head>
<body>
    <!-- Error Modal Only -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <h3>❌ Login Failed!</h3>
            <p>Invalid username or password</p>
        </div>
    </div>

    <div class="login-container" style="position:relative;">
        <div class="logo">
            <i class="fas fa-shield-alt"></i>
            <h1>Admin Panel</h1>
            <p>Library Management System</p>
        </div>

        <form method="POST" id="loginForm">
            <div class="form-group">
                <input type="text" name="username" placeholder=" " required autocomplete="username">
            </div>

            <div class="form-group password-group">
                <input type="password" name="password" id="password" placeholder=" " required autocomplete="current-password">
                <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" name="login" class="login-btn">
                <span id="btnText">🔐 Sign In</span>
                <div class="loading-overlay" id="loadingOverlay">
                    <div class="login-spinner"></div>
                </div>
            </button>
        </form>
    </div>

    <script>
        // ✅ SHOW ERROR MODAL ONLY ON FAIL
        <?php if($show_error_modal): ?>
            setTimeout(() => document.getElementById('errorModal').style.display = 'flex', 300);
        <?php endif; ?>

        // Password toggle
        function togglePassword(){
            const pwd = document.getElementById('password');
            const icon = event.target;
            pwd.type = pwd.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }

        // Loading state
        document.getElementById('loginForm').onsubmit = function(){
            const btnText = document.getElementById('btnText');
            const loading = document.getElementById('loadingOverlay');
            btnText.style.opacity = '0';
            loading.style.display = 'flex';
        };

        // Close modal
        document.getElementById('errorModal').onclick = function(e){
            if(e.target.id === 'errorModal') this.style.display = 'none';
        };

        // Focus effects
        document.querySelectorAll('input').forEach(input => {
            input.onfocus = () => input.parentElement.classList.add('focused');
            input.onblur = () => input.parentElement.classList.remove('focused');
        });
    </script>
</body>
</html>