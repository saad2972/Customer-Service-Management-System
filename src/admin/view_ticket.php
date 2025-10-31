<?php
$require_admin = true;
include("../includes/auth.php");
include("../includes/db_connect.php");
include("../includes/header.php");
include("sidebar.php");

// Get ticket ID from URL
$ticket_id = $_GET['id'] ?? 0;

// Get ticket details
$ticket_query = mysqli_query($conn, "SELECT t.*, u.username, u.email 
                                    FROM tickets t 
                                    JOIN users u ON t.user_id = u.id 
                                    WHERE t.id = $ticket_id");
$ticket = mysqli_fetch_assoc($ticket_query);

if (!$ticket) {
    echo "Ticket not found!";
    exit();
}
?>

<div class="main-content">
    <div class="page-header">
        <h1>Ticket Details</h1>
        <a href="manage_tickets.php" class="btn btn-outline">← Back to Tickets</a>
    </div>

    <div class="ticket-details">
        <div class="detail-card">
            <h3>Ticket Information</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <label>Ticket ID:</label>
                    <span>#<?php echo $ticket['id']; ?></span>
                </div>
                <div class="detail-item">
                    <label>User:</label>
                    <span><?php echo htmlspecialchars($ticket['username']); ?></span>
                </div>
                <div class="detail-item">
                    <label>Email:</label>
                    <span><?php echo htmlspecialchars($ticket['email']); ?></span>
                </div>
                <div class="detail-item">
                    <label>Category:</label>
                    <span><?php echo htmlspecialchars($ticket['category']); ?></span>
                </div>
                <div class="detail-item">
                    <label>Service Type:</label>
                    <span><?php echo htmlspecialchars($ticket['type']); ?></span>
                </div>
                <div class="detail-item">
                    <label>Price:</label>
                    <span>$<?php echo number_format($ticket['price'], 2); ?></span>
                </div>
                <div class="detail-item">
                    <label>Status:</label>
                    <span class="status-badge status-<?php echo strtolower($ticket['status']); ?>">
                        <?php echo $ticket['status']; ?>
                    </span>
                </div>
                <div class="detail-item">
                    <label>Created:</label>
                    <span><?php echo date('M j, Y g:i A', strtotime($ticket['created_at'])); ?></span>
                </div>
            </div>
        </div>

        <?php if (!empty($ticket['image'])): ?>
        <div class="detail-card">
            <h3>Attached Image</h3>
            <img src="../uploads/tickets/<?php echo htmlspecialchars($ticket['image']); ?>" 
                 alt="Ticket Image" class="ticket-detail-image">
        </div>
        <?php endif; ?>

        <div class="action-buttons">
            <a href="update_ticket.php?id=<?php echo $ticket['id']; ?>" class="btn btn-primary">Update Ticket</a>
            <a href="manage_tickets.php" class="btn btn-outline">Back to List</a>
        </div>
    </div>
</div>

<?php 
mysqli_close($conn);
include("../includes/footer.php"); 
?>