<?php
include('includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "INSERT INTO users (first_name, last_name, email, password, role)
            VALUES ('$first', '$last', '$email', '$password', 'user')";

    if (mysqli_query($conn, $sql)) {
        echo "Registration successful! <a href='login.php'>Login</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Community Event Hub</title>
  <style>
    /* ==========================================================
       THEME COLORS
       ========================================================== */
    :root {
      --primary: rgb(251, 105, 98);
      --primary-hover: #e85c50;
      --bg-light: #f5f7fa;
      --text-dark: #333;
      --neutral-50: #f9fafb;
      --neutral-300: #d1d5db;
      --neutral-500: #6b7280;
      --neutral-700: #374151;
      --white: #ffffff;
    }

    /* ==========================================================
       PAGE BACKGROUND
       ========================================================== */
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #fff 0%, #fef2f2 100%);
      color: var(--text-dark);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    /* ==========================================================
       CARD CONTAINER
       ========================================================== */
    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      width: 100%;
    }

    .login-card {
      background: var(--white);
      padding: 3rem 2.5rem;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      border: 1px solid rgba(251, 105, 98, 0.15);
      max-width: 430px;
      width: 100%;
      text-align: center;
    }

    /* ==========================================================
       LOGO & HEADER
       ========================================================== */
    .logo-text {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 1rem;
    }

    .login-header h2 {
      color: var(--primary);
      font-size: 1.8rem;
      margin-bottom: 0.5rem;
    }

    .login-header p {
      color: var(--neutral-500);
      font-size: 1rem;
      margin-bottom: 2rem;
    }

    /* ==========================================================
       FORM STYLING
       ========================================================== */
    form {
      text-align: left;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: var(--neutral-700);
      font-size: 0.9rem;
    }

    .form-group input {
      width: 100%;
      padding: 0.8rem 1rem;
      border: 1.8px solid var(--neutral-300);
      border-radius: 10px;
      background: var(--neutral-50);
      font-size: 1rem;
      transition: border-color 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
    }

    .form-group input:focus {
      outline: none;
      border-color: var(--primary);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(251, 105, 98, 0.1);
    }

    /* ==========================================================
       BUTTON
       ========================================================== */
    .login-btn {
      width: 100%;
      padding: 1rem;
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 0.5rem;
    }

    .login-btn:hover {
      background: var(--primary-hover);
      box-shadow: 0 6px 20px rgba(251, 105, 98, 0.25);
      transform: translateY(-2px);
    }

    /* ==========================================================
       FOOTER LINKS
       ========================================================== */
    .login-footer {
      text-align: center;
      color: var(--neutral-500);
      margin-top: 1.5rem;
      font-size: 0.95rem;
    }

    .login-footer a {
      color: var(--primary);
      font-weight: 600;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .login-footer a:hover {
      color: var(--primary-hover);
      text-decoration: underline;
    }

    /* ==========================================================
       RESPONSIVE DESIGN
       ========================================================== */
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
        <h1 class="logo-text">🎉 Community Hub</h1>
      </div>

      <div class="login-header">
        <h2>Create an Account</h2>
        <p>Join our community and participate in exciting events!</p>
      </div>

      <form method="post" class="login-form">
        <div class="form-group">
          <label>First Name:</label>
          <input type="text" name="first_name" required>
        </div>

        <div class="form-group">
          <label>Last Name:</label>
          <input type="text" name="last_name">
        </div>

        <div class="form-group">
          <label>Email:</label>
          <input type="email" name="email" required>
        </div>

        <div class="form-group">
          <label>Password:</label>
          <input type="password" name="password" required>
        </div>

        <button type="submit" class="login-btn">Register</button>

        <div class="login-footer">
          Already have an account? <a href="login.php">Login here</a>
        </div>
      </form>

    </div>
  </div>

</body>
</html>
