<?php
$require_admin = true;

include("../includes/auth.php");
include("../includes/db_connect.php");
// Use centralized head + header includes
include("../includes/head.php");
include("../includes/header.php");
include("sidebar.php"); // Use admin sidebar
?>

    <div class="main-content">
        <div class="page-header">
            <h1>Manage Tickets</h1>
            <p>View and manage all service tickets</p>
        </div>
    
    <?php
    $result = mysqli_query($conn, "SELECT t.*, u.first_name, u.last_name 
                                   FROM tickets t 
                                   JOIN users u ON t.user_id = u.id 
                                   ORDER BY t.created_at DESC");
    ?>
    
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>User</th>
                        <th>Category</th>
                        <th>Service Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Date Created</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
     <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td>
                    <?php 
                        echo htmlspecialchars($row['first_name']);
                        if (!empty($row['last_name'])) {
                            echo ' ' . htmlspecialchars($row['last_name']);
                        }
                    ?>
                </td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['type']); ?></td>
                <td>$<?php echo number_format($row['price'], 2); ?></td>
                <td>
                    <span class="status-badge status-<?php echo strtolower($row['status']); ?>">
                        <?php echo $row['status']; ?>
                    </span>
                </td>
                <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                <td>
                    <?php if (!empty($row['image'])): ?>
                        <img src="../uploads/tickets/<?php echo $row['image']; ?>" width="60">
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td>
                    <a href="view_ticket.php?id=<?php echo $row['id']; ?>" class="btn-small btn-view">View</a>
                    <a href="update_ticket.php?id=<?php echo $row['id']; ?>" class="btn-small btn-edit">Update</a>
                    <a href="delete_ticket.php?id=<?php echo $row['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this ticket?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php 
mysqli_close($conn);
include("../includes/footer.php"); 
?>