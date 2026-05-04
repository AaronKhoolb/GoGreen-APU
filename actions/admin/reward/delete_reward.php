<?php
/**
 * Author: Damian Loh Yi Feng
 * Date: 2026-01-25
 * Description: Action script to delete a reward by admin
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reward_id'])) {
    
    $id = intval($_POST['reward_id']);
    
    $delete_query = "DELETE FROM rewards WHERE id = $id";
    
    if (mysqli_query($conn, $delete_query)) {
        header("Location: /GoGreen-APU/frontend/admin/rewards/index.php?status=success");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: /GoGreen-APU/frontend/admin/rewards/index.php");
}
exit();
?>