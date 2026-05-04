<!--
    Author: Chong Ray Han
    Date: 2026-01-28
    Description: Backend functions for fetching notifications
-->

<?php
function getNotifications($conn, $user_id, $filter = 'all')
{
    $user_id = intval($user_id);
    $sql = "SELECT n.*, e.title as event_title, e.image_path as event_image,
            (SELECT a.image_path FROM announcements a 
             WHERE a.target_event_id = n.link_event_id 
             AND n.title LIKE CONCAT('Announcement: ', a.title)
             ORDER BY a.created_at DESC LIMIT 1) as announcement_image
            FROM notifications n 
            LEFT JOIN events e ON n.link_event_id = e.id 
            WHERE n.user_id = $user_id";

    if ($filter == 'unread') {
        $sql .= " AND n.is_read = 0";
    } else if ($filter == 'events') {
        $sql .= " AND (n.type = 'event' OR n.type = 'reward')";
    } else if ($filter == 'system') {
        $sql .= " AND (n.type = 'system' OR n.type = 'general')";
    }

    $sql .= " ORDER BY n.created_at DESC";
    $result = mysqli_query($conn, $sql);

    $notifications = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $notifications[] = $row;
        }
    }

    return $notifications;
}

function countUnreadNotifications($conn, $user_id)
{
    $user_id = intval($user_id);
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM notifications WHERE user_id = $user_id AND is_read = 0");

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return intval($row['count']);
    }

    return 0;
}

function getTimeAgo($datetime)
{
    $created_at = strtotime($datetime);
    $now = time();
    $diff = $now - $created_at;

    if ($diff < 60) {
        return 'Just now';
    } else if ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
    } else if ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } else if ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return date('M j, Y', $created_at);
    }
}


function getNotificationIcon($notif)
{
    $title_lower = strtolower($notif['title']);
    $message_lower = strtolower($notif['message']);
    $notif_type = $notif['type'];

    $icon_path = '/GoGreen-APU/assets/icons/';

    if (strpos($title_lower, 'announcement') !== false) {
        $icon_path .= 'megaphone.svg';
        $icon_class = 'announcement';
    } else if (strpos($title_lower, 'approved') !== false || strpos($message_lower, 'approved') !== false || strpos($message_lower, 'accepted') !== false) {
        $icon_path .= 'clock.badge.checkmark.svg';
        $icon_class = 'approved';
    } else if (strpos($title_lower, 'rejected') !== false || strpos($message_lower, 'rejected') !== false || strpos($message_lower, 'declined') !== false) {
        $icon_path .= 'x.circle.fill.svg';
        $icon_class = 'rejected';
    } else if ($notif_type == 'reward' || strpos($title_lower, 'reward') !== false || strpos($title_lower, 'coin') !== false || strpos($message_lower, 'ap coin') !== false) {
        $icon_path .= 'dollarsign.circle.fill.svg';
        $icon_class = 'reward';
    } else if ($notif_type == 'event') {
        $icon_path .= 'calendar.badge.clock.svg';
        $icon_class = 'event';
    } else if ($notif_type == 'system') {
        $icon_path .= 'gearshape.fill.svg';
        $icon_class = 'system';
    } else {
        $icon_path .= 'bell.fill.svg';
        $icon_class = 'general';
    }

    return [
        'icon_path' => $icon_path,
        'icon_class' => $icon_class
    ];
}


function getNotificationImage($notif)
{
    $title_lower = strtolower($notif['title']);

    if (strpos($title_lower, 'announcement') !== false && !empty($notif['announcement_image'])) {
        return [
            'show_image' => true,
            'image_url' => '/GoGreen-APU/uploads/announcements/' . $notif['announcement_image']
        ];
    }

    return [
        'show_image' => false,
        'image_url' => ''
    ];
}

function getNotificationLink($notif)
{
    if ($notif['link_event_id']) {
        return '/GoGreen-APU/frontend/student/explore/event/index.php?id=' . $notif['link_event_id'];
    }
    return '#';
}
?>