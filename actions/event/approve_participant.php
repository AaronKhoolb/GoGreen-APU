<!--
    Author: Khoo Lay Bin
    Date: 2026-1-5
    Description: My Events approve, reject participants actions
-->

<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

    $event_id = intval($_GET['id']);
    $participant_id = intval($_GET['participant_id']);
    $action = $_GET['action'];
    $approver_id = intval($_SESSION['user_id']);
    $role = $_SESSION['role'];

    $result = mysqli_query($conn, "SELECT ep.user_id, e.title FROM event_participants ep JOIN events e ON ep.event_id = e.id WHERE ep.id = $participant_id");
    $data = mysqli_fetch_assoc($result);
    $student_id = $data['user_id'];
    $event_title = $data['title'];

    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE event_participants SET approval_status = 1, approved_by = $approver_id, approved_at = NOW() WHERE id = $participant_id");
        mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time) VALUES ($approver_id, '$role', 'Participant', 'Approved participant id $participant_id for event id $event_id', NOW())");
        mysqli_query($conn, "INSERT INTO notifications (user_id, type, title, message, link_event_id, is_read, created_at) VALUES ($student_id, 'event', 'Registration Approved', 'Your registration for $event_title has been approved!', $event_id, 0, NOW())");
    } else {
        mysqli_query($conn, "UPDATE event_participants SET approval_status = 0, approved_by = $approver_id, approved_at = NOW() WHERE id = $participant_id");
        mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time) VALUES ($approver_id, '$role', 'Participant', 'Rejected participant id $participant_id for event id $event_id', NOW())");
        mysqli_query($conn, "INSERT INTO notifications (user_id, type, title, message, link_event_id, is_read, created_at) VALUES ($student_id, 'event', 'Registration Rejected', 'Your registration for $event_title has been rejected.', $event_id, 0, NOW())");
    }

    if ($role == 'admin') {
        $redirect = "/GoGreen-APU/frontend/admin/event/participants.php?id=$event_id";
    } else {
        $redirect = "/GoGreen-APU/frontend/organizer/my_events/participants.php?id=$event_id";
    }
    header("Location: $redirect");
exit;
