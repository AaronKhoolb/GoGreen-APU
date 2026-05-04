 <!--
    Author: Chong Jun Yoong
    Date: 2026-1-15
    Description: Action to delete an event by admin
-->
<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$event_id = intval($_GET['id']);
$user_id = intval($_SESSION['user_id']);

mysqli_query($conn, "DELETE FROM events WHERE id = $event_id");
mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time) 
                     VALUES ($user_id, 'organizer', 'Event', 'Event id $event_id deleted', NOW())");

header("Location: /GoGreen-APU/frontend/admin/event/index.php");
exit;
