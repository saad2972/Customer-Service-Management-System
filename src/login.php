<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection FIRST
include('includes/db_connect.php');

// echo "Session before login: ";
// print_r($_SESSION);

// Redirect if already logged in
if(isset($_SESSION['user'])) {
    if($_SESSION['user']['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: customer/dashboard.php"); // Fixed: customer instead of user
    }
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $user;

        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: customer/dashboard.php"); // Fixed: customer instead of user
        }
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechFix</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Fixed CSS path -->
    <style>
    /* ==========================================================
   THEME: Community Event Hub — Login Page
   Consistent with dashboard & event pages
   Accent Color: rgb(251, 105, 98)
   ========================================================== */

:root {
    --primary: rgb(251, 105, 98);
    --primary-hover: rgb(245, 85, 77);
    --neutral-50: #f8fafc;
    --neutral-100: #f1f5f9;
    --neutral-300: #cbd5e1;
    --neutral-500: #64748b;
    --neutral-700: #334155;
}

/* Centering Container */
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    padding: 2rem;
}

/* Card Layout */
.login-card {
    background: #fff;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(251, 105, 98, 0.15);
    width: 100%;
    max-width: 400px;
    border-left: 5px solid var(--primary);
}

/* Logo / Branding */
.logo {
    text-align: center;
    margin-bottom: 1.5rem;
}

.logo-text {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

/* Header Text */
.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.login-header h2 {
    color: var(--primary);
    font-size: 2rem;
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.login-header p {
    color: var(--neutral-500);
    font-size: 1rem;
}

/* Form Inputs */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--neutral-700);
    font-weight: 600;
    font-size: 0.9rem;
}

.form-group input {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 2px solid var(--neutral-300);
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: var(--neutral-50);
}

.form-group input:focus {
    outline: none;
    border-color: var(--primary);
    background: white;
    box-shadow: 0 0 0 3px rgba(251, 105, 98, 0.1);
}

/* Button Styling */
.login-btn {
    width: 100%;
    padding: 1rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
}

.login-btn:hover {
    background: var(--primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(251, 105, 98, 0.25);
}

/* Footer Links */
.login-footer {
    text-align: center;
    color: var(--neutral-500);
}

.login-footer a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.login-footer a:hover {
    color: var(--primary-hover);
    text-decoration: underline;
}

/* Alerts / Messages */
.error-message {
    background: #ffe4e1;
    color: #7f1d1d;
    padding: 0.8rem 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    text-align: center;
    border: 1px solid #fecaca;
    font-weight: 500;
}

.success-message {
    background: #dcfce7;
    color: #166534;
    padding: 0.8rem 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    text-align: center;
    border: 1px solid #bbf7d0;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 480px) {
    .login-card {
        padding: 2rem 1.5rem;
        margin: 1rem;
    }
    
    .login-header h2 {
        font-size: 1.5rem;
    }
}

    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <div class="logo-text">TechFix</div>
            </div>
            
            <div class="login-header">
                <h2>Login</h2>
                <p>Welcome back to TechFix</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
                <div class="success-message">
                    Registration successful! Please login to continue.
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        placeholder="Enter your email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        placeholder="Enter your password"
                    >
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>