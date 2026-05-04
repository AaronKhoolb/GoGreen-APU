<?php
/*
    Author: Damian Loh Yi Feng
    Date: 2026-01-20
    Description: Action script to manually mark a student (Redirect-based)
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

if (!isset($_SESSION['user_id'])) {
    die("ERROR: Unauthorized access.");
}

$marker_id = $_SESSION['user_id']; 

if (isset($_GET['id']) && isset($_GET['event_id'])) {
    $participant_id = intval($_GET['id']);
    $event_id = intval($_GET['event_id']);

    $check_sql = "SELECT ep.user_id, ep.status, e.coins_earned 
                  FROM event_participants ep
                  JOIN events e ON ep.event_id = e.id
                  WHERE ep.id = $participant_id";
    
    $check_res = mysqli_query($conn, $check_sql);
    $data = mysqli_fetch_assoc($check_res);

    if ($data) {
        if ($data['status'] === 'attended') {
            header("Location: /GoGreen-APU/frontend/admin/event/attendance/index.php?id=" . $event_id . "&msg=already_done");
            exit;
        }

        $student_user_id = $data['user_id'];
        $coins_reward = intval($data['coins_earned']);

        mysqli_begin_transaction($conn);

        try {
            $update_ep = "UPDATE event_participants 
                          SET status = 'attended', 
                              check_in_time = NOW(), 
                              coins_earned = $coins_reward, 
                              marked_by = $marker_id 
                          WHERE id = $participant_id";
            mysqli_query($conn, $update_ep);

            $update_student = "UPDATE students 
                               SET ap_coins = ap_coins + $coins_reward 
                               WHERE user_id = $student_user_id";
            mysqli_query($conn, $update_student);

            mysqli_commit($conn);
            header("Location: /GoGreen-APU/frontend/admin/event/attendance/index.php?id=" . $event_id . "&status=success");
            exit;

        } catch (Exception $e) {
            mysqli_rollback($conn);
            header("Location: /GoGreen-APU/frontend/admin/event/attendance/index.php?id=" . $event_id . "&status=error");
            exit;
        }
    } else {
        die("ERROR: Participant record not found.");
    }
} else {
    die("ERROR: Invalid Request.");
}
?>