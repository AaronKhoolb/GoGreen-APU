<!--
    Author: Damian Loh Yi Feng
    Date: 2026-1-10
    Description: Admin Dashboard Page
-->
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$res_students = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM users WHERE role='student'");
$row_students = mysqli_fetch_assoc($res_students);
$total_students = $row_students['cnt'];

$res_clubs = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM clubs");
$row_clubs = mysqli_fetch_assoc($res_clubs);
$total_clubs = $row_clubs['cnt'];

$res_coins = mysqli_query($conn, "SELECT SUM(ap_coins) as total FROM students");
$row_coins = mysqli_fetch_assoc($res_coins);
$total_coins = $row_coins['total'] ?? 0;
$total_coins_display = ($total_coins >= 1000) ? round($total_coins / 1000, 1) . 'k' : $total_coins;

$res_events = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM events");
$row_events = mysqli_fetch_assoc($res_events);
$total_events = $row_events['cnt'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Management Center | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/frosted_glass.css">
    
    <style>
        .admin-main { 
            padding: 30px; 
            max-width: 1600px; 
        }
        .hero-banner {
            width: 100%; 
            height: 260px;
            border-radius: 24px; 
            overflow: hidden;
            position: relative; 
            margin-bottom: 35px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .hero-banner img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            opacity: 0.7; 
        }
        .hero-welcome {
            position: absolute; 
            bottom: 0; 
            left: 0; 
            padding: 30px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            width: 100%;
        }
        .summary-stats {
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px; 
            margin-bottom: 35px;
        }
        .stat-box {
            background: rgba(255, 255, 255, 0.03);
            padding: 20px; 
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-left: 3px solid #4ade80; 
        }
        .stat-box label { 
            color: #888; 
            font-size: 0.8rem; 
            display: block; 
            margin-bottom: 5px; 
        }
        .stat-box h2 { 
            color: #fff; 
            margin: 0; 
            font-size: 1.6rem; 
            font-family: 'Inter', sans-serif; 
        }

        .action-grid {
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .action-link {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 25px;
            text-decoration: none;
            display: flex; align-items: center; gap: 20px;
            transition: 0.3s ease;
        }
        .action-link:hover {
            background: rgba(255, 255, 255, 0.09);
            border-color: #4ade80;
        }
        .icon-wrap {
            width: 50px; 
            height: 50px;
            background: rgba(74, 222, 128, 0.1);
            border-radius: 12px;
            display: flex; 
            align-items: center; 
            justify-content: center;
            flex-shrink: 0;
        }
        .icon-wrap img { 
            width: 22px; 
            opacity: 0.8; 
        }

        .action-info h3 { 
            color: #fff; 
            margin: 0; 
            font-size: 1.1rem; 
        }
        .action-info p { 
            color: #777; 
            margin: 4px 0 0 0; 
            font-size: 0.85rem; 
            line-height: 1.4; 
        }

        .recent-log {
            margin-top: 45px; 
            padding: 25px;
            background: rgba(255,255,255,0.02);
            border-radius: 20px; 
            border: 1px solid rgba(255,255,255,0.05);
        }
        .log-item {
            padding: 12px 0; 
            font-size: 0.9rem; 
            color: #999;
            border-bottom: 1px solid rgba(255,255,255,0.03);
        }
        .log-item:last-child { 
            border-bottom: none; 
        }
    </style>
</head>

<body>
    <?php
    $page_name = 'dashboard';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main class="admin-main">
        
        <div class="hero-banner">
            <img src="/GoGreen-APU/assets/images/event/2.png" alt="">
            <div class="hero-welcome">
                <h1 style="color: #fff; margin: 0;">Management Overview</h1>
                <p style="color: #4ade80; margin: 5px 0 0 0; font-size: 0.95rem;">Welcome to Admin Page</p>
            </div>
        </div>

        <div class="summary-stats">
            <div class="stat-box" style="border-left-color: #4ade80;">
                <label>Total Students</label>
                <h2 style="color: #4ade80;"><?php echo number_format($total_students); ?></h2>
            </div>
            <div class="stat-box" style="border-left-color: #60a5fa;">
                <label>Sustainability Clubs</label>
                <h2 style="color: #60a5fa;"><?php echo number_format($total_clubs); ?></h2>
            </div>
            <div class="stat-box" style="border-left-color: #fbbf24;">
                <label>Total AP Coins</label>
                <h2 style="color: #fbbf24;"><?php echo $total_coins_display; ?></h2>
            </div>
            <div class="stat-box" style="border-left-color: #f87171;">
                <label>Total Events</label>
                <h2 style="color: #f87171;"><?php echo number_format($total_events); ?></h2>
            </div>
        </div>

        <div class="action-grid">
            
            <a href="/GoGreen-APU/frontend/admin/user/index.php" class="action-link">
                <div class="icon-wrap"><img src="/GoGreen-APU/assets/icons/user.svg" style="filter: invert(1);"></div>
                <div class="action-info">
                    <h3>User Directory</h3>
                    <p>View and manage all system participants</p>
                </div>
            </a>

            <a href="/GoGreen-APU/frontend/admin/event/index.php" class="action-link">
                <div class="icon-wrap"><img src="/GoGreen-APU/assets/icons/my_events.svg" style="filter: invert(1);"></div>
                <div class="action-info">
                    <h3>Event Center</h3>
                    <p>Review and manage events</p>
                </div>
            </a>

            <a href="/GoGreen-APU/frontend/admin/club/index.php" class="action-link">
                <div class="icon-wrap"><img src="/GoGreen-APU/assets/icons/diversity_3_1000dp_1F1F1F_FILL0_wght400_GRAD0_opsz48.svg" style="filter: brightness(0) invert(1);"></div>
                <div class="action-info">
                    <h3>Club Center</h3>
                    <p>Review and moderate club profiles</p>
                </div>
            </a>

            <a href="/GoGreen-APU/frontend/admin/reward/index.php" class="action-link">
                <div class="icon-wrap"><img src="/GoGreen-APU/assets/icons/navigation/rewards.svg"></div>
                <div class="action-info">
                    <h3>Reward Center</h3>
                    <p>Review and manage reward</p>
                </div>
            </a>

        </div>

        <div class="recent-log">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="color: #eee; margin: 0; font-size: 1rem;">System Feed</h3>
                <a href="/GoGreen-APU/frontend/admin/my_activities/index.php" style="color: #4ade80; font-size: 0.85rem; text-decoration: none; opacity: 0.7;">View All History</a>
            </div>

            <?php
            $feed_query = "SELECT * FROM logs ORDER BY date_time DESC LIMIT 5";
            $feed_res = mysqli_query($conn, $feed_query);

            if (mysqli_num_rows($feed_res) > 0) {
                while ($log = mysqli_fetch_assoc($feed_res)) {
                    $user_id = $log['user_id'];
                    $user_query = "SELECT first_name, last_name, avatar_path, role FROM users WHERE id = $user_id";
                    $user_res = mysqli_query($conn, $user_query);
                    $user_data = mysqli_fetch_assoc($user_res);

                    $first_name = $user_data['first_name'] ?? 'Unknown';
                    $role = isset($user_data['role']) ? strtolower($user_data['role']) : '';
                    $avatar_path = $user_data['avatar_path'] ?? 'default.png';
                    
                    $action_color = "#4ade80";
                    
                    if ($role === 'admin') {
                        $action_color = "#f87171";
                    } elseif ($role === 'organizer') {
                        $action_color = "#60a5fa";
                    } elseif ($role === 'collaborator') {
                        $action_color = "#c084fc";
                    }
                    
                    $log_time = strtotime($log['date_time']);
                    $time_display = (date('Y-m-d', $log_time) == date('Y-m-d')) ? 'Today, ' . date('H:i', $log_time) : date('d M, H:i', $log_time);
            ?>
                <div class="log-item" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.03);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="/GoGreen-APU/assets/images/profile/<?php echo $avatar_path; ?>" 
                             style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">
                        
                        <div>
                            <span style="color: <?php echo $action_color; ?>; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <?php echo htmlspecialchars($role); ?>
                            </span>
                            <p style="color: #ccc; margin: 2px 0 0 0; font-size: 0.85rem;">
                                <strong style="color: #eee;"><?php echo htmlspecialchars($first_name); ?></strong> 
                                <?php echo htmlspecialchars($log['details']); ?>
                            </p>
                        </div>
                    </div>
                    <span style="color: #555; font-size: 0.75rem; font-family: monospace;"><?php echo $time_display; ?></span>
                </div>
            <?php 
                } 
            } else {
                echo '<p style="color: #555; text-align: center; padding: 20px;">No recent activities found.</p>';
            }
            ?>
        </div>
    </main>
</body>
</html>