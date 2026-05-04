<?php
/**
 * Author: Damian Loh Yi Feng
 * Date: 2026-01-25
 * Description: Save New Reward Action
 */
include(__DIR__ . '/../../../includes/db_conn.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $cost        = intval($_POST['cost']);
    $quantity    = intval($_POST['quantity']);
    
    $is_active   = isset($_POST['is_active']) ? 1 : 0;

    $created_by  = $_SESSION['user_id'] ?? 1;

    $image_filename = "default.png";

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = __DIR__ . '/../../../assets/images/reward/';
        
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        
        $new_filename = "reward_" . time() . "." . $imageFileType;
        $target_file = $target_dir . $new_filename;

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_filename = $new_filename;
            } else {
                echo "<script>alert('Error: Failed to move uploaded file.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Error: Only JPG, JPEG, PNG & GIF files are allowed.'); window.history.back();</script>";
            exit;
        }
    }

    $query = "INSERT INTO rewards (title, description, cost, quantity, image_path, is_active, created_by, created_at) 
              VALUES ('$title', '$description', '$cost', '$quantity', '$image_filename', '$is_active', '$created_by', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('New reward created successfully!');
                window.location.href = '/GoGreen-APU/frontend/admin/rewards/index.php';
              </script>";
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }

} else {
    header("Location: /GoGreen-APU/frontend/admin/rewards/index.php");
    exit;
}
?>