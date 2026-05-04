<!-- Author: Chong Ray Han
Date: 2026-1-4
Description: reset to default icon
-->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/auth/require_login.php';

$redirect_url = '/GoGreen-APU/frontend/admin/system_setting/general/index.php';

$logo_dir = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/logo/';
$defaults_dir = $logo_dir . 'defaults/';

$files_to_reset = [
    'GoGreen@APU icon.svg'
];

$success = true;

$possible_extensions = ['svg', 'png', 'jpeg', 'jpg', 'gif', 'webp', 'ico'];
foreach ($possible_extensions as $ext) {
    $existing_file = $logo_dir . 'GoGreen@APU icon.' . $ext;
    if (file_exists($existing_file)) {
        unlink($existing_file);
    }
}

foreach ($files_to_reset as $filename) {
    $default_file = $defaults_dir . $filename;
    $target_file = $logo_dir . $filename;

    if (file_exists($default_file)) {
        if (!copy($default_file, $target_file)) {
            $success = false;
        }
    }
}

if ($success) {
    header("Location: $redirect_url?success=icon_reset");
    exit;
} else {
    header("Location: $redirect_url?error=reset_failed");
    exit;
}
