<!--
    Author: Damian Loh Yi Feng
    Date: 2025-12-30
    Description: StudentReward Details Page 
-->
<?php
include(__DIR__ . '/../../../includes/db_conn.php'); 
session_start();

$reward_id = 0;
if (isset($_GET['id'])) {
    $reward_id = intval($_GET['id']);
}

$redemption_id = null;
if (isset($_GET['redemption_id'])) {
    $redemption_id = intval($_GET['redemption_id']);
}

$user_id = 3;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if (!$conn) {
    die("Database connection failed.");
}

$sql_reward = "SELECT * FROM rewards WHERE id = $reward_id";
$res_reward = mysqli_query($conn, $sql_reward);
$reward = mysqli_fetch_assoc($res_reward);

if (!$reward) {
    die("Reward not found.");
}

$redemption_info = null;
if ($redemption_id) {
    $sql_red = "SELECT * FROM reward_redemptions WHERE id = $redemption_id AND user_id = $user_id";
    $res_red = mysqli_query($conn, $sql_red);
    $redemption_info = mysqli_fetch_assoc($res_red);
}

$sql_user = "SELECT ap_coins FROM students WHERE user_id = $user_id";
$res_user = mysqli_query($conn, $sql_user);
$user_data = mysqli_fetch_assoc($res_user);
$current_balance = 0;

if ($user_data) {
    $current_balance = $user_data['ap_coins'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title><?php echo htmlspecialchars($reward['title']); ?> - Details</title>
    
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/nav.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/reward/reward.css">
</head>
<body>
    <?php 
    $page_name = 'rewards'; 
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/nav.php'); 
    ?>

    <main class="main-content">
        <a href="index.php" class="back-link">← Return to Rewards Store</a>
        
        <div class="detail-container">
            <div class="image-section">
                <img src="/GoGreen-APU/assets/images/reward/<?php echo htmlspecialchars($reward['image_path']); ?>" alt="Reward Image">
            </div>

            <div class="info-section">
                
                <?php if ($redemption_info) { ?>
                    <div class="reward-tag">REDEMPTION VOUCHER</div>
                    <h1 class="reward-title"><?php echo htmlspecialchars($reward['title']); ?></h1>
                    
                    <div class="voucher-card">
                        <p style="margin:0; color:#888; font-size:0.8rem;">COLLECTION CODE</p>
                        
                        <div class="voucher-id">#<?php echo str_pad($redemption_info['id'], 5, "0", STR_PAD_LEFT); ?></div>
                        
                        <?php 
                        $status = strtolower($redemption_info['status']);
                        $bg_color = ($status == 'redeemed') ? '#22c55e' : '#ff9800'; 
                        ?>
                        <div class="status-badge" style="background: <?php echo $bg_color; ?>;">
                            <?php echo strtoupper($redemption_info['status']); ?>
                        </div>
                        
                        <p style="margin-top:20px; color:#666; font-size:0.8rem;">
                            <?php if($status == 'pending') { ?>
                                Show this code to APU GoGreen staff to claim your item.
                            <?php } else { ?>
                                Item successfully collected.
                            <?php } ?>
                        </p>
                    </div>

                    <a href="index.php" class="btn-action" style="background: #333; color: #fff;">Back to History</a>

                <?php } else { ?>
                    <div class="reward-tag">AVAILABLE REWARD</div>
                    <h1 class="reward-title"><?php echo htmlspecialchars($reward['title']); ?></h1>
                    
                    <div class="reward-price">
                        <img src="/GoGreen-APU/assets/icons/APcoins.png" style="width: 50px; height: 50px; object-fit: contain; filter: drop-shadow(0 0 10px rgba(34, 197, 94, 0.4));">
                        <div>
                            <?php echo number_format($reward['cost']); ?> 
                            <small style="font-size: 1.2rem; opacity: 0.6; font-weight: 400; display: block; line-height: 0.8;">AP Coins</small>
                        </div>
                    </div>
                    
                    <div class="description-text">
                        <?php echo htmlspecialchars($reward['description']); ?>
                    </div>

                    <p style="font-size: 0.9rem; color: #848484; margin-bottom: 20px;">
                        Currently <b><?php echo $reward['quantity']; ?></b> units available in stock.
                    </p>

                    <?php if ($current_balance >= $reward['cost']) { ?>
                        <a href="process_redemption.php?id=<?php echo $reward['id']; ?>" 
                           class="btn-action" 
                           onclick="return confirm('Spend <?php echo $reward['cost']; ?> AP Coins on this reward?')">
                            Confirm Redemption
                        </a>
                        <div class="balance-note">Your current balance: <?php echo number_format($current_balance); ?> AP Coins</div>
                    <?php } else { ?>
                        <div class="btn-action btn-disabled">Insufficient Coins</div>
                        <div class="balance-note">You need <?php echo number_format($reward['cost'] - $current_balance); ?> more coins to redeem this item.</div>
                    <?php } ?>
                    
                <?php } ?>
            </div>
        </div>
    </main>
</body>
</html>