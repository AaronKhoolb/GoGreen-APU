<!-- 
Author: Chong Ray Han
Date: 2026-1-4
Description: Reset password logic
-->

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');


if (isset($_POST['reset_btn'])) {
    $apkey = mysqli_real_escape_string($conn, $_POST['apkey']);
    $ans1 = $_POST['ans1'];
    $ans2 = $_POST['ans2'];
    $ans3 = $_POST['ans3'];
    $new_password = $_POST['new_password'];

    $sql = "SELECT security_ans1, security_ans2, security_ans3 FROM users WHERE apkey = '$apkey'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (
            strcasecmp($ans1, $row['security_ans1']) == 0 &&
            strcasecmp($ans2, $row['security_ans2']) == 0 &&
            strcasecmp($ans3, $row['security_ans3']) == 0
        ) {

            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password = '$hashed_password' WHERE apkey = '$apkey'";

            if (mysqli_query($conn, $update_sql)) {
                header("Location: /GoGreen-APU/auth/login.php?success=Password reset successful. Please login.");
                exit();
            } else {
                header("Location: /GoGreen-APU/auth/reset-pass.php?apkey=$apkey&error=Database error. Please try again.");
                exit();
            }

        } else {
            header("Location: /GoGreen-APU/auth/reset-pass.php?apkey=$apkey&error=Incorrect security answers.");
            exit();
        }

    } else {
        header("Location: /GoGreen-APU/auth/reset-pass.php?error=User not found.");
        exit();
    }

} else {
    header("Location: /GoGreen-APU/auth/reset-pass.php");
    exit();
}
?>