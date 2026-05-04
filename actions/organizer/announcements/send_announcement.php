<!--
    Author: Chong Ray Han
    Date: 2026-01-28
    Description: Send announcement to event participants with optional image attachment
-->

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /GoGreen-APU/auth/login.php');
    exit;
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /GoGreen-APU/frontend/organizer/my_events/index.php');
    exit;
}

$user_id = intval($_SESSION['user_id']);
$event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate inputs
if ($event_id <= 0 || empty($title) || empty($message)) {
    header('Location: /GoGreen-APU/frontend/organizer/announcements/announcements.php?id=' . $event_id . '&error=missing_fields');
    exit;
}

// Verify the user is the organizer of this event or an admin
$check_sql = "SELECT e.id, e.title as event_title, e.created_by 
              FROM events e 
              WHERE e.id = $event_id 
              AND (e.created_by = $user_id OR EXISTS (SELECT 1 FROM users WHERE id = $user_id AND role = 'admin'))";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) == 0) {
    header('Location: /GoGreen-APU/frontend/organizer/my_events/index.php?error=unauthorized');
    exit;
}

$event = mysqli_fetch_assoc($check_result);
$event_title = $event['event_title'];

// Handle image upload
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['image'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (in_array($file['type'], $allowed_types)) {
        // Create announcements upload directory if it doesn't exist
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/uploads/announcements/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Generate unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $event_id . '_' . time() . '.' . $ext;
        $target_path = $upload_dir . $filename;

        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            chmod($target_path, 0644);
            $image_path = $filename;
        }
    }
}

// Insert announcement into announcements table
$title_escaped = mysqli_real_escape_string($conn, $title);
$message_escaped = mysqli_real_escape_string($conn, $message);
$image_path_escaped = $image_path ? mysqli_real_escape_string($conn, $image_path) : null;
$now = date('Y-m-d H:i:s');

if ($image_path_escaped) {
    $insert_announcement_sql = "INSERT INTO announcements (title, message, image_path, target_event_id, created_by, created_at) 
                                VALUES ('$title_escaped', '$message_escaped', '$image_path_escaped', $event_id, $user_id, '$now')";
} else {
    $insert_announcement_sql = "INSERT INTO announcements (title, message, target_event_id, created_by, created_at) 
                                VALUES ('$title_escaped', '$message_escaped', $event_id, $user_id, '$now')";
}

if (!mysqli_query($conn, $insert_announcement_sql)) {
    header('Location: /GoGreen-APU/frontend/organizer/announcements/announcements.php?id=' . $event_id . '&error=db_error');
    exit;
}

// Get all approved participants for this event
$participants_sql = "SELECT ep.user_id 
                     FROM event_participants ep 
                     WHERE ep.event_id = $event_id 
                     AND ep.approval_status = 1";
$participants_result = mysqli_query($conn, $participants_sql);

$notification_count = 0;

// Insert notification for each participant
while ($participant = mysqli_fetch_assoc($participants_result)) {
    $participant_user_id = intval($participant['user_id']);

    $notification_title = "Announcement: " . $title_escaped;
    $notification_message = $message_escaped;

    $insert_notification_sql = "INSERT INTO notifications (user_id, type, title, message, link_event_id, is_read, created_at) 
                                VALUES ($participant_user_id, 'event', '$notification_title', '$notification_message', $event_id, 0, '$now')";

    if (mysqli_query($conn, $insert_notification_sql)) {
        $notification_count++;
    }
}

// Redirect back with success message
header('Location: /GoGreen-APU/frontend/organizer/announcements/announcements.php?id=' . $event_id . '&success=1&count=' . $notification_count);
exit;
