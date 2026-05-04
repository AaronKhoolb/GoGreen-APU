<!-- 
Author: Chong Ray Han
Date: 2025-12-29
Description: Check if page needs login (student, organizer, collaborator, admin folders)
-->
<?php

$path = $_SERVER['SCRIPT_FILENAME'];

// Check if in protected folder
if (strpos($path, '/frontend/student/') !== false) {
    $need_role = 'student';
} elseif (strpos($path, '/frontend/organizer/') !== false) {
    $need_role = 'organizer';
} elseif (strpos($path, '/frontend/collaborator/') !== false) {
    $need_role = 'collaborator';
} elseif (strpos($path, '/frontend/admin/') !== false) {
    $need_role = 'admin';
} else {
    $need_role = null; // No login needed
}

// If login needed, check it
if ($need_role) {
    // Not logged in?
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header("Location: /GoGreen-APU/auth/login.php?error=Please login to access this page");
        exit();
    }

    // Wrong role?
    if ($_SESSION['role'] !== $need_role) {
        header("Location: /GoGreen-APU/frontend/" . $_SESSION['role'] . "/index.php");
        exit();
    }
}
?>