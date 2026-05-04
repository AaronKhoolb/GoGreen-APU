<!--
    Author: Khoo Lay Bin
    Date: 2026-1-9
    Description: Guest Page navbar
-->
<!-- nav css -->
<link rel="stylesheet" href="/GoGreen-APU/assets/css/student/nav.css">
<!-- nav script -->
<script src="/GoGreen-APU/assets/js/student/nav.js" defer></script>

<!-- desktop nav -->
<div class="desktop-nav-container">
    <!-- logo left side -->
    <div class="desktop-nav-logo">
        <img src="/GoGreen-APU/assets/images/logo/GoGreen@APU logo.svg" alt="GoGreen@APU">
    </div>

    <!-- Right Side Group -->
    <div class="desktop-nav-right">
        <!-- search bar -->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/guest/search/index.php'; ?>

        <!-- nav buttons -->
        <nav class="desktop-nav-main glass-effect-border">
            <a href="/GoGreen-APU/frontend/guest/explore/index.php"
                class="desktop-nav-btn <?php echo ($page_name == 'explore') ? 'active' : ''; ?>" data-page="explore">
                <img src="/GoGreen-APU/assets/icons/navigation/explore.svg" alt="Explore">
                <span>Explore</span>
            </a>
            <a href="/GoGreen-APU/frontend/guest/about_us/index.php"
                class="desktop-nav-btn <?php echo ($page_name == 'about') ? 'active' : ''; ?>" data-page="about">
                <img class="nav-icon" src="/GoGreen-APU/assets/icons/info.circle.svg" alt="About">
                <span>About</span>
            </a>
            <a href="/GoGreen-APU/frontend/guest/faq/index.php"
                class="desktop-nav-btn <?php echo ($page_name == 'faq') ? 'active' : ''; ?>" data-page="faq">
                <img class="nav-icon" src="/GoGreen-APU/assets/icons/text.bubble.svg" alt="FAQ">
                <span>FAQ</span>
            </a>
        </nav>

        <!-- login button -->
        <a href="/GoGreen-APU/auth/login.php" class="desktop-account-btn glass-effect">
            <img class="nav-icon" src="/GoGreen-APU/assets/icons/navigation/person.crop.circle.fill.badge.plus.svg"
                alt="Login">
        </a>
    </div>
</div>

<!-- mobile bottom nav -->
<div class="mobile-nav-bottom">
    <nav class="mobile-nav-main glass-effect-border">
        <a href="/GoGreen-APU/frontend/guest/explore/index.php"
            class="mobile-nav-btn <?php echo ($page_name == 'explore') ? 'active glass-active-pill' : ''; ?>"
            data-page="explore">
            <img src="/GoGreen-APU/assets/icons/navigation/explore.svg" alt="Explore">
            <span>Explore</span>
        </a>
        <a href="/GoGreen-APU/frontend/guest/about_us/index.php"
            class="mobile-nav-btn <?php echo ($page_name == 'about') ? 'active glass-active-pill' : ''; ?>"
            data-page="about">
            <img class="nav-icon" src="/GoGreen-APU/assets/icons/info.circle.svg" alt="About">
            <span>About</span>
        </a>
        <a href="/GoGreen-APU/frontend/guest/faq/index.php"
            class="mobile-nav-btn <?php echo ($page_name == 'faq') ? 'active glass-active-pill' : ''; ?>"
            data-page="faq">
            <img class="nav-icon" src="/GoGreen-APU/assets/icons/text.bubble.svg" alt="FAQ">
            <span>FAQ</span>
        </a>
        <!-- Login button -->
        <a href="/GoGreen-APU/auth/login.php"
            class="mobile-nav-btn <?php echo ($page_name == 'login') ? 'active glass-active-pill' : ''; ?>"
            data-page="login">
            <img class="nav-icon" src="/GoGreen-APU/assets/icons/navigation/person.crop.circle.fill.badge.plus.svg"
                alt="Login">
            <span>Login</span>
        </a>
    </nav>

    <nav class="mobile-nav-search glass-effect-border">
        <!-- Mobile search button -> explore page -->
        <a href="/GoGreen-APU/frontend/guest/explore/index.php" class="mobile-nav-btn mobile-search-btn"
            data-page="search">
            <img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search">
        </a>
    </nav>
</div>

<!-- mobile top nav -->
<div class="mobile-nav-top">
    <div class="mobile-nav-logo">
        <img src="/GoGreen-APU/assets/images/logo/GoGreen@APU logo.svg" alt="GoGreen@APU">
    </div>
</div>
