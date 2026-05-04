<?php
/*
    Author: Damian Loh Yi Feng
    Date: 2026-01-20
    Description: Action script to generate attendance code for an event
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

if ($event_id > 0) {
    $code = rand(100, 999); 
    $remaining = 120;
    $update_sql = "UPDATE events SET attendance_code = '$code' WHERE id = $event_id";
    mysqli_query($conn, $update_sql);
    echo "success|" . $code . "|" . $remaining;
} else {
    echo "error|invalid_id|0";
}
exit;
?>