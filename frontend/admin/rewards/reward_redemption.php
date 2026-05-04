 <!--
    Author: Damian Loh Yi Feng
    Date: 2026-1-10
    Description: Reward Redemption Management Page for Admins
-->
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle_id']) && isset($_POST['new_status'])) {
        $id = intval($_POST['toggle_id']);
        $new_status = mysqli_real_escape_string($conn, $_POST['new_status']);
        $update_sql = "UPDATE reward_redemptions SET status = '$new_status' WHERE id = $id";
        mysqli_query($conn, $update_sql);
    }
    elseif (isset($_POST['delete_id'])) {
        $id = intval($_POST['delete_id']);
        $del_sql = "DELETE FROM reward_redemptions WHERE id = $id";
        mysqli_query($conn, $del_sql);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$total_pending = 0;
$total_redeemed = 0;

$sql_stats = "SELECT 
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN status = 'redeemed' THEN 1 ELSE 0 END) as redeemed
    FROM reward_redemptions";
$res_stats = mysqli_query($conn, $sql_stats);

if ($row_stats = mysqli_fetch_assoc($res_stats)) {
    $total_pending = $row_stats['pending'] ?? 0;
    $total_redeemed = $row_stats['redeemed'] ?? 0;
}

$redemptions = array();
$sql_list = "SELECT * FROM reward_redemptions ORDER BY redeemed_at DESC";
$res_list = mysqli_query($conn, $sql_list);

