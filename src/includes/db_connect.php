<?php
// Database Connection

$servername = "localhost";
$username = "root";    // default for XAMPP/WAMP
$password = "";        // leave blank unless you set one
$dbname = "techfix_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
