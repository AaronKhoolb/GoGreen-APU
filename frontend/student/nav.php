<!--
    Author: Khoo Lay Bin
    Date: 2025-11-5
    Description: Student mobile nav (bottom nav button, top logo and notification button) and desktop top nav
-->


<link rel="stylesheet" href="/GoGreen-APU/assets/css/student/nav.css">
<link rel="stylesheet" href="/GoGreen-APU/assets/css/student/account.css">

<script src="/GoGreen-APU/assets/js/student/nav.js"></script>


<!-- Desktop Part-->
<div class="desktop-nav-container">
    <div class="desktop-nav-logo">
        <img src="/GoGreen-APU/assets/images/logo/GoGreen@APU logo.svg" alt="GoGreen@APU">
    </div>


    <div class="desktop-nav-right">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/search/index.php'; ?>


        <nav class="desktop-nav-main glass-effect-border">
            <a href="/GoGreen-APU/frontend/student/index.php"
                class="desktop-nav-btn <?php echo ($page_name == 'home') ? 'active' : ''; ?>" data-page="home">
                <img src="/GoGreen-APU/assets/icons/navigation/home.svg" alt="Home">
                <span>Home</span>
            </a>
            <a href="/GoGreen-APU/frontend/student/explore/index.php"
                class="desktop-nav-btn <?php echo ($page_name == 'explore') ? 'active' : ''; ?>" data-page="explore">
                <img src="/GoGreen-APU/assets/icons/navigation/explore.svg" alt="Explore">
                <span>Explore</span>
            </a>
            <a href="/GoGreen-APU/frontend/student/rewards/index.php"
                class="desktop-nav-btn <?php echo ($page_name == 'rewards') ? 'active' : ''; ?>" data-page="rewards">
                <img src="/GoGreen-APU/assets/icons/navigation/rewards.svg" alt="Rewards">
                <span>Rewards</span>
            </a>
        </nav>


        <a href="/GoGreen-APU/frontend/student/notification/index.php"
            class="desktop-notification-btn <?php echo ($page_name == 'notification') ? 'active' : ''; ?>"
            data-page="notification">
            <img src="/GoGreen-APU/assets/icons/navigation/notification.badge.svg" alt="Notification">
        </a>


        <button type="button" onclick="document.getElementById('account-modal-overlay').classList.toggle('show')"
            class="desktop-account-btn glass-effect <?php echo ($page_name == 'account') ? 'active' : ''; ?>">
            <img src="/GoGreen-APU/assets/images/profile/<?php echo htmlspecialchars($_SESSION['avatar_path']); ?>"
                alt="Account">
        </button>
    </div>
</div>


<div class="account-modal-overlay" id="account-modal-overlay"
    onclick="if(event.target === this) this.classList.remove('show')">
    <div class="account-modal glass-modal">
        <button type="button" class="account-modal-close"
            onclick="document.getElementById('account-modal-overlay').classList.remove('show')">
            <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Close">
        </button>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/account/content.php'; ?>
    </div>
</div>




<!-- This mobile de -->
<div class="mobile-nav-bottom">
    <nav class="mobile-nav-main glass-effect-border">
        <a href="/GoGreen-APU/frontend/student/index.php"
            class="mobile-nav-btn <?php echo ($page_name == 'home') ? 'active glass-active-pill' : ''; ?>"
            data-page="home">
            <img src="/GoGreen-APU/assets/icons/navigation/home.svg" alt="Home">
            <span>Home</span>
        </a>
        <a href="/GoGreen-APU/frontend/student/explore/index.php"
            class="mobile-nav-btn <?php echo ($page_name == 'explore') ? 'active glass-active-pill' : ''; ?>"
            data-page="explore">
            <img src="/GoGreen-APU/assets/icons/navigation/explore.svg" alt="Explore">
            <span>Explore</span>
        </a>
        <a href="/GoGreen-APU/frontend/student/rewards/index.php"
            class="mobile-nav-btn <?php echo ($page_name == 'rewards') ? 'active glass-active-pill' : ''; ?>"
            data-page="rewards">
            <img src="/GoGreen-APU/assets/icons/navigation/rewards.svg" alt="Rewards">
            <span>Rewards</span>
        </a>
        <a href="/GoGreen-APU/frontend/student/account/index.php"
            class="mobile-nav-btn account-with-avatar <?php echo ($page_name == 'account') ? 'active glass-active-pill' : ''; ?>"
            data-page="account">
            <img class="mobile-account-avatar"
                src="/GoGreen-APU/assets/images/profile/<?php echo htmlspecialchars($_SESSION['avatar_path']); ?>"
                alt="Account">
            <span>Account</span>
        </a>
    </nav>


    <nav class="mobile-nav-search glass-effect-border">
        <a href="/GoGreen-APU/frontend/student/explore/index.php" class="mobile-nav-btn mobile-search-btn"
            data-page="search">
            <img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search">
        </a>
    </nav>
</div>

<!-- mobile top de logo and notification -->
<div class="mobile-nav-top">
    <div class="mobile-nav-logo">
        <img src="/GoGreen-APU/assets/images/logo/GoGreen@APU logo.svg" alt="GoGreen@APU">
    </div>

    
    <nav class="mobile-nav-notification glass-effect-border">
        <a href="/GoGreen-APU/frontend/student/notification/index.php"
            class="mobile-nav-btn mobile-notification-btn <?php echo ($page_name == 'notification') ? 'active glass-active-pill' : ''; ?>"
            data-page="notification">
            <img src="/GoGreen-APU/assets/icons/navigation/notification.badge.svg" alt="Notification">
        </a>
    </nav>
</div>