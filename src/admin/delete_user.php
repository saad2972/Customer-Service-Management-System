<?php
$require_admin = true;

include("../includes/auth.php");
include("../includes/db_connect.php");

$user_id = $_GET['id'] ?? 0;

// Prevent deleting admin users
$user_check = mysqli_query($conn, "SELECT role FROM users WHERE id = $user_id");
$user_data = mysqli_fetch_assoc($user_check);

if ($user_data && $user_data['role'] != 'admin') {
    $delete_query = "DELETE FROM users WHERE id = $user_id";
    
    if (mysqli_query($conn, $delete_query)) {
        header("Location: manage_users.php?message=User deleted successfully");
    } else {
        header("Location: manage_users.php?error=Error deleting user");
    }
} else {
    header("Location: manage_users.php?error=Cannot delete admin users");
}

mysqli_close($conn);
exit();
?>