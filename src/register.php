<?php
include('includes/db_connect.php');

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    // Check if email already exists
    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if(mysqli_num_rows($check_email) > 0) {
        $error = "This email is already registered!";
    } else {
        $sql = "INSERT INTO users (first_name, last_name, email, password, role)
                VALUES ('$first', '$last', '$email', '$password', 'user')";

        if (mysqli_query($conn, $sql)) {
            $success = "Registration successful! You can now <a href='login.php'>login</a>";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<style>
.register-wrapper {
    min-height: 50vh;
    padding: 80px 0;
    background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
}

.register-container {
    max-width: 500px;
    margin: 0 auto;
    padding: 2rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.register-header {
    text-align: center;
    margin-bottom: 2rem;
}

.register-header h1 {
    color: #333;
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.register-header p {
    color: #666;
}

.register-form .form-group {
    margin-bottom: 1.5rem;
}

.register-form input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}

.register-form input:focus {
    border-color: rgb(251, 105, 98);
    box-shadow: 0 0 0 3px rgba(251, 105, 98, 0.1);
    outline: none;
}

.register-form button {
    width: 100%;
    padding: 12px;
    background: rgb(251, 105, 98);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s ease;
}

.register-form button:hover {
    background: #e85c50;
}

.register-footer {
    text-align: center;
    margin-top: 1.5rem;
    color: #666;
}

.register-footer a {
    color: rgb(251, 105, 98);
    text-decoration: none;
}

.register-footer a:hover {
    text-decoration: underline;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    text-align: center;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

<div class="register-wrapper">
    <div class="register-container">
        <div class="register-header">
            <h1>Create Account</h1>
            <p>Join TechFix for reliable tech support</p>
        </div>
        
        <?php if($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form class="register-form" method="POST" action="">
            <div class="form-group">
                <input type="text" name="first_name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        
        <div class="register-footer">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</div>


