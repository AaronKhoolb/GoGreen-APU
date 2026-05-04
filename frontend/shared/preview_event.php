<!--
    Author: Khoo Lay Bin
    Date: 2026-01-24
    Description: Admin, Organizer, Collaborator preview event page
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <?php

    $event_id = intval($_GET['id']);


    $event_query = "SELECT e.*, c.name as club_name, c.description as club_description, c.logo_path as club_logo, c.email as club_email FROM events e LEFT JOIN clubs c ON e.club_id = c.id WHERE e.id = $event_id";
    $event_result = mysqli_query($conn, $event_query);
    $event = mysqli_fetch_assoc($event_result);


    $participant_query = "SELECT COUNT(*) as count FROM event_participants WHERE event_id = $event_id";
    $participant_result = mysqli_query($conn, $participant_query);
    $participant_count = mysqli_fetch_assoc($participant_result)['count'];

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

    $is_paid = $event['is_paid'] == 1;
    $has_transportation = $event['transportation'] == 1;
    $has_transport_details = !empty($event['transport_details']);
    $has_map = !empty($event['embed_map']);

    $start_day = (int) $start_date->format('j');

    function formatTime($time)
    {
        if (!$time) {
            return '';
        }
        return date('g:i A', strtotime($time));
    }

    function formatDate($date)
    {
        return $date->format('D, j M Y');
    }
    ?>
    <title>
        <?php echo htmlspecialchars($event['title']); ?> - Preview
    </title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/explore/event-details.css">
</head>

