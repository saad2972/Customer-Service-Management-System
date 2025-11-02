<?php
$require_admin = true;

include("../includes/auth.php");
include("../includes/db_connect.php");
include("../includes/header.php");
include("sidebar.php");

$ticket_id = $_GET['id'] ?? 0;
$message = "";

// Get current ticket data
$ticket_query = mysqli_query($conn, "SELECT * FROM tickets WHERE id = $ticket_id");
$ticket = mysqli_fetch_assoc($ticket_query);

if (!$ticket) {
    echo "Ticket not found!";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    $update_query = "UPDATE tickets SET status = '$status', price = '$price' WHERE id = $ticket_id";
    
    if (mysqli_query($conn, $update_query)) {
        $message = "Ticket updated successfully!";
        // Refresh ticket data
        $ticket_query = mysqli_query($conn, "SELECT * FROM tickets WHERE id = $ticket_id");
        $ticket = mysqli_fetch_assoc($ticket_query);
    } else {
        $message = "Error updating ticket: " . mysqli_error($conn);
    }
}
?>
<head>
    <link rel="stylesheet" href="../css/style.css">
</head>
<div class="main-content">
    <div class="page-header">
        <h1>Update Ticket</h1>
        <a href="manage_tickets.php" class="btn btn-outline">← Back to Tickets</a>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="form-container">
        <form method="post" class="ticket-form">
            <div class="form-group">
                <label>Ticket ID:</label>
                <input type="text" value="#<?php echo $ticket['id']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label>Category:</label>
                <input type="text" value="<?php echo htmlspecialchars($ticket['category']); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label>Service Type:</label>
                <input type="text" value="<?php echo htmlspecialchars($ticket['type']); ?>" readonly>
            </div>
            
            <div class="form-group">
                <label>Status:</label>
                <select name="status" required>
                    <option value="Pending" <?php echo $ticket['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="In Progress" <?php echo $ticket['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="Resolved" <?php echo $ticket['status'] == 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                    <option value="Cancelled" <?php echo $ticket['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Price ($):</label>
                <input type="number" name="price" step="0.01" value="<?php echo $ticket['price']; ?>" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Ticket</button>
                <a href="view_ticket.php?id=<?php echo $ticket['id']; ?>" class="btn btn-outline">View Details</a>
                <a href="manage_tickets.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<div>
    <?php
    mysqli_close($conn);
    include("../includes/footer.php"); 
    ?>
</div>
 