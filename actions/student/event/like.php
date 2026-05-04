<!--
    Author: Khoo Lay Bin
    Date: 2026-1-11
    Description: Student event page like event actions
-->

<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

    $event_id = intval($_POST['event_id']);

    mysqli_query($conn, "UPDATE events SET like_count = like_count + 1 WHERE id = $event_id");


    if (isset($_SESSION['role']) && $_SESSION['role'] == 'student') {
        header("Location: /GoGreen-APU/frontend/student/explore/event/index.php?id=" . $event_id);
    } else {
        header("Location: /GoGreen-APU/frontend/guest/explore/event/index.php?id=" . $event_id);
    }
    exit;
?>