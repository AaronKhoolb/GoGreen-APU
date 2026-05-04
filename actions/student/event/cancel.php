<!--
    Author: Khoo Lay Bin
    Date: 2026-1-11
    Description: Student event page cancel registration actions
-->

<?php
    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

    $event_id = intval($_POST['event_id']);
    $user_id = intval($_SESSION['user_id']);

    
    $event_query = "SELECT title FROM events WHERE id = $event_id";
    $event_result = mysqli_query($conn, $event_query);
    $event = mysqli_fetch_assoc($event_result);
    $event_title = mysqli_real_escape_string($conn, $event['title']);

    
    $participant_query = "SELECT receipt_path FROM event_participants WHERE event_id = $event_id AND user_id = $user_id";
    $participant_result = mysqli_query($conn, $participant_query);
    $participant = mysqli_fetch_assoc($participant_result);
    unlink($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/uploads/receipt/' . $participant['receipt_path']);

    
    mysqli_query($conn, "DELETE FROM event_participants WHERE event_id = $event_id AND user_id = $user_id");

    mysqli_query($conn, "INSERT INTO notifications (user_id, type, title, message, link_event_id, is_read, created_at)  VALUES ($user_id, 'event', 'Registration Cancelled', 'You have cancelled your registration for $event_title.', $event_id, 0, NOW())");
    
    mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time)  VALUES ($user_id, 'student', 'Event', 'Cancelled registration for event id $event_id', NOW())");

    
    header("Location: /GoGreen-APU/frontend/student/explore/event/index.php?id=" . $event_id);
    exit;
?>