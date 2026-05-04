<!--
    Author: Chong Jun Yoong
    Date: 2026-1-4
    Description: Admin interface for managing event submissions, including viewing event details, approving or rejecting events, and displaying event statistics.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Admin - Manage Events</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <style>
        .table-left-container {
            width: calc(100% - 220px);
        }

        .table-right-container {
            width: 220px;
        }

        .user-info-with-avatar {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-info-with-avatar .usr_info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .user-info-with-avatar .usr_info .name {
            font-weight: 500;
        }

        .user-info-with-avatar .usr_info .id_num {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
        }
    </style>
</head>

<?php
$search = $_GET['search'] ?? '';
$filter_status = $_GET['status'] ?? 'all';

$total_events = 0;
$pending_events = 0;
$approved_events = 0;
$rejected_events = 0;
$total_participants = 0;
$upcoming_events = 0;
$events = [];

$events_result = mysqli_query($conn, "SELECT e.id, e.title, e.image_path, e.start_date, e.is_approved, (SELECT COUNT(*) FROM event_participants ep WHERE ep.event_id = e.id AND ep.status != 'cancelled') as participant_count, u.first_name, u.last_name, u.apkey, u.avatar_path FROM events e LEFT JOIN users u ON e.created_by = u.id ORDER BY e.start_date DESC");

$counter = 1;
while ($event = mysqli_fetch_assoc($events_result)) {
    $event['no'] = $counter++;
    $events[] = $event;
    $total_events++;
    if ($event['is_approved'] === null)
        $pending_events++;
    elseif ($event['is_approved'] == 1)
        $approved_events++;
    else
        $rejected_events++;
    $total_participants += $event['participant_count'];
    if (strtotime($event['start_date']) >= strtotime('today'))
        $upcoming_events++;
}

$total_collaborators = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT user_id) as collab_count FROM collaborators"))['collab_count'] ?? 0;
?>

<body>
    <?php
    $page_name = 'my_events';
    include('../sidebar.php');
    ?>

    <main>
        <div class="page-header">
            <div class="page-header-text">
                <h1>My Events</h1>
                <p>Approve event submissions and view event details.</p>
            </div>
            <a href="/GoGreen-APU/frontend/admin/event/create_event.php" class="create-event-btn green-glass-effect-border">
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
                        <span class="stat-pending"><span class="dot"></span><?php echo $pending_events; ?>Pending</span>
                        <span class="stat-approved"><span class="dot"></span><?php echo $approved_events; ?>Approved</span>
                        <span class="stat-rejected"><span class="dot"></span><?php echo $rejected_events; ?>Rejected</span>
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
                    <select id="filter-status" onchange="location.href='?search=<?php echo $search; ?>&status=' + this.value">
                        <option value="all" <?php if ($filter_status == 'all') echo 'selected'; ?>>All</option>
                        <option value="pending" <?php if ($filter_status == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="approved" <?php if ($filter_status == 'approved') echo 'selected'; ?>>Approved</option>
                        <option value="rejected" <?php if ($filter_status == 'rejected') echo 'selected'; ?>>Rejected</option>
                    </select>
                </div>
            </div>

            <div class="table-manage-container glass-effect-border">
                <?php if (!empty($events)): ?>
                    <div class="table-left-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>EVENT NAME</th>
                                    <th style="text-align: center;">DATE</th>
                                    <th style="text-align: center;">STATUS</th>
                                    <th style="text-align: center;">CREATED BY</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                    if ($search != '' && stripos($event['title'], $search) === false)
                                        continue;
                                    if ($filter_status != 'all' && $filter_status != $status)
                                        continue;
                                    ?>
                                    <tr>
                                        <td><?php echo $event['no']; ?></td>
                                        <td class="event-title">
                                            <span class="event-image"><img src="/GoGreen-APU/assets/images/event/<?php echo $event['image_path']; ?>" alt=""></span>
                                            <span><?php echo $event['title']; ?></span>
                                        </td>
                                        <td><?php echo date('Y-m-d', strtotime($event['start_date'])); ?></td>
                                        <td><span class="status-badge <?php echo $status_class; ?>"><?php echo ucfirst($status); ?></span></td>
                                        <td>
                                            <div class="user-info-with-avatar">
                                                <span class="event-image" style="width: 45px; height: 45px; border-radius: 50%; overflow: hidden;">
                                                    <img src="/GoGreen-APU/assets/images/profile/<?php echo $event['avatar_path']; ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                                </span>
                                                <div class="usr_info">
                                                    <span class="name"><?php echo $event['last_name'] . ' ' . $event['first_name']; ?></span>
                                                    <span class="id_num"><?php echo $event['apkey']; ?></span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-right-container glass-effect">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $event):
                                    if ($event['is_approved'] === null)
                                        $status = 'pending';
                                    elseif ($event['is_approved'] == 1)
                                        $status = 'approved';
                                    else
                                        $status = 'rejected';
                                    if ($search != '' && stripos($event['title'], $search) === false)
                                        continue;
                                    if ($filter_status != 'all' && $filter_status != $status)
                                        continue;
                                    $is_checked = ($status == 'approved') ? 'checked' : '';
                                    $next_action = ($status == 'approved') ? 'reject' : 'approve';
                                    ?>
                                    <tr>
                                        <td>
                                            <form method="POST" action="/GoGreen-APU/actions/admin/event/update_status.php" style="margin: 0;">
                                                <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                                <input type="hidden" name="action" value="<?php echo $next_action; ?>">
                                                <div class="checkbox-switch" style="justify-content: center;">
                                                    <input type="checkbox" id="status_<?php echo $event['id']; ?>" onchange="this.form.submit()" <?php echo $is_checked; ?>>
                                                    <label for="status_<?php echo $event['id']; ?>"></label>
                                                </div>
                                            </form>
                                        </td>
                                        <td><a href="/GoGreen-APU/frontend/admin/event/overview.php?id=<?php echo $event['id']; ?>"><span><img src="/GoGreen-APU/assets/icons/square.and.pencil.svg" alt="Edit"></span></a></td>
                                        <td><a href="/GoGreen-APU/actions/admin/event/delete_event_admin.php?id=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?');"><span class="trash-btn"><img src="/GoGreen-APU/assets/icons/trash.svg" alt="Delete"></span></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 60px 40px;">
                        <img src="/GoGreen-APU/assets/icons/calendar.badge.exclamationmark.svg" alt="No events" style="width: 80px; height: 80px; filter: invert(1); opacity: 0.3; margin-bottom: 20px;">
                        <h3 style="font-size: 22px; margin-bottom: 10px; color: rgba(255, 255, 255, 0.8);">No Events Found</h3>
                        <p style="font-size: 15px; color: rgba(255, 255, 255, 0.5);">No event submissions to review at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>