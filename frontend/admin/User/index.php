<!--
    Author: Chong Jun Yoong
    Date: 2026-1-26
    Description: Admin interface for managing users, including viewing user details and displaying user statistics.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Admin - Manage Users</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/admin/role_picker.css">
    <style>
        .table-left-container { width: calc(100% - 120px); }
        .table-right-container { width: 120px; }
        .user-info-with-avatar { display: flex; align-items: center; gap: 12px; }
        .user-info-with-avatar .usr_info { display: flex; flex-direction: column; gap: 4px; }
        .user-info-with-avatar .usr_info .name { font-weight: 500; }
        .user-info-with-avatar .usr_info .id_num { font-size: 0.85rem; color: rgba(255, 255, 255, 0.6); }
        .stats-container { gap: 12px; padding: 0 16px; }
        .stat-card { min-width: 160px; padding: 14px 16px; min-height: 90px; }
        .stat-icon { top: 12px; right: 12px; width: 28px; height: 28px; }
        .stat-icon img { width: 22px; height: 22px; }
        .stat-content { gap: 3px; }
        .stat-value { font-size: 30px; }
    </style>
</head>

<?php
$search = $_GET['search'] ?? '';
$filter_role = $_GET['role'] ?? 'all';

$total_users = 0;
$total_students = 0;
$total_organizers = 0;
$total_collaborators = 0;
$users = [];

