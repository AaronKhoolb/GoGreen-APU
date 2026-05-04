 <!--
    Author: Chong Jun Yoong & Damian Loh Yi Feng
    Date: 2026-1-11
    Description: Sidebar for collaborator pages
-->
<?php
$name = trim(($_SESSION['last_name'] ?? '') . ' ' . ($_SESSION['name'] ?? ''));
$apkey = $_SESSION['apkey'] ?? '';
$avatar_path = $_SESSION['avatar_path'] ?? 'profile.jpg';

include_once($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$current_user_id = $_SESSION['user_id'] ?? 0;
$collab_event_id = 0;

if ($current_user_id) {
    $collab_sql = "SELECT event_id FROM collaborators WHERE user_id = $current_user_id LIMIT 1";
    if ($result = mysqli_query($conn, $collab_sql)) {
        if ($row = $result->fetch_assoc()) {
            $collab_event_id = intval($row['event_id']);
        }
    }
}
$event_id_param = $collab_event_id ? ('?id=' . $collab_event_id) : '';
?>
<div id="side_nav">

    <button id="toggle_btn" onclick="switchSidebar()">
        <img src="/GoGreen-APU/assets/icons/navigation/sidebar.leading.svg" alt="Menu">
    </button>

    <div id="logo_sec">
        <img id="logo_img" src="/GoGreen-APU/assets/images/logo/GoGreen@APU icon.svg" alt="Logo">
        <div id="brand_name">
            <span class="title-name">
                <span class="go">Go</span><span class="green">Green</span><span class="apu">@APU</span>
            </span>
            <span id="role_label">Collaborator</span>
        </div>
    </div>

    <nav>
        <div class="nav_group">
            <a class="menu_link <?php if ($page_name == 'dashboard')
                echo 'active'; ?>" href="/GoGreen-APU/frontend/collaborator/index.php">
                <span class="icon"><img src="/GoGreen-APU/assets/icons/navigation/home.svg"
                        alt="Home"></span>
                <span class="label">Event Overview</span>
            </a>
        </div>

        <div class="nav_group">
            <span class="group_title">My Event</span>

            <a class="menu_link <?php if ($page_name == 'edit_details')
                echo 'active'; ?>" href="/GoGreen-APU/frontend/collaborator/edit_details/index.php<?php echo $event_id_param; ?>">
                <span class="icon"><img src="/GoGreen-APU/assets/icons/calendar.badge.plus.svg" alt="Anno"></span>
                <span class="label">Edit Details</span>
            </a>

            <a class="menu_link <?php if ($page_name == 'participants')
                echo 'active'; ?>" href="/GoGreen-APU/frontend/collaborator/participants/index.php<?php echo $event_id_param; ?>">
                <span class="icon"><img src="/GoGreen-APU/assets/icons/person.3.fill.svg" alt="Anno"></span>
                <span class="label">Participants</span>
            </a>

            <a class="menu_link <?php if ($page_name == 'attendance_codes')
                echo 'active'; ?>" href="/GoGreen-APU/frontend/collaborator/attandance_codes/index.php<?php echo $event_id_param; ?>">
                <span class="icon"><img src="/GoGreen-APU/assets/icons/megaphone.svg" alt="Anno"></span>
                <span class="label">Attendance Codes</span>
            </a>
        </div>
    </nav>

    <div id="bottom_profile">
        <a class="<?php if ($page_name == 'profile')
            echo 'active'; ?>" href="/GoGreen-APU/frontend/collaborator/account/index.php">
            <img class="usr_pic" src="/GoGreen-APU/assets/images/profile/<?php echo $avatar_path; ?>"
                alt="Pic">
            <div class="usr_info">
                <span class="name"><?php echo $name; ?></span>
                <span class="id_num"><?php echo $apkey; ?></span>
            </div>
        </a>
        <a class="out_btn" href="/GoGreen-APU/actions/logout.php">
            <img src="/GoGreen-APU/assets/icons/navigation/logout.svg" alt="Out">
        </a>
    </div>

</div>

<script src="/GoGreen-APU/assets/js/organizer/sidebar.js"></script>