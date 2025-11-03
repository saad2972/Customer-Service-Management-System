<!-- <?php
// Optional: include authentication and database if needed
// This changes is only made for puling 

include("../includes/auth.php");
include("../includes/db_connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Test Page</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <?php include("../includes/header.php"); ?>

  <div class="dashboard-wrapper">
    <?php include("sidebar.php"); ?>

    <div class="main-content">
      <div class="dashboard-header">
        <h1>Test Page</h1>
        <p>This is a test of the layout and styling.</p>
      </div>

      <div class="cards">
        <div class="card">
          <div class="card-icon">🧪</div>
          <div class="card-content">
            <h3>Test Card</h3>
            <p class="card-number">123</p>
          </div>
        </div>
      </div>

      <div class="dashboard-section">
        <h2>Test Table</h2>
        <table class="data-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Sample User</td>
              <td><span class="status-badge status-pending">Pending</span></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Test Admin</td>
              <td><span class="status-badge status-resolved">Resolved</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php include("../includes/footer.php"); ?>
</body>
</html> -->
