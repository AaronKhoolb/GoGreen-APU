<!--
    Author: Damian Loh Yi Feng
    Date: 2025-12-30
    Description: Student Process Reward Redemption
-->
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$reward_id = 0;
if (isset($_GET['id'])) {
    $reward_id = intval($_GET['id']);
}

$user_id = 3;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if ($reward_id <= 0) {
    echo "<script>alert('Invalid Reward'); window.location.href='index.php';</script>";
    exit();
}

$sql_reward = "SELECT * FROM rewards WHERE id = $reward_id";
$res_reward = mysqli_query($conn, $sql_reward);
$reward = mysqli_fetch_assoc($res_reward);

$sql_student = "SELECT ap_coins FROM students WHERE user_id = $user_id";
$res_student = mysqli_query($conn, $sql_student);
$student = mysqli_fetch_assoc($res_student);

if ($reward && $student) {
    $cost = intval($reward['cost']);
    $balance = intval($student['ap_coins']);
    $stock = intval($reward['quantity']);

    if ($balance < $cost) {
        echo "<script>alert('Not enough AP Coins!'); window.location.href='index.php';</script>";
        exit();
    }

    if ($stock <= 0) {
        echo "<script>alert('Out of stock!'); window.location.href='index.php';</script>";
        exit();
    }

    $sql_update_student = "UPDATE students SET ap_coins = ap_coins - $cost WHERE user_id = $user_id";
    $sql_update_reward = "UPDATE rewards SET quantity = quantity - 1 WHERE id = $reward_id";
    $sql_insert_history = "INSERT INTO reward_redemptions (reward_id, user_id, ap_coins_spent, status, redeemed_at) 
                           VALUES ($reward_id, $user_id, $cost, 'Pending', NOW())";

    $res1 = mysqli_query($conn, $sql_update_student);
    $res2 = mysqli_query($conn, $sql_update_reward);
    $res3 = mysqli_query($conn, $sql_insert_history);

    if ($res1 && $res2 && $res3) {
        echo "<script>alert('Redemption Successful!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Database Error!'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Record not found!'); window.location.href='index.php';</script>";
}
?>