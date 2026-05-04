<!-- Author: Chong Ray Han
Date: 2026-1-4
Description: Add faq logic for admin 
-->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/auth/require_login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/index.php');
    exit;
}


$category = isset($_POST['category']) ? mysqli_real_escape_string($conn, $_POST['category']) : 'general';
$question = isset($_POST['question']) ? mysqli_real_escape_string($conn, $_POST['question']) : '';
$answer = isset($_POST['answer']) ? mysqli_real_escape_string($conn, $_POST['answer']) : '';


if (empty($question) || empty($answer)) {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/add_faq.php?category=' . $category . '&error=missing_fields');
    exit;
}


$valid_categories = ['general', 'events', 'account', 'rewards'];
if (!in_array($category, $valid_categories)) {
    $category = 'general';
}

$created_by = $_SESSION['user_id'];

$sql = "INSERT INTO faq (category, question, answer, created_by, updated_at, updated_by) VALUES ('$category', '$question', '$answer', '$created_by', NOW(), '$created_by')";

if (mysqli_query($conn, $sql)) {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/index.php?success=added');
    exit;
} else {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/add_faq.php?category=' . $category . '&error=db_error');
    exit;
}
