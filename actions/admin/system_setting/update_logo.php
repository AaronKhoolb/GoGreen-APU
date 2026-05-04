<!-- Author: Chong Ray Han
Date: 2026-1-4
Description: change logo logic
-->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/auth/require_login.php';

$redirect_url = '/GoGreen-APU/frontend/admin/system_setting/general/index.php';

if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
    header("Location: $redirect_url?error=no_file");
    exit;
}

$file = $_FILES['logo'];
$allowed_types = ['image/svg+xml', 'image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp'];
$max_size = 5 * 1024 * 1024; 

$file_type = mime_content_type($file['tmp_name']);
if (!in_array($file_type, $allowed_types)) {
    header("Location: $redirect_url?error=invalid_type");
    exit;
}

if ($file['size'] > $max_size) {
    header("Location: $redirect_url?error=file_too_large");
    exit;
}

$logo_dir = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/logo/';
$logo_filename = 'GoGreen@APU logo.svg';

$possible_extensions = ['svg', 'png', 'jpeg', 'jpg', 'gif', 'webp'];
foreach ($possible_extensions as $ext) {
    $existing_file = $logo_dir . 'GoGreen@APU logo.' . $ext;
    if (file_exists($existing_file)) {
        unlink($existing_file);
    }
}


$file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if ($file_ext === 'svg' || $file_type === 'image/svg+xml') {
    $target_path = $logo_dir . $logo_filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        header("Location: $redirect_url?success=logo_updated");
        exit;
    } else {
        header("Location: $redirect_url?error=upload_failed");
        exit;
    }
} else {
    $new_filename = 'GoGreen@APU logo.' . $file_ext;
    $target_path = $logo_dir . $new_filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        header("Location: $redirect_url?success=logo_updated");
        exit;
    } else {
        header("Location: $redirect_url?error=upload_failed");
        exit;
    }
}
