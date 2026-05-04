<!-- Author: Chong Ray Han
Date: 2026-1-4
Description: Login logic 
-->
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/redirect_role.php');

if (!isset($_POST['login_btn'])) {
    header("Location: /GoGreen-APU/auth/login.php");
    exit();
}

$apkey = trim($_POST['apkey']);
$pass = trim($_POST['password']);


// Check input
if (empty($apkey)) {
    header("Location: /GoGreen-APU/auth/login.php?error=APKey is required");
    exit();
}

if (empty($pass)) {
    header("Location: /GoGreen-APU/auth/login.php?error=Password is required");
    exit();
}

if (strpos($apkey, "TP") !== 0) {
    header("Location: /GoGreen-APU/auth/login.php?error=Please start with TP");
    exit();
}

// Check user
$apkey_escaped = mysqli_real_escape_string($conn, $apkey);
$sql = "SELECT * FROM users WHERE apkey='$apkey_escaped'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) !== 1) {
    header("Location: /GoGreen-APU/auth/login.php?error=Incorrect Name or Password");
    exit();
}

$row = mysqli_fetch_assoc($result);

// Check password
if (!password_verify($pass, $row['password'])) {
    header("Location: /GoGreen-APU/auth/login.php?error=Incorrect Name or Password");
    exit();
}

// Login success
$_SESSION['user_id'] = $row['id'];
$_SESSION['name'] = $row['first_name'];
$_SESSION['last_name'] = $row['last_name'];
$_SESSION['role'] = $row['role'];
$_SESSION['avatar_path'] = $row['avatar_path'];
$_SESSION['apkey'] = $row['apkey'];

// Update last_login
$update_login = "UPDATE users SET last_login = NOW() WHERE id = " . $row['id'];
mysqli_query($conn, $update_login);

redirectUserByRole($row['role']);
exit();
?>