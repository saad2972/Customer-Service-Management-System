<?php if (!isset($_SESSION['user']) || $_SESSION['user']['role'] == 'user'): ?>
    <nav class="subheader">
        <div class="subheader-links">
            <a href="index.php">Home</a>
            <a href="services.php">Services</a>
            <a href="user/create_ticket.php">Book Service</a>
            <a href="user/my_services.php">My Services</a>
        </div>
    </nav>
    <hr>
<?php endif; ?>

