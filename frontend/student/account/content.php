<!-- 
    Author: Khoo Lay Bin
    Date: 2026-1-6
    Description: account page information
-->

<?php
$first_name = $_SESSION['name'];
$last_name = $_SESSION['last_name'];
$full_name = $last_name . ' ' . $first_name;
$tp_number = $_SESSION['apkey'];
$avatar_path = $_SESSION['avatar_path'];
?>

<div class="account-content">
    <div class="account-top">
        <span class="account-tp">
            <?php echo htmlspecialchars($tp_number); ?>
        </span>


        <div class="account-avatar-wrapper glass-effect-border">
            <img src="/GoGreen-APU/assets/images/profile/<?php echo htmlspecialchars($avatar_path); ?>" alt="Profile" class="account-avatar">
        </div>


        <span class="account-name">
            <?php echo htmlspecialchars($full_name); ?>
        </span>


        <a href="/GoGreen-APU/frontend/student/account/edit.php" class="account-manage-btn">
            <img src="/GoGreen-APU/assets/icons/square.and.pencil.svg" alt="Edit">

            <span>Manage Profile</span>
        </a>
    </div>



    <nav class="account-menu">
        <a href="/GoGreen-APU/frontend/guest/privacy_policy/index.php" class="account-menu-link">
            <span class="icon"><img src="/GoGreen-APU/assets/icons/lock.fill.svg" alt="Privacy Policy"></span>
            <span class="label">Privacy Policy</span>
        </a>

        <a href="/GoGreen-APU/frontend/guest/faq/index.php" class="account-menu-link">
            <span class="icon"><img src="/GoGreen-APU/assets/icons/text.bubble.svg" alt="FAQ"></span>
            <span class="label">FAQ</span>
        </a>

        <a href="/GoGreen-APU/frontend/guest/about_us/index.php" class="account-menu-link">
            <span class="icon"><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt="About Us"></span>
            <span class="label">About Us</span>
        </a>
    </nav>



    <div class="account-bottom">
        <a href="/GoGreen-APU/actions/logout.php" class="account-logout-btn">
            <img src="/GoGreen-APU/assets/icons/navigation/logout.svg" alt="Logout">

            <span>Logout</span>
        </a>
    </div>
</div>