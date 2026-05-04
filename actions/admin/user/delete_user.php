<!--
    Author: Chong Jun Yoong
    Date: 2026-1-26
    Description: Action to delete a user by admin
-->
<?php

session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$user_id = intval($_GET['id']);

$user_query = mysqli_query($conn, "SELECT id, avatar_path, role FROM users WHERE id = $user_id");

if (!$user_query || mysqli_num_rows($user_query) === 0) {
    header('Location: /GoGreen-APU/frontend/admin/User/index.php');
    exit();
}

$user = mysqli_fetch_assoc($user_query);

mysqli_begin_transaction($conn);

mysqli_query($conn, "DELETE FROM event_participants WHERE user_id = $user_id");

mysqli_query($conn, "DELETE FROM comments WHERE user_id = $user_id");

mysqli_query($conn, "DELETE FROM reward_redemptions WHERE user_id = $user_id");

mysqli_query($conn, "DELETE FROM notifications WHERE user_id = $user_id");

$events_query = mysqli_query($conn, "SELECT id FROM events WHERE created_by = $user_id");
while ($event = mysqli_fetch_assoc($events_query)) {
    mysqli_query($conn, "DELETE FROM event_participants WHERE event_id = " . $event['id']);
    mysqli_query($conn, "DELETE FROM comments WHERE event_id = " . $event['id']);
}

mysqli_query($conn, "DELETE FROM events WHERE created_by = $user_id");

mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");

if ($user['avatar_path']) {
    $avatar_path = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/profile/' . $user['avatar_path'];
    if (file_exists($avatar_path)) {
        unlink($avatar_path);
    }
}

mysqli_commit($conn);

header('Location: /GoGreen-APU/frontend/admin/User/index.php?delete_success=1');
exit();
?>
