<!--
    Author: Chong Ray Han
    Date: 2026-01-28
    Description: Student Notifications Page
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/notification/notification.css">
    <title>GoGreen@APU - Notifications</title>
</head>

<body>
    <?php
    $page_name = 'notification';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/nav.php');

    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/actions/student/notification/get_notifications.php');

    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

    $filter_all = ($filter == 'all');
    $filter_unread = ($filter == 'unread');
    $filter_events = ($filter == 'events');
    $filter_system = ($filter == 'system');

    $user_id = $_SESSION['user_id'];

    // Fetch notifications using backend function
    $notifications = getNotifications($conn, $user_id, $filter);

    // Count unread notifications
    $count_unread = countUnreadNotifications($conn, $user_id);
    ?>

    <main class="main-content">
        <div class="notification-page">
            <div class="notification-header">
                <h1>Notifications</h1>
                <?php if ($count_unread > 0): ?>
                    <a href="/GoGreen-APU/actions/student/notification/mark_read.php?action=all" class="mark-all-read-btn">
                        Mark all as read
                    </a>
                <?php endif; ?>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-header">
                    <span class="filter-label">Filter by Type</span>
                    <?php if ($filter != 'all'): ?>
                        <a href="?" class="filter-clear">Clear</a>
                    <?php endif; ?>
                </div>

                <div class="filter-row">
                    <a href="?" class="filter-btn filter-all <?php if ($filter_all) echo 'active'; ?>">
                        <img src="/GoGreen-APU/assets/icons/bell.fill.svg" alt="">
                        <span>All</span>
                    </a>
                    <a href="?filter=unread" class="filter-btn filter-unread <?php if ($filter_unread) echo 'active'; ?>">
                        <img src="/GoGreen-APU/assets/icons/envelope.svg" alt="">
                        <span>Unread</span>
                        <?php if ($count_unread > 0): ?>
                            <span class="filter-badge"><?php echo $count_unread; ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="?filter=events" class="filter-btn filter-events <?php if ($filter_events) echo 'active'; ?>">
                        <img src="/GoGreen-APU/assets/icons/calendar.badge.clock.svg" alt="">
                        <span>Events</span>
                    </a>
                    <a href="?filter=system" class="filter-btn filter-system <?php if ($filter_system) echo 'active'; ?>">
                        <img src="/GoGreen-APU/assets/icons/gearshape.fill.svg" alt="">
                        <span>System</span>
                    </a>
                </div>
            </div>

            <?php if (count($notifications) > 0): ?>
                <!-- Notifications List -->
                <div class="notification-list">
                    <?php foreach ($notifications as $notif):
                        $is_unread = ($notif['is_read'] == 0);
                        $notif_type = $notif['type'];
                        $category = ($notif_type == 'event' || $notif_type == 'reward') ? 'events' : 'system';
                        $time_ago = getTimeAgo($notif['created_at']);

                        $notif_link = getNotificationLink($notif);
                        $image_data = getNotificationImage($notif);
                        $show_image = $image_data['show_image'];
                        $image_url = $image_data['image_url'];
                        $icon_data = getNotificationIcon($notif);
                        $icon_path = $icon_data['icon_path'];
                        $icon_class = $icon_data['icon_class'];
                    ?>
                        <a href="<?php echo $notif_link; ?>" class="notification-item <?php if ($is_unread) echo 'unread'; ?> <?php if ($show_image) echo 'has-image'; ?>" data-type="<?php echo $category; ?>" data-id="<?php echo $notif['id']; ?>">
                            <?php if ($show_image): ?>
                                <div class="notification-image">
                                    <img src="<?php echo $image_url; ?>" alt="">
                                </div>
                            <?php else: ?>
                                <div class="notification-icon <?php echo $icon_class; ?>">
                                    <img src="<?php echo $icon_path; ?>" alt="">
                                </div>
                            <?php endif; ?>
                            <div class="notification-content">
                                <h3 class="notification-title"><?php echo htmlspecialchars($notif['title']); ?></h3>
                                <p class="notification-text"><?php echo htmlspecialchars($notif['message']); ?></p>
                                <span class="notification-time"><?php echo $time_ago; ?></span>
                            </div>
                            <div class="notification-actions">
                                <?php if ($is_unread): ?>
                                    <span class="unread-dot"></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <img src="/GoGreen-APU/assets/icons/bell.fill.svg" alt="">
                    <h3>No Notifications</h3>
                    <p>
                        <?php if ($filter == 'unread'): ?>
                            You're all caught up! No unread notifications.
                        <?php elseif ($filter == 'events'): ?>
                            No event notifications yet.
                        <?php elseif ($filter == 'system'): ?>
                            No system notifications yet.
                        <?php else: ?>
                            You don't have any notifications yet. Check back later for updates.
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mark notification as read when clicked
            const notificationItems = document.querySelectorAll('.notification-item');

            notificationItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    const notifId = this.dataset.id;
                    const isUnread = this.classList.contains('unread');
                    const originalHref = this.getAttribute('href');

                    if (isUnread && notifId) {
                        e.preventDefault();
                        sessionStorage.setItem('notification_redirect', originalHref);
                        window.location.href = '/GoGreen-APU/actions/student/notification/mark_read.php?id=' + notifId + '&redirect=' + encodeURIComponent(originalHref);
                    }
                });
            });

            const storedRedirect = sessionStorage.getItem('notification_redirect');
            if (storedRedirect && storedRedirect !== '#') {
                sessionStorage.removeItem('notification_redirect');
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('success') && urlParams.get('success') === 'marked') {
                    window.location.href = storedRedirect;
                }
            }
        });
    </script>
</body>

</html>