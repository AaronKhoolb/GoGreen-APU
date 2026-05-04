<!--
    Author: Chong Ray Han
    Date: 2026-1-30
    Description: Admin interface for creating a new club.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');
    ?>
    <title>GoGreen@APU - Admin</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/admin/club/create_club.css">
    <style>
        .form-hint {
            font-size: 13px;
            color: #aaa;
            margin: -10px 0 15px 0;
            padding-left: 5px;
        }

        .required-star {
            color: #f44336;
            margin-left: 3px;
        }
    </style>
</head>

<body>
    <?php
    $page_name = 'clubs'; // Highlight 'clubs' in sidebar
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <section class="page-content">

            <form action="/GoGreen-APU/actions/admin/club/create_club_admin.php" method="post"
                enctype="multipart/form-data" id="club-info-form">
                <div class="page-header">
                    <h2>Create New Club</h2>
                    <div class="header-actions">
                        <a href="/GoGreen-APU/frontend/admin/club/index.php" class="btn-discard" style="text-decoration:none; display:flex; align-items:center; gap:8px;">
                            <img src="/GoGreen-APU/assets/icons/x.circle.fill.svg" alt="">
                            <span>Discard</span>
                        </a>
                        <button type="submit" class="btn-save" value="Create Club">
                            <img src="/GoGreen-APU/assets/icons/plus.app.fill.svg" alt="">
                            <span>Create Club</span>
                        </button>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt=""></span>
                        <h3>Club Information</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-field">
                            <label for="club_name">Club Name <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="club_name" id="club_name" required>
                                <button type="button" class="clear-btn" data-target="club_name">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="">
                                </button>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="description">Description (Max 500 chars) <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <textarea name="description" id="description" maxlength="500" required style="height: 120px;"></textarea>
                                <button type="button" class="clear-btn" data-target="description"><img
                                        src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="club_logo">Club Logo (JPG, PNG, GIF, WebP, SVG)</label>
                            <div class="txt-container glass-effect-border">
                                <input type="file" name="club_logo" id="club_logo" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/antenna.radiowaves.left.and.right.svg" alt=""></span>
                        <h3>Contact & Web</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-field">
                            <label for="email">Club Email</label>
                            <div class="txt-container glass-effect-border">
                                <input type="email" id="email" name="email">
                                <button type="button" class="clear-btn" data-target="email">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                </button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="website_link">Website Link</label>
                            <div class="txt-container glass-effect-border">
                                <input type="url" id="website_link" name="website_link" placeholder="https://...">
                                <button type="button" class="clear-btn" data-target="website_link">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </section>
    </main>

    <script>
        <?php if (isset($_SESSION['success_message'])): ?>
            alert('<?php echo addslashes($_SESSION['success_message']); ?>');
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            alert('<?php echo addslashes($_SESSION['error_message']); ?>');
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        // Simple clear button logic if not already in included JS
        document.querySelectorAll('.clear-btn').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetInput = document.getElementById(targetId);
                if (targetInput) {
                    targetInput.value = '';
                }
            });
        });
    </script>
    <script src="/GoGreen-APU/assets/js/organizer/information.js"></script>
</body>

</html>