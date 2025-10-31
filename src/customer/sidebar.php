<?php
// customer/sidebar.php - Simple customer sidebar
?>
<div class="sidebar">
    <div class="sidebar-header">
        <h3>My Account</h3>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="dashboard.php" class="nav-item">
                    <span class="nav-icon">📊</span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            
            <li>
                <a href="create_ticket.php" class="nav-item">
                    <span class="nav-icon">➕</span>
                    <span class="nav-text">Book Service</span>
                </a>
            </li>
            
            <li>
                <a href="my_services.php" class="nav-item">
                    <span class="nav-icon">📋</span>
                    <span class="nav-text">My Services</span>
                </a>
            </li>
            
            <li>
                <a href="../profile.php" class="nav-item">
                    <span class="nav-icon">👤</span>
                    <span class="nav-text">My Profile</span>
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