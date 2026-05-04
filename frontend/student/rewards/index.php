<!--
    Author: Damian Loh Yi Feng
    Date: 2025-12-30
    Description: Student Rewards Page
-->
<?php

include(__DIR__ . '/../../../includes/db_conn.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = 3;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if (!$conn) {
    die("Database connection failed.");
}

$user_query = "SELECT ap_coins FROM students WHERE user_id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$current_balance = 0;

if ($user_result) {
    $row = mysqli_fetch_assoc($user_result);
    if ($row) {
        $current_balance = $row['ap_coins'];
    }
}

$rewards_query = "SELECT * FROM rewards WHERE quantity > 0 AND is_active = 1 ORDER BY cost ASC";
$rewards_result = mysqli_query($conn, $rewards_query);

$history_query = "SELECT * FROM reward_redemptions WHERE user_id = $user_id ORDER BY redeemed_at DESC";
$history_result = mysqli_query($conn, $history_query);

$count_pending = 0;
$count_collected = 0;

$history_data = array();

if ($history_result) {
    while ($row = mysqli_fetch_assoc($history_result)) {
        if (strtolower($row['status']) === 'redeemed') {
            $count_collected++;
        } else {
            $count_pending++;
        }
        
        $reward_id = $row['reward_id'];
        $reward_info_query = "SELECT title, image_path FROM rewards WHERE id = $reward_id";
        $reward_info_result = mysqli_query($conn, $reward_info_query);
        $reward_info = mysqli_fetch_assoc($reward_info_result);
        
        if ($reward_info) {
            $row['title'] = $reward_info['title'];
            $row['image_path'] = $reward_info['image_path'];
            $row['reward_actual_id'] = $reward_id;
        } else {
            $row['title'] = 'Unknown Reward';
            $row['image_path'] = 'default.png';
            $row['reward_actual_id'] = 0;
        }
        
        $history_data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Rewards</title>

    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/nav.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/reward/reward.css">
</head>

<body>
    <?php
    $page_name = "rewards";
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/nav.php');
    ?>

    <main class="main-content">
        <div class="dashboard-header">
            <div class="dashboard-glow"></div>

            <div class="stats-row">
                <div class="main-stat">
                    <div class="stat-icon-wrapper">
                        <img src="/GoGreen-APU/assets/icons/APcoins.png" class="stat-icon-img" alt="AP Coins">
                    </div>
                    <div class="stat-content">
                        <h1><?php echo number_format($current_balance); ?></h1>
                        <p>Available AP Coins</p>
                    </div>
                </div>

                <div class="secondary-stats">
                    <div class="sub-stat">
                        <div class="sub-stat-label">
                            <span style="width:6px; height:6px; background:#ff9800; border-radius:50%;"></span>
                            Pending Collection
                        </div>
                        <div class="sub-stat-value" style="color: #ff9800;">
                            <?php echo $count_pending; ?> Items
                        </div>
                    </div>

                    <div class="sub-stat">
                        <div class="sub-stat-label">
                            Total Redeemed
                        </div>
                        <div class="sub-stat-value">
                            <?php echo $count_collected; ?> Items
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabs">
            <div class="tab-btn active" onclick="switchTab(event, 'browse')">Shop Rewards</div>
            <div class="tab-btn" onclick="switchTab(event, 'history')">Collection History</div>
        </div>

        <div id="browse" class="tab-content active">
            <div class="reward-grid">
                <?php if (mysqli_num_rows($rewards_result) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($rewards_result)) { ?>
                        <div class="glass-effect-card reward-item" onclick="location.href='reward_details.php?id=<?php echo $row['id']; ?>'">
                            <div class="reward-img-container">
                                <img src="/GoGreen-APU/assets/images/reward/<?php echo htmlspecialchars($row['image_path']); ?>"
                                    class="reward-img">
                            </div>
                            <div class="reward-info">
                                <h3 class="reward-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                                <p class="reward-description"><?php echo htmlspecialchars($row['description']); ?></p>

                                <span style="font-size: 0.8rem; color: var(--text-muted); display:flex; align-items:center;">
                                    In Stock: <?php echo $row['quantity']; ?>
                                </span>
                            </div>
                            <div class="reward-footer">
                                <span class="cost-tag"><?php echo $row['cost']; ?> AP Coins</span>
                                <?php if ($current_balance >= $row['cost']) { ?>
                                    <a href="process_redemption.php?id=<?php echo $row['id']; ?>" class="btn-redeem"
                                        onclick="event.stopPropagation(); return confirm('Confirm redemption of <?php echo addslashes($row['title']); ?>?')">Redeem</a>
                                <?php } else { ?>
                                    <button class="btn-redeem" style="background: #333; color: #666; cursor: not-allowed; box-shadow:none;" disabled>Locked</button>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div style="grid-column: 1/-1; text-align:center; padding:60px; color: #888;">
                        <p>No rewards available at the moment.</p>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div id="history" class="tab-content">
            <?php if (count($history_data) > 0) { ?>
                <?php foreach ($history_data as $h) { ?>
                    <div class="glass-effect-card history-item" onclick="location.href='reward_details.php?id=<?php echo $h['reward_actual_id']; ?>&redemption_id=<?php echo $h['id']; ?>'">
                        <div style="display:flex; align-items:center; gap:25px;">
                            <div style="background: #fff; padding: 10px; border-radius: 16px; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                <img src="/GoGreen-APU/assets/images/reward/<?php echo $h['image_path']; ?>" style="max-width:100%; max-height:100%; object-fit:contain;">
                            </div>
                            <div>
                                <h4 style="margin:0; font-size: 1.2rem; color: #fff; font-weight: 600;"><?php echo htmlspecialchars($h['title']); ?></h4>
                                <p style="margin:8px 0 0 0; font-size:0.85rem; color: var(--text-muted);">Redeemed on: <?php echo date('d M Y, H:i', strtotime($h['redeemed_at'])); ?></p>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div class="redeem-id">REF: #<?php echo str_pad($h['id'], 5, "0", STR_PAD_LEFT); ?></div>

                            <?php
                            $status_color = (strtolower($h['status']) == 'redeemed') ? '#22c55e' : '#ff9800';
                            ?>

                            <p style="margin:12px 0 0 0; font-size:0.9rem; font-weight: bold; color: <?php echo $status_color; ?>; display:flex; align-items:center; justify-content:flex-end; gap:5px;">
                                <span style="width:8px; height:8px; border-radius:50%; background:<?php echo $status_color; ?>; display:inline-block;"></span>
                                <?php echo strtoupper($h['status']); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="glass-effect-card" style="text-align:center; padding:80px; color: var(--text-muted); border-style: dashed;">
                    <p style="font-size: 1.2rem;">You haven't redeemed any rewards yet.</p>
                </div>
            <?php } ?>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>

    <script>
        function switchTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            if (evt.currentTarget) {
                evt.currentTarget.classList.add("active");
            }
        }
    </script>
</body>

</html>