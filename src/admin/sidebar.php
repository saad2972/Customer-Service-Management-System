<?php
// Admin sidebar navigation
?>
<div class="sidebar">
    <div class="sidebar-header">
        <h3>Admin Panel</h3>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="dashboard.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">📊</span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            
            <li>
                <a href="manage_users.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'manage_users.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">👥</span>
                    <span class="nav-text">Manage Users</span>
                </a>
            </li>
            
            <li>
                <a href="manage_tickets.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'manage_tickets.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">🎫</span>
                    <span class="nav-text">Manage Tickets</span>
                </a>
            </li>
            
            <li>
                <a href="services.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">⚙️</span>
                    <span class="nav-text">Services & Pricing</span>
                </a>
            </li>
            
            <li>
                <a href="reports.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">📈</span>
                    <span class="nav-text">Reports</span>
                </a>
            </li>
            
            <li>
                <a href="profile.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
                    <span class="nav-icon">👤</span>
                    <span class="nav-text">Admin Profile</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <a href="../logout.php" class="nav-item logout-btn">
            <span class="nav-icon">🚪</span>
            <span class="nav-text">Logout</span>
        </a>
    </div>
</div>