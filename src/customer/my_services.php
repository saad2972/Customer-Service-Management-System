<?php

$require_customer = true;
include("../includes/auth.php");
include("../includes/db_connect.php");
include("sidebar.php"); // Uses customer sidebar

$user_id = $_SESSION['user']['id']; // Fixed session variable
$result = mysqli_query($conn, "SELECT * FROM tickets WHERE user_id=$user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Services - TechFix</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <?php include("../includes/subheader.php"); ?>

    <div class="main-content">
        <div class="page-header">
            <h1>My Services</h1>
            <p>All your service requests appear below:</p>
        </div>

        <?php if(mysqli_num_rows($result) > 0): ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Category</th>
                            <th>Service Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Date Created</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="ticket-id">#<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>
                                <td class="price">$<?php echo number_format($row['price'], 2); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $row['status'])); ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td class="date"><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                                <td class="image-cell">
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="../uploads/tickets/<?php echo htmlspecialchars($row['image']); ?>" 
                                             alt="Ticket Image" 
                                             class="ticket-image"
                                             onerror="this.style.display='none'">
                                    <?php else: ?>
                                        <span class="no-image">No Image</span>
                                    <?php endif; ?>
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
                <p>You haven't created any service requests yet.</p>
                <a href="create_ticket.php" class="btn btn-primary">Book Your First Service</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include("../includes/footer.php"); ?>
</body>
</html>