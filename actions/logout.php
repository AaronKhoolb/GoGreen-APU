<!-- Author: Chong Ray Han
Date: 2026-1-4
Description: Logout Logic 
-->

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

session_unset();
session_destroy();

header("Location: /GoGreen-APU/index.php");
exit;
?>