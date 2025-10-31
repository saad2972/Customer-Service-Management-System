<?php
// Only start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base path for consistent redirects
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));

// Function to get correct redirect paths
function getRedirectPath() {
    $current_dir = dirname($_SERVER['PHP_SELF']);
    
    if (strpos($current_dir, 'admin') !== false) {
        return '../login.php';
    } elseif (strpos($current_dir, 'customer') !== false) {
        return '../login.php';
    } else {
        return 'login.php';
    }
}

// Function to get dashboard path based on role
function getDashboardPath($role) {
    if ($role === 'admin') {
        return 'admin/dashboard.php';
    } else {
        return 'customer/dashboard.php';
    }
}

// If admin page required
if (isset($require_admin) && $require_admin === true) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: " . getRedirectPath());
        exit();
    }
}

// If customer page required
if (isset($require_customer) && $require_customer === true) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
        header("Location: " . getRedirectPath());
        exit();
    }
}

// If user is logged in but trying to access login page
if (basename($_SERVER['PHP_SELF']) == 'login.php' && isset($_SESSION['user'])) {
    $dashboard_path = getDashboardPath($_SESSION['user']['role']);
    header("Location: " . $dashboard_path);
    exit();
}

// If user not logged in and trying to access protected page
$public_pages = ['login.php', 'register.php', 'index.php'];
if (!isset($_SESSION['user']) && !in_array(basename($_SERVER['PHP_SELF']), $public_pages)) {
    header("Location: " . getRedirectPath());
    exit();
}

// Additional security: Prevent role mixing
if (isset($_SESSION['user'])) {
    $current_dir = dirname($_SERVER['PHP_SELF']);
    $user_role = $_SESSION['user']['role'];
    
    // If admin trying to access customer area
    if ($user_role === 'admin' && strpos($current_dir, 'customer') !== false) {
        header("Location: ../admin/dashboard.php");
        exit();
    }
    
    // If customer trying to access admin area
    if ($user_role === 'customer' && strpos($current_dir, 'admin') !== false) {
        header("Location: ../customer/dashboard.php");
        exit();
    }
}
?>