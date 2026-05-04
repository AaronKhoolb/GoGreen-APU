<!--
    Author: Chong Jun Yoong
    Date: 2026-2-6
    Description: Action to approve or reject an event by admin
-->

<?php
    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /GoGreen-APU/frontend/admin/event/index.php");
        exit;
    }

    
    $event_id = intval($_POST['event_id']);
    $action = $_POST['action'];
    $user_id = intval($_SESSION['user_id']);

    
    if ($action !== 'approve' && $action !== 'reject') {
        header("Location: /GoGreen-APU/frontend/admin/event/index.php");
        exit;
    }

    
    if ($action === 'approve') {
        $is_approved = 1;
        $log_action = "approved";
    } else {
        $is_approved = 0;
        $log_action = "rejected";
    }

    
    $sql = "UPDATE events SET is_approved = $is_approved, approved_by = $user_id, approved_at = NOW() WHERE id = $event_id";
    mysqli_query($conn, $sql);

    
    $log_sql = "INSERT INTO logs (user_id, role, action, details, date_time) 
                VALUES ($user_id, 'admin', 'Event', 'Event id $event_id $log_action by admin id $user_id', NOW())";
    mysqli_query($conn, $log_sql);

    
    header("Location: /GoGreen-APU/frontend/admin/event/index.php");
    exit;
?>