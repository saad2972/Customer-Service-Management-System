<?php
// Start session and include required files
session_start();
include("../includes/db_connect.php");


// Check if admin is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Get ticket ID from URL
$ticket_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Basic W3Schools style query to get ticket details
$sql = "SELECT t.*, u.first_name, u.last_name, u.email 
        FROM tickets t 
        JOIN users u ON t.user_id = u.id 
        WHERE t.id = $ticket_id";
$result = mysqli_query($conn, $sql);
$ticket = mysqli_fetch_assoc($result);

// If ticket not found, show error
if (!$ticket) {
    $_SESSION['error'] = "Ticket not found!";
    header('Location: manage_tickets.php');
    exit;
}

// Include header and sidebar
include("../includes/header.php");
include("sidebar.php");
include("../includes/head.php");
?>

<div class="main-content view-ticket">
    <!-- Top Bar with Title and Back Button -->
    <div class="ticket-top-bar">
        <div class="title-section">
            <h1>View Ticket #<?php echo $ticket_id; ?></h1>
        </div>
        <div class="back-button">
            <a href="manage_tickets.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Tickets
            </a>
        </div>
    </div>

    <!-- Action Buttons Bar -->
    <div class="ticket-action-bar">
        <a href="update_ticket.php?id=<?php echo $ticket_id; ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Update Ticket
        </a>
        <a href="view_user.php?id=<?php echo $ticket['user_id']; ?>" class="btn btn-primary">
            <i class="fas fa-user"></i> View Customer
        </a>
        <a href="#" onclick="if(confirm('Are you sure you want to delete this ticket?')) window.location.href='delete_ticket.php?id=<?php echo $ticket_id; ?>'" 
           class="btn btn-danger">
            <i class="fas fa-trash"></i> Delete Ticket
        </a>
    </div>

    <!-- Show success/error messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Ticket Details -->
    <div class="ticket-details">
        <table class="details-table">
            <tr>
                <th>Customer Name:</th>
                <td><?php echo htmlspecialchars($ticket['first_name'] . ' ' . $ticket['last_name']); ?></td>
            </tr>
            <tr>
                <th>Customer Email:</th>
                <td><?php echo htmlspecialchars($ticket['email']); ?></td>
            </tr>
            <tr>
                <th>Category:</th>
                <td><?php echo htmlspecialchars($ticket['category']); ?></td>
            </tr>
            <tr>
                <th>Service Type:</th>
                <td><?php echo htmlspecialchars($ticket['type']); ?></td>
            </tr>
            <tr>
                <th>Price:</th>
                <td>$<?php echo number_format($ticket['price'], 2); ?></td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>
                    <span class="status-badge status-<?php echo strtolower($ticket['status']); ?>">
                        <?php echo htmlspecialchars($ticket['status']); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th>Created Date:</th>
                <td><?php echo date('F j, Y, g:i a', strtotime($ticket['created_at'])); ?></td>
            </tr>
            <?php if ($ticket['description']): ?>
            <tr>
                <th>Description:</th>
                <td><?php echo nl2br(htmlspecialchars($ticket['description'])); ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <!-- Show ticket image if exists -->
        <?php if (!empty($ticket['image'])): ?>
            <div class="ticket-image">
                <h3>Ticket Image</h3>
                <img src="../uploads/tickets/<?php echo htmlspecialchars($ticket['image']); ?>" 
                     alt="Ticket Image">
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
// Close database connection and include footer
mysqli_close($conn);
include("../includes/footer.php"); 
?>