<!-- 
    Author: Khoo Lay Bin
    Date: 2025-11-5
    Description: Student preview cert page that include certificate layout
-->

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>

    <?php
    $event_id = intval($_GET['id']);

    $user_id = $_SESSION['user_id'];


    $sql_event = "SELECT e.*, c.name as club_name, c.logo_path as club_logo FROM events e LEFT JOIN clubs c ON e.club_id = c.id WHERE e.id = $event_id";
    $res_event = mysqli_query($conn, $sql_event);

    $event = mysqli_fetch_assoc($res_event);


    $sql_user = "SELECT * FROM users WHERE id = $user_id";
    $res_user = mysqli_query($conn, $sql_user);
    $user = mysqli_fetch_assoc($res_user);


    $cert_recipient_name = "Daniel Mago Vistro";
    $cert_event_title = $event['title'];


    $start_date = new DateTime($event['start_date']);

    if ($event['end_date']) {
        $end_date = new DateTime($event['end_date']);
    } else {
        $end_date = null;
    }

    $cert_date = $start_date->format('F j, Y');

    if ($end_date) {
        if ($start_date->format('Y-m-d') !== $end_date->format('Y-m-d')) {
            $cert_date = $start_date->format('F j, Y') . " - " . $end_date->format('F j, Y');
        }
    }


    $logo_path = "/GoGreen-APU/assets/images/logo/GoGreen@APU%20logo.svg";

    $club_logo_path = "/GoGreen-APU/assets/images/club/" . $event['club_logo'];


    $club_name = $event['club_name'];
    ?>

    <title>Preview Certificate - <?php echo htmlspecialchars($cert_event_title); ?></title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/nav.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/certificate.css">


    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Great+Vibes&display=swap" rel="stylesheet">
</head>


<body>
    <?php
    $page_name = 'explore';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/nav.php');
    ?>

    <div class="main-content">
        <div class="certificate-page">
            <a href="/GoGreen-APU/frontend/student/explore/event/?id=<?php echo $event_id; ?>" class="cert-back-btn glass-effect-card">
                <img class="icon" src="/GoGreen-APU/assets/icons/chevron.left.svg" alt="Back">
            </a>


            <div class="cert-wrapper">
                <?php include('cert.php'); ?>
            </div>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>
</body>

</html>