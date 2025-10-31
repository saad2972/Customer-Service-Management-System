<?php
$require_admin = true;

include("../includes/auth.php");
include("../includes/db_connect.php");
include("../includes/header.php");
include("sidebar.php");

// Get all counts safely
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$total_tickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tickets"))['total'];
$pending_tickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tickets WHERE status='Pending'"))['total'];
$resolved_tickets = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tickets WHERE status='Completed'"))['total']; // Fixed: Your DB uses 'Completed' not 'Resolved'

// Get recent tickets for activity overview - FIXED VARIABLE NAME
$recent_tickets_query = "SELECT t.*, u.first_name, u.last_name 
                         FROM tickets t 
                         JOIN users u ON t.user_id = u.id 
                         ORDER BY t.created_at DESC 
                         LIMIT 5";
$recent_tickets_result = mysqli_query($conn, $recent_tickets_query); // FIXED: Changed $recent_tickets to $recent_tickets_result
?>

<div class="main-content">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, <?php 
            echo htmlspecialchars($_SESSION['user']['first_name'] ?? 'Admin');
            if (isset($_SESSION['user']['last_name'])) {
                echo ' ' . htmlspecialchars($_SESSION['user']['last_name']);
            }
        ?>!</p>
    </div>

    <!-- Stats Cards -->
    <div class="cards">
        <div class="card">
            <div class="card-icon">👥</div>
            <div class="card-content">
                <h3>Total Users</h3>
                <p class="card-number"><?php echo $total_users; ?></p>
            </div>
        </div>
        
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
                <h3>Pending Tickets</h3>
                <p class="card-number"><?php echo $pending_tickets; ?></p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-icon">✅</div>
            <div class="card-content">
                <h3>Completed Tickets</h3> <!-- Fixed: Changed from Resolved to Completed -->
                <p class="card-number"><?php echo $resolved_tickets; ?></p>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="dashboard-section">
        <h2>Recent Tickets</h2>
        <?php if($recent_tickets_result && mysqli_num_rows($recent_tickets_result) > 0): ?> <!-- FIXED LINE 77: Added error check -->
            <div class="recent-tickets">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>User</th>
                            <th>Category</th>
                            <th>Service Type</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($ticket = mysqli_fetch_assoc($recent_tickets_result)): ?>
                            <tr>
                                <td>#<?php echo $ticket['id']; ?></td>
                                <td>
                                    <?php 
                                        echo htmlspecialchars($ticket['first_name']);
                                        if (!empty($ticket['last_name'])) {
                                            echo ' ' . htmlspecialchars($ticket['last_name']);
                                        }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($ticket['category']); ?></td>
                                <td><?php echo htmlspecialchars($ticket['type']); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $ticket['status'])); ?>">
                                        <?php echo $ticket['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($ticket['created_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-data">No tickets found.</p>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="dashboard-section">
        <h2>Quick Actions</h2>
        <div class="quick-actions">
            <a href="manage_users.php" class="action-btn">
                <span class="action-icon">👥</span>
                Manage Users
            </a>
            <a href="manage_tickets.php" class="action-btn">
                <span class="action-icon">🎫</span>
                Manage Tickets
            </a>
            <a href="services.php" class="action-btn">
                <span class="action-icon">⚙️</span>
                Manage Services
            </a>
            <a href="reports.php" class="action-btn">
                <span class="action-icon">📊</span>
                View Reports
            </a>
        </div>
    </div>
</div>

<?php 
mysqli_close($conn);
include("../includes/footer.php"); 
?>