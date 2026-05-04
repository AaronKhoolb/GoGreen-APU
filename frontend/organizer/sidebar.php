<!--
    Author: Khoo Lay Bin
    Date: 2026-1-5
    Description: Organizer sidebar
-->

<?php
$name = trim($_SESSION['last_name'] . ' ' . $_SESSION['name']);
$apkey = $_SESSION['apkey'];
$avatar_path = $_SESSION['avatar_path'] ?? 'profile.jpg';
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


            <span id="role_label">Organizer</span>
        </div>
    </div>


    <nav>
        <div class="nav_group">


            <?php
            $event_pages = ['my_events', 'event_overview', 'event_info', 'event_participants', 'event_attendance', 'event_certificate', 'event_collaborators', 'event_report'];
            $show_dropdown = in_array($page_name, $event_pages);


            $event_id_param = !empty($_GET['id']) ? '?id=' . intval($_GET['id']) : '';
            $sub_link_disabled = $event_id_param ? '' : 'disabled';
            ?>


            <div class="dropdown_box">
                <a class="menu_link parent_link <?php if ($page_name == 'my_events') echo 'active'; ?>" href="/GoGreen-APU/frontend/organizer/my_events/index.php">
                    <span class="icon"><img src="/GoGreen-APU/assets/icons/my_events.svg" alt="Events"></span>

                    <span class="label">My Events</span>

                    <span class="arrow <?php if ($show_dropdown) echo 'open'; ?>">
                        <img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">">
                    </span>
                </a>


                <div class="sub_menu <?php if ($show_dropdown) echo 'show'; ?>">
                    <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_overview') echo 'active'; ?>" href="/GoGreen-APU/frontend/organizer/my_events/overview.php<?php echo $event_id_param; ?>">
                        <span class="icon"><img src="/GoGreen-APU/assets/icons/dashboard.svg" alt="Db"></span>

                        <span class="label">Overview</span>
                    </a>


                    <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_info') echo 'active'; ?>" href="/GoGreen-APU/frontend/organizer/my_events/information.php<?php echo $event_id_param; ?>">
                        <span class="icon"><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt="Info"></span>

                        <span class="label">Information</span>
                    </a>


                    <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_participants') echo 'active'; ?>" href="/GoGreen-APU/frontend/organizer/my_events/participants.php<?php echo $event_id_param; ?>">
                        <span class="icon"><img src="/GoGreen-APU/assets/icons/person.3.svg" alt="ppl"></span>

                        <span class="label">Participants</span>
                    </a>


                    <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_attendance') echo 'active'; ?>" href="/GoGreen-APU/frontend/organizer/my_events/attendance.php<?php echo $event_id_param; ?>">
                        <span class="icon"><img src="/GoGreen-APU/assets/icons/clock.badge.checkmark.svg" alt="Att"></span>

                        <span class="label">Attendance</span>
                    </a>


                    <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_certificate') echo 'active'; ?>" href="/GoGreen-APU/frontend/organizer/my_events/certificate.php<?php echo $event_id_param; ?>">
                        <span class="icon"><img src="/GoGreen-APU/assets/icons/certificate.svg" alt="Cert"></span>

                        <span class="label">Certificate</span>
                    </a>


                    <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_collaborators') echo 'active'; ?>" href="/GoGreen-APU/frontend/organizer/my_events/collaborators/<?php echo $event_id_param; ?>">
                        <span class="icon"><img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt="Collab"></span>

                        <span class="label">Collaborators</span>
                    </a>


                    <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_report') echo 'active'; ?>" href="/GoGreen-APU/frontend/organizer/reports/generate_report.php<?php echo $event_id_param; ?>">
                        <span class="icon"><img src="/GoGreen-APU/assets/icons/text.document.svg" alt="Report"></span>

                        <span class="label">Report</span>
                    </a>
                </div>
            </div>



    </nav>


    <div id="bottom_profile">
        <a class="<?php if ($page_name == 'profile') echo 'active'; ?>" href="/GoGreen-APU/frontend/organizer/account/index.php">
            <img class="usr_pic" src="/GoGreen-APU/assets/images/profile/<?php echo $avatar_path; ?>" alt="Pic">


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