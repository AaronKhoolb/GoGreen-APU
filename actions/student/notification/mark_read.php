<!--
    Author: Chong Ray Han
    Date: 2026-01-28
    Description: Mark notification as read
-->

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

// Base redirect URL
$redirect_url = '/GoGreen-APU/frontend/student/notification/index.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: " . $redirect_url . "?error=not_logged_in");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Get action type: 'single' or 'all'
$action = isset($_GET['action']) ? $_GET['action'] : 'single';

// Preserve filter if set
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$filter_param = $filter ? "&filter=" . urlencode($filter) : "";

if ($action == 'all') {
    // Mark all notifications as read for this user
    $sql = "UPDATE notifications SET is_read = 1 WHERE user_id = $user_id AND is_read = 0";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $affected = mysqli_affected_rows($conn);
        header("Location: " . $redirect_url . "?success=marked_all&count=" . $affected . $filter_param);
    } else {
        header("Location: " . $redirect_url . "?error=db_error" . $filter_param);
    }
} else {
    // Mark single notification as read
    if (!isset($_GET['id'])) {
        header("Location: " . $redirect_url . "?error=missing_id" . $filter_param);
        exit;
    }

    $notification_id = intval($_GET['id']);

    // Verify the notification belongs to this user
    $check_sql = "SELECT id FROM notifications WHERE id = $notification_id AND user_id = $user_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) == 0) {
        header("Location: " . $redirect_url . "?error=not_found" . $filter_param);
        exit;
    }

    $sql = "UPDATE notifications SET is_read = 1 WHERE id = $notification_id AND user_id = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: " . $redirect_url . "?success=marked&id=" . $notification_id . $filter_param);
    } else {
        header("Location: " . $redirect_url . "?error=db_error" . $filter_param);
    }
}
?>