<body>
    <div class="main-content" style="padding-top: 30px;">
        <div class="event-page">
            <!-- Back Button -->
            <button onclick="window.close()" class="event-back-btn glass-effect-card"
                style="border: none; cursor: pointer;">
                <img class="icon" src="/GoGreen-APU/assets/icons/chevron.left.svg" alt="Back">
            </button>

            <div class="event-grid">

                <div class="event-left">
                    <div class="event-poster glass-effect-card">
                        <img src="/GoGreen-APU/assets/images/event/<?php echo htmlspecialchars($event['image_path']); ?>"
                            alt="<?php echo htmlspecialchars($event['title']); ?>">
                    </div>


                    <div class="event-header">
                        <h1 class="event-title">
                            <?php echo htmlspecialchars($event['title']); ?>
                        </h1>

                        <p class="event-description">
                            <?php echo htmlspecialchars($event['short_description']); ?>
                        </p>


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
                                <img class="icon"
                                    src="/GoGreen-APU/assets/icons/date/<?php echo $start_day; ?>.calendar.svg"
                                    alt="Start">


                                <?php if (!$is_single_date): ?>
                                    <span class="date-separator">-</span>

                                    <img class="icon"
                                        src="/GoGreen-APU/assets/icons/date/<?php echo (int) $end_date->format('j'); ?>.calendar.svg"
                                        alt="End">
                                <?php endif; ?>
                            </div>


                            <div class="meta-content">
                                <p class="meta-label">Date</p>

                                <p class="meta-value">
                                    <?php if ($is_single_date): ?>
                                        <?php echo formatDate($start_date); ?>


                                    <?php else: ?>
                                        <?php echo formatDate($start_date); ?> -

                                        <?php echo formatDate($end_date); ?>
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


                        <div class="meta-row <?php if (!$has_map) {
                            echo 'no-border';
                        } ?>">

                            <div class="meta-icon">
                                <img class="icon" src="/GoGreen-APU/assets/icons/mappin.and.ellipse.svg" alt="Location">
                            </div>
                            <div class="meta-content">
                                <p class="meta-label">Location</p>

                                <p class="meta-value">
                                    <?php echo htmlspecialchars($event['location']); ?>
                                </p>
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

                    <div class="club-card glass-effect-card">
                        <div class="club-logo">
                            <img src="/GoGreen-APU/assets/images/club/<?php echo htmlspecialchars($event['club_logo']); ?>"
                                alt="<?php echo htmlspecialchars($event['club_name']); ?>">
                        </div>

                        <div class="club-info">
                            <p class="club-label">Presented by</p>

                            <h3 class="club-name">
                                <?php echo htmlspecialchars($event['club_name']); ?>
                            </h3>

                            <p class="club-desc">
                                <?php echo htmlspecialchars($event['club_description']); ?>
                            </p>
                        </div>
                    </div>


                    <div class="registration-card glass-effect-card">

                        <div class="participants-info">
                            <div class="participants-header">
                                <div class="participants-count">
                                    <img class="icon" src="/GoGreen-APU/assets/icons/person.3.fill.svg"
                                        alt="Participants">

                                    <span>
                                        <?php echo $participant_count; ?> Going
                                    </span>
                                </div>

                                <span class="participants-max">Max Participants:
                                    <?php echo $event['max_participants']; ?>
                                </span>
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

                            <span class="deadline-value">
                                <?php echo date('M j, Y @ h:i A', strtotime($event['registration_deadline'])); ?>
                            </span>
                        </div>


                        <div class="ticket-box">
                            <label class="ticket-row">
                                <input type="checkbox" class="ticket-checkbox" disabled>

                                <span class="ticket-price">
                                    <?php if ($is_paid): ?>
                                        RM
                                        <?php echo number_format($event['price'], 2); ?>

                                    <?php else: ?>
                                        FREE
                                    <?php endif; ?>
                                </span>

                                <span class="ticket-coins">+
                                    <?php echo $event['coins_earned']; ?> AP Coins
                                </span>
                            </label>
                        </div>


                        <?php if ($is_paid): ?>
                            <div class="pdf-upload-section">
                                <p class="upload-label">Payment Receipt <span class="required">*</span></p>

                                <label class="pdf-upload-area disabled-preview">
                                    <div class="upload-content">
                                        <img class="icon" src="/GoGreen-APU/assets/icons/text.document.svg" alt="Upload">

                                        <span class="upload-text">Click to upload PDF</span>
                                    </div>
                                </label>
                            </div>
                        <?php endif; ?>


                        <div class="registration-buttons">
                            <button type="button" class="register-btn disabled-preview">Register</button>
                        </div>


                        <div class="info-note">
                            <img class="icon" src="/GoGreen-APU/assets/icons/info.circle.svg" alt="Info">

                            <span>Registration requires approval</span>
                        </div>


                        <div class="social-actions">
                            <button type="button" class="like-btn disabled-preview">
                                <img class="icon" src="/GoGreen-APU/assets/icons/hand.thumbsup.svg" alt="Like">

                                <span>Like (
                                    <?php echo $event['like_count']; ?>)
                                </span>
                            </button>


                            <button class="share-btn disabled-preview">
                                <img class="icon" src="/GoGreen-APU/assets/icons/link.svg" alt="Share">
                            </button>
                        </div>
                    </div>


                    <div class="certificate-card glass-effect-card">
                        <div class="certificate-header">
                            <img class="icon" src="/GoGreen-APU/assets/icons/certificate.svg" alt="Certificate">

                            <h3 class="certificate-title">Certificate</h3>
                        </div>


                        <p class="certificate-message">View or preview your participation certificate for this event.</p>


                        <div class="certificate-buttons">
                            <button type="button" class="action-btn disabled-preview">
                                <img class="icon" src="/GoGreen-APU/assets/icons/eye.svg" alt="Preview">

                                <span>Preview Certificate</span>
                            </button>
                        </div>
                    </div>


                    <div class="feedback-card glass-effect-card">
                        <div class="feedback-header">
                            <div class="feedback-title-area">
                                <img class="icon" src="/GoGreen-APU/assets/icons/text.bubble.svg" alt="Comment">

                                <h3 class="feedback-title">Comment</h3>
                            </div>


                            <span class="coin-badge">Earn 5 Coins</span>
                        </div>


                        <div class="feedback-input-area">
                            <div class="txt-container glass-effect-border">
                                <textarea id="feedback-text" placeholder="Share your thoughts about the event..." rows="3" disabled></textarea>
                            </div>


                            <div class="feedback-actions">
                                <button type="button" class="send-feedback-btn disabled-preview">
                                    <img class="icon" src="/GoGreen-APU/assets/icons/paperplane.svg" alt="Send">

                                    <span>Send</span>
                                </button>
                            </div>
                        </div>


                        <div class="comments-list">
                            <div class="comment-item">
                                <div class="comment-avatar">
                                    <img src="/GoGreen-APU/assets/images/profile/1.png" alt="Avatar">
                                </div>

                                <div class="comment-content">
                                    <div class="comment-header">
                                        <span class="comment-author">Khoo Lay Bin</span>

                                        <span class="comment-date">2 hours ago</span>
                                    </div>

                                    <p class="comment-text">This event looks amazing! Can't wait to participate and learn more about sustainability.</p>
                                </div>
                            </div>


                            <div class="comment-item">
                                <div class="comment-avatar">
                                    <img src="/GoGreen-APU/assets/images/profile/2.png" alt="Avatar">
                                </div>

                                <div class="comment-content">
                                    <div class="comment-header">
                                        <span class="comment-author">Chong Ray Han</span>

                                        <span class="comment-date">5 hours ago</span>
                                    </div>

                                    <p class="comment-text">Great initiative! Looking forward to meeting like-minded people at this event.</p>
                                </div>
                            </div>


                            <div class="comment-item">
                                <div class="comment-avatar">
                                    <img src="/GoGreen-APU/assets/images/profile/3.png" alt="Avatar">
                                </div>

                                <div class="comment-content">
                                    <div class="comment-header">
                                        <span class="comment-author">Chong Jun Yoong</span>

                                        <span class="comment-date">1 day ago</span>
                                    </div>

                                    <p class="comment-text">Already registered! This is going to be an awesome experience.</p>
                                </div>
                            </div>


                            <div class="comment-item">
                                <div class="comment-avatar">
                                    <img src="/GoGreen-APU/assets/images/profile/4.png" alt="Avatar">
                                </div>

                                <div class="comment-content">
                                    <div class="comment-header">
                                        <span class="comment-author">Damain Loh</span>

                                        <span class="comment-date">2 days ago</span>
                                    </div>

                                    <p class="comment-text">The location is so convenient. Hope to see everyone there!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>