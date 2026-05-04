<!-- Author: Chong Ray Han
Date: 2026-1-4
Description: Register logic
-->

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

if (isset($_POST['register_btn'])) {
    $apkey = $_POST['apkey'];
    $pass = $_POST['password'];
    $role = 'student';
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone_no'];

    // Security Questions
    $quest1 = $_POST['security_quest1'];
    $ans1 = $_POST['security_ans1'];
    $quest2 = $_POST['security_quest2'];
    $ans2 = $_POST['security_ans2'];
    $quest3 = $_POST['security_quest3'];
    $ans3 = $_POST['security_ans3'];

    // Student Data
    $course = $_POST['course'];
    $grad_year = $_POST['graduation'];

    $ap_coins = 0;

    // Password hashing
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $sql_user = "INSERT INTO users (apkey, password, role, first_name, last_name, avatar_path, dob, gender, phone_no, security_quest1, security_ans1, security_quest2, security_ans2, security_quest3, security_ans3) 
                 VALUES (?, ?, ?, ?, ?, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql_user);

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssssssss",
            $apkey,
            $hashed_password,
            $role,
            $first_name,
            $last_name,
            $dob,
            $gender,
            $phone,
            $quest1,
            $ans1,
            $quest2,
            $ans2,
            $quest3,
            $ans3
        );

        if (mysqli_stmt_execute($stmt)) {
            $new_user_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['avatar']['tmp_name'];
                $file_name = $_FILES['avatar']['name'];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

                if (in_array($file_ext, $allowed_ext)) {
                    $new_filename = $new_user_id . '.' . $file_ext;
                    $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/profile/' . $new_filename;

                    if (move_uploaded_file($file_tmp, $upload_path)) {
                        chmod($upload_path, 0644);
                        $sql_avatar = "UPDATE users SET avatar_path = ? WHERE id = ?";
                        $stmt_avatar = mysqli_prepare($conn, $sql_avatar);
                        mysqli_stmt_bind_param($stmt_avatar, "si", $new_filename, $new_user_id);
                        mysqli_stmt_execute($stmt_avatar);
                        mysqli_stmt_close($stmt_avatar);
                    }
                }
            }

            $sql_student = "INSERT INTO students (user_id, course, graduation, ap_coins) VALUES (?, ?, ?, ?)";
            $stmt_student = mysqli_prepare($conn, $sql_student);

            if ($stmt_student) {
                mysqli_stmt_bind_param($stmt_student, "isii", $new_user_id, $course, $grad_year, $ap_coins);

                if (mysqli_stmt_execute($stmt_student)) {
                    // SUCCESS
                    echo "<script>alert('Registration Successful!'); window.location.href='/GoGreen-APU/index.php';</script>";
                } else {
                    // Student insert failed
                    echo "<script>alert('Error registering student details.'); window.history.back();</script>";
                }
                mysqli_stmt_close($stmt_student);
            } else {
                echo "<script>alert('Database error (Student Prep).'); window.history.back();</script>";
            }

        } else {
            echo "<script>alert('Error registering user. TP Number might already exist.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Database error (User Prep).'); window.history.back();</script>";
    }

} else {
    echo "<script>window.location.href='/GoGreen-APU/index.php';</script>";
    exit();
}
?>