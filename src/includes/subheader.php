<?php 
// Only show subheader on index.php
$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page === 'index.php'): 
?>
    <nav class="subheader">
        <div class="subheader-links">
            <a href="#home">Home</a>
            <a href="#services">Services</a>
            <a href="#about">About Us</a>
            <a href="#how-it-works">How It Works</a>
            <a href="#contact">Contact</a>
            <?php if (!isset($_SESSION['user'])): ?>
                <a href="register.php">Get Started</a>
            <?php endif; ?>
        </div>
    </nav>
<?php endif; ?>

