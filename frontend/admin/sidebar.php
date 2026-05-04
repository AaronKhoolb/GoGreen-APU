<!--
    Author: Damian Loh Yi Feng
    Date: 2026-1-10
    Description: Admin Sidebar Navigation
-->
 <?php
    $current_user_id = $_SESSION['user_id'] ?? 0;
    $display_name = "Guest";
    $display_apkey = "TP000000";
    $display_avatar = "profile.jpg";

if ($current_user_id > 0) {
    $sql_sidebar = "SELECT first_name, last_name, apkey, avatar_path FROM users WHERE id = $current_user_id";
    $res_sidebar = mysqli_query($conn, $sql_sidebar);

        if ($res_sidebar && mysqli_num_rows($res_sidebar) > 0) {
            $user_db = mysqli_fetch_assoc($res_sidebar);
            $display_name = trim($user_db['last_name'] . ' ' . $user_db['first_name']);
            $display_apkey = $user_db['apkey'];
            $display_avatar = $user_db['avatar_path'] ?: 'profile.jpg';
        }
    }

    $user_pages = ['user', 'create_user', 'manage_users'];
    $event_pages = ['my_events', 'event_overview', 'event_info', 'event_participants', 'event_attendance', 'event_certificate', 'event_collaborators', 'event_reports', 'event_report'];
    $reward_pages = ['reward', 'reward_redemption'];
    $club_pages = ['club', 'create_club', 'manage_club'];
    $settings_pages = ['settings', 'settings_general', 'settings_pinned_post', 'settings_faq'];

    $show_user_dropdown = in_array($page_name, $user_pages);
    $show_event_dropdown = in_array($page_name, $event_pages);
    $show_reward_dropdown = in_array($page_name, $reward_pages);
    $show_club_dropdown = in_array($page_name, $club_pages);
    $show_settings_dropdown = in_array($page_name, $settings_pages);

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $event_id_param = '?id=' . intval($_GET['id']);
        $sub_link_disabled = '';
    } else {
        $event_id_param = '';
        $sub_link_disabled = 'disabled';
    }
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
            <span id="role_label">Admin</span>
        </div>
    </div>

     <nav>
         <div class="nav_group">
             <a class="menu_link <?php if ($page_name == 'dashboard') {
                                        echo 'active';
                                    } ?>" href="/GoGreen-APU/frontend/admin/index.php">
                 <span class="icon"><img src="/GoGreen-APU/assets/icons/navigation/home.svg" alt="Home"></span>
                 <span class="label">Dashboard</span>
             </a>
         </div>

        <div class="nav_group">
            <span class="group_title">Management</span>

             <div class="dropdown_box">
                 <a class="menu_link parent_link <?php if ($page_name == 'user') {
                                                        echo 'active';
                                                    } ?>" href="/GoGreen-APU/frontend/admin/user/index.php">
                     <span class="icon"><img src="/GoGreen-APU/assets/icons/user.svg" alt="Users"></span>
                     <span class="label">Users</span>
                 </a>
             </div>

             <div class="dropdown_box">
                 <a class="menu_link parent_link <?php if ($page_name == 'my_events') {
                                                        echo 'active';
                                                    } ?>" href="/GoGreen-APU/frontend/admin/event/index.php">
                     <span class="icon"><img src="/GoGreen-APU/assets/icons/my_events.svg" alt="Events"></span>
                     <span class="label">Manage Events</span>
                     <span class="arrow <?php if ($show_event_dropdown) {
                                            echo 'open';
                                        } ?>">
                         <img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">">
                     </span>
                 </a>
                 <div class="sub_menu <?php if ($show_event_dropdown) {
                                            echo 'show';
                                        } ?>">
                     <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_overview') {
                                                                                echo 'active';
                                                                            } ?>" href="/GoGreen-APU/frontend/admin/event/overview.php<?php echo $event_id_param; ?>">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/dashboard.svg" alt="Overview"></span>
                         <span class="label">Overview</span>
                     </a>
                     <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_info') {
                                                                                echo 'active';
                                                                            } ?>" href="/GoGreen-APU/frontend/admin/event/information.php<?php echo $event_id_param; ?>">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt="Info"></span>
                         <span class="label">Information</span>
                     </a>
                     <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_participants') {
                                                                                echo 'active';
                                                                            } ?>" href="/GoGreen-APU/frontend/admin/event/participants.php<?php echo $event_id_param; ?>">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/person.3.svg" alt="Participants"></span>
                         <span class="label">Participants</span>
                     </a>
                     <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_attendance') {
                                                                                echo 'active';
                                                                            } ?>" href="/GoGreen-APU/frontend/admin/event/attendance/index.php<?php echo $event_id_param; ?>">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/clock.badge.checkmark.svg"
                                 alt="Attendance"></span>
                         <span class="label">Attendance</span>
                     </a>
                     <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_certificate') {
                                                                                echo 'active';
                                                                            } ?>" href="/GoGreen-APU/frontend/admin/event/certificate.php<?php echo $event_id_param; ?>">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/certificate.svg"
                                 alt="Certificate"></span>
                         <span class="label">Certificate</span>
                     </a>
                     <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_collaborators') {
                                                                                echo 'active';
                                                                            } ?>" href="/GoGreen-APU/frontend/admin/event/collaborators/<?php echo $event_id_param; ?>">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg"
                                 alt="Collaborators"></span>
                         <span class="label">Collaborators</span>
                     </a>
                     <a class="menu_link <?php echo $sub_link_disabled; ?> <?php if ($page_name == 'event_reports' || $page_name == 'event_report') {
                                                                                echo 'active';
                                                                            } ?>"
                         href="/GoGreen-APU/frontend/admin/reports/generate_report.php<?php echo $event_id_param; ?>">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/text.document.svg" alt="Report"></span>
                         <span class="label">Report</span>
                     </a>
                 </div>
             </div>

             <div class="dropdown_box">
                 <a class="menu_link parent_link <?php if ($page_name == 'reward') {
                                                        echo 'active';
                                                    } ?>" href="/GoGreen-APU/frontend/admin/rewards/index.php">
                     <span class="icon"><img src="/GoGreen-APU/assets/icons/navigation/rewards.svg" alt="Rewards"></span>
                     <span class="label">Rewards</span>
                     <span class="arrow <?php if ($show_reward_dropdown) {
                                            echo 'open';
                                        } ?>">
                         <img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">">
                     </span>
                 </a>
                 <div class="sub_menu <?php if ($show_reward_dropdown) {
                                            echo 'show';
                                        } ?>">

                     <a class="menu_link <?php if ($page_name == 'reward_redemption') {
                                                echo 'active';
                                            } ?>" href="/GoGreen-APU/frontend/admin/rewards/reward_redemption.php">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/clock.svg" alt="History"></span>
                         <span class="label">Reward redemption</span>
                     </a>
                 </div>
             </div>

             <div class="dropdown_box">
                 <a class="menu_link parent_link <?php if ($page_name == 'club') {
                                                        echo 'active';
                                                    } ?>" href="/GoGreen-APU/frontend/admin/club/index.php">
                     <span class="icon"><img
                             src="/GoGreen-APU/assets/icons/diversity_3_1000dp_1F1F1F_FILL0_wght400_GRAD0_opsz48.svg"
                             alt="Club"></span>
                     <span class="label">Club</span>
                     <span class="arrow <?php if ($show_club_dropdown) {
                                            echo 'open';
                                        } ?>">
                         <img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">">
                     </span>
                 </a>
                 <div class="sub_menu <?php if ($show_club_dropdown) {
                                            echo 'show';
                                        } ?>">
                     <a class="menu_link <?php if ($page_name == 'create_club') {
                                                echo 'active';
                                            } ?>" href="/GoGreen-APU/frontend/admin/club/create_club.php">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/plus.svg" alt="Create"></span>
                         <span class="label">Create Club</span>
                     </a>
                     <a class="menu_link <?php if ($page_name == 'manage_club') {
                                                echo 'active';
                                            } ?>" href="/GoGreen-APU/frontend/admin/club/manage_club.php">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/gearshape.fill.svg" alt="Manage"></span>
                         <span class="label">Manage Club</span>
                     </a>
                 </div>
             </div>

        </div>

         <div class="nav_group">
             <span class="group_title">My Activities</span>
             <a class="menu_link <?php if ($page_name == 'my_activities') {
                                        echo 'active';
                                    } ?>" href="/GoGreen-APU/frontend/admin/my_activities/index.php">
                 <span class="icon"><img
                         src="/GoGreen-APU/assets/icons/clock.arrow.trianglehead.counterclockwise.rotate.90.svg"
                         alt="Activities"></span>
                 <span class="label">My Activities</span>
             </a>
         </div>

        <div class="nav_group">
            <span class="group_title">System Settings</span>

             <div class="dropdown_box">
                 <a class="menu_link parent_link <?php if ($page_name == 'settings') {
                                                        echo 'active';
                                                    } ?>" href="/GoGreen-APU/frontend/admin/system_setting/general/index.php">
                     <span class="icon"><img src="/GoGreen-APU/assets/icons/settings.svg" alt="Settings"></span>
                     <span class="label">Settings</span>
                     <span class="arrow <?php if ($show_settings_dropdown) {
                                            echo 'open';
                                        } ?>">
                         <img src="/GoGreen-APU/assets/icons/navigation/chevron.right.svg" alt=">">
                     </span>
                 </a>
                 <div class="sub_menu <?php if ($show_settings_dropdown) {
                                            echo 'show';
                                        } ?>">
                     <a class="menu_link <?php if ($page_name == 'settings_general') {
                                                echo 'active';
                                            } ?>" href="/GoGreen-APU/frontend/admin/system_setting/general/index.php">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/slider.horizontal.3.svg"
                                 alt="General"></span>
                         <span class="label">General</span>
                     </a>
                     <a class="menu_link <?php if ($page_name == 'settings_pinned_post') {
                                                echo 'active';
                                            } ?>" href="/GoGreen-APU/frontend/admin/system_setting/pinned_post/index.php">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/pin.svg" alt="Pinned"></span>
                         <span class="label">Pinned Posts</span>
                     </a>
                     <a class="menu_link <?php if ($page_name == 'settings_faq') {
                                                echo 'active';
                                            } ?>" href="/GoGreen-APU/frontend/admin/system_setting/faq/index.php">
                         <span class="icon"><img src="/GoGreen-APU/assets/icons/text.bubble.svg" alt="FAQ"></span>
                         <span class="label">FAQ</span>
                     </a>
                 </div>
             </div>
         </div>
     </nav>

     <div id="bottom_profile">
         <a class="<?php echo ($page_name == 'profile') ? 'active' : ''; ?>" href="/GoGreen-APU/frontend/admin/account/index.php">
             <img class="usr_pic" src="/GoGreen-APU/assets/images/profile/<?php echo $display_avatar; ?>" alt="Profile">

             <div class="usr_info">
                 <span class="name"><?php echo htmlspecialchars($display_name); ?></span>
                 <span class="id_num"><?php echo htmlspecialchars($display_apkey); ?></span>
             </div>
         </a>
         <a class="out_btn" href="/GoGreen-APU/actions/logout.php">
             <img src="/GoGreen-APU/assets/icons/navigation/logout.svg" alt="Logout">
         </a>
     </div>

</div>

<script src="/GoGreen-APU/assets/js/organizer/sidebar.js"></script>