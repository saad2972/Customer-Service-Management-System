<?php


include("../includes/auth.php");
include("../includes/db_connect.php");


// Fixed: Use the correct session variable
$user_id = $_SESSION['user']['id'];

// Fetch ticket counts with error handling
$total_tickets = 0;
$pending_tickets = 0;
$resolved_tickets = 0;

$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tickets WHERE user_id=$user_id");
if ($total_result) {
    $total_tickets = mysqli_fetch_assoc($total_result)['total'];
}

$pending_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tickets WHERE user_id=$user_id AND status='Pending'");
if ($pending_result) {
    $pending_tickets = mysqli_fetch_assoc($pending_result)['total'];
}

$resolved_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tickets WHERE user_id=$user_id AND status='Resolved'");
if ($resolved_result) {
    $resolved_tickets = mysqli_fetch_assoc($resolved_result)['total'];
}
?>

<?php
// Standardized includes
include("../includes/head.php");
include("../includes/header.php");
?>

    <div class="main-container">
        <?php include("sidebar.php"); ?>

        <div class="main-content">
            <div class="dashboard-header">
                <h1>Customer Dashboard</h1>
                <p>Welcome back, <?php
                                    echo htmlspecialchars($_SESSION['user']['first_name'] ?? 'Customer');
                                    if (isset($_SESSION['user']['last_name'])) {
                                        echo ' ' . htmlspecialchars($_SESSION['user']['last_name']);
                                    }
                                    ?>!</p>
            </div>

            <!-- Stats Cards -->
            <div class="cards">
                <div class="card">
                    <div class="card-icon">🎫</div>
                    <div class="card-content">
                        <h3>Total Tickets</h3>
                        <p class="card-number"><?php echo $total_tickets; ?></p>
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
                    <div class="card-icon">✅</div>
                    <div class="card-content">
                        <h3>Resolved</h3>
                        <p class="card-number"><?php echo $resolved_tickets; ?></p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-section">
                <h2>Quick Actions</h2>
                <div class="quick-actions">
                    <a href="create_ticket.php" class="action-btn">
                        <span class="action-icon">➕</span>
                        Book New Service
                    </a>
                    <a href="my_services.php" class="action-btn">
                        <span class="action-icon">📋</span>
                        View My Services
                    </a>
                    <a href="../profile.php" class="action-btn">
                        <span class="action-icon">👤</span>
                        Update Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php include("../includes/footer.php"); ?>
</body>

</html>