<!-- 
Author: Chong Ray Han
Date: 2025-12-29
Description: require login
-->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



if (!isset($_SESSION['user_id'])) {
    header("Location: /GoGreen-APU/index.php");
    exit();
}
?>