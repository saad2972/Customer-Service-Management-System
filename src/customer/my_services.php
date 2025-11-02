<?php
// Start session and include required files
session_start();
include("../includes/db_connect.php");

// Check if customer is logged in (W3Schools style)
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: ../login.php');
    exit;
}

// Get user ID from session
$user_id = $_SESSION['user']['id'];

// Get user's service tickets with simple JOIN (W3Schools style)
$sql = "SELECT tickets.*, 
               services.description as service_description 
        FROM tickets 
        LEFT JOIN services ON tickets.category = services.category 
           AND tickets.type = services.type 
        WHERE tickets.user_id = $user_id 
        ORDER BY tickets.created_at DESC";

$result = mysqli_query($conn, $sql);

// Get service statistics
$total_tickets = mysqli_num_rows($result);
$pending_sql = "SELECT COUNT(*) as count FROM tickets WHERE user_id = $user_id AND status = 'Pending'";
$pending_result = mysqli_query($conn, $pending_sql);
$pending_count = mysqli_fetch_assoc($pending_result)['count'];

$resolved_sql = "SELECT COUNT(*) as count FROM tickets WHERE user_id = $user_id AND status = 'Resolved'";
$resolved_result = mysqli_query($conn, $resolved_sql);
$resolved_count = mysqli_fetch_assoc($resolved_result)['count'];

// Include header files
include("../includes/head.php");
include("../includes/header.php");
include("sidebar.php");
?>

    <div class="main-content">
        <!-- Top Section with Stats -->
        <div class="service-stats">
            <div class="stat-card">
                <h3>Total Services</h3>
                <p><?php echo $total_tickets; ?></p>
            </div>
            <div class="stat-card">
                <h3>Pending</h3>
                <p><?php echo $pending_count; ?></p>
            </div>
            <div class="stat-card">
                <h3>Resolved</h3>
                <p><?php echo $resolved_count; ?></p>
            </div>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h1>My Services</h1>
                <p>Track all your service requests</p>
            </div>
            <a href="create_ticket.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Book New Service
            </a>
        </div>

        <!-- Service Tickets Table -->
        <?php if(mysqli_num_rows($result) > 0): ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Service</th>
                            <th>Details</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="text-center">#<?php echo $row['id']; ?></td>
                                <td>
                                    <div class="service-info">
                                        <strong><?php echo htmlspecialchars($row['type']); ?></strong>
                                        <span class="category-badge"><?php echo htmlspecialchars($row['category']); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="ticket-details">
                                        <div class="service-description">
                                            <?php echo htmlspecialchars($row['service_description'] ?? 'No description available'); ?>
                                        </div>
                                        <div class="ticket-date">
                                            Created: <?php echo date('M j, Y', strtotime($row['created_at'])); ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="price">$<?php echo number_format($row['price'], 2); ?></div>
                                </td>
                                <td class="text-center">
                                    <span class="status-badge status-<?php echo strtolower($row['status']); ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="view_ticket.php?id=<?php echo $row['id']; ?>" class="btn-action">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($row['status'] === 'Pending'): ?>
                                            <a href="edit_ticket.php?id=<?php echo $row['id']; ?>" class="btn-action">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h3>No Services Found</h3>
                <p>You haven't booked any services yet.</p>
                <a href="create_ticket.php" class="btn btn-primary">Book Your First Service</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include("../includes/footer.php"); ?>

    <!-- Add some basic CSS styles -->
    <style>
        .service-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: #666;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            color: #333;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .service-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .category-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            background: #f0f0f0;
            border-radius: 4px;
            font-size: 0.875rem;
            color: #666;
        }

        .ticket-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .service-description {
            font-size: 0.875rem;
            color: #666;
        }

        .ticket-date {
            font-size: 0.75rem;
            color: #999;
        }

        .text-center {
            text-align: center;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 4px;
            background: #f0f0f0;
            color: #666;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background: #e0e0e0;
            color: #333;
        }
    </style>
</body>
</html>