<!--
    Author: Khoo Lay Bin
    Date: 2026-1-9
    Description: Update approval status 
-->
<?php

session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['event_id']) && isset($data['status'])) {
    $event_id = intval($data['event_id']);
    $status = $data['status'];
    
    if ($status === 'pending') {
        $is_approved = 'NULL';
        $approved_by = 'NULL';
        $approved_at = 'NULL';
        $status_text = 'pending';
    } elseif ($status === 'approved') {
        $is_approved = 1;
        $approved_by = $user_id;
        $approved_at = 'NOW()';
        $status_text = 'approved';
    } else { 
        $is_approved = 0;
        $approved_by = $user_id;
        $approved_at = 'NOW()';
        $status_text = 'rejected';
    }
    
    $sql = "UPDATE events SET 
            is_approved = $is_approved, 
            approved_by = $approved_by, 
            approved_at = $approved_at 
            WHERE id = $event_id";
    
    if ($conn->query($sql)) {
        $log_details = "Event id $event_id status changed to $status_text";
        $sql_log = "INSERT INTO logs (user_id, role, action, details, date_time) 
                    VALUES ($user_id, 'admin', 'Event', '$log_details', NOW())";
        $conn->query($sql_log);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Status updated successfully',
            'status' => $status_text
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Database error: ' . $conn->error
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Missing required data'
    ]);
}

$conn->close();
?>