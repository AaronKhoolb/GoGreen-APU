<!--
    Author: Chong Jun Yoong
    Date: 2026-01-12
    Description: Action script to create a new event by organizer
-->
<?php

session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$club_query = "SELECT club_id FROM organizers WHERE user_id = $user_id";
$club_result = mysqli_query($conn, $club_query);
$club_row = mysqli_fetch_assoc($club_result);
$club_id = $club_row['club_id'];

$title = mysqli_real_escape_string($conn, $_POST['event_title']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$details = mysqli_real_escape_string($conn, $_POST['details']);
$start_date = $_POST['start_date'];
$start_time = $_POST['start_time'];
$address = mysqli_real_escape_string($conn, $_POST['address']);
$embed_map = mysqli_real_escape_string($conn, $_POST['embed_map']);
$transport_details = mysqli_real_escape_string($conn, $_POST['transportation_details']);
$coins = intval($_POST['coins_earned']);
$max_participants = intval($_POST['max_participants']);
$deadline = $_POST['registration_deadline'];
$phone = mysqli_real_escape_string($conn, $_POST['phone_number']);
$whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);
$facebook = mysqli_real_escape_string($conn, $_POST['facebook']);
$instagram = mysqli_real_escape_string($conn, $_POST['instagram']);
$discord = mysqli_real_escape_string($conn, $_POST['discord']);
$teams = mysqli_real_escape_string($conn, $_POST['teams']);

if (!empty($_POST['end_date'])) {
    $end_date = "'" . $_POST['end_date'] . "'";
} else {
    $end_date = "NULL";
}

$end_time = $_POST['end_time'];

if (isset($_POST['transportation'])) {
    $transportation = 1;
} else {
    $transportation = 0;
}

if (isset($_POST['is_paid'])) {
    $is_paid = 1;
    $price = floatval($_POST['price']);
} else {
    $is_paid = 0;
    $price = 0;
}

if (isset($_POST['sdg1'])) {
    $sdg1 = 1;
} else {
    $sdg1 = 0;
}
if (isset($_POST['sdg2'])) {
    $sdg2 = 1;
} else {
    $sdg2 = 0;
}
if (isset($_POST['sdg3'])) {
    $sdg3 = 1;
} else {
    $sdg3 = 0;
}
if (isset($_POST['sdg4'])) {
    $sdg4 = 1;
} else {
    $sdg4 = 0;
}
if (isset($_POST['sdg5'])) {
    $sdg5 = 1;
} else {
    $sdg5 = 0;
}
if (isset($_POST['sdg6'])) {
    $sdg6 = 1;
} else {
    $sdg6 = 0;
}
if (isset($_POST['sdg7'])) {
    $sdg7 = 1;
} else {
    $sdg7 = 0;
}
if (isset($_POST['sdg8'])) {
    $sdg8 = 1;
} else {
    $sdg8 = 0;
}
if (isset($_POST['sdg9'])) {
    $sdg9 = 1;
} else {
    $sdg9 = 0;
}
if (isset($_POST['sdg10'])) {
    $sdg10 = 1;
} else {
    $sdg10 = 0;
}
if (isset($_POST['sdg11'])) {
    $sdg11 = 1;
} else {
    $sdg11 = 0;
}
if (isset($_POST['sdg12'])) {
    $sdg12 = 1;
} else {
    $sdg12 = 0;
}
if (isset($_POST['sdg13'])) {
    $sdg13 = 1;
} else {
    $sdg13 = 0;
}
if (isset($_POST['sdg14'])) {
    $sdg14 = 1;
} else {
    $sdg14 = 0;
}
if (isset($_POST['sdg15'])) {
    $sdg15 = 1;
} else {
    $sdg15 = 0;
}
if (isset($_POST['sdg16'])) {
    $sdg16 = 1;
} else {
    $sdg16 = 0;
}
if (isset($_POST['sdg17'])) {
    $sdg17 = 1;
} else {
    $sdg17 = 0;
}

$sql = "INSERT INTO events (
    club_id, title, short_description, details,
    image_path, 
    start_date, start_time, end_date, end_time,
    location, embed_map,
    transportation, transport_details,
    coins_earned, max_participants, registration_deadline,
    is_paid, price,
    sdg1, sdg2, sdg3, sdg4, sdg5, sdg6, sdg7, sdg8, sdg9, sdg10,
    sdg11, sdg12, sdg13, sdg14, sdg15, sdg16, sdg17,
    phone_no, whatsapp, facebook, instagram, discord, teams,
    created_at, created_by, updated_at, updated_by
) VALUES (
    $club_id, '$title', '$description', '$details',
    'default.png',
    '$start_date', '$start_time', $end_date, '$end_time',
    '$address', '$embed_map',
    $transportation, '$transport_details',
    $coins, $max_participants, '$deadline',
    $is_paid, $price,
    $sdg1, $sdg2, $sdg3, $sdg4, $sdg5, $sdg6, $sdg7, $sdg8, $sdg9, $sdg10,
    $sdg11, $sdg12, $sdg13, $sdg14, $sdg15, $sdg16, $sdg17,
    '$phone', '$whatsapp', '$facebook', '$instagram', '$discord', '$teams',
    NOW(), $user_id, NOW(), $user_id
)";
mysqli_query($conn, $sql);
$new_event_id = mysqli_insert_id($conn);

if (isset($_FILES['event_cover']) && $_FILES['event_cover']['error'] == 0) {
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/event/';

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
        chmod($upload_dir, 0777);
    }

    $file_ext = strtolower(pathinfo($_FILES['event_cover']['name'], PATHINFO_EXTENSION));
    $new_file_name = $new_event_id . '.' . $file_ext;
    $target_path = $upload_dir . $new_file_name;

    move_uploaded_file($_FILES['event_cover']['tmp_name'], $target_path);
    chmod($target_path, 0644);

    mysqli_query($conn, "UPDATE events SET image_path = '$new_file_name' WHERE id = $new_event_id");
}

mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time) 
                     VALUES ($user_id, '$role', 'Event', 'Event id $new_event_id created', NOW())");

$_SESSION['success_message'] = "Event created successfully!";
header("Location: /GoGreen-APU/frontend/organizer/my_events/index.php");
exit;
?>