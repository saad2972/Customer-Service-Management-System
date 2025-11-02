<?php
$require_admin = true;

// Database connection
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';

// Get report data
$total_tickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tickets"))['total'];
$resolved_tickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tickets WHERE status = 'resolved'"))['total'];
$pending_tickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tickets WHERE status = 'pending'"))['total'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(price) AS total FROM tickets"))['total'] ?: 0;

// Standardized head + header
$page_title = 'Reports - TechFix';
include('../includes/head.php');
include('../includes/header.php');
?>

    <?php include('sidebar.php'); ?>

    <div class="dashboard-wrapper">
        <div class="main-content">
            <div class="page-header">
                <h1>Reports</h1>
                <p>Automatic performance and billing report.</p>
            </div>

            <div class="cards">
                <div class="card">
                    <div class="card-icon">🎫</div>
                    <div class="card-content">
                        <h3>Total Tickets</h3>
                        <p class="card-number"><?php echo $total_tickets; ?></p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-icon">✅</div>
                    <div class="card-content">
                        <h3>Resolved</h3>
                        <p class="card-number"><?php echo $resolved_tickets; ?></p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-icon">⏳</div>
                    <div class="card-content">
                        <h3>Pending</h3>
                        <p class="card-number"><?php echo $pending_tickets; ?></p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-icon">💰</div>
                    <div class="card-content">
                        <h3>Total Revenue</h3>
                        <p class="card-number">$<?php echo number_format($total_revenue, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>