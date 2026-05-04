<!--
    Author: Chong Ray Han
    Date: 2026-01-28
    Description: Announcements page for organizer - send announcements to event participants
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Announcements - My Events | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/announcements.css">
</head>

<body>
    <?php
    $page_name = 'event_announcements';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/organizer/sidebar.php');

    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/backend/organizer/announcements/make_announcement.php');
    ?>

    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/organizer/my_events/hero.php'); ?>

        <section class="page-content">
            <form id="announcement-form" action="/GoGreen-APU/actions/organizer/announcements/send_announcement.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

                <div class="page-header">
                    <h2>Send Announcement</h2>
                    <div class="header-actions">
                        <button type="submit" class="btn-send" <?php echo ($participant_count == 0) ? 'disabled title="No approved participants to notify"' : ''; ?>>
                            <img src="/GoGreen-APU/assets/icons/megaphone.svg" alt="">
                            <span>Send Announcement</span>
                        </button>
                    </div>
                </div>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        Announcement sent successfully to <?php echo $notification_count; ?> participant(s)!
                    </div>
                <?php endif; ?>

                <?php if ($error == 'missing_fields'): ?>
                    <div class="alert alert-error">
                        Please fill in both title and message fields.
                    </div>
                <?php elseif ($error == 'db_error'): ?>
                    <div class="alert alert-error">
                        Failed to send announcement. Please try again.
                    </div>
                <?php endif; ?>

                <!-- Compose Announcement -->
                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/megaphone.svg" alt=""></span>
                        <h3>Compose Announcement</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="recipient-info">
                            <img src="/GoGreen-APU/assets/icons/person.3.svg" alt="">
                            <span>This announcement will be sent to <span class="recipient-count"><?php echo $participant_count; ?></span> approved participant(s)</span>
                        </div>

                        <div class="form-field">
                            <label>Announcement Title</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="title" name="title" placeholder="Enter announcement title..." required>
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Message</label>
                            <p class="field-helper">Write the message you want to send to all participants.</p>
                            <div class="txt-container glass-effect-border">
                                <textarea id="message" name="message" placeholder="Write your announcement message here..." required></textarea>
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Attach Image (Optional)</label>
                            <p class="field-helper">Attach an image to include with your announcement.</p>
                            <div class="txt-container glass-effect-border">
                                <input type="file" id="image" name="image" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Sent Announcements -->
            <div class="form-part">
                <div class="form-part-header">
                    <span><img src="/GoGreen-APU/assets/icons/clock.svg" alt=""></span>
                    <h3>Sent Announcements</h3>
                </div>

                <div class="form-part-content">
                    <?php if (count($announcements) > 0): ?>
                        <div class="announcements-list">
                            <?php foreach ($announcements as $announcement): ?>
                                <div class="announcement-card">
                                    <div class="announcement-header">
                                        <span class="announcement-title"><?php echo htmlspecialchars($announcement['title']); ?></span>
                                        <span class="announcement-meta">
                                            <span class="time">
                                                <img src="/GoGreen-APU/assets/icons/clock.svg" alt="">
                                                <?php echo date('M d, Y - h:i A', strtotime($announcement['created_at'])); ?>
                                            </span>
                                        </span>
                                    </div>
                                    <p class="announcement-message"><?php echo nl2br(htmlspecialchars($announcement['message'])); ?></p>

                                    <?php if (!empty($announcement['image_path'])): ?>
                                        <div class="announcement-image">
                                            <img src="/GoGreen-APU/uploads/announcements/<?php echo htmlspecialchars($announcement['image_path']); ?>" alt="Announcement Image">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <img src="/GoGreen-APU/assets/icons/megaphone.svg" alt="">
                            <h4>No Announcements Yet</h4>
                            <p>You haven't sent any announcements for this event.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
</body>

</html>