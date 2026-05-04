<!-- 
    Author: Khoo Lay Bin
    Date: 2025-11-5
    Description: Student certificate page that include certificate layout
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


    $sql_part = "SELECT * FROM event_participants WHERE event_id = $event_id AND user_id = $user_id";
    $res_part = mysqli_query($conn, $sql_part);
    $participant = mysqli_fetch_assoc($res_part);


    $sql_cert = "SELECT signature_path FROM certificate WHERE event_id = $event_id";
    $res_cert = mysqli_query($conn, $sql_cert);
    $cert_data = mysqli_fetch_assoc($res_cert);


    $cert_recipient_name = $user['last_name'] . " " . $user['first_name'];
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


    $cert_id = "CERT-" . $user['apkey'] . "-" . $participant['id'];


    $logo_path = "/GoGreen-APU/assets/images/logo/GoGreen@APU%20logo.svg";

    if ($event['club_logo']) {
        $club_logo_path = "/GoGreen-APU/assets/images/club/" . $event['club_logo'];
    } else {
        $club_logo_path = "/GoGreen-APU/assets/images/club/default.png";
    }

    $club_name = $event['club_name'];

    $signature_path = "/GoGreen-APU/uploads/cert_seals/" . $cert_data['signature_path'];
    ?>

    <title>GoGreen@APU</title>
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


            <div class="cert-wrapper" id="certificate-print-area">
                <?php include('cert.php'); ?>
            </div>


            <button onclick="window.print()" class="print-btn glass-effect-card">
                <img class="icon" src="/GoGreen-APU/assets/icons/printer.svg" alt="Print">
                <span>Print as PDF</span>
            </button>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>
</body>

</html>