<?php
// Header: only output the header markup. The <head> and <body> are handled by includes/head.php
?>
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