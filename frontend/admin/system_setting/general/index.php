<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - General Settings</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/admin/general.css">
</head>

<body>
    <?php
    $page_name = 'settings_general';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-text">
                <h1>General Settings</h1>
            </div>
        </div>

        <div class="general-settings-content">
            <h3>Site Identity</h3>
            <div class="section-line"></div>
            <?php
            // Detect logo path
            $logo_path = '/GoGreen-APU/assets/images/logo/GoGreen@APU logo.svg'; // default fallback
            $possible_extensions = ['svg', 'png', 'jpeg', 'jpg', 'gif', 'webp'];
            foreach ($possible_extensions as $ext) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/logo/GoGreen@APU logo.' . $ext)) {
                    $logo_path = '/GoGreen-APU/assets/images/logo/GoGreen@APU logo.' . $ext . '?v=' . time();
                    break;
                }
            }

            // Detect icon path
            $icon_path = '/GoGreen-APU/assets/images/logo/GoGreen@APU icon.svg'; // default fallback
            $icon_extensions = ['svg', 'png', 'jpeg', 'jpg', 'gif', 'webp', 'ico'];
            foreach ($icon_extensions as $ext) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/logo/GoGreen@APU icon.' . $ext)) {
                    $icon_path = '/GoGreen-APU/assets/images/logo/GoGreen@APU icon.' . $ext . '?v=' . time();
                    break;
                }
            }
            ?>

            <!-- Preview Card -->
            <div class="preview-card glass-effect-card">
                <h3>Preview</h3>
                <span class="preview-label">Top Navigation Bar (Guest View)</span>

                <!-- Nav Bar Preview -->
                <div class="nav-preview-container">
                    <div class="nav-preview glass-effect-border">
                        <!-- Logo left side -->
                        <div class="nav-preview-logo">
                            <img src="<?php echo $logo_path; ?>" alt="GoGreen@APU">
                        </div>

                        <!-- Right Side Group -->
                        <div class="nav-preview-right">
                            <!-- Nav buttons -->
                            <div class="nav-preview-main glass-effect-border">
                                <span class="nav-preview-btn active">
                                    <img src="/GoGreen-APU/assets/icons/navigation/explore.svg" alt="Explore">
                                    <span>Explore</span>
                                </span>
                                <span class="nav-preview-btn">
                                    <img src="/GoGreen-APU/assets/icons/info.circle.svg" alt="About">
                                    <span>About</span>
                                </span>
                                <span class="nav-preview-btn">
                                    <img src="/GoGreen-APU/assets/icons/text.bubble.svg" alt="FAQ">
                                    <span>FAQ</span>
                                </span>
                            </div>

                            <!-- Login button -->
                            <span class="nav-preview-account glass-effect">
                                <img src="/GoGreen-APU/assets/icons/navigation/person.crop.circle.fill.badge.plus.svg" alt="Login">
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Icon Preview -->
                <div class="icon-preview-section">
                    <span class="preview-label">Sidebar Icon (Collapsed View)</span>
                    <div class="icon-preview-box glass-effect-border">
                        <img src="<?php echo $icon_path; ?>" alt="Current Icon">
                    </div>
                </div>
            </div>

            <form action="/GoGreen-APU/actions/admin/system_setting/update_logo.php" method="POST" enctype="multipart/form-data">
                <div class="setting-section glass-effect-card">
                    <div class="setting-text">
                        <h3>Website Logo</h3>
                        <p>This logo will appear in guest top navigation bar.</p>
                    </div>
                    <div class="setting-action">
                        <label class="upload-btn green-glass-effect-border">
                            <img src="/GoGreen-APU/assets/icons/photo.badge.plus.svg" alt="Upload">
                            <span>Select Logo</span>
                            <input type="file" name="logo" accept="image/*" hidden onchange="this.form.submit()">
                        </label>
                        <a href="/GoGreen-APU/actions/admin/system_setting/reset_logo.php" class="reset-btn red-glass-effect-border" onclick="return confirm('Are you sure you want to reset to the default logo?')">
                            <img src="/GoGreen-APU/assets/icons/clock.arrow.trianglehead.counterclockwise.rotate.90.svg" alt="Reset">
                            <span>Reset</span>
                        </a>
                    </div>
                </div>
            </form>

            <form action="/GoGreen-APU/actions/admin/system_setting/update_icon.php" method="POST" enctype="multipart/form-data">
                <div class="setting-section glass-effect-card">
                    <div class="setting-text">
                        <h3>Website Icon</h3>
                        <p>This icon will appear in sidebar collapsed view</p>
                    </div>
                    <div class="setting-action">
                        <label class="upload-btn green-glass-effect-border">
                            <img src="/GoGreen-APU/assets/icons/photo.badge.plus.svg" alt="Upload">
                            <span>Select Icon</span>
                            <input type="file" name="icon" accept="image/*" hidden onchange="this.form.submit()">
                        </label>
                        <a href="/GoGreen-APU/actions/admin/system_setting/reset_icon.php" class="reset-btn red-glass-effect-border" onclick="return confirm('Are you sure you want to reset to the default icon?')">
                            <img src="/GoGreen-APU/assets/icons/clock.arrow.trianglehead.counterclockwise.rotate.90.svg" alt="Reset">
                            <span>Reset</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>


    </main>
</body>

</html>