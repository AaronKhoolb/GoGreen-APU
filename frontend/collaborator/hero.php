 <!--
    Author: Chong Jun Yoong
    Date: 2026-1-15
    Description: Hero section for collaborator event pages.
-->
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$event_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$collab_sql = "SELECT * FROM collaborators WHERE user_id = $user_id AND event_id = $event_id";
$collab_result = mysqli_query($conn, $collab_sql);

if (mysqli_num_rows($collab_result) == 0) {
    header("Location: /GoGreen-APU/frontend/collaborator/index.php");
    exit();
}

$sql = "SELECT * FROM events WHERE id = $event_id";
$result = mysqli_query($conn, $sql);
$event = mysqli_fetch_assoc($result);

$club_sql = "SELECT * FROM clubs WHERE id = {$event['club_id']}";
$club_result = mysqli_query($conn, $club_sql);
$club = mysqli_fetch_assoc($club_result);

$event_name = $event['title'];
$event_id_param = $event_id;
?>

<section id="events-hero">
    <div class="hero-background" id="hero-bg">
        <img src="/GoGreen-APU/assets/images/event/<?php echo $event['image_path']; ?>" alt="Hero Background"
            id="hero-bg-img">
        <div class="hero-blur-overlay"></div>
    </div>

    <div id="middle-row">
        <div class="hero-info">
            <h1 class="hero-title" id="hero-title"><?php echo htmlspecialchars($event['title']); ?></h1>
            <div class="hero-meta" id="hero-meta">
                <img src="/GoGreen-APU/assets/images/club/<?php echo $club['logo_path']; ?>" alt="Club Logo">
                <span><?php echo htmlspecialchars($club['name']); ?></span>
            </div>
        </div>
    </div>

    <nav id="event-nav">
        <a href="/GoGreen-APU/frontend/collaborator/edit_details/index.php?id=<?php echo $event_id; ?>"
            class="event-nav-link <?php echo ($page_name == 'edit_details') ? 'active glass-active-underline' : ''; ?>">
            <img src="/GoGreen-APU/assets/icons/calendar.badge.plus.svg" alt="">
            <span>Edit Details</span>
        </a>
        <a href="/GoGreen-APU/frontend/collaborator/participants/index.php?id=<?php echo $event_id; ?>"
            class="event-nav-link <?php echo ($page_name == 'participants') ? 'active glass-active-underline' : ''; ?>">
            <img src="/GoGreen-APU/assets/icons/person.3.svg" alt="">
            <span>Participants</span>
        </a>
        <a href="/GoGreen-APU/frontend/collaborator/attandance_codes/index.php?id=<?php echo $event_id; ?>"
            class="event-nav-link <?php echo ($page_name == 'attendance_codes') ? 'active glass-active-underline' : ''; ?>">
            <img src="/GoGreen-APU/assets/icons/clock.badge.checkmark.svg" alt="">
            <span>Attendance Codes</span>
        </a>
    </nav>
</section>