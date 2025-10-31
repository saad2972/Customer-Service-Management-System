<?php
$require_admin = true;

// Database connection
require_once '../includes/db_connect.php'; // Adjust path as needed
// OR if config.php is not available, create connection directly:
// $com = mysqli_connect("localhost", "username", "password", "database_name");

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get total tickets count
$total_tickets_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tickets");
$total_tickets_data = mysqli_fetch_assoc($total_tickets_result);
$total_tickets = $total_tickets_data['total'];

// Get resolved tickets count
$resolved_tickets_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tickets WHERE status = 'resolved'");
$resolved_tickets_data = mysqli_fetch_assoc($resolved_tickets_result);
$resolved_tickets = $resolved_tickets_data['total'];

// Get pending tickets count
$pending_tickets_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tickets WHERE status = 'pending'");
$pending_tickets_data = mysqli_fetch_assoc($pending_tickets_result);
$pending_tickets = $pending_tickets_data['total'];

// Get total revenue
$total_revenue_result = mysqli_query($conn, "SELECT SUM(price) AS total FROM tickets");
$total_revenue_data = mysqli_fetch_assoc($total_revenue_result);
$total_revenue = $total_revenue_data['total'] ?: 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports</title>
</head>
<body>
    <h1>Reports</h1>
    <p>Automatic performance and billing report.</p>
    
    <div>
        <strong>Total Tickets:</strong>
        <?php echo $total_tickets; ?>
    </div>
    
    <div>
        <strong>Resolved:</strong>
        <?php echo $resolved_tickets; ?>
    </div>
    
    <div>
        <strong>Pending:</strong>
        <?php echo $pending_tickets; ?>
    </div>
    
    <div>
        <strong>Total Revenue: $</strong>
        <?php echo number_format($total_revenue, 2); ?>
    </div>
</body>
</html>