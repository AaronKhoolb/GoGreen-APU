<!--
    Author: Admin
    Date: 2026-01-26
    Description: System logs show all activity history
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Admin - Activity Logs</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/admin/logs.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/admin/my_activities/logs.css">
</head>

<?php
    $search = $_GET['search'] ?? '';
    $filter_role = $_GET['role'] ?? 'all';
    $filter_action = $_GET['action'] ?? 'all';


    $total_logs = 0;
    $admin_logs = 0;
    $organizer_logs = 0;
    $student_logs = 0;
    $collaborator_logs = 0;
    $logs = [];



    $actions_result = mysqli_query($conn, "SELECT DISTINCT action FROM logs ORDER BY action");


    $available_actions = [];


    while ($action_row = mysqli_fetch_assoc($actions_result)) {
        $available_actions[] = $action_row['action'];
    }




    $query = "SELECT l.id, l.user_id, l.role, l.action, l.details, l.date_time, u.first_name, u.last_name, u.apkey, u.avatar_path FROM logs l LEFT JOIN users u ON l.user_id = u.id WHERE 1=1";

    if ($filter_role != 'all') {
        $query .= " AND l.role = '" . mysqli_real_escape_string($conn, $filter_role) . "'";
    }
    if ($filter_action != 'all') {
        $query .= " AND l.action = '" . mysqli_real_escape_string($conn, $filter_action) . "'";
    }
    if ($search != '') {
        $search_escaped = mysqli_real_escape_string($conn, $search);
        $query .= " AND (l.details LIKE '%$search_escaped%' OR u.first_name LIKE '%$search_escaped%' OR u.last_name LIKE '%$search_escaped%' OR CONCAT(u.last_name, ' ', u.first_name) LIKE '%$search_escaped%' OR u.apkey LIKE '%$search_escaped%')";
    }


    $query .= " ORDER BY l.date_time DESC";

    $logs_result = mysqli_query($conn, $query);

    $counter = 1;
    while ($log = mysqli_fetch_assoc($logs_result)) {
        $log['no'] = $counter++;
        $logs[] = $log;
    }


    $stats_result = mysqli_query($conn, "SELECT role, COUNT(*) as count FROM logs GROUP BY role");
    while ($stat = mysqli_fetch_assoc($stats_result)) {
        if ($stat['role'] == 'admin')
            $admin_logs = $stat['count'];
        elseif ($stat['role'] == 'organizer')
            $organizer_logs = $stat['count'];
        elseif ($stat['role'] == 'student')
            $student_logs = $stat['count'];
        elseif ($stat['role'] == 'collaborator')
            $collaborator_logs = $stat['count'];
    }
    $total_logs = $admin_logs + $organizer_logs + $student_logs + $collaborator_logs;


    $today_logs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM logs WHERE DATE(date_time) = CURDATE()"))['count'] ?? 0;
?>

