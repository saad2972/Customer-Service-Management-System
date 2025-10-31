<?php
// Make sure no session_start() or redirects here
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechFix</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="logo">TechFix</div>
        <nav>
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Display user's first name instead of "Dashboard" -->
                <a href="<?php echo $_SESSION['user']['role'] == 'admin' ? 'admin/dashboard.php' : 'customer/dashboard.php'; ?>" class="user-welcome">
                    <?php echo htmlspecialchars($_SESSION['user']['first_name'] ?? 'User'); ?>
                </a>
                <a href="../logout.php" onclick="return confirmLogout()">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>