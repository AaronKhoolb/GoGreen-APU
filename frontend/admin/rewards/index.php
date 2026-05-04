 <!--
    Author: Damian Loh Yi Feng
    Date: 2026-1-10
    Description: Reward Management Page for Admins
-->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php'); 

$total_rewards = 0;
$active_rewards = 0;
$inactive_rewards = 0;
$total_redemptions = 0;

$sql_stats = "SELECT * FROM rewards";
$res_stats = mysqli_query($conn, $sql_stats);

if ($res_stats) {
    while ($row = mysqli_fetch_assoc($res_stats)) {
        $total_rewards++;
        if ($row['is_active'] == 1) {
            $active_rewards++;
        } else {
            $inactive_rewards++;
        }
    }
}

$rewards = array();
$sql_rewards = "SELECT * FROM rewards ORDER BY created_at DESC";
$res_rewards = mysqli_query($conn, $sql_rewards);

$count = 1;
if($res_rewards) {
    while ($row = mysqli_fetch_assoc($res_rewards)) {
        $row['no'] = $count++;
        
        $reward_id = $row['id'];
        $sql_count = "SELECT COUNT(*) as cnt FROM reward_redemptions WHERE reward_id = $reward_id";
        $res_count = mysqli_query($conn, $sql_count);
        $count_data = mysqli_fetch_assoc($res_count);
        
        $row['redemption_count'] = $count_data['cnt'];
        $total_redemptions += $row['redemption_count'];
        
        $rewards[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Reward Management</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/table.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/checkbox_switch.css">
    <style>
        .table-manage-container { 
            display: flex; 
            align-items: stretch; 
            gap: 0; 
        }
        .table-left-container { 
            flex: 1; 
            overflow-x: auto; 
        }
        .table-right-container { 
            width: 180px; 
            border-left: 1px solid rgba(255, 255, 255, 0.1); 
        }
        .table-left-container table tbody tr td,
        .table-right-container table tbody tr td {
            height: 85px; 
            padding: 0 15px;
            vertical-align: middle;
            box-sizing: border-box;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .table-right-container table tbody tr td { 
            text-align: center; 
        }

        .reward-image {
            width: 100px; 
            height: 56px; 
            border-radius: 8px;
            object-fit: cover; 
            margin-right: 15px;
            background: rgba(255,255,255,0.1); 
            vertical-align: middle;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }

        .action-btns {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }
        
        .action-btns img { 
            width: 18px; 
            filter: brightness(0) invert(1); 
            opacity: 0.7; 
            transition: 0.3s; 
        }
        .action-btns img:hover { 
            opacity: 1; 
        }
        .trash-btn img { 
            filter: invert(30%) sepia(100%) saturate(500%) hue-rotate(330deg); 
        }
    </style>
</head>

<body>
    <?php
    $page_name = 'reward'; 
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="color: #4ade80;">My Rewards</h1>
                <p>Monitor and manage student eco-rewards shop.</p>
            </div>
            <a href="/GoGreen-APU/frontend/admin/rewards/create_reward.php"
                class="create-event-btn green-glass-effect-border">
                <img src="/GoGreen-APU/assets/icons/plus.app.fill.svg" alt="Create">
                <span>Create Reward</span>
            </a>
        </div>

        <div class="stats-container">
            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/my_events.svg"></div>
                <div class="stat-content">
                    <span class="stat-label">TOTAL ITEMS</span>
                    <span class="stat-value"><?php echo $total_rewards; ?></span>
                    <div class="stat-breakdown">
                        <span class="stat-approved"><span class="dot"></span><?php echo $active_rewards; ?> Active</span>
                        <span class="stat-rejected"><span class="dot" style="background:#ff4d4d;"></span><?php echo $inactive_rewards; ?> Hidden</span>
                    </div>
                </div>
            </div>
            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/person.3.fill.svg"></div>
                <div class="stat-content">
                    <span class="stat-label">TOTAL REDEMPTIONS</span>
                    <span class="stat-value"><?php echo $total_redemptions; ?></span>
                    <span class="stat-subtitle">Lifetime claims</span>
                </div>
            </div>
        </div>

        <div class="table-actions-container glass-effect">
            <div class="table-search-bar">
                <input type="text" id="reward-search-input" class="table-search-input" placeholder="Search rewards...">
                <button class="table-clear-btn clear-btn" type="button" id="clear-search">
                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                </button>
                <button class="table-search-btn" type="button">
                    <img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search" class="search-icon">
                    <span class="search-text">Search</span>
                </button>
            </div>

            <div class="table-filters">
                <div class="filter-group glass-effect-border">
                    <label for="filter-status">Status</label>
                    <select id="filter-status">
                        <option value="all">All</option>
                        <option value="active">Active</option>
                        <option value="hidden">Hidden</option>
                    </select>
                </div>
            </div>

            <div class="table-manage-container glass-effect-border">
                <?php if (!empty($rewards)) { ?>
                    <div class="table-left-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>REWARD INFO</th>
                                    <th style="text-align: center;">COST</th>
                                    <th style="text-align: center;">STOCK</th>
                                    <th style="text-align: center;">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rewards as $r) { ?>
                                    <tr data-name="<?php echo strtolower($r['title']); ?>" 
                                        data-status="<?php echo $r['is_active'] ? 'active' : 'hidden'; ?>">
                                        <td><?php echo $r['no']; ?></td>
                                        <td class="event-title">
                                            <?php $img = $r['image_path'] ? $r['image_path'] : 'default.png'; ?>
                                            <img src="/GoGreen-APU/assets/images/reward/<?php echo $img; ?>" class="reward-image" alt="Reward Image">
                                            <span><?php echo htmlspecialchars($r['title']); ?></span>
                                        </td>
                                        <td style="text-align: center;"><b><?php echo $r['cost']; ?> pts</b></td>
                                        <td style="text-align: center;"><?php echo $r['quantity']; ?></td>
                                        <td style="text-align: center;">
                                            <?php if ($r['is_active']) { ?>
                                                <span class="status-badge status-approved">Active</span>
                                            <?php } else { ?>
                                                <span class="status-badge status-rejected">Hidden</span>
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
                                <tr>
                                    <th colspan="3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rewards as $reward) { 
                                    $is_checked = ($reward['is_active'] == 1) ? 'checked' : '';
                                    $next_status = ($reward['is_active'] == 1) ? 0 : 1;
                                ?>
                                    <tr>
                                        <td>
                                            <div class="action-btns">
                                                <form method="POST" action="/GoGreen-APU/actions/admin/reward/toggle_status.php" style="margin: 0;">
                                                    <input type="hidden" name="reward_id" value="<?php echo $reward['id']; ?>">
                                                    <input type="hidden" name="is_active" value="<?php echo $next_status; ?>">
                                                    <div class="checkbox-switch">
                                                        <input type="checkbox" id="status_<?php echo $reward['id']; ?>"
                                                            onchange="this.form.submit()" <?php echo $is_checked; ?>>
                                                        <label for="status_<?php echo $reward['id']; ?>"></label>
                                                    </div>
                                                </form>

                                                <a href="manage_reward.php?id=<?php echo $reward['id']; ?>">
                                                    <img src="/GoGreen-APU/assets/icons/square.and.pencil.svg" alt="Edit">
                                                </a>

                                                <form method="POST" action="/GoGreen-APU/actions/admin/reward/delete_reward.php" 
                                                    style="margin: 0; display: inline;" 
                                                    onsubmit="return confirm('Are you sure you want to delete this reward?');">
                                                    
                                                    <input type="hidden" name="reward_id" value="<?php echo $reward['id']; ?>">
                                                    
                                                    <button type="submit" class="trash-btn" style="background: none; border: none; cursor: pointer; padding: 0;">
                                                        <img src="/GoGreen-APU/assets/icons/trash.svg" alt="Delete">
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
                        <img src="/GoGreen-APU/assets/icons/calendar.badge.plus.svg" alt="No items"
                            style="width: 80px; height: 80px; filter: invert(1); opacity: 0.3; margin-bottom: 20px;">
                        <h3 style="font-size: 22px; margin-bottom: 10px; color: rgba(255, 255, 255, 0.8);">No Rewards Found</h3>
                        <p style="font-size: 15px; color: rgba(255, 255, 255, 0.5);">Start by adding some rewards to the shop</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <script>
        const searchInput = document.getElementById('reward-search-input');
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