<!-- 
Author: Chong Ray Han
Date: 2026-1-4
Description: create user logic
-->

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

if (isset($_POST['create_user_btn'])) {

    // User Data
    $apkey = $_POST['apkey'];
    $pass = $_POST['password'];
    $role = $_POST['role'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone_no'];
    $ans1 = $_POST['security_ans1'];
    $ans2 = $_POST['security_ans2'];
    $ans3 = $_POST['security_ans3'];

    // Password hashing
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $sql_user = "INSERT INTO users (apkey, password, role, first_name, last_name, avatar_path, dob, gender, phone_no, security_ans1, security_ans2, security_ans3) 
                 VALUES ('$apkey', '$hashed_password', '$role', '$first_name', '$last_name', NULL, '$dob', '$gender', '$phone', '$ans1', '$ans2', '$ans3')";

    if (mysqli_query($conn, $sql_user)) {

        $new_user_id = mysqli_insert_id($conn);

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
                    $sql_avatar = "UPDATE users SET avatar_path = '$new_filename' WHERE id = $new_user_id";
                    mysqli_query($conn, $sql_avatar);
                }
            }
        }

        if ($role === 'student') {
            $course = $_POST['course'];
            $graduation = $_POST['graduation'];
            $ap_coins = 0;

            $sql_student = "INSERT INTO students (user_id, course, graduation, ap_coins) 
                            VALUES ('$new_user_id', '$course', '$graduation', '$ap_coins')";
            mysqli_query($conn, $sql_student);

        } else if ($role === 'organizer') {
            $club_id = $_POST['club_id'];
            $position = $_POST['position'];

            if (!empty($club_id)) {
                $sql_organizer = "INSERT INTO organizers (user_id, club_id, positions) 
                                  VALUES ('$new_user_id', '$club_id', '$position')";
                mysqli_query($conn, $sql_organizer);
            }
        }

        echo "<script>alert('User Created Successfully!'); window.location.href='/GoGreen-APU/frontend/admin/create_user_temp.php';</script>";

    } else {
        echo "Error creating user: " . mysqli_error($conn);
    }

} else {
    header("Location: /GoGreen-APU/frontend/admin/create_user_temp.php");
    exit();
}
?>