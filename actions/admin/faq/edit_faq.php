<!-- Author: Chong Ray Han
Date: 2026-1-4
Description: Edit faq logic for admin
-->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/auth/require_login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/index.php');
    exit;
}

$id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : '';
$category = isset($_POST['category']) ? mysqli_real_escape_string($conn, $_POST['category']) : 'general';
$question = isset($_POST['question']) ? mysqli_real_escape_string($conn, $_POST['question']) : '';
$answer = isset($_POST['answer']) ? mysqli_real_escape_string($conn, $_POST['answer']) : '';


if (empty($id) || empty($question) || empty($answer)) {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/edit_faq.php?id=' . $id . '&error=missing_fields');
    exit;
}


$valid_categories = ['general', 'events', 'account', 'rewards'];
if (!in_array($category, $valid_categories)) {
    $category = 'general';
}

$updated_by = $_SESSION['user_id'];

$sql = "UPDATE faq SET 
        category = '$category', 
        question = '$question', 
        answer = '$answer', 
        updated_at = NOW(), 
        updated_by = '$updated_by' 
        WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/index.php?success=updated');
    exit;
} else {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/edit_faq.php?id=' . $id . '&error=db_error');
    exit;
}
