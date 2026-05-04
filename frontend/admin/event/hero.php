<!--
    Author: Chong Jun Yoong
    Date: 2026-1-9
    Description: Hero component for the admin event management pages
-->
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$event_id = intval($_GET['id']);

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
        <img src="/GoGreen-APU/assets/images/event/<?php echo $event['image_path']; ?>" alt="Hero Background" id="hero-bg-img">

        <div class="hero-blur-overlay"></div>
    </div>


    <div id="top-row">
        <div id="top-left">
            <a id="back-btn" class="glass-effect-border" href="/GoGreen-APU/frontend/admin/event/index.php">
                <span id="back-icon"><img src="/GoGreen-APU/assets/icons/chevron.left.svg" alt="Back"></span>
            </a>


            <div id="breadcrumb-path" class="glass-effect-border">
                <a href="/GoGreen-APU/frontend/admin/event/index.php">My Events</a>


                <span class="breadcrumb-icon"><img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">"></span>


                <?php if ($page_name == 'event_overview'): ?>
                    <a href="/GoGreen-APU/frontend/admin/event/overview.php?id=<?php echo $event_id_param; ?>"><?php echo $event_name; ?></a>


                <?php elseif ($page_name == 'event_info'): ?>
                    <a href="/GoGreen-APU/frontend/admin/event/overview.php?id=<?php echo $event_id_param; ?>"><?php echo $event_name; ?></a>

                    <span class="breadcrumb-icon"><img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">"></span>

                    <a href="/GoGreen-APU/frontend/admin/event/information.php?id=<?php echo $event_id_param; ?>">Information</a>
                <?php elseif ($page_name == 'event_participants'): ?>
                    <a href="/GoGreen-APU/frontend/admin/event/overview.php?id=<?php echo $event_id_param; ?>"><?php echo $event_name; ?></a>

                    <span class="breadcrumb-icon"><img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">"></span>

                    <a href="/GoGreen-APU/frontend/admin/event/participants.php?id=<?php echo $event_id; ?>">Participants</a>
                <?php elseif ($page_name == 'event_attendance'): ?>
                    <a href="/GoGreen-APU/frontend/admin/event/overview.php?id=<?php echo $event_id_param; ?>"><?php echo $event_name; ?></a>

                    <span class="breadcrumb-icon"><img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">"></span>

                    <a href="/GoGreen-APU/frontend/admin/event/attendance/index.php?id=<?php echo $event_id; ?>">Attendance</a>
                <?php elseif ($page_name == 'event_certificate'): ?>
                    <a href="/GoGreen-APU/frontend/admin/event/overview.php?id=<?php echo $event_id_param; ?>"><?php echo $event_name; ?></a>

                    <span class="breadcrumb-icon"><img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">"></span>

                    <a href="/GoGreen-APU/frontend/admin/event/certificate.php?id=<?php echo $event_id; ?>">Certificate</a>
                <?php elseif ($page_name == 'event_collaborators'): ?>
                    <a href="/GoGreen-APU/frontend/admin/event/overview.php?id=<?php echo $event_id_param; ?>"><?php echo $event_name; ?></a>

                    <span class="breadcrumb-icon"><img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">"></span>

                    <a href="/GoGreen-APU/frontend/admin/event/collaborators/?id=<?php echo $event_id; ?>">Collaborators</a>
                <?php elseif ($page_name == 'event_report'): ?>
                    <a href="/GoGreen-APU/frontend/admin/event/overview.php?id=<?php echo $event_id_param; ?>"><?php echo $event_name; ?></a>

                    <span class="breadcrumb-icon"><img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">"></span>

                    <a href="/GoGreen-APU/frontend/admin/reports/generate_report.php?id=<?php echo $event_id; ?>">Report</a>
                <?php else: ?>
                    <a href="/GoGreen-APU/frontend/admin/event/overview.php?id=<?php echo $event_id_param; ?>"><?php echo $event_name; ?></a>
                <?php endif; ?>
            </div>
        </div>

        <form action="/GoGreen-APU/actions/organizer/my_events/change_poster.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="event_id" value="<?php echo $event_id_param; ?>">
            <label class="change-poster-btn glass-effect-border">
                <input type="file" name="poster" accept="image/*" hidden onchange="this.form.submit()">
                <img src="/GoGreen-APU/assets/icons/photo.badge.plus.svg" alt="Change">
                <span>Change Poster</span>
            </label>
        </form>
    </div>

    <!-- Middle Row: Title + Actions -->
    <div id="middle-row">
        <!-- Left: Title and Meta -->
        <div class="hero-info">
            <h1 class="hero-title" id="hero-title"><?php echo htmlspecialchars($event['title']); ?></h1>
            <div class="hero-meta" id="hero-meta">
                <img src="/GoGreen-APU/assets/images/club/<?php echo $club['logo_path']; ?>" alt="Club Logo">
                <span><?php echo htmlspecialchars($club['name']); ?></span>
            </div>
        </div>

        <!-- Right: Action Buttons -->
        <div class="hero-actions">
            <a href="#" class="delete-btn red-glass-effect-border" title="Delete Event">
                <img src="/GoGreen-APU/assets/icons/trash.svg" alt="Delete">
            </a>
            <a href="/GoGreen-APU/frontend/shared/preview_event.php?id=<?php echo $event_id; ?>" target="_blank"
                class="preview-btn glass-effect-border">
                <img src="/GoGreen-APU/assets/icons/eye.svg" alt="Preview">
                <span>Preview</span>
            </a>
        </div>
    </div>

    <!-- Bottom: Event Navigation - use $page_name like sidebar -->
    <nav id="event-nav">
        <a href="/GoGreen-APU/frontend/admin/event/overview.php?id=<?php echo $event_id; ?>"
            class="event-nav-link <?php echo ($page_name == 'event_overview') ? 'active glass-active-underline' : ''; ?>">
            <img src="/GoGreen-APU/assets/icons/dashboard.svg" alt="">
            <span>Overview</span>
        </a>
        <a href="/GoGreen-APU/frontend/admin/event/information.php?id=<?php echo $event_id; ?>"
            class="event-nav-link <?php echo ($page_name == 'event_info') ? 'active glass-active-underline' : ''; ?>">
            <img src="/GoGreen-APU/assets/icons/info.circle.svg" alt="">
            <span>Information</span>
        </a>
        <a href="/GoGreen-APU/frontend/admin/event/participants.php?id=<?php echo $event_id; ?>"
            class="event-nav-link <?php echo ($page_name == 'event_participants') ? 'active glass-active-underline' : ''; ?>">
            <img src="/GoGreen-APU/assets/icons/person.3.svg" alt="">
            <span>Participants</span>
        </a>
        <a href="/GoGreen-APU/frontend/admin/event/attendance/index.php?id=<?php echo $event_id; ?>"
            class="event-nav-link <?php echo ($page_name == 'event_attendance') ? 'active glass-active-underline' : ''; ?>">
            <img src="/GoGreen-APU/assets/icons/clock.badge.checkmark.svg" alt="">
            <span>Attendance</span>
        </a>
        <a href="/GoGreen-APU/frontend/admin/event/certificate.php?id=<?php echo $event_id; ?>"
            class="event-nav-link <?php echo ($page_name == 'event_certificate') ? 'active glass-active-underline' : ''; ?>">
            <img src="/GoGreen-APU/assets/icons/certificate.svg" alt="">
            <span>Certificate</span>
        </a>
        <a href="/GoGreen-APU/frontend/admin/event/collaborators/?id=<?php echo $event_id; ?>"
            class="event-nav-link <?php echo ($page_name == 'event_collaborators') ? 'active glass-active-underline' : ''; ?>">
            <img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt="">
            <span>Collaborators</span>
        </a>
        <a href="/GoGreen-APU/frontend/admin/reports/generate_report.php?id=<?php echo $event_id; ?>"
            class="event-nav-link <?php echo ($page_name == 'event_report') ? 'active glass-active-underline' : ''; ?>">
            <img src="/GoGreen-APU/assets/icons/text.document.svg" alt="">
            <span>Report</span>
        </a>
    </nav>
</section>