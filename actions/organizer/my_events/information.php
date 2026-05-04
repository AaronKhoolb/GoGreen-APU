<!--
    Author: Khoo Lay Bin
    Date: 2026-1-24
    Description: Update event information actions file (for admin, organizer and collaborator)
-->

<?php

include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');


if (!empty($_POST['end_date'])) {
    $end_date = "'{$_POST['end_date']}'";
} else {
    $end_date = "NULL";
}


if (isset($_POST['transportation'])) {
    $transportation = 1;
} else {
    $transportation = 0;
}

if (isset($_POST['is_paid'])) {
    $is_paid = 1;
} else {
    $is_paid = 0;
}


if (isset($_POST['price'])) {
    $price = $_POST['price'];
} else {
    $price = 0;
}


for ($i = 1; $i <= 17; $i++) {
    if (isset($_POST["sdg$i"])) {
        ${"sdg$i"} = 1;
    } else {
        ${"sdg$i"} = 0;
    }
}

$transport_details = mysqli_real_escape_string($conn, $_POST['transportation_details']);

$sql = "UPDATE events SET 
    title = '{$_POST['event_title']}', 
    short_description = '{$_POST['description']}', 
    details = '{$_POST['details']}',
    start_date = '{$_POST['start_date']}', 
    start_time = '{$_POST['start_time']}', 
    end_date = $end_date, 
    end_time = '{$_POST['end_time']}',
    location = '{$_POST['address']}', 
    embed_map = '{$_POST['embed_map']}',
    transportation = $transportation, 
    transport_details = '$transport_details',
    coins_earned = {$_POST['coins_earned']}, 
    max_participants = {$_POST['max_participants']}, 
    registration_deadline = '".str_replace('T', ' ', $_POST['registration_deadline'])."',
    is_paid = $is_paid, 
    price = $price,
    sdg1 = $sdg1, sdg2 = $sdg2, sdg3 = $sdg3, sdg4 = $sdg4, sdg5 = $sdg5,
    sdg6 = $sdg6, sdg7 = $sdg7, sdg8 = $sdg8, sdg9 = $sdg9, sdg10 = $sdg10,
    sdg11 = $sdg11, sdg12 = $sdg12, sdg13 = $sdg13, sdg14 = $sdg14, sdg15 = $sdg15,
    sdg16 = $sdg16, sdg17 = $sdg17,
    phone_no = '{$_POST['phone_number']}', 
    whatsapp = '{$_POST['whatsapp']}', 
    facebook = '{$_POST['facebook']}', 
    instagram = '{$_POST['instagram']}', 
    discord = '{$_POST['discord']}', 
    teams = '{$_POST['teams']}',
    updated_at = NOW(), 
    updated_by = {$_SESSION['user_id']}
    WHERE id = {$_POST['event_id']}";

mysqli_query($conn, $sql);
mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time) VALUES ({$_SESSION['user_id']}, '{$_SESSION['role']}', 'Event', 'Event id {$_POST['event_id']} information updated', NOW())");

if ($_SESSION['role'] == 'admin') {
    header("Location: /GoGreen-APU/frontend/admin/event/information.php?id={$_POST['event_id']}");
} else if ($_SESSION['role'] == 'organizer') {
    header("Location: /GoGreen-APU/frontend/organizer/my_events/information.php?id={$_POST['event_id']}");
} else if ($_SESSION['role'] == 'collaborator') {
    header("Location: /GoGreen-APU/frontend/collaborator/edit_details/index.php?id={$_POST['event_id']}");
}
exit;
?>
