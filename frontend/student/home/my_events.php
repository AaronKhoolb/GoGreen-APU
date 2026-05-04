<!--
    Author: Khoo Lay Bin
    Date: 2026-01-23
    Description: My Events (Upcoming and Past Event Cards) included in student home page
-->

<?php
$current_user_id = $_SESSION['user_id'];


$events_sql = "SELECT e.*, c.name as club_name, ep.status as participant_status, ep.approval_status
               FROM event_participants ep
               JOIN events e ON ep.event_id = e.id
               JOIN clubs c ON e.club_id = c.id
               WHERE ep.user_id = $current_user_id
               AND e.is_approved = 1
               ORDER BY e.start_date ASC";
$events_result = mysqli_query($conn, $events_sql);


$upcoming_events = [];

$past_events = [];

$today = date('Y-m-d');

while ($event = mysqli_fetch_assoc($events_result)) {
    if ($event['start_date'] >= $today) {
        $upcoming_events[] = $event;
    } else {
        $past_events[] = $event;
    }
}

$total_events = count($upcoming_events) + count($past_events);
?>

<section class="my-events-section">

    <div class="my-events-header">
        <h1 class="my-events-title">My Events</h1>
        <span class="events-count"><?php echo $total_events; ?> Events Joined</span>
    </div>

    <?php if ($total_events == 0): ?>
        <div class="my-events-empty">
            <p>You haven't joined any events yet.</p>
            <a href="/GoGreen-APU/frontend/student/explore/" class="explore-link">Explore Events</a>
        </div>
    <?php else: ?>


        <div class="my-events-group">

            <h3 class="group-title">Upcoming Events</h3>

            <?php if (count($upcoming_events) == 0): ?>
                <p class="no-events">No upcoming events.</p>

            <?php else: ?>
                <div class="events-scroll-container">
                    <?php foreach ($upcoming_events as $event):
                        $start_day = date('j', strtotime($event['start_date']));

                        
                        if ($event['approval_status'] == NULL) {
                            $status_text = "Pending";
                            $status_class = "pending";
                        } elseif ($event['participant_status'] == 'attended') {
                            $status_text = "Attended";
                            $status_class = "attended";
                        } elseif ($event['participant_status'] == 'absent') {
                            $status_text = "Absent";
                            $status_class = "absent";
                        } else {
                            $status_text = "Registered";
                            $status_class = "registered";
                        }
                        ?>


                        <div class="event-card">

                            <div class="card-image">
                                <img src="/GoGreen-APU/assets/images/event/<?php echo $event['image_path']; ?>" alt="">

                                <span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                            </div>


                            <div class="card-content">

                                <h3 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h3>

                                <div class="card-meta">
                                    <img src="/GoGreen-APU/assets/icons/date/<?php echo $start_day; ?>.calendar.svg" alt="">

                                    <?php echo date('D, j M Y', strtotime($event['start_date'])); ?>

                                    <?php if ($event['end_date'] && $event['end_date'] != $event['start_date']): ?>
                                        - <?php echo date('D, j M Y', strtotime($event['end_date'])); ?>
                                    <?php endif; ?>

                                </div>


                                <div class="card-meta">
                                    <img src="/GoGreen-APU/assets/icons/clock.svg" alt="">

                                    <?php echo date('g:i A', strtotime($event['start_time'])); ?>

                                    <?php if ($event['end_time']): ?>
                                        - <?php echo date('g:i A', strtotime($event['end_time'])); ?>
                                    <?php endif; ?>
                                </div>


                                <div class="card-meta">
                                    <img src="/GoGreen-APU/assets/icons/mappin.and.ellipse.svg" alt="">

                                    <?php echo htmlspecialchars($event['location']); ?>
                                </div>


                                <div class="card-footer">
                                    <a href="/GoGreen-APU/frontend/student/explore/event/index.php?id=<?php echo $event['id']; ?>"
                                        class="view-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>


        
        <div class="my-events-group">

            <h3 class="group-title">Past Events</h3>

            <?php if (count($past_events) == 0): ?>
                <p class="no-events">No past events.</p>

            <?php else: ?>
                <div class="events-scroll-container">
                    <?php foreach ($past_events as $event):
                        $start_day = date('j', strtotime($event['start_date']));
                        $is_attended = $event['participant_status'] === 'attended';
                        $has_cert = mysqli_num_rows(mysqli_query($conn, "SELECT event_id FROM certificate WHERE event_id = " . $event['id'])) > 0;


                        if ($event['approval_status'] == NULL) {
                            $status_text = "Pending";
                            $status_class = "pending";
                        } elseif ($event['participant_status'] == 'attended') {
                            $status_text = "Attended";
                            $status_class = "attended";
                        } elseif ($event['participant_status'] == 'absent') {
                            $status_text = "Absent";
                            $status_class = "absent";
                        } else {
                            $status_text = "Registered";
                            $status_class = "registered";
                        }
                        ?>


                        <div class="event-card">
                            <div class="card-image">
                                <img src="/GoGreen-APU/assets/images/event/<?php echo $event['image_path']; ?>" alt="">
                                <span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                            </div>

                            <div class="card-content">
                                <h3 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h3>


                                <div class="card-meta">
                                    <img src="/GoGreen-APU/assets/icons/date/<?php echo $start_day; ?>.calendar.svg" alt="">

                                    <?php echo date('D, j M Y', strtotime($event['start_date'])); ?>

                                    <?php if ($event['end_date'] && $event['end_date'] != $event['start_date']): ?>
                                        -
                                        <?php echo date('D, j M Y', strtotime($event['end_date'])); ?>
                                    <?php endif; ?>
                                </div>


                                <div class="card-meta">
                                    <img src="/GoGreen-APU/assets/icons/clock.svg" alt="">

                                    <?php echo date('g:i A', strtotime($event['start_time'])); ?>

                                    <?php if ($event['end_time']): ?>
                                        - <?php echo date('g:i A', strtotime($event['end_time'])); ?>
                                    <?php endif; ?>
                                </div>


                                <div class="card-meta">
                                    <img src="/GoGreen-APU/assets/icons/mappin.and.ellipse.svg" alt="">

                                    <?php echo htmlspecialchars($event['location']); ?>
                                </div>


                                <div class="card-footer">
                                    <a href="/GoGreen-APU/frontend/student/explore/event/index.php?id=<?php echo $event['id']; ?>"
                                        class="view-btn">View Details</a>


                                    <?php if ($is_attended && $has_cert): ?>
                                        <a href="/GoGreen-APU/frontend/student/certificate/index.php?id=<?php echo $event['id']; ?>" class="view-btn">Certificate</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</section>