<!--
    Author: Khoo Lay Bin
    Date: 2026-1-11
    Description: Student event page registration actions
-->

<?php
    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

    $event_id = intval($_POST['event_id']);
    $user_id = intval($_SESSION['user_id']);

    
    $event_query = "SELECT title, is_paid FROM events WHERE id = $event_id";
    $event_result = mysqli_query($conn, $event_query);
    $event = mysqli_fetch_assoc($event_result);
    $event_title = mysqli_real_escape_string($conn, $event['title']);

    
    $receipt_path = 'NULL';
    if ($event['is_paid'] == 1) {
        $file_name = $event_id . '_' . $user_id . '.pdf';
        $target_path = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/uploads/receipt/' . $file_name;
        move_uploaded_file($_FILES['receipt']['tmp_name'], $target_path);
        chmod($target_path, 0777);
        $receipt_path = "'$file_name'";
    }

    
    mysqli_query($conn, "INSERT INTO event_participants (event_id, user_id, receipt_path, registered_at)  VALUES ($event_id, $user_id, $receipt_path, NOW())");

    mysqli_query($conn, "INSERT INTO notifications (user_id, type, title, message, link_event_id, is_read, created_at)  VALUES ($user_id, 'event', 'Registration Submitted', 'You have requested to register for $event_title. Waiting for approval.', $event_id, 0, NOW())");

    mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time)  VALUES ($user_id, 'student', 'Event', 'Registered for event id $event_id', NOW())");


    header("Location: /GoGreen-APU/frontend/student/explore/event/index.php?id=" . $event_id);
    exit;
?>