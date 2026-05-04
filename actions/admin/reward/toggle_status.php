<?php
/**
 * Author: Damian Loh Yi Feng
 * Date: 2026-01-25
 * Description: Action script to toggle reward status by admin
 */
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['reward_id']) && isset($_POST['is_active'])) {
        
        $id = intval($_POST['reward_id']);
        $status = intval($_POST['is_active']);

        $sql = "UPDATE rewards SET is_active = $status WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
            } else {
                header("Location: /GoGreen-APU/frontend/admin/reward/index.php");
            }
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "Missing parameters.";
    }
} else {
    header("Location: /GoGreen-APU/frontend/admin/reward/index.php");
    exit();
}
?>