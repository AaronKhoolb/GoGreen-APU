<!-- Author: Chong Ray Han
Date: 2026-1-4
Description: Delete faq logic
-->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/auth/require_login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php';


if (!isset($_GET['id'])) {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/index.php?error=missing_id');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

$sql = "DELETE FROM faq WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/index.php?success=deleted');
    exit;
} else {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/index.php?error=db_error');
    exit;
}