$users_result = mysqli_query($conn, "SELECT u.id, u.apkey, u.first_name, u.last_name, u.avatar_path, u.phone_no, u.role, u.dob, 
    (SELECT COUNT(*) FROM event_participants ep WHERE ep.user_id = u.id AND ep.approval_status IS NOT NULL) as events_joined 
    FROM users u WHERE u.role != 'admin' ORDER BY u.id DESC");

$counter = 1;
while ($user = mysqli_fetch_assoc($users_result)) {
    $user['no'] = $counter++;
    $users[] = $user;
    $total_users++;
    if ($user['role'] == 'student') $total_students++;
    elseif ($user['role'] == 'organizer') $total_organizers++;
    elseif ($user['role'] == 'collaborator') $total_collaborators++;
}

$total_participants = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as participant_count FROM event_participants WHERE approval_status IS NOT NULL"))['participant_count'] ?? 0;
?>

<body>
    <?php
    $page_name = 'user';
    include('../sidebar.php');
    ?>

    <main>
        <div class="page-header">
            <div class="page-header-text">
                <h1>Manage Users</h1>
                <p>View and manage user accounts and their details.</p>
            </div>
            <button onclick="window.location.href='/GoGreen-APU/frontend/admin/User/choose_role.php'" class="create-event-btn green-glass-effect-border">
                <img src="/GoGreen-APU/assets/icons/person.badge.plus.svg" alt="Create">
                <span>Create User</span>
            </button>
        </div>

        <div class="stats-container">
            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/person.3.fill.svg" alt="Users"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Users</span>
                    <span class="stat-value"><?php echo $total_users; ?></span>
                    <span class="stat-subtitle">All registered users</span>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/person.fill.svg" alt="Students"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Students</span>
                    <span class="stat-value"><?php echo $total_students; ?></span>
                    <span class="stat-subtitle">Registered student users</span>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/person.3.fill.svg" alt="Participants"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Participants</span>
                    <span class="stat-value"><?php echo $total_participants; ?></span>
                    <span class="stat-subtitle">Event participants</span>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/person.fill.svg" alt="Organizers"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Organizers</span>
                    <span class="stat-value"><?php echo $total_organizers; ?></span>
                    <span class="stat-subtitle">Event organizers</span>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt="Collaborators"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Collaborators</span>
                    <span class="stat-value"><?php echo $total_collaborators; ?></span>
                    <span class="stat-subtitle">Active collaborators</span>
                </div>
            </div>
        </div>

        <div class="table-actions-container glass-effect">
            <form class="table-search-bar <?php if ($search != '') echo 'has-text'; ?>" method="GET">
                <input type="hidden" name="role" value="<?php echo $filter_role; ?>">
                <input type="text" name="search" id="user-search-input" class="table-search-input" placeholder="Search users..." value="<?php echo $search; ?>">
                <button class="table-clear-btn clear-btn" type="button" data-target="user-search-input">
                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                </button>
                <button class="table-search-btn" type="submit">
                    <img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search" class="search-icon">
                </button>
            </form>

            <div class="table-filters">
                <div class="filter-group glass-effect-border">
                    <label for="filter-role">Role</label>
                    <select id="filter-role" onchange="location.href='?search=<?php echo $search; ?>&role=' + this.value">
                        <option value="all" <?php if ($filter_role == 'all') echo 'selected'; ?>>All</option>
                        <option value="student" <?php if ($filter_role == 'student') echo 'selected'; ?>>Student</option>
                        <option value="organizer" <?php if ($filter_role == 'organizer') echo 'selected'; ?>>Organizer</option>
                        <option value="collaborator" <?php if ($filter_role == 'collaborator') echo 'selected'; ?>>Collaborator</option>
                    </select>
                </div>
            </div>

            <div class="table-manage-container glass-effect-border">
                <?php if (!empty($users)): ?>
                    <div class="table-left-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>USER</th>
                                    <th style="text-align: center;">ROLE</th>
                                    <th style="text-align: center;">DATE OF BIRTH</th>
                                    <th style="text-align: center;">PHONE NUMBER</th>
                                    <th style="text-align: center;">EVENTS JOINED</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): 
                                    if ($search != '' && stripos($user['first_name'] . ' ' . $user['last_name'], $search) === false && stripos($user['apkey'], $search) === false) continue;
                                    if ($filter_role != 'all' && $filter_role != $user['role']) continue;
                                ?>
                                    <tr>
                                        <td><a href="/GoGreen-APU/frontend/admin/edit_<?php echo $user['role']; ?>.php?id=<?php echo $user['id']; ?>" style="color: inherit; text-decoration: none;"><?php echo $user['no']; ?></a></td>
                                        <td>
                                            <div class="user-info-with-avatar">
                                                <span class="event-image" style="width: 45px; height: 45px; border-radius: 50%; overflow: hidden;">
                                                    <img src="/GoGreen-APU/assets/images/profile/<?php echo $user['avatar_path']; ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                                </span>
                                                <div class="usr_info">
                                                    <span class="name"><?php echo $user['last_name'] . ' ' . $user['first_name']; ?></span>
                                                    <span class="id_num"><?php echo $user['apkey']; ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center;"><?php echo ucfirst($user['role']); ?></td>
                                        <td style="text-align: center;"><?php echo date('Y-m-d', strtotime($user['dob'])); ?></td>
                                        <td style="text-align: center;"><?php echo $user['phone_no']; ?></td>
                                        <td style="text-align: center;"><?php echo $user['events_joined']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-right-container glass-effect">
                        <table>
                            <thead>
                                <tr><th colspan="2">Actions</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): 
                                    if ($search != '' && stripos($user['first_name'] . ' ' . $user['last_name'], $search) === false && stripos($user['apkey'], $search) === false) continue;
                                    if ($filter_role != 'all' && $filter_role != $user['role']) continue;
                                ?>
                                    <tr>
                                        <td><a href="/GoGreen-APU/frontend/admin/User/edit_<?php echo $user['role']; ?>.php?id=<?php echo $user['id']; ?>"><span><img src="/GoGreen-APU/assets/icons/square.and.pencil.svg" alt="Edit"></span></a></td>
                                        <td><a href="/GoGreen-APU/actions/admin/user/delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');"><span class="trash-btn"><img src="/GoGreen-APU/assets/icons/trash.svg" alt="Delete"></span></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 60px 40px;">
                        <img src="/GoGreen-APU/assets/icons/person.fill.questionmark.svg" alt="No users" style="width: 80px; height: 80px; filter: invert(1); opacity: 0.3; margin-bottom: 20px;">
                        <h3 style="font-size: 22px; margin-bottom: 10px; color: rgba(255, 255, 255, 0.8);">No Users Found</h3>
                        <p style="font-size: 15px; color: rgba(255, 255, 255, 0.5);">No users to display at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>