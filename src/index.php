session_start();
<?php
include("includes/db_connect.php");
session_start();

// Standardized head + header
$page_title = 'TechFix - Home';
include('includes/head.php');
?>

<html>

<body class="landing-page">
    <?php
    include('includes/header.php');
    include('includes/subheader.php');
    ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-flex">
            <div class="hero-content">
                <h1>Welcome to <span class="highlight">TechFix</span></h1>
                <p class="hero-subtitle">
                    Your reliable customer service management solution for all tech needs
                </p>
                <div class="hero-buttons">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                            <a href="admin/dashboard.php" class="btn btn-primary">Admin Dashboard</a>
                        <?php else: ?>
                            <a href="user/dashboard.php" class="btn btn-primary">Your Dashboard</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Sign In</a>
                        <a href="register.php" class="btn btn-secondary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hero-image">
                <img src="assets/img/hero-tech.png" alt="Tech Support" />
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <h2>Our Services</h2>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🔧</div>
                    <h3>Hardware Repair</h3>
                    <p>Professional repair services for computers, laptops, and devices.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">💻</div>
                    <h3>Software Support</h3>
                    <p>Operating system installation, virus removal, and app troubleshooting.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🌐</div>
                    <h3>Network Solutions</h3>
                    <p>WiFi setup, configuration, and connectivity issue resolutions.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📱</div>
                    <h3>Mobile Services</h3>
                    <p>Screen repair, battery replacement, and device optimization.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works">
        <div class="container">
            <h2>How It Works</h2>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Book Service</h3>
                    <p>Schedule your service appointment online easily.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Expert Diagnosis</h3>
                    <p>Certified technicians assess and identify the issue.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Quick Repair</h3>
                    <p>We repair your device using genuine parts and best practices.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Quality Check</h3>
                    <p>Thorough testing to ensure your device runs perfectly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container stats-grid">
            <div class="stat">
                <h3>10,000+</h3>
                <p>Devices Repaired</p>
            </div>
            <div class="stat">
                <h3>98%</h3>
                <p>Customer Satisfaction</p>
            </div>
            <div class="stat">
                <h3>24/7</h3>
                <p>Support Available</p>
            </div>
            <div class="stat">
                <h3>50+</h3>
                <p>Certified Technicians</p>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <h2>What Our Customers Say</h2>
            <div class="testimonial-grid">
                <div class="testimonial">
                    <p>"TechFix saved my business when our server crashed. Fast and professional service!"</p>
                    <div class="customer">
                        <strong>Sarah Johnson</strong>
                        <span>Small Business Owner</span>
                    </div>
                </div>
                <div class="testimonial">
                    <p>"My laptop was fixed in under 2 hours. The pricing was transparent and fair."</p>
                    <div class="customer">
                        <strong>Mike Chen</strong>
                        <span>Student</span>
                    </div>
                </div>
                <div class="testimonial">
                    <p>"Excellent service! They explained everything clearly and fixed my phone quickly."</p>
                    <div class="customer">
                        <strong>Emily Rodriguez</strong>
                        <span>Marketing Manager</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Get Your Tech Fixed?</h2>
            <p>Join thousands of satisfied customers who trust TechFix with their devices.</p>
            <div class="cta-buttons">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="user/create_ticket.php" class="btn btn-large">Book Service Now</a>
                <?php else: ?>
                    <a href="register.php" class="btn btn-large">Get Started Today</a>
                    <a href="login.php" class="btn btn-large btn-outline">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>
</body>

</html>