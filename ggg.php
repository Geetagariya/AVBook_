<?php
session_start();

// DB Connection
$conn = mysqli_connect("localhost", "root", "", "avbook_db", 3307);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// LOGIN LOGIC - SECURE
$login_status = '';
$error = '';

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $login_status = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔐 Admin Login - Library Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{
            font-family:'Poppins',sans-serif;
            background:#f8fafc;
            min-height:100vh;
            display:flex;align-items:center;justify-content:center;
            padding:20px;
        }
        
        .login-container{
            background:white;
            padding:50px 40px;
            border-radius:25px;
            box-shadow:0 25px 80px rgba(0,0,0,0.15);
            border:1px solid #e2e8f0;
            width:100%;max-width:420px;
            backdrop-filter:blur(10px);
            position:relative;overflow:hidden;
        }
        .login-container::before{
            content:'';position:absolute;top:0;left:0;right:0;height:5px;
            background:linear-gradient(90deg,#1e3c72,#2a5298,#1e3c72);
        }
        
        .logo{text-align:center;margin-bottom:30px;}
        .logo i{font-size:3.5rem;color:#1e3c72;margin-bottom:15px;}
        .logo h1{
            font-size:1.8rem;color:#1e293b;font-weight:700;
            background:linear-gradient(45deg,#1e3c72,#2a5298);
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;
        }
        .logo p{color:#64748b;font-size:15px;margin-bottom:10px;}
        
        .form-group{position:relative;margin-bottom:25px;}
        .form-group label{
            position:absolute;left:20px;top:18px;color:#64748b;
            font-size:14px;font-weight:500;transition:all 0.3s;
            pointer-events:none;
        }
        .form-group input{
            width:100%;padding:20px 20px 10px;font-size:16px;
            border:2px solid #e2e8f0;border-radius:15px;background:white;
            transition:all 0.3s;font-family:inherit;color:#1e293b;
            box-shadow:0 4px 15px rgba(0,0,0,0.05);
        }
        .form-group input:focus{
            outline:none;border-color:#1e3c72;box-shadow:0 10px 30px rgba(30,60,114,0.15);
            transform:translateY(-2px);
        }
        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label{
            top:8px;left:15px;font-size:12px;color:#1e3c72;background:white;
            padding:0 8px;
        }
        
        /* Password Toggle */
        .password-group{position:relative;}
        .password-toggle{
            position:absolute;right:20px;top:50%;transform:translateY(-50%);
            background:none;border:none;color:#64748b;font-size:18px;
            cursor:pointer;transition:all 0.3s;
        }
        .password-toggle:hover{color:#1e3c72;}
        
        /* Remember Me */
        .remember-me{
            display:flex;align-items:center;gap:10px;margin:20px 0;
            color:#64748b;font-size:14px;
        }
        .remember-me input{width:18px;height:18px;}
        
        /* Login Button */
        .login-btn{
            width:100%;padding:18px;border:none;border-radius:15px;
            background:linear-gradient(135deg,#1e3c72,#2a5298);
            color:white;font-size:17px;font-weight:600;cursor:pointer;
            transition:all 0.3s;box-shadow:0 10px 30px rgba(30,60,114,0.3);
            position:relative;overflow:hidden;
        }
        .login-btn:hover{transform:translateY(-3px);box-shadow:0 20px 40px rgba(30,60,114,0.4);}
        .login-btn:active{transform:translateY(-1px);}
        
        /* Loading Overlay */
        .loading-overlay{display:none;position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(255,255,255,0.9);z-index:10;align-items:center;justify-content:center;}
        .login-spinner{width:30px;height:30px;border:3px solid rgba(255,255,255,0.3);border-top:3px solid white;border-radius:50%;animation:spin 1s linear infinite;}
        
        /* Modals */
        .modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);backdrop-filter:blur(10px);z-index:2000;align-items:center;justify-content:center;}
        .modal-content{background:white;padding:40px;border-radius:25px;text-align:center;box-shadow:0 25px 70px rgba(0,0,0,0.3);max-width:400px;width:90%;transform:scale(0.7);animation:modalPop 0.4s ease forwards;}
        @keyframes modalPop{to{transform:scale(1);}}
        @keyframes spin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
        .success-icon{font-size:4rem;color:#10b981;margin-bottom:20px;}
        .error-icon{font-size:4rem;color:#ef4444;margin-bottom:20px;}
        .modal h3{color:#1e293b;margin-bottom:15px;font-size:1.5rem;}
        .modal p{color:#64748b;font-size:16px;}
        
        /* Responsive */
        @media(max-width:480px){
            .login-container{padding:40px 25px;margin:10px;}
            .logo i{font-size:2.8rem;}
            .logo h1{font-size:1.6rem;}
        }
    </style>
</head>
<body>
    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-check-circle success-icon"></i>
            <h3>✅ Login Successful!</h3>
            <p>Redirecting to dashboard...</p>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <h3>❌ Login Failed!</h3>
            <p>Invalid username or password</p>
        </div>
    </div>

    <div class="login-container">
        <div class="logo">
            <i class="fas fa-shield-alt"></i>
            <h1>Admin Panel</h1>
            <p>Library Management System</p>
        </div>

        <form method="POST" id="loginForm">
            <div class="form-group">
                <input type="text" name="username" placeholder=" " required>
                <label>Username</label>
            </div>

            <div class="form-group password-group">
                <input type="password" name="password" id="password" placeholder=" " required>
                <label>Password</label>
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
        // Show error modal if login failed
        <?php if($login_status=='error'): ?>
            setTimeout(() => document.getElementById('errorModal').style.display='flex', 500);
        <?php endif; ?>

        // Password visibility toggle
        function togglePassword(){
            const password = document.getElementById('password');
            const toggle = event.target;
            if(password.type === 'password'){
                password.type = 'text';
                toggle.classList.remove('fa-eye');
                toggle.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                toggle.classList.remove('fa-eye-slash');
                toggle.classList.add('fa-eye');
            }
        }

        // Form submission loading
        document.getElementById('loginForm').onsubmit = function(){
            const btn = document.querySelector('.login-btn');
            const btnText = document.getElementById('btnText');
            const loading = document.getElementById('loadingOverlay');
            
            btnText.style.opacity = '0';
            loading.style.display = 'flex';
            btn.disabled = true;
        };

        // Close modals on outside click
        document.querySelectorAll('.modal').forEach(modal => {
            modal.onclick = e => {
                if(e.target.classList.contains('modal')) modal.style.display = 'none';
            };
        });

        // Floating label animation
        document.querySelectorAll('input').forEach(input => {
            input.onfocus = () => input.parentElement.classList.add('focused');
            input.onblur = () => {
                if(!input.value) input.parentElement.classList.remove('focused');
            };
        });
    </script>
</body>
</html>