<!--
    Author: Chong Ray Han
    Date: 2026-02-05
    Description: Admin interface for editing club information.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/backend/admin/club/manage_club.php');
    ?>
    <title>GoGreen@APU - Admin - Manage Club</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/admin/club/create_club.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/admin/club/manage_club.css">
</head>

<body>
    <?php
    $page_name = 'club';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <section class="page-content">
            <?php if ($club): ?>
                <form action="/GoGreen-APU/actions/admin/club/update_club.php" method="post"
                    enctype="multipart/form-data" id="club-info-form">
                    <input type="hidden" name="club_id" value="<?php echo $club['id']; ?>">

                    <div class="page-header">
                        <h2>Edit Club</h2>
                        <div class="header-actions">
                            <a href="/GoGreen-APU/frontend/admin/club/index.php" class="btn-discard" style="text-decoration:none; display:flex; align-items:center; gap:8px;">
                                <img src="/GoGreen-APU/assets/icons/x.circle.fill.svg" alt="">
                                <span>Cancel</span>
                            </a>
                            <button type="submit" class="btn-save" value="Save Changes">
                                <img src="/GoGreen-APU/assets/icons/square.and.pencil.svg" alt="">
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </div>

                    <!-- Club Stats -->
                    <div class="club-stats">
                        <div class="club-stat-item">
                            <img src="/GoGreen-APU/assets/icons/my_events.svg" alt="Events">
                            <div class="stat-info">
                                <span class="stat-value"><?php echo $event_count; ?></span>
                                <span class="stat-label">Events</span>
                            </div>
                        </div>
                        <div class="club-stat-item">
                            <img src="/GoGreen-APU/assets/icons/person.3.fill.svg" alt="Organizers">
                            <div class="stat-info">
                                <span class="stat-value"><?php echo $organizer_count; ?></span>
                                <span class="stat-label">Organizers</span>
                            </div>
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
                                    <input type="text" name="club_name" id="club_name" required
                                        value="<?php echo htmlspecialchars($club['name']); ?>">
                                    <button type="button" class="clear-btn" data-target="club_name">
                                        <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="">
                                    </button>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="description">Description (Max 500 chars) <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <textarea name="description" id="description" maxlength="500" required style="height: 120px;"><?php echo htmlspecialchars($club['description']); ?></textarea>
                                    <button type="button" class="clear-btn" data-target="description"><img
                                            src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                                </div>
                            </div>

                            <div class="form-field">
                                <label>Current Logo</label>
                                <div class="current-logo-preview">
                                    <?php if (!empty($club['logo_path']) && $club['logo_path'] !== 'default.png'): ?>
                                        <img src="/GoGreen-APU/assets/images/club/<?php echo htmlspecialchars($club['logo_path']); ?>" alt="Club Logo">
                                        <div class="logo-info">
                                            <span class="logo-label">Current File</span>
                                            <span class="logo-name"><?php echo htmlspecialchars($club['logo_path']); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <img src="/GoGreen-APU/assets/icons/diversity_3_1000dp_1F1F1F_FILL0_wght400_GRAD0_opsz48.svg" alt="Default Logo" style="opacity: 0.3;">
                                        <div class="logo-info">
                                            <span class="logo-label">Current</span>
                                            <span class="logo-name">No custom logo set</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="club_logo">Change Logo (JPG, PNG, GIF, WebP, SVG)</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="file" name="club_logo" id="club_logo" accept="image/*">
                                </div>
                                <p class="form-hint">Leave empty to keep the current logo.</p>
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
                                    <input type="email" id="email" name="email"
                                        value="<?php echo htmlspecialchars($club['email'] ?? ''); ?>">
                                    <button type="button" class="clear-btn" data-target="email">
                                        <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                    </button>
                                </div>
                            </div>
                            <div class="form-field">
                                <label for="website_link">Website Link</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="url" id="website_link" name="website_link" placeholder="https://..."
                                        value="<?php echo htmlspecialchars($club['website_link'] ?? ''); ?>">
                                    <button type="button" class="clear-btn" data-target="website_link">
                                        <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <div class="error-state">
                    <img src="/GoGreen-APU/assets/icons/exclamationmark.triangle.svg" alt="Error">
                    <h3>Club Not Found</h3>
                    <p>The club you're looking for doesn't exist or may have been deleted.</p>
                    <a href="/GoGreen-APU/frontend/admin/club/index.php">
                        <img src="/GoGreen-APU/assets/icons/arrow.left.svg" alt="">
                        <span>Back to Clubs</span>
                    </a>
                </div>
            <?php endif; ?>

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

        // Simple clear button logic
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