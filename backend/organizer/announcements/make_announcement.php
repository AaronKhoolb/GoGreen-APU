<!--
    Author: Chong Ray Han
    Date: 2026-01-28
    Description: Backend logic for announcements page - handles data fetching for event announcements
-->

<?php
// Get event ID from URL
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get participant count for this event (approved only)
$participant_count_sql = "SELECT COUNT(*) as count FROM event_participants WHERE event_id = $event_id AND approval_status = 1";
$participant_count_result = mysqli_query($conn, $participant_count_sql);
$participant_count = 0;
if ($participant_count_result) {
    $participant_count = mysqli_fetch_assoc($participant_count_result)['count'];
}

// Get sent announcements for this event
$announcements_sql = "SELECT a.*, u.first_name, u.last_name 
                      FROM announcements a 
                      LEFT JOIN users u ON a.created_by = u.id 
                      WHERE a.target_event_id = $event_id 
                      ORDER BY a.created_at DESC";
$announcements_result = mysqli_query($conn, $announcements_sql);
$announcements = [];
if ($announcements_result) {
    while ($row = mysqli_fetch_assoc($announcements_result)) {
        $announcements[] = $row;
    }
}

// Check for success/error messages
$success = isset($_GET['success']) && $_GET['success'] == '1';
$notification_count = isset($_GET['count']) ? intval($_GET['count']) : 0;
$error = isset($_GET['error']) ? $_GET['error'] : '';
