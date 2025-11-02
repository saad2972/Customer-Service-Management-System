<?php
$require_admin = true;

include("../includes/auth.php");
include("../includes/db_connect.php");
// Standardized head + header
include("../includes/head.php");
include("../includes/header.php");

// Get all users from database
$result = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>

    <?php include("sidebar.php"); ?>

    <div class="main-content">
        <div class="page-header">
            <h1>Manage Users</h1>
            <p>View and manage all system users</p>
        </div>

        <?php if(isset($_GET['message'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="user-id">#<?php echo $row['id']; ?></td>
                                <td>
                                    <?php 
                                        echo htmlspecialchars($row['first_name']);
                                        if (!empty($row['last_name'])) {
                                            echo ' ' . htmlspecialchars($row['last_name']);
                                        }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo !empty($row['phone']) ? htmlspecialchars($row['phone']) : 'N/A'; ?></td>
                                <td>
                                    <span class="role-badge role-<?php echo $row['role']; ?>">
                                        <?php echo ucfirst($row['role']); ?>
                                    </span>
                                </td>
                                <td class="date"><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                                <td class="action-cell">
                                    <div class="action-buttons">
                                        <a href="view_user.php?id=<?php echo $row['id']; ?>" class="btn-small btn-view">View</a>
                                        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn-small btn-edit">Edit</a>
                                        <?php if($row['role'] != 'admin'): ?>
                                            <a href="delete_user.php?id=<?php echo $row['id']; ?>" 
                                               class="btn-small btn-danger" 
                                               onclick="return confirm('Are you sure you want to delete this user? This will also delete all their tickets.');">Delete</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="no-data">
                                <div class="empty-state">
                                    <p>No users found.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php 
    mysqli_close($conn);
    include("../includes/footer.php"); 
    ?>
</body>
</html>