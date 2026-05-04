<!--
    Author: Khoo Lay Bin
    Date: 2026-01-22
    Description: Guest Event Details Page
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

        $event_id = intval($_GET['id']);
        $event_query = "SELECT e.*, c.name as club_name, c.description as club_description, c.logo_path as club_logo, c.email as club_email FROM events e LEFT JOIN clubs c ON e.club_id = c.id WHERE e.id = $event_id";
        $event_result = mysqli_query($conn, $event_query);
        $event = mysqli_fetch_assoc($event_result);

        $og_title = $event['title'] . ' - GoGreen@APU';
        $og_description = $event['short_description'];
    ?>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>


    <?php
    $participant_query = "SELECT COUNT(*) as count FROM event_participants WHERE event_id = $event_id";
    $participant_result = mysqli_query($conn, $participant_query);
    $participant_count = mysqli_fetch_assoc($participant_result)['count'];


    $comments_query = "SELECT c.*, u.first_name, u.last_name, u.avatar_path FROM comments c  LEFT JOIN users u ON c.user_id = u.id WHERE c.event_id = $event_id ORDER BY c.created_at DESC";
    $comments_result = mysqli_query($conn, $comments_query);


    $now = new DateTime();
    $registration_deadline = new DateTime($event['registration_deadline']);
    $is_deadline_passed = $now > $registration_deadline;

    $start_date = new DateTime($event['start_date']);


    if ($event['end_date']) {
        $end_date = new DateTime($event['end_date']);
    } else {
        $end_date = null;
    }


    if (!$end_date || $start_date->format('Y-m-d') === $end_date->format('Y-m-d')) {
        $is_single_date = true;
    } else {
        $is_single_date = false;
    }


    if ($end_date) {
        $is_event_ended = $now > $end_date;
    } else {
        $is_event_ended = $now > $start_date;
    }


    $cert_check_query = "SELECT event_id FROM certificate WHERE event_id = $event_id";
    $cert_check_result = mysqli_query($conn, $cert_check_query);
    $has_certificate = $cert_check_result && mysqli_num_rows($cert_check_result) > 0;

    $is_full = $participant_count >= $event['max_participants'];
    $is_paid = $event['is_paid'] == 1;
    $is_approved = $event['is_approved'] == 1;
    $has_transportation = $event['transportation'] == 1;
    $has_transport_details = !empty($event['transport_details']);
    $has_map = !empty($event['embed_map']);



    $start_day = (int) $start_date->format('j');
    if ($end_date) {
        $end_day = (int) $end_date->format('j');
    } else {
        $end_day = $start_day;
    }

    function formatTime($time)
    {
        if (!$time)
            return '';
        return date('g:i A', strtotime($time));
    }


    function formatDate($date)
    {
        return $date->format('D, j M Y');
    }
    ?>


    <link rel="stylesheet" href="/GoGreen-APU/assets/css/guest/nav.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/explore/event-details.css">
    <script src="/GoGreen-APU/assets/js/student/explore/share.js" defer></script>
</head>

