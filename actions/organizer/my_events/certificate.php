<!--
    Author: Khoo Lay Bin
    Date: 2026-1-5
    Description: My Events Generate Certificate Page Actions - upload signature pic, record to db
-->

<?php
    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

    $event_id = intval($_POST['event_id']);
    $user_id = $_SESSION['user_id'];

    
    $file_ext = strtolower(pathinfo($_FILES['signature']['name'], PATHINFO_EXTENSION));
    $new_filename = $event_id . '.' . $file_ext;
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/uploads/cert_seals/';

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    move_uploaded_file($_FILES['signature']['tmp_name'], $upload_dir . $new_filename);

    $check_sql = "SELECT event_id FROM certificate WHERE event_id = $event_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $sql = "UPDATE certificate SET signature_path = '$new_filename', updated_at = NOW(), updated_by = $user_id WHERE event_id = $event_id";
    } else {
        $sql = "INSERT INTO certificate (event_id, signature_path, updated_at, updated_by) VALUES ($event_id, '$new_filename', NOW(), $user_id)";
    }
    mysqli_query($conn, $sql);

    
    if ($_SESSION['role'] == 'admin') {
        header("Location: /GoGreen-APU/frontend/admin/event/certificate.php?id=" . $event_id);
    } elseif ($_SESSION['role'] == 'organizer') {
        header("Location: /GoGreen-APU/frontend/organizer/my_events/certificate.php?id=" . $event_id);
    }
    exit;
?>
