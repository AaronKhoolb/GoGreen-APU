<!--
    Author: Chong Ray Han
    Date: 2026-1-9
    Description: setting page for changing faq for admin
-->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php'; ?>
<?php

$faq_query = "SELECT * FROM faq ORDER BY category, id";
$faq_result = mysqli_query($conn, $faq_query);


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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Manage FAQs</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/guest/faq.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/admin/faq.css">
</head>

<body>
    <?php
    $page_name = 'settings_faq';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-text">
                <h1>Manage FAQs</h1>
                <p>Create and manage frequently asked questions.</p>
            </div>
        </div>

        <div class="admin-faq-content">
            <div class="faq-main">
                <?php foreach ($category_info as $category_key => $info): ?>
                    <section id="<?php echo $category_key; ?>" class="faq-section">
                        <div class="section-header">
                            <div class="section-title-row">
                                <h2 class="section-title"><?php echo htmlspecialchars($info['title']); ?></h2>
                                <a href="add_faq.php?category=<?php echo $category_key; ?>" class="add-faq-btn" title="Add new FAQ to <?php echo htmlspecialchars($info['title']); ?>">
                                    <img src="/GoGreen-APU/assets/icons/plus.svg" alt="Add">
                                </a>
                            </div>
                            <div class="section-line"></div>
                        </div>
                        <div class="faq-list">
                            <?php if (!empty($faqs_by_category[$category_key])): ?>
                                <?php foreach ($faqs_by_category[$category_key] as $faq): ?>
                                    <div class="faq-card active" id="faq-<?php echo $faq['id']; ?>">
                                        <div class="faq-question">
                                            <h3 onclick="toggleFaq(this)"><?php echo htmlspecialchars($faq['question']); ?></h3>

                                            <div class="faq-actions">
                                                <a href="edit_faq.php?id=<?php echo $faq['id']; ?>" class="action-btn edit-btn">
                                                    <img src="/GoGreen-APU/assets/icons/square.and.pencil.svg" alt="">
                                                    <span>Edit</span>
                                                </a>
                                                <button onclick="deleteFaq(<?php echo $faq['id']; ?>)" class="action-btn delete-btn">
                                                    <img src="/GoGreen-APU/assets/icons/trash.svg" alt="">
                                                    <span>Delete</span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="faq-answer">
                                            <div class="faq-answer-content">
                                                <?php echo $faq['answer']; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="faq-empty">
                                    <p>No FAQs available in this category yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>

    </main>


    <script>
        function deleteFaq(id) {
            if (confirm('Are you sure you want to delete this FAQ?')) {
                window.location.href = '/GoGreen-APU/actions/admin/faq/delete_faq.php?id=' + id;
            }
        }
    </script>
</body>

</html>