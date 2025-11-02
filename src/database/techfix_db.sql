-- ==========================================================
-- TECHFIX BASIC APP DATABASE (Improved Version)
-- Database: techfix_db
-- Description: Customer Service Management System
-- ==========================================================

CREATE DATABASE IF NOT EXISTS techfix_db;
USE techfix_db;

-- ==========================================================
-- 1. USERS TABLE
-- ==========================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100),
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('user', 'admin') DEFAULT 'user',
    profile_img VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- ==========================================================
-- 2. SERVICES TABLE (Predefined data for category/type/pricing)
-- ==========================================================
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('Hardware', 'Software') NOT NULL,
    type VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_service(category, type)
);

-- ==========================================================
-- 3. TICKETS TABLE
-- ==========================================================
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category ENUM('Hardware', 'Software') NOT NULL,
    type VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    status ENUM('Pending', 'In Progress', 'Resolved', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id(user_id),
    INDEX idx_status(status)
);

-- ==========================================================
-- 4. SERVICE PRICING TABLE (Optional for dynamic billing)
-- ==========================================================
CREATE TABLE service_pricing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('Hardware','Software') NOT NULL,
    type VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    UNIQUE KEY unique_pricing(category, type)
);

-- ==========================================================
-- 5. ADMIN REPORT LOGS
-- ==========================================================
CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_name VARCHAR(150),
    total_tickets INT,
    total_revenue DECIMAL(10,2),
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================================
-- 6. DEFAULT ADMIN ACCOUNT
-- ==========================================================
INSERT INTO users (first_name, last_name, email, password, role)
VALUES ('Muhammad', 'Saad', 'admin@techfix.com', MD5('admin123'), 'admin');

-- ==========================================================
-- 7. DEFAULT SERVICE DATA
-- ==========================================================
-- Hardware Services
INSERT INTO services (category, type, description, price) VALUES
('Hardware', 'Upgrade (RAM & SSD)', 'Upgrade system memory or storage.', 150.00),
('Hardware', 'Cleaning & Maintenance', 'Full system cleaning and maintenance.', 60.00),
('Hardware', 'Repairing', 'Hardware repair for laptops and PCs.', 120.00);

-- Software Services
INSERT INTO services (category, type, description, price) VALUES
('Software', 'Windows Key', 'Windows license and activation service.', 80.00),
('Software', 'Application Key', 'Software activation (Office, Antivirus, etc.)', 50.00),
('Software', 'Driver Pack', 'Driver installation and configuration.', 40.00),
('Software', 'Diagnostic Tools', 'System diagnostics and issue detection.', 70.00);

-- Populate service_pricing table for auto-billing
INSERT INTO service_pricing (category, type, price) VALUES
('Hardware', 'Upgrade (RAM & SSD)', 150.00),
('Hardware', 'Cleaning & Maintenance', 60.00),
('Hardware', 'Repairing', 120.00),
('Software', 'Windows Key', 80.00),
('Software', 'Application Key', 50.00),
('Software', 'Driver Pack', 40.00),
('Software', 'Diagnostic Tools', 70.00);

-- ==========================================================
-- 8. SAMPLE USER (for testing)
-- ==========================================================
INSERT INTO users (first_name, last_name, email, password, role)
VALUES ('Test', 'User', 'user@techfix.com', MD5('user123'), 'user');

-- ==========================================================
-- 9. SAMPLE TICKETS (demo data)
-- ==========================================================
INSERT INTO tickets (user_id, category, type, description, price, status)
VALUES 
(2, 'Hardware', 'Upgrade (RAM & SSD)', 'Upgrade laptop RAM and SSD for performance.', 150.00, 'Resolved'),
(2, 'Software', 'Windows Key', 'Need Windows 11 activation.', 80.00, 'Pending');

-- ==========================================================
-- END OF IMPROVED DATABASE SCRIPT
-- ==========================================================
