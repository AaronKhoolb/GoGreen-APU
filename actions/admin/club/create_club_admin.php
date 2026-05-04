<!-- Author: Chong Ray Han
Date: 2026-1-4
Description: Create club page for admin
-->

<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /GoGreen-APU/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];


if ($role !== 'admin') {
    $_SESSION['error_message'] = "Unauthorized access.";
    header("Location: /GoGreen-APU/index.php");
    exit;
}


$name = mysqli_real_escape_string($conn, $_POST['club_name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$website_link = mysqli_real_escape_string($conn, $_POST['website_link']);


$sql = "INSERT INTO clubs (name, description, logo_path, email, website_link) 
        VALUES ('$name', '$description', 'default.png', '$email', '$website_link')";

if (mysqli_query($conn, $sql)) {
    $new_club_id = mysqli_insert_id($conn);

    if (isset($_FILES['club_logo']) && $_FILES['club_logo']['error'] == 0) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/club/';

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
            chmod($upload_dir, 0777);
        }

        $file_ext = strtolower(pathinfo($_FILES['club_logo']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = $new_club_id . '.' . $file_ext;
            $target_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($_FILES['club_logo']['tmp_name'], $target_path)) {
                chmod($target_path, 0644);
                mysqli_query($conn, "UPDATE clubs SET logo_path = '$new_file_name' WHERE id = $new_club_id");
            }
        }
    }


    $log_details = "Club id $new_club_id created: $name";
    mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time) 
                         VALUES ($user_id, '$role', 'Club', '$log_details', NOW())");

    $_SESSION['success_message'] = "Club created successfully!";
    header("Location: /GoGreen-APU/frontend/admin/club/index.php");
} else {
    $_SESSION['error_message'] = "Error creating club: " . mysqli_error($conn);
    header("Location: /GoGreen-APU/frontend/admin/club/create_club.php");
}
exit;