<body>
    <?php
    $page_name = 'my_activities';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <div class="page-header">
            <div class="page-header-text">
                <h1>Activity Logs</h1>

                <p>View and monitor all system activities and user actions.</p>
            </div>
        </div>


        <div class="stats-container">
            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/doc.text.fill.svg" alt="Logs"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Logs</span>

                    <span class="stat-value"><?php echo $total_logs; ?></span>

                    <div class="stat-breakdown">
                        <div>
                            <span class="stat-approved"><span class="dot" style="background-color: #ce93d8;"></span><?php echo $admin_logs; ?> Admin</span>

                            <span class="stat-approved"><span class="dot" style="background-color: #64b5f6;"></span><?php echo $organizer_logs; ?> Organizer</span>
                        </div>


                        <div>
                            <span class="stat-approved"><span class="dot" style="background-color: #81c784;"></span><?php echo $student_logs; ?> Student</span>

                            <span class="stat-approved"><span class="dot" style="background-color: #ffb74d;"></span><?php echo $collaborator_logs; ?> Collaborator</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/calendar.badge.clock.svg" alt="Today"></div>

                <div class="stat-content">
                    <span class="stat-label">Today's Activities</span>

                    <span class="stat-value"><?php echo $today_logs; ?></span>

                    <span class="stat-subtitle">Logged today</span>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/person.3.fill.svg" alt="Roles"></div>
                <div class="stat-content">
                    <span class="stat-label">Active Roles</span>

                    <span class="stat-value">4</span>

                    <span class="stat-subtitle">Admin, Organizer, Student, Collaborator</span>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/list.bullet.clipboard.svg" alt="Actions">
                </div>
                <div class="stat-content">
                    <span class="stat-label">Action Types</span>

                    <span class="stat-value"><?php echo count($available_actions); ?></span>

                    <span class="stat-subtitle">
                        <?php
                        if (empty($available_actions)) {
                            echo "No actions";
                        } else {
                            foreach ($available_actions as $action) {
                                echo $action . ", ";
                            }
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="table-actions-container glass-effect">
            <form class="table-search-bar <?php if ($search != '')
                echo 'has-text'; ?>" method="GET">

                <input type="hidden" name="role" value="<?php echo htmlspecialchars($filter_role); ?>">

                <input type="hidden" name="action" value="<?php echo htmlspecialchars($filter_action); ?>">

                <input type="text" name="search" id="log-search-input" class="table-search-input" placeholder="Search logs..." value="<?php echo htmlspecialchars($search); ?>">

                <a href="?" class="clear-btn" type="button"><img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear"></a>

                <button class="table-search-btn" type="submit"><img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search" class="search-icon"></button>
            </form>

            <form class="filter-form" method="GET" id="filter-form">
                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">

                <div class="filter-group glass-effect-border">
                    <label for="filter-role">Role</label>

                    <select id="filter-role" name="role" onchange="document.getElementById('filter-form').submit()">
                        <option value="all" <?php if ($filter_role == 'all') echo 'selected'; ?>>All</option>
                        <option value="admin" <?php if ($filter_role == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="organizer" <?php if ($filter_role == 'organizer') echo 'selected'; ?>>Organizer</option>
                        <option value="student" <?php if ($filter_role == 'student') echo 'selected'; ?>>Student</option>
                        <option value="collaborator" <?php if ($filter_role == 'collaborator') echo 'selected'; ?>>Collaborator</option>
                    </select>
                </div>

                <div class="filter-group glass-effect-border">
                    <label for="filter-action">Action</label>

                    <select id="filter-action" name="action" onchange="document.getElementById('filter-form').submit()">
                        <option value="all" <?php if ($filter_action == 'all') echo 'selected'; ?>>All</option>

                        <?php foreach ($available_actions as $action_item): ?>
                            <option value="<?php echo htmlspecialchars($action_item); ?>" <?php if ($filter_action == $action_item) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($action_item); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <a href="?" class="filter-reset-btn"><img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">Clear</a>
            </form>

            <div class="table-manage-container glass-effect-border">
                <?php if (!empty($logs)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>USER</th>
                                <th class="text-center">ROLE</th>
                                <th class="text-center">ACTION</th>
                                <th>DETAILS</th>
                                <th class="text-center">DATE & TIME</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($logs as $log):
                                $role_class = 'role-' . $log['role'];
                                ?>
                                <tr>
                                    <td><?php echo $log['no']; ?></td>


                                    <td>
                                        <div class="user-info-with-avatar">
                                            <span class="event-image">
                                                <img src="/GoGreen-APU/assets/images/profile/<?php echo $log['avatar_path']; ?>" alt="Avatar">
                                            </span>

                                            <div class="usr_info">
                                                <span class="name"><?php echo htmlspecialchars($log['last_name'] . ' ' . $log['first_name']); ?></span>

                                                <span class="id_num"><?php echo htmlspecialchars($log['apkey']); ?></span>
                                            </div>
                                        </div>
                                    </td>


                                    <td class="text-center">
                                        <span class="role-badge <?php echo $role_class; ?>"><?php echo ucfirst($log['role']); ?></span>
                                    </td>


                                    <td class="text-center"><?php echo htmlspecialchars($log['action']); ?></td>


                                    <td class="details-cell" title="<?php echo htmlspecialchars($log['details']); ?>">
                                        <?php echo htmlspecialchars($log['details']); ?>
                                    </td>


                                    <td class="text-center">
                                        <?php echo date('Y-m-d H:i:s', strtotime($log['date_time'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>


                <?php else: ?>
                    <div class="no-logs-container">
                        <img src="/GoGreen-APU/assets/icons/doc.text.fill.svg" alt="No logs" class="no-logs-icon">

                        <h3 class="no-logs-title">No Logs Found</h3>

                        <p class="no-logs-text">No activity logs match your current filters.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>