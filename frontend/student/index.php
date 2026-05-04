<!--
    Author: Khoo Lay Bin
    Date: 2026-1-5
    Description: Student home page with hero section carousel and my events section
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/home/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/home/attendance_btn.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/home/my_events.css">
</head>

<body>
    <?php
    $page_name = 'home';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/nav.php');
    ?>

    <?php include('home/hero.php'); ?>

    <?php include('home/attendance_btn.php'); ?>

    <?php include('home/my_events.php'); ?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>
</body>

</html>