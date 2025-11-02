<?php
session_start();
require_once '../includes/db_connect.php';

// Ensure admin access
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Get and validate user id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = 'No user selected.';
    header('Location: manage_users.php');
    exit;
}

$user_id = (int) $_GET['id'];

// Fetch user - Basic W3Schools style
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    $_SESSION['error'] = 'User not found.';
    header('Location: manage_users.php');
    exit;
}

// Fetch tickets - Basic W3Schools style
$ticket_sql = "SELECT id, image, category, type, description, status, created_at 
               FROM tickets 
               WHERE user_id = '$user_id' 
               ORDER BY created_at DESC";
$ticket_result = mysqli_query($conn, $ticket_sql);

$page_title = 'View User: ' . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
include '../includes/head.php';
?>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="dashboard-wrapper">
        <?php include 'sidebar.php'; ?>

        <div class="main-content view-user">
            <!-- Top Bar with Title and Back Button -->
            <div class="user-top-bar">
                <div class="title-section">
                    <h1>View User Details</h1>
                </div>
                <div class="back-button">
                    <a href="manage_users.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                </div>
            </div>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <!-- User Info Section -->
            <div class="user-info-section">
                <div class="user-header">
                    <div class="name-and-role">
                        <h2><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h2>
                        <span class="role-badge role-<?php echo strtolower($user['role']); ?>">
                            <?php echo ucfirst(htmlspecialchars($user['role'])); ?>
                        </span>
                    </div>
                    <div class="edit-button">
                        <a href="update_user.php?id=<?php echo $user_id; ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                    </div>
                </div>

                <!-- User Details Bar -->
                <div class="user-details-bar">
                    <div class="detail-item">
                        <span class="label">Email:</span>
                        <span class="value"><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                    <div class="detail-separator">|</div>
                    <div class="detail-item">
                        <span class="label">Phone:</span>
                        <span class="value"><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></span>
                    </div>
                    <div class="detail-separator">|</div>
                    <div class="detail-item">
                        <span class="label">Member Since:</span>
                        <span class="value"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></span>
                    </div>
                </div>
            </div>

            <!-- Tickets Section -->
            <div class="tickets-section">
                <div class="section-header">
                    <h2>User Tickets</h2>
                    <a href="create_ticket.php?user_id=<?php echo $user_id; ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Ticket
                    </a>
                    </div>
                </div>

                <?php if ($ticket_result && mysqli_num_rows($ticket_result) > 0): ?>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Service</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($ticket = mysqli_fetch_assoc($ticket_result)): ?>
                                    <tr>
                                        <td>#<?php echo htmlspecialchars($ticket['id']); ?></td>
                                        <td><?php echo htmlspecialchars($ticket['category']); ?></td>
                                        <td><?php echo htmlspecialchars($ticket['type']); ?></td>
                                        <td><div class="description-preview" title="<?php echo htmlspecialchars($ticket['description']); ?>"><?php echo htmlspecialchars($ticket['description']); ?></div></td>
                                        <td>
                                            <?php if (!empty($ticket['image'])): ?>
                                                <img src="../uploads/tickets/<?php echo htmlspecialchars($ticket['image']); ?>" alt="Ticket Image" class="ticket-image" onclick="window.open(this.src)" />
                                            <?php else: ?>
                                                <span class="no-image">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="status-badge status-<?php echo strtolower($ticket['status']); ?>"><?php echo ucfirst(htmlspecialchars($ticket['status'])); ?></span></td>
                                        <td><?php echo date('M d, Y', strtotime($ticket['created_at'])); ?></td>
                                        <td class="action-buttons">
                                            <a href="view_ticket.php?id=<?php echo $ticket['id']; ?>" class="btn-small btn-view" title="View"><i class="fas fa-eye"></i>View</a>
                                            <a href="update_ticket.php?id=<?php echo $ticket['id']; ?>" class="btn-small btn-edit" title="Edit"><i class="fas fa-edit"></i>Update</a>
                                            <a href="#" onclick="deleteTicket(<?php echo $ticket['id']; ?>)" class="btn-small btn-danger" title="Delete"><i class="fas fa-trash"></i>Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <h3>No Tickets Found</h3>
                        <p>This user hasn't created any tickets yet.</p>
                        <a href="create_ticket.php?user_id=<?php echo $user_id; ?>" class="btn btn-primary">Create First Ticket</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Delete Ticket</h2>
            <p>Are you sure you want to delete this ticket? This action cannot be undone.</p>
            <div class="modal-actions">
                <button onclick="confirmDelete()" class="btn btn-danger">Delete</button>
                <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>

    <script>
    let ticketToDelete = null;
    function deleteTicket(ticketId) {
        ticketToDelete = ticketId;
        document.getElementById('deleteModal').style.display = 'flex';
    }
    function confirmDelete() {
        if (ticketToDelete) {
            window.location.href = `delete_ticket.php?id=${ticketToDelete}&redirect=view_user.php?id=<?php echo $user_id; ?>`;
        }
    }
    function closeModal() {
        document.getElementById('deleteModal').style.display = 'none';
        ticketToDelete = null;
    }
    </script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
