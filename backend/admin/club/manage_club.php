<?php
/*
    Author: Chong Ray Han
    Date: 2026-02-05
    Description: Backend logic for fetching club data for editing
*/

// Get club ID from URL
$club_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch club data
$club = null;
$event_count = 0;
$organizer_count = 0;

if ($club_id > 0) {
    $club_query = "
        SELECT 
            c.*,
            (SELECT COUNT(*) FROM events e WHERE e.club_id = c.id) as event_count,
            (SELECT COUNT(*) FROM organizers o WHERE o.club_id = c.id) as organizer_count
        FROM clubs c 
        WHERE c.id = $club_id
    ";
    $club_result = mysqli_query($conn, $club_query);
    if ($club_result && mysqli_num_rows($club_result) > 0) {
        $club = mysqli_fetch_assoc($club_result);
        $event_count = $club['event_count'];
        $organizer_count = $club['organizer_count'];
    }
}
