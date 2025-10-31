<?php
$require_admin = true;

include("../includes/auth.php");
include("../includes/db_connect.php");

$ticket_id = $_GET['id'] ?? 0;

// Delete ticket
$delete_query = "DELETE FROM tickets WHERE id = $ticket_id";

if (mysqli_query($conn, $delete_query)) {
    header("Location: manage_tickets.php?message=Ticket deleted successfully");
} else {
    header("Location: manage_tickets.php?error=Error deleting ticket");
}

mysqli_close($conn);
exit();
?>