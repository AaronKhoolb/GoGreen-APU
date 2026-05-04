<!-- 
Author: Chong Ray Han
Date: 2025-01-28
Description: fetch faq from database 
  -->
<?php

$faq_query = "SELECT * FROM faq ORDER BY category, id";
$faq_result = mysqli_query($conn, $faq_query);

// Group FAQs by category
$faqs_by_category = [
    'general' => [],
    'events' => [],
    'account' => [],
    'rewards' => []
];

if ($faq_result && mysqli_num_rows($faq_result) > 0) {
    while ($row = mysqli_fetch_assoc($faq_result)) {
        $category = strtolower($row['category'] ?? 'general');
        if (array_key_exists($category, $faqs_by_category)) {
            $faqs_by_category[$category][] = $row;
        } else {
            $faqs_by_category['general'][] = $row;
        }
    }
}

$category_info = [
    'general' => ['title' => 'General Questions', 'icon' => 'info.circle.svg'],
    'events' => ['title' => 'Events & Registration', 'icon' => 'calendar.badge.clock.svg'],
    'account' => ['title' => 'Account & Profile', 'icon' => 'person.3.svg'],
    'rewards' => ['title' => 'Rewards & AP Coins', 'icon' => 'leaf.svg']
];
