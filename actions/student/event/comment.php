<!--
    Author: Khoo Lay Bin
    Date: 2026-1-11
    Description: Student event page add comment actions
-->

<?php
    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

    $event_id = intval($_POST['event_id']);
    $comment = mysqli_real_escape_string($conn, trim($_POST['comment']));
    $user_id = intval($_SESSION['user_id']);

    
    mysqli_query($conn, "INSERT INTO comments (event_id, user_id, comment, coins_awarded, created_at) VALUES ($event_id, $user_id, '$comment', 5, NOW())");

    mysqli_query($conn, "UPDATE students SET ap_coins = ap_coins + 5 WHERE user_id = $user_id");

    mysqli_query($conn, "INSERT INTO notifications (user_id, type, title, message, link_event_id, is_read, created_at) VALUES ($user_id, 'reward', 'Comment Reward', 'You earned 5 AP Coins for commenting!', $event_id, 0, NOW())");

    mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time) VALUES ($user_id, 'student', 'Comment', 'Commented on event id $event_id', NOW())");


    
    header("Location: /GoGreen-APU/frontend/student/explore/event/index.php?id=" . $event_id);
    exit;
?>