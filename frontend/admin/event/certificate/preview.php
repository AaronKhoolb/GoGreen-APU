 <!--
    Author: Chong Jun Yoong
    Date: 2026-1-13
    Description: Certificate preview page.
-->
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$event_id = intval($_GET['id']);

$sql_event = "SELECT e.*, c.name as club_name, c.logo_path as club_logo 
              FROM events e 
              LEFT JOIN clubs c ON e.club_id = c.id 
              WHERE e.id = $event_id";
$res_event = mysqli_query($conn, $sql_event);
$event = mysqli_fetch_assoc($res_event);


$sql_cert = "SELECT signature_path FROM certificate WHERE event_id = $event_id";
$res_cert = mysqli_query($conn, $sql_cert);
$cert_data = mysqli_fetch_assoc($res_cert);

$cert_recipient_name = "Daniel Mago Vistro";
$cert_event_title = $event['title'];
$cert_id = "CERT-PREVIEW-000";

$start_date = new DateTime($event['start_date']);
$end_date = $event['end_date'] ? new DateTime($event['end_date']) : null;

$cert_date = $start_date->format('F j, Y');
if ($end_date && $start_date->format('Y-m-d') !== $end_date->format('Y-m-d')) {
    $cert_date = $start_date->format('F j, Y') . " - " . $end_date->format('F j, Y');
}

$logo_path = "/GoGreen-APU/assets/images/logo/GoGreen@APU%20logo.svg";
$club_logo_path = "/GoGreen-APU/assets/images/club/" . $event['club_logo'];
$club_name = $event['club_name'];
$signature_path = $cert_data ? "/GoGreen-APU/uploads/cert_seals/" . $cert_data['signature_path'] : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Preview Certificate - <?php echo htmlspecialchars($cert_event_title); ?></title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/certificate.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Great+Vibes&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php
    $page_name = 'event_certificate';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/event/hero.php'); ?>
        <div class="certificate-page" style="margin: 24px 70px 20px;">

            <a href="/GoGreen-APU/frontend/admin/event/certificate.php?id=<?php echo $event_id; ?>"
                class="cert-back-btn glass-effect-card">
                <img class="icon" src="/GoGreen-APU/assets/icons/chevron.left.svg" alt="Back">
            </a>

            <div class="cert-wrapper">
                <?php include('cert.php'); ?>
            </div>

        </div>
    </main>
</body>

</html>