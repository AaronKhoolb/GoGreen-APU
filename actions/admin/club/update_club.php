<!-- Author: Chong Ray Han
Date: 2026-02-05
Description: Update club information for admin
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

// Get club ID
$club_id = isset($_POST['club_id']) ? intval($_POST['club_id']) : 0;

if ($club_id <= 0) {
    $_SESSION['error_message'] = "Invalid club ID.";
    header("Location: /GoGreen-APU/frontend/admin/club/index.php");
    exit;
}

// Check if club exists
$check_query = "SELECT * FROM clubs WHERE id = $club_id";
$check_result = mysqli_query($conn, $check_query);

if (!$check_result || mysqli_num_rows($check_result) == 0) {
    $_SESSION['error_message'] = "Club not found.";
    header("Location: /GoGreen-APU/frontend/admin/club/index.php");
    exit;
}

$old_club = mysqli_fetch_assoc($check_result);

// Get form data
$name = mysqli_real_escape_string($conn, $_POST['club_name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$website_link = mysqli_real_escape_string($conn, $_POST['website_link']);

// Update club info
$sql = "UPDATE clubs SET 
        name = '$name', 
        description = '$description', 
        email = '$email', 
        website_link = '$website_link' 
        WHERE id = $club_id";

if (mysqli_query($conn, $sql)) {
    if (isset($_FILES['club_logo']) && $_FILES['club_logo']['error'] == 0) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/club/';

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
            chmod($upload_dir, 0777);
        }

        $file_ext = strtolower(pathinfo($_FILES['club_logo']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = $club_id . '.' . $file_ext;
            $target_path = $upload_dir . $new_file_name;

            // Delete old logo if it exists and is different from default
            if (!empty($old_club['logo_path']) && $old_club['logo_path'] !== 'default.png') {
                $old_logo_path = $upload_dir . $old_club['logo_path'];
                // Only delete if the new file has a different extension
                if ($old_club['logo_path'] !== $new_file_name && file_exists($old_logo_path)) {
                    unlink($old_logo_path);
                }
            }

            if (move_uploaded_file($_FILES['club_logo']['tmp_name'], $target_path)) {
                chmod($target_path, 0644);
                mysqli_query($conn, "UPDATE clubs SET logo_path = '$new_file_name' WHERE id = $club_id");
            }
        } else {
            $_SESSION['error_message'] = "Club updated, but logo upload failed: Invalid file type.";
            header("Location: /GoGreen-APU/frontend/admin/club/manage_club.php?id=$club_id");
            exit;
        }
    }

    $log_details = "Club id $club_id updated: $name";
    mysqli_query($conn, "INSERT INTO logs (user_id, role, action, details, date_time) 
                         VALUES ($user_id, '$role', 'Club', '$log_details', NOW())");

    $_SESSION['success_message'] = "Club updated successfully!";
    header("Location: /GoGreen-APU/frontend/admin/club/index.php");
} else {
    $_SESSION['error_message'] = "Error updating club: " . mysqli_error($conn);
    header("Location: /GoGreen-APU/frontend/admin/club/manage_club.php?id=$club_id");
}
exit;
