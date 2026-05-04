<!--
    Author: Khoo Lay Bin
    Date: 2026-1-5
    Description: a global css that fix the font, size, color, ... for all pages (included in head.php)
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Organizer</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
</head>

<?php
$user_id = $_SESSION['user_id'];
$search = $_GET['search'] ?? '';
$filter_status = $_GET['status'] ?? 'all';
$filter_paid = $_GET['paid'] ?? 'all';
$filter_slots = $_GET['slots'] ?? 'all';

$club_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT club_id FROM organizers WHERE user_id = $user_id"))['club_id'];

$total_events = 0;
$pending_events = 0;
$approved_events = 0;
$rejected_events = 0;
$total_participants = 0;
$upcoming_events = 0;
$events = [];

$events_result = mysqli_query($conn, "
        SELECT e.id, e.title, e.image_path, e.start_date, e.max_participants, e.is_paid, e.like_count, e.is_approved,
        COUNT(CASE WHEN ep.status != 'cancelled' THEN 1 END) as participant_count,
        COUNT(CASE WHEN ep.approval_status IS NULL AND ep.status = 'registered' THEN 1 END) as pending_registrations
        FROM events e
        LEFT JOIN event_participants ep ON ep.event_id = e.id
        WHERE e.club_id = $club_id
        GROUP BY e.id
        ORDER BY e.start_date DESC
    ");

while ($event = mysqli_fetch_assoc($events_result)) {
    $events[] = $event;
    $total_events++;
    if ($event['is_approved'] === null) $pending_events++;
    elseif ($event['is_approved'] == 1) $approved_events++;
    else $rejected_events++;
    $total_participants += $event['participant_count'];
    if (strtotime($event['start_date']) >= strtotime('today')) $upcoming_events++;
}

$total_collaborators = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT c.user_id) as collab_count FROM collaborators c INNER JOIN events e ON c.event_id = e.id WHERE e.club_id = $club_id"))['collab_count'] ?? 0;
?>