<body>
    <?php
    $page_name = 'explore';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/guest/nav.php');
    ?>

    <div class="main-content">
        <div class="event-page">

            <a href="/GoGreen-APU/frontend/guest/explore/" class="event-back-btn glass-effect-card">
                <img class="icon" src="/GoGreen-APU/assets/icons/chevron.left.svg" alt="Back">
            </a>

            <div class="event-grid">
                <div class="event-left">

                    <div class="event-poster glass-effect-card">
                        <img src="/GoGreen-APU/assets/images/event/<?php echo htmlspecialchars($event['image_path']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                    </div>


                    <div class="event-header">
                        <h1 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h1>

                        <p class="event-description"><?php echo htmlspecialchars($event['short_description']); ?></p>


                        <div class="sdg-pills">
                            <span class="sdg-pill sdg1" style="<?php if ($event['sdg1'] != 1) echo 'display:none;'; ?>">SDG 1: No Poverty</span>
                            <span class="sdg-pill sdg2" style="<?php if ($event['sdg2'] != 1) echo 'display:none;'; ?>">SDG 2: Zero Hunger</span>
                            <span class="sdg-pill sdg3" style="<?php if ($event['sdg3'] != 1) echo 'display:none;'; ?>">SDG 3: Good Health</span>
                            <span class="sdg-pill sdg4" style="<?php if ($event['sdg4'] != 1) echo 'display:none;'; ?>">SDG 4: Quality Education</span>
                            <span class="sdg-pill sdg5" style="<?php if ($event['sdg5'] != 1) echo 'display:none;'; ?>">SDG 5: Gender Equality</span>
                            <span class="sdg-pill sdg6" style="<?php if ($event['sdg6'] != 1) echo 'display:none;'; ?>">SDG 6: Clean Water</span>
                            <span class="sdg-pill sdg7" style="<?php if ($event['sdg7'] != 1) echo 'display:none;'; ?>">SDG 7: Clean Energy</span>
                            <span class="sdg-pill sdg8" style="<?php if ($event['sdg8'] != 1) echo 'display:none;'; ?>">SDG 8: Decent Work</span>
                            <span class="sdg-pill sdg9" style="<?php if ($event['sdg9'] != 1) echo 'display:none;'; ?>">SDG 9: Industry & Innovation</span>
                            <span class="sdg-pill sdg10" style="<?php if ($event['sdg10'] != 1) echo 'display:none;'; ?>">SDG 10: Reduced Inequality</span>
                            <span class="sdg-pill sdg11" style="<?php if ($event['sdg11'] != 1) echo 'display:none;'; ?>">SDG 11: Sustainable Cities</span>
                            <span class="sdg-pill sdg12" style="<?php if ($event['sdg12'] != 1) echo 'display:none;'; ?>">SDG 12: Responsible Consumption</span>
                            <span class="sdg-pill sdg13" style="<?php if ($event['sdg13'] != 1) echo 'display:none;'; ?>">SDG 13: Climate Action</span>
                            <span class="sdg-pill sdg14" style="<?php if ($event['sdg14'] != 1) echo 'display:none;'; ?>">SDG 14: Life Below Water</span>
                            <span class="sdg-pill sdg15" style="<?php if ($event['sdg15'] != 1) echo 'display:none;'; ?>">SDG 15: Life on Land</span>
                            <span class="sdg-pill sdg16" style="<?php if ($event['sdg16'] != 1) echo 'display:none;'; ?>">SDG 16: Peace & Justice</span>
                            <span class="sdg-pill sdg17" style="<?php if ($event['sdg17'] != 1) echo 'display:none;'; ?>">SDG 17: Partnerships</span>
                        </div>
                    </div>


                    <div class="event-meta-card glass-effect-card">
                        <div class="meta-row">
                            <div class="meta-icon date-range">
                                <img class="icon" src="/GoGreen-APU/assets/icons/date/<?php echo $start_day; ?>.calendar.svg" alt="Start">


                                <?php if (!$is_single_date): ?>
                                    <span class="date-separator">-</span>

                                    <img class="icon" src="/GoGreen-APU/assets/icons/date/<?php echo $end_day; ?>.calendar.svg" alt="End">
                                <?php endif; ?>
                            </div>


                            <div class="meta-content">
                                <p class="meta-label">Date</p>


                                <p class="meta-value">
                                    <?php if ($is_single_date): ?>
                                        <?php echo formatDate($start_date); ?>

                                    <?php else: ?>
                                        <?php echo formatDate($start_date); ?> - <?php echo formatDate($end_date); ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>


                        <div class="meta-row">
                            <div class="meta-icon">
                                <img class="icon" src="/GoGreen-APU/assets/icons/clock.svg" alt="Time">
                            </div>


                            <div class="meta-content">
                                <p class="meta-label">Time</p>


                                <p class="meta-value">
                                    <?php if ($event['end_time']): ?>
                                        <?php echo formatTime($event['start_time']); ?> -
                                        <?php echo formatTime($event['end_time']); ?>

                                    <?php else: ?>
                                        <?php echo formatTime($event['start_time']); ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>


                        <div class="meta-row">
                            <div class="meta-icon">
                                <img class="icon" src="/GoGreen-APU/assets/icons/bus.svg" alt="Transportation">
                            </div>


                            <div class="meta-content">
                                <p class="meta-label">Transportation</p>


                                <p class="meta-value">
                                    <?php if ($has_transportation): ?>
                                        <span class="transport-pill provided">Provided</span>

                                    <?php else: ?>
                                        <span class="transport-pill not-provided">Not Provided</span>
                                    <?php endif; ?>
                                </p>


                                <?php if ($has_transportation && $has_transport_details): ?>
                                    <div class="html-content">
                                        <?php echo $event['transport_details']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>


                        <div class="meta-row <?php if (!$has_map) echo 'no-border'; ?>">

                            <div class="meta-icon">
                                <img class="icon" src="/GoGreen-APU/assets/icons/mappin.and.ellipse.svg" alt="Location">
                            </div>


                            <div class="meta-content">
                                <p class="meta-label">Location</p>

                                <p class="meta-value"><?php echo htmlspecialchars($event['location']); ?></p>
                            </div>
                        </div>


                        <?php if ($has_map): ?>
                            <div class="event-map">
                                <?php echo $event['embed_map']; ?>
                            </div>
                        <?php endif; ?>
                    </div>


                    <div class="event-about">
                        <div class="section-header">
                            <h2 class="section-title">About Event</h2>

                            <div class="section-line"></div>
                        </div>


                        <div class="html-content">
                            <?php echo $event['details']; ?>
                        </div>
                    </div>


                    <?php
                    $has_any_social = !empty($event['instagram']) || !empty($event['whatsapp']) || !empty($event['facebook']) || !empty($event['discord']) || !empty($event['teams']) || !empty($event['phone_no']);
                    ?>
                    <?php if ($has_any_social): ?>
                        <div class="event-social-section">
                            <div class="section-header">
                                <h2 class="section-title">Contact & Social</h2>

                                <div class="section-line"></div>
                            </div>


                            <div class="event-social-grid">
                                <?php if (!empty($event['instagram'])): ?>
                                    <a href="<?php echo htmlspecialchars($event['instagram']); ?>" target="_blank" class="event-social-link instagram">
                                        <img class="icon" src="/GoGreen-APU/assets/icons/social/instagram-167-svgrepo-com.svg" alt="Instagram">

                                        <span>Instagram</span>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($event['whatsapp'])): ?>
                                    <a href="<?php echo htmlspecialchars($event['whatsapp']); ?>" target="_blank" class="event-social-link whatsapp">
                                        <img class="icon" src="/GoGreen-APU/assets/icons/social/whatsapp-svgrepo-com.svg" alt="WhatsApp">

                                        <span>WhatsApp</span>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($event['facebook'])): ?>
                                    <a href="<?php echo htmlspecialchars($event['facebook']); ?>" target="_blank" class="event-social-link facebook">
                                        <img class="icon" src="/GoGreen-APU/assets/icons/social/facebook-svgrepo-com.svg" alt="Facebook">

                                        <span>Facebook</span>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($event['discord'])): ?>
                                    <a href="<?php echo htmlspecialchars($event['discord']); ?>" target="_blank" class="event-social-link discord">
                                        <img class="icon" src="/GoGreen-APU/assets/icons/social/discord-svgrepo-com.svg" alt="Discord">

                                        <span>Discord</span>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($event['teams'])): ?>
                                    <a href="<?php echo htmlspecialchars($event['teams']); ?>" target="_blank" class="event-social-link teams">
                                        <img class="icon" src="/GoGreen-APU/assets/icons/social/teams-fill.svg" alt="Teams">

                                        <span>Teams</span>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($event['phone_no'])): ?>
                                    <a href="tel:<?php echo htmlspecialchars($event['phone_no']); ?>" class="event-social-link phone">
                                        <img class="icon" src="/GoGreen-APU/assets/icons/social/phone.svg" alt="Phone">

                                        <span>Call</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>



                <div class="event-sidebar">

                    <a href="/GoGreen-APU/frontend/guest/explore/?club=<?php echo $event['club_id']; ?>" class="club-card glass-effect-card">
                        <div class="club-logo">
                            <img src="/GoGreen-APU/assets/images/club/<?php echo htmlspecialchars($event['club_logo']); ?>" alt="<?php echo htmlspecialchars($event['club_name']); ?>">
                        </div>


                        <div class="club-info">
                            <p class="club-label">Presented by</p>

                            <h3 class="club-name"><?php echo htmlspecialchars($event['club_name']); ?></h3>

                            <p class="club-desc">
                                <?php echo htmlspecialchars($event['club_description']); ?>
                            </p>
                        </div>
                    </a>


                    <?php if (!$is_deadline_passed && !$is_event_ended): ?>
                        <div class="registration-card glass-effect-card">

                            <div class="participants-info">
                                <div class="participants-header">
                                    <div class="participants-count">
                                        <img class="icon" src="/GoGreen-APU/assets/icons/person.3.fill.svg" alt="Participants">

                                        <?php if ($is_full): ?>
                                            <span>Full</span>

                                        <?php else: ?>
                                            <span><?php echo $participant_count; ?> Going</span>
                                        <?php endif; ?>
                                    </div>


                                    <span class="participants-max">Max Participants: <?php echo $event['max_participants']; ?></span>
                                </div>


                                <div class="progress-track">
                                    <div class="progress-fill"
                                        style="width: <?php echo ($participant_count / $event['max_participants']) * 100; ?>%;">
                                    </div>
                                </div>
                            </div>


                            <div class="deadline-row">
                                <img class="icon" src="/GoGreen-APU/assets/icons/bell.fill.svg" alt="Deadline">

                                <span class="deadline-label">Deadline:</span>

                                <span class="deadline-value"><?php echo date('M j, Y @ h:i A', strtotime($event['registration_deadline'])); ?></span>
                            </div>


                            <div class="ticket-box">
                                <div class="ticket-row">
                                    <span class="ticket-price">
                                        <?php if ($is_paid): ?>
                                            RM <?php echo number_format($event['price'], 2); ?>

                                        <?php else: ?>
                                            FREE
                                        <?php endif; ?>
                                    </span>


                                    <span class="ticket-coins">+<?php echo $event['coins_earned']; ?> AP Coins</span>
                                </div>
                            </div>


                            <div class="registration-buttons">
                                <a href="/GoGreen-APU/auth/login.php" class="register-btn login-btn">Login to Register</a>
                            </div>


                            <div class="info-note">
                                <img class="icon" src="/GoGreen-APU/assets/icons/info.circle.svg" alt="Info">

                                <span>Login required to register for events</span>
                            </div>


                            <div class="social-actions">
                                <form action="/GoGreen-APU/actions/student/event/like.php" method="POST">
                                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">


                                    <button type="submit" class="like-btn">
                                        <img class="icon" src="/GoGreen-APU/assets/icons/hand.thumbsup.svg" alt="Like">

                                        <span>Like (<?php echo $event['like_count']; ?>)</span>
                                    </button>
                                </form>


                                <button class="share-btn"
                                    data-url="/GoGreen-APU/frontend/guest/explore/event/?id=<?php echo $event_id; ?>"
                                    data-title="<?php echo htmlspecialchars($event['title']); ?> | GoGreen@APU"
                                    data-description="<?php echo htmlspecialchars($event['short_description']); ?>">

                                    <img class="icon" src="/GoGreen-APU/assets/icons/link.svg" alt="Share">
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>


                    <?php if ($is_deadline_passed || $is_event_ended): ?>
                        <div class="registration-closed-card glass-effect-card">
                            <div class="closed-header">
                                <img class="icon" src="/GoGreen-APU/assets/icons/lock.fill.svg" alt="Closed">

                                <h3 class="closed-title">
                                    <?php if ($is_event_ended): ?>
                                        Event Ended

                                    <?php else: ?>
                                        Registration Closed
                                    <?php endif; ?>
                                </h3>
                            </div>


                            <p class="closed-message">
                                <?php if ($is_event_ended): ?>
                                    This event has already ended. Check out other upcoming events!

                                <?php else: ?>
                                    The registration deadline for this event has passed.
                                <?php endif; ?>
                            </p>


                            <a href="/GoGreen-APU/frontend/guest/explore/" class="browse-btn">Browse Other Events</a>


                            <div class="social-actions">
                                <form action="/GoGreen-APU/actions/student/event/like.php" method="POST">
                                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">


                                    <button type="submit" class="like-btn">
                                        <img class="icon" src="/GoGreen-APU/assets/icons/hand.thumbsup.svg" alt="Like">

                                        <span>Like (<?php echo $event['like_count']; ?>)</span>
                                    </button>
                                </form>


                                <button class="share-btn"
                                    data-url="/GoGreen-APU/frontend/guest/explore/event/?id=<?php echo $event_id; ?>"
                                    data-title="<?php echo htmlspecialchars($event['title']); ?> | GoGreen@APU"
                                    data-description="<?php echo htmlspecialchars($event['short_description']); ?>">

                                    <img class="icon" src="/GoGreen-APU/assets/icons/link.svg" alt="Share">
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>


                    <div class="certificate-card glass-effect-card">
                        <div class="certificate-header">
                            <img class="icon" src="/GoGreen-APU/assets/icons/certificate.svg" alt="Certificate">

                            <h3 class="certificate-title">Certificate</h3>
                        </div>


                        <p class="certificate-message">Preview the participation certificate for this event.</p>


                        <div class="certificate-buttons">
                            <a href="/GoGreen-APU/frontend/guest/certificate/preview/index.php?id=<?php echo $event_id; ?>" class="action-btn"
                                <?php if (!$is_approved)
                                    echo 'style="pointer-events:none;opacity:0.5;"';
                                ?>>
                                <img class="icon" src="/GoGreen-APU/assets/icons/eye.svg" alt="Preview">

                                <span>Preview Certificate</span>
                            </a>
                        </div>
                    </div>


                    <div class="feedback-card glass-effect-card">
                        <div class="feedback-header">
                            <div class="feedback-title-area">
                                <img class="icon" src="/GoGreen-APU/assets/icons/text.bubble.svg" alt="Comment">

                                <h3 class="feedback-title">Comments</h3>
                            </div>
                        </div>


                        <div class="comments-list">
                            <?php if ($comments_result && mysqli_num_rows($comments_result) > 0): ?>
                                <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
                                    <div class="comment-item">
                                        <div class="comment-avatar">
                                            <img src="/GoGreen-APU/assets/images/profile/<?php echo $comment['avatar_path']; ?>" alt="Avatar">
                                        </div>


                                        <div class="comment-content">
                                            <div class="comment-header">
                                                <span class="comment-author"><?php echo htmlspecialchars($comment['last_name'] . ' ' . $comment['first_name']); ?></span>

                                                <span class="comment-date">
                                                    <?php
                                                        $comment_time = strtotime($comment['created_at']);
                                                        $diff = time() - $comment_time;

                                                        if ($diff < 60) {
                                                            echo 'Just now';
                                                        } else if ($diff < 3600) {
                                                            $mins = floor($diff / 60);
                                                            echo $mins . ' min ago';
                                                        } else if ($diff < 86400) {
                                                            $hours = floor($diff / 3600);
                                                            echo $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
                                                        } else {
                                                            $days = floor($diff / 86400);
                                                            echo $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
                                                        }
                                                    ?>
                                                </span>
                                            </div>


                                            <p class="comment-text"><?php echo htmlspecialchars($comment['comment']); ?></p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>

                            <?php else: ?>
                                <p style="color: rgba(255,255,255,0.4); text-align: center; font-size: 13px; padding: 20px 0;">No comments yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>
</body>

</html>