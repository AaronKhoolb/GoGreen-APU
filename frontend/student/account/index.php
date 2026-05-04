<!-- 
    Author: Khoo Lay Bin
    Date: 2026-1-6
    Description: Student account page
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/account.css">
    <title>GoGreen@APU - Account</title>
</head>

<body>
    <?php
    $page_name = 'account';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/nav.php');
    ?>

    <main class="main-content">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/account/content.php'); ?>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>
</body>

</html>