<body>
    <?php
    $page_name = 'my_events';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/organizer/sidebar.php');
    ?>

    <main>
        <div class="page-header">
            <div class="page-header-text">
                <h1>My Events</h1>
                <p>Manage, track, and organize all your upcoming and past events.</p>
            </div>
            <a href="/GoGreen-APU/frontend/organizer/my_events/create_event.php" class="create-event-btn green-glass-effect-border">
                <img src="/GoGreen-APU/assets/icons/calendar.badge.plus.svg" alt="Create">
                <span>Create Event</span>
            </a>
        </div>

        <div class="stats-container">
            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/my_events.svg" alt="Events"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Events</span>
                    <span class="stat-value"><?php echo $total_events; ?></span>
                    <div class="stat-breakdown">
                        <span class="stat-pending"><span class="dot"></span><?php echo $pending_events; ?> Pending</span>
                        <span class="stat-approved"><span class="dot"></span><?php echo $approved_events; ?> Approved</span>
                        <span class="stat-rejected"><span class="dot"></span><?php echo $rejected_events; ?> Rejected</span>
                    </div>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/person.3.fill.svg" alt="Participants"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Participants</span>
                    <span class="stat-value"><?php echo $total_participants; ?></span>
                    <span class="stat-subtitle">Across all events</span>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt="Collaborators"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Collaborators</span>
                    <span class="stat-value"><?php echo $total_collaborators; ?></span>
                    <span class="stat-subtitle">Active team members</span>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/calendar.badge.clock.svg" alt="Upcoming"></div>
                <div class="stat-content">
                    <span class="stat-label">Upcoming Events</span>
                    <span class="stat-value"><?php echo $upcoming_events; ?></span>
                </div>
            </div>
        </div>

        <div class="table-actions-container glass-effect">
            <form class="table-search-bar <?php if ($search != '') echo 'has-text'; ?>" method="GET">
                <input type="hidden" name="status" value="<?php echo $filter_status; ?>">
                <input type="hidden" name="paid" value="<?php echo $filter_paid; ?>">
                <input type="hidden" name="slots" value="<?php echo $filter_slots; ?>">
                <input type="text" name="search" id="event-search-input" class="table-search-input" placeholder="Search events..." value="<?php echo $search; ?>">
                <button class="table-clear-btn clear-btn" type="button" data-target="event-search-input">
                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                </button>
                <button class="table-search-btn" type="submit">
                    <img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search" class="search-icon">
                </button>
            </form>

            <div class="table-filters">
                <div class="filter-group glass-effect-border">
                    <label for="filter-status">Status</label>
                    <select id="filter-status" onchange="location.href='?search=<?php echo $search; ?>&status=' + this.value + '&paid=<?php echo $filter_paid; ?>&slots=<?php echo $filter_slots; ?>'">
                        <option value="all" <?php if ($filter_status == 'all') echo 'selected'; ?>>All</option>
                        <option value="pending" <?php if ($filter_status == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="approved" <?php if ($filter_status == 'approved') echo 'selected'; ?>>Approved</option>
                        <option value="rejected" <?php if ($filter_status == 'rejected') echo 'selected'; ?>>Rejected</option>
                    </select>
                </div>

                <div class="filter-group glass-effect-border">
                    <label for="filter-paid">Fee</label>
                    <select id="filter-paid" onchange="location.href='?search=<?php echo $search; ?>&status=<?php echo $filter_status; ?>&paid=' + this.value + '&slots=<?php echo $filter_slots; ?>'">
                        <option value="all" <?php if ($filter_paid == 'all') echo 'selected'; ?>>All</option>
                        <option value="free" <?php if ($filter_paid == 'free') echo 'selected'; ?>>Free</option>
                        <option value="paid" <?php if ($filter_paid == 'paid') echo 'selected'; ?>>Paid</option>
                    </select>
                </div>

                <div class="filter-group glass-effect-border">
                    <label for="filter-slots">Slots</label>
                    <select id="filter-slots" onchange="location.href='?search=<?php echo $search; ?>&status=<?php echo $filter_status; ?>&paid=<?php echo $filter_paid; ?>&slots=' + this.value">
                        <option value="all" <?php if ($filter_slots == 'all') echo 'selected'; ?>>All</option>
                        <option value="available" <?php if ($filter_slots == 'available') echo 'selected'; ?>>Available</option>
                        <option value="full" <?php if ($filter_slots == 'full') echo 'selected'; ?>>Full</option>
                    </select>
                </div>
            </div>

            <div class="table-manage-container glass-effect-border">
                <div class="table-left-container">
                    <table>
                        <thead>
                            <tr>
                                <th>TITLE</th>
                                <th>DATE</th>
                                <th>PARTICIPANTS</th>
                                <th>PAID</th>
                                <th>LIKES</th>
                                <th>PENDING REG.</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($events)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 2rem;">No events found. Create your first event!</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($events as $event):
                                    if ($event['is_approved'] === null) {
                                        $status = 'pending';
                                        $status_class = 'status-pending';
                                    } elseif ($event['is_approved'] == 1) {
                                        $status = 'approved';
                                        $status_class = 'status-approved';
                                    } else {
                                        $status = 'rejected';
                                        $status_class = 'status-rejected';
                                    }

                                    $is_full = $event['participant_count'] >= $event['max_participants'];
                                    $slots = $is_full ? 'full' : 'available';
                                    $paid = $event['is_paid'] ? 'paid' : 'free';

                                    if ($search != '' && stripos($event['title'], $search) === false) continue;
                                    if ($filter_status != 'all' && $filter_status != $status) continue;
                                    if ($filter_paid != 'all' && $filter_paid != $paid) continue;
                                    if ($filter_slots != 'all' && $filter_slots != $slots) continue;
                                ?>
                                    <tr>
                                        <td class="event-title">
                                            <span class="event-image"><img src="/GoGreen-APU/assets/images/event/<?php echo $event['image_path']; ?>" alt=""></span>
                                            <span><?php echo $event['title']; ?></span>
                                        </td>
                                        <td><?php echo date('Y-m-d', strtotime($event['start_date'])); ?></td>
                                        <td><span class="<?php echo $is_full ? 'participants-full' : 'participants-available'; ?>"><?php echo $event['participant_count']; ?> / <?php echo $event['max_participants']; ?></span></td>
                                        <td><?php echo $event['is_paid'] ? 'Yes' : 'No'; ?></td>
                                        <td><?php echo $event['like_count']; ?></td>
                                        <td><?php echo $event['pending_registrations'] > 0 ? '<span class="badge badge-warning">' . $event['pending_registrations'] . '</span>' : '0'; ?></td>
                                        <td><span class="status-badge <?php echo $status_class; ?>"><?php echo ucfirst($status); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="table-right-container glass-effect">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($events)): ?>
                                <tr>
                                    <td colspan="2" style="text-align: center;">-</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($events as $event):
                                    if ($event['is_approved'] === null) $status = 'pending';
                                    elseif ($event['is_approved'] == 1) $status = 'approved';
                                    else $status = 'rejected';

                                    $is_full = $event['participant_count'] >= $event['max_participants'];
                                    $slots = $is_full ? 'full' : 'available';
                                    $paid = $event['is_paid'] ? 'paid' : 'free';

                                    if ($search != '' && stripos($event['title'], $search) === false) continue;
                                    if ($filter_status != 'all' && $filter_status != $status) continue;
                                    if ($filter_paid != 'all' && $filter_paid != $paid) continue;
                                    if ($filter_slots != 'all' && $filter_slots != $slots) continue;
                                ?>
                                    <tr>
                                        <td><a href="/GoGreen-APU/frontend/organizer/my_events/overview.php?id=<?php echo $event['id']; ?>"><span><img src="/GoGreen-APU/assets/icons/square.and.pencil.svg" alt="Edit"></span></a></td>
                                        <td><a href="/GoGreen-APU/actions/organizer/my_events/delete_event.php?id=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?');"><span class="trash-btn"><img src="/GoGreen-APU/assets/icons/trash.svg" alt="Delete"></span></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>
</body>

</html>