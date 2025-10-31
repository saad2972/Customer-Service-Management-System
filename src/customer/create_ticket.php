<?php
include("../includes/auth.php");
include("../includes/db_connect.php");
include("sidebar.php"); // Uses customer sidebar

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $user_id = $_SESSION['user']['id']; // Fixed: using user array from session
    $status = "Pending";
    $created_at = date('Y-m-d H:i:s');

    // Get price based on service type
    $price_query = mysqli_query($conn, "SELECT price FROM service_pricing WHERE category='$category' AND type='$type'");
    if ($price_query && mysqli_num_rows($price_query) > 0) {
        $price_row = mysqli_fetch_assoc($price_query);
        $price = $price_row['price'];
    } else {
        $price = 0;
    }

    // Handle image upload
    $image_name = "";
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
        $upload_dir = "../uploads/tickets/";
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        $target = $upload_dir . $image_name;
        
        // Check file type for security
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                // File uploaded successfully
            } else {
                $message = "Error uploading image.";
            }
        } else {
            $message = "Invalid file type. Only JPG, PNG, GIF allowed.";
        }
    }

    // Insert ticket if no error message
    if (empty($message)) {
        $sql = "INSERT INTO tickets (user_id, category, type, price, status, image, created_at)
                VALUES ('$user_id', '$category', '$type', '$price', '$status', '$image_name', '$created_at')";
        
        if (mysqli_query($conn, $sql)) {
            $message = "Ticket created successfully!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service - TechFix</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>
    <?php include("../includes/subheader.php"); ?>

    <div class="main-content">
        <h1>Book a Service</h1>

        <?php if ($message): ?>
            <div class="alert <?php echo strpos($message, 'Error') !== false ? 'alert-error' : 'alert-success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="service-form">
            <div class="form-group">
                <label for="category">Service Category:</label>
                <select name="category" id="category" required onchange="updateServiceTypes()">
                    <option value="">Select Category</option>
                    <option value="Hardware">Hardware</option>
                    <option value="Software">Software</option>
                </select>
            </div>

            <div class="form-group">
                <label for="type">Service Type:</label>
                <select name="type" id="type" required>
                    <option value="">Select Service Type</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
            </div>

            <div class="form-group">
                <label for="image">Upload Image (optional):</label>
                <input type="file" name="image" id="image" accept="image/*">
                <small>Accepted formats: JPG, PNG, GIF (Max: 5MB)</small>
            </div>

            <button type="submit" class="btn btn-primary">Submit Ticket</button>
        </form>
    </div>

    <?php include("../includes/footer.php"); ?>

    <script>
        const serviceTypes = {
            'Hardware': [
                'Repair',
                'Upgrade (RAM/SSD)',
                'Cleaning and Maintenance',
                'Screen Replacement',
                'Battery Replacement'
            ],
            'Software': [
                'Windows Key',
                'Application Key',
                'Driver Pack',
                'Diagnostic Tools',
                'Virus Removal',
                'OS Installation'
            ]
        };

        function updateServiceTypes() {
            const category = document.getElementById('category').value;
            const typeSelect = document.getElementById('type');
            
            // Clear existing options
            typeSelect.innerHTML = '<option value="">Select Service Type</option>';
            
            if (category && serviceTypes[category]) {
                serviceTypes[category].forEach(type => {
                    const option = document.createElement('option');
                    option.value = type;
                    option.textContent = type;
                    typeSelect.appendChild(option);
                });
            }
        }

        // Initialize service types on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateServiceTypes();
        });
    </script>
</body>
</html>