$counter = 1;
if ($res_list) {
    while ($row = mysqli_fetch_assoc($res_list)) {
        $row['no'] = $counter++;
        
        $user_id = intval($row['user_id']);
        $sql_user = "SELECT first_name, last_name FROM users WHERE id = $user_id";
        $res_user = mysqli_query($conn, $sql_user);
        $user_data = mysqli_fetch_assoc($res_user);
        
        if ($user_data) {
            $row['first_name'] = $user_data['first_name'];
            $row['last_name'] = $user_data['last_name'];
        } else {
            $row['first_name'] = 'Unknown';
            $row['last_name'] = 'User';
        }

        $reward_id = intval($row['reward_id']);
        $sql_reward = "SELECT title, image_path FROM rewards WHERE id = $reward_id";
        $res_reward = mysqli_query($conn, $sql_reward);
        $reward_data = mysqli_fetch_assoc($res_reward);

        if ($reward_data) {
            $row['reward_title'] = $reward_data['title'];
            $row['image_path'] = $reward_data['image_path'];
        } else {
            $row['reward_title'] = 'Unknown Reward';
            $row['image_path'] = 'default.png';
        }

        $redemptions[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Redemption Management</title>
    
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/table.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/checkbox_switch.css">

    <style>
        .table-left-container { 
            width: calc(100% - 150px); 
        }
        .table-right-container { 
            width: 150px; 
        }
        .table-left-container table tbody tr, .table-right-container table tbody tr { 
            height: 80px; 
        }
        .table-right-container td { 
            vertical-align: middle; 
            text-align: center; 
        }
        .user-info-with-avatar { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
        }
        .usr_info { 
            display: flex; 
            flex-direction: column; 
            gap: 2px; 
        }
        .usr_info .name { 
            font-weight: 600; 
            color: #fff; 
            font-size: 0.95rem; 
        }
        .usr_info .code { 
            font-family: monospace; 
            color: #22c55e; 
            font-size: 0.85rem; 
        }
        .reward-image-small { 
            width: 40px; 
            height: 40px; 
            border-radius: 6px; 
            object-fit: contain; 
            background: #fff; 
            padding: 2px; 
        }
        .action-buttons-container { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 15px; 
            height: 100%; 
        }
        .status-badge { 
            padding: 5px 10px; 
            border-radius: 50px; 
            font-size: 0.75rem; 
            font-weight: 700; 
            text-transform: uppercase; 
        }
        .status-pending { 
            background: rgba(255, 152, 0, 0.15); 
            color: #ff9800; 
            border: 1px solid rgba(255, 152, 0, 0.3); 
        }
        .status-redeemed { 
            background: rgba(34, 197, 94, 0.15); 
            color: #22c55e; 
            border: 1px solid rgba(34, 197, 94, 0.3); 
        }
    </style>
</head>

<body>
    <?php
    $page_name = 'reward_redemption';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="color: #ff9800;">Redemption Desk</h1>
                <p>Verify codes and hand out rewards using the toggle switch.</p>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/clock.arrow.circlepath.svg" style="filter: invert(1);"></div>
                <div class="stat-content">
                    <span class="stat-label">Pending</span>
                    <span class="stat-value" style="color: #ff9800;"><?php echo $total_pending; ?></span>
                </div>
            </div>
            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/checkmark.circle.fill.svg" style="filter: invert(1);"></div>
                <div class="stat-content">
                    <span class="stat-label">Collected</span>
                    <span class="stat-value"><?php echo $total_redeemed; ?></span>
                </div>
            </div>
        </div>

        <div class="table-actions-container glass-effect">
            <div class="table-search-bar">
                <input type="text" id="redemption-search-input" class="table-search-input" placeholder="Search by Code or Student Name...">
                <button class="table-clear-btn clear-btn" type="button" id="clear-search">
                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                </button>
                <button class="table-search-btn" type="button">
                    <img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search" class="search-icon">
                </button>
            </div>

            <div class="table-filters">
                <div class="filter-group glass-effect-border">
                    <label for="filter-status">Status</label>
                    <select id="filter-status">
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="redeemed">Collected</option>
                    </select>
                </div>
            </div>

            <div class="table-manage-container glass-effect-border">
                <?php if (!empty($redemptions)) { ?>
                    
                    <div class="table-left-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>STUDENT & CODE</th>
                                    <th>ITEM</th>
                                    <th style="text-align:center;">DATE</th>
                                    <th style="text-align:center;">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($redemptions as $r) { 
                                    $full_name = $r['first_name'] . ' ' . $r['last_name'];
                                    $img_path = !empty($r['image_path']) ? $r['image_path'] : 'default.png';
                                ?>
                                    <tr class="searchable-row" 
                                        data-name="<?php echo strtolower($full_name . ' ' . $r['id']); ?>" 
                                        data-status="<?php echo strtolower($r['status']); ?>">
                                        
                                        <td><?php echo $r['no']; ?></td>

                                        <td>
                                            <div class="user-info-with-avatar">
                                                <div class="usr_info">
                                                    <span class="name"><?php echo htmlspecialchars($full_name); ?></span>
                                                    <span class="code">#<?php echo str_pad($r['id'], 5, "0", STR_PAD_LEFT); ?></span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="event-title">
                                            <span class="event-image">
                                                <img src="/GoGreen-APU/assets/images/reward/<?php echo $img_path; ?>" class="reward-image-small">
                                            </span>
                                            <span><?php echo htmlspecialchars($r['reward_title']); ?></span>
                                        </td>

                                        <td style="text-align:center; color:#aaa; font-size:0.85rem;">
                                            <?php echo date('d/m/Y', strtotime($r['redeemed_at'])); ?>
                                        </td>

                                        <td style="text-align:center;">
                                            <?php if (strtolower($r['status']) == 'pending') { ?>
                                                <span class="status-badge status-pending">Pending</span>
                                            <?php } else { ?>
                                                <span class="status-badge status-redeemed">Collected</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-right-container glass-effect">
                        <table>
                            <thead>
                                <tr><th colspan="1">Actions</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($redemptions as $r) {
                                    $is_checked = (strtolower($r['status']) == 'redeemed') ? 'checked' : '';
                                    $next_status = (strtolower($r['status']) == 'pending') ? 'redeemed' : 'pending';
                                ?>
                                    <tr>
                                        <td>
                                            <div class="action-buttons-container">
                                                
                                                <form method="POST" style="margin: 0; display:flex; align-items:center;">
                                                    <input type="hidden" name="toggle_id" value="<?php echo $r['id']; ?>">
                                                    <input type="hidden" name="new_status" value="<?php echo $next_status; ?>">
                                                    
                                                    <div class="checkbox-switch">
                                                        <input type="checkbox" id="status_<?php echo $r['id']; ?>" 
                                                               onchange="this.form.submit()" <?php echo $is_checked; ?>>
                                                        <label for="status_<?php echo $r['id']; ?>"></label>
                                                    </div>
                                                </form>

                                                <form method="POST" style="margin:0; display:flex;">
                                                    <input type="hidden" name="delete_id" value="<?php echo $r['id']; ?>">
                                                    <button type="submit" onclick="return confirm('Delete this record? Cannot be undone.');" 
                                                            style="background:none; border:none; padding:0; cursor:pointer;">
                                                        <span class="trash-btn"><img src="/GoGreen-APU/assets/icons/trash.svg" alt="Delete"></span>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                <?php } else { ?>
                    <div style="text-align: center; padding: 60px 40px; width: 100%;">
                        <img src="/GoGreen-APU/assets/icons/calendar.badge.exclamationmark.svg" alt="No items"
                            style="width: 80px; height: 80px; filter: invert(1); opacity: 0.3; margin-bottom: 20px;">
                        <h3 style="font-size: 22px; margin-bottom: 10px; color: rgba(255, 255, 255, 0.8);">No Redemptions</h3>
                        <p style="font-size: 15px; color: rgba(255, 255, 255, 0.5);">No redemption history found.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <script>
        const searchInput = document.getElementById('redemption-search-input');
        const statusFilter = document.getElementById('filter-status');
        const clearBtn = document.getElementById('clear-search');
        
        const lRows = document.querySelectorAll('.table-left-container tbody tr');
        const rRows = document.querySelectorAll('.table-right-container tbody tr');

        function filterTable() {
            const query = searchInput.value.toLowerCase();
            const status = statusFilter.value;

            for (let i = 0; i < lRows.length; i++) {
                const row = lRows[i];
                const nameMatch = row.getAttribute('data-name').includes(query);
                const statusMatch = (status === 'all' || row.getAttribute('data-status') === status);
                
                const isVisible = nameMatch && statusMatch;
                
                row.style.display = isVisible ? '' : 'none';
                if(rRows[i]) {
                    rRows[i].style.display = isVisible ? '' : 'none';
                }
            }
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
        
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            filterTable();
        });
    </script>
</body>
</html>