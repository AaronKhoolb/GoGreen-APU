<!-- 
Author: Chong Ray Han
Date: 2025-12-29
Description: starts session and cookie config
-->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 60 * 60 * 24, // expires in 1 day
        'path' => '/',
        'domain' => null,
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);

    session_start();
}
?>
