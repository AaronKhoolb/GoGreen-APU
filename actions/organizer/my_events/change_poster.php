<!-- Author: Khoo Lay Bin
Date: 2026-1-4
Description: Change Poster logic
-->
<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$event_id = intval($_POST['event_id']);
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$file = $_FILES['poster'];

$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = $event_id . '.' . $ext;
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/GoGreen-APU/assets/images/event/" . $filename;

move_uploaded_file($file['tmp_name'], $target_dir);
chmod($target_dir, 0644);

mysqli_query($conn, "UPDATE events SET image_path = '$filename', updated_at = NOW(), updated_by = '$user_id' WHERE id = $event_id");
mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time) VALUES ('$user_id', '$role', 'Event', 'Event id $event_id poster updated', NOW())");

$_SESSION['success_message'] = "Poster updated successfully!";

header("Location: /GoGreen-APU/frontend/organizer/my_events/overview.php?id=" . $event_id);
exit;
?>