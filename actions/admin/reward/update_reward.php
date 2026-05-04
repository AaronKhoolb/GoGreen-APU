<?php
/**
 * Author: Damian Loh Yi Feng
 * Date: 2026-01-25
 * Description: Action script to update a reward by admin
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['reward_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $cost = intval($_POST['cost']);
    $quantity = intval($_POST['quantity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "UPDATE rewards SET title = '$title', cost = $cost, quantity = $quantity, description = '$description' WHERE id = $id";

    if (!empty($_FILES['reward_image']['name'])) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/GoGreen-APU/assets/images/reward/";
        $filename = time() . '_' . $_FILES['reward_image']['name'];
        if (move_uploaded_file($_FILES['reward_image']['tmp_name'], $target_dir . $filename)) {
            $sql = "UPDATE rewards SET title = '$title', cost = $cost, quantity = $quantity, description = '$description', image_path = '$filename' WHERE id = $id";
        }
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: /GoGreen-APU/frontend/admin/rewards/index.php?status=updated");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}