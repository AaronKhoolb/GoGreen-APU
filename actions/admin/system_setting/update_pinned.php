<!--
    Author: Khoo Lay Bin
    Date: 2026-1-23
    Description: Actions for pinned post in student hero section carousel and send announcement for advertise event
-->

<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$event_id = intval($_POST['event_id']);


$pinned = isset($_POST['pinned']) ? 1 : 0;
$user_id = $_SESSION['user_id'];


mysqli_query($conn, "UPDATE events SET pinned = $pinned WHERE id = $event_id");


$action_text = $pinned == 1 ? "Pinned event id $event_id" : "Unpinned event id $event_id";
mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time) VALUES ($user_id, 'admin', 'Pinned Post', '$action_text', NOW())");


if ($pinned == 1) {
    $event = mysqli_fetch_assoc(mysqli_query($conn, "SELECT title, short_description FROM events WHERE id = $event_id"));
    if ($event) {
        $title = mysqli_real_escape_string($conn, $event['title']);
        $message = mysqli_real_escape_string($conn, $event['short_description']);

        
        mysqli_query($conn, "INSERT INTO announcements (title, message, target_event_id, created_by, created_at) VALUES ('$title', '$message', $event_id, $user_id, NOW())");

        
        $students = mysqli_query($conn, "SELECT user_id FROM students");
        while ($s = mysqli_fetch_assoc($students)) {
            mysqli_query($conn, "INSERT INTO notifications (user_id, type, title, message, link_event_id, is_read, created_at) VALUES ({$s['user_id']}, 'event', 'Announcement: $title', '$message', $event_id, 0, NOW())");
        }
    }
}

header("Location: /GoGreen-APU/frontend/admin/system_setting/pinned_post/index.php");
exit;
?>