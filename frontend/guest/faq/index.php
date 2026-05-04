<!-- 
Author: Chong Ray Han
Date: 2025-01-28
Description: Faq Page. 
  -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/actions/guest/get_faqs.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/nav.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/guest/faq.css">
</head>

<body class="faq-page">
    <?php
    $page_name = 'faq';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/guest/nav.php');
    ?>

    <div class="main-content">
        <!-- Hero Section -->
        <section class="faq-hero">
            <h1>How can we <span>help</span>?</h1>
            <p>Search for answers about events, rewards, and your account. We're here to help you make the most of
                GoGreen@APU.</p>

            <div class="faq-searchbox">
                <img class="icon" src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search">
                <input type="text" id="faq-search" placeholder="Type your question here...">
            </div>
        </section>

        <!-- Main Content -->
        <div class="faq-content">
            <!-- Sidebar Navigation -->
            <aside class="faq-sidebar">
                <div class="sidebar-card">
                    <p class="sidebar-header">Categories</p>
                    <ul class="category-list">
                        <?php
                        $first = true;
                        foreach ($category_info as $key => $info):
                        ?>
                            <li>
                                <a href="#<?php echo $key; ?>" class="category-item <?php echo $first ? 'active' : ''; ?>" data-category="<?php echo $key; ?>">
                                    <img class="icon" src="/GoGreen-APU/assets/icons/<?php echo $info['icon']; ?>" alt="">
                                    <span><?php echo ucfirst($key); ?></span>
                                </a>
                            </li>
                        <?php
                            $first = false;
                        endforeach;
                        ?>
                    </ul>
                </div>

                <!-- Contact Card -->
                <div class="contact-card" style="margin-top: 20px;">
                    <div class="icon-wrapper">
                        <img class="icon" src="/GoGreen-APU/assets/icons/text.bubble.svg" alt="">
                    </div>
                    <h3>Still have questions?</h3>
                    <p>Can't find what you're looking for? Reach out to our support team.</p>
                    <a href="mailto:gogreen@apu.edu.my" class="contact-btn">
                        <span>Contact Support</span>
                    </a>
                </div>
            </aside>

            <!-- FAQ Sections -->
            <main class="faq-main">
                <?php foreach ($category_info as $category_key => $info): ?>
                    <section id="<?php echo $category_key; ?>" class="faq-section">
                        <div class="section-header">
                            <h2 class="section-title"><?php echo htmlspecialchars($info['title']); ?></h2>
                            <div class="section-line"></div>
                        </div>
                        <div class="faq-list">
                            <?php if (!empty($faqs_by_category[$category_key])): ?>
                                <?php foreach ($faqs_by_category[$category_key] as $faq): ?>
                                    <div class="faq-card">
                                        <div class="faq-question">
                                            <h3><?php echo htmlspecialchars($faq['question']); ?></h3>
                                            <div class="faq-toggle">
                                                <img class="icon" src="/GoGreen-APU/assets/icons/navigation/chevron.down.svg" alt="">
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
            </main>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>

    <script>
        document.querySelectorAll('.faq-question').forEach(function(question) {
            question.addEventListener('click', function() {
                var card = this.parentElement;
                var isActive = card.classList.contains('active');

                // Close all other cards in the same section
                var section = card.closest('.faq-section');
                section.querySelectorAll('.faq-card.active').forEach(function(activeCard) {
                    if (activeCard !== card) {
                        activeCard.classList.remove('active');
                    }
                });

                // Toggle current card
                card.classList.toggle('active', !isActive);
            });
        });

        // Category Navigation
        document.querySelectorAll('.category-item').forEach(function(item) {
            item.addEventListener('click', function(e) {
                // Remove active class from all items
                document.querySelectorAll('.category-item').forEach(function(i) {
                    i.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // Search Functionality
        document.getElementById('faq-search').addEventListener('input', function() {
            var searchTerm = this.value.toLowerCase();

            document.querySelectorAll('.faq-card').forEach(function(card) {
                var question = card.querySelector('h3').textContent.toLowerCase();
                var answerContent = card.querySelector('.faq-answer-content');
                var answer = answerContent ? answerContent.textContent.toLowerCase() : '';

                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    card.style.display = 'block';
                    if (searchTerm.length > 2) {
                        card.classList.add('active');
                    }
                } else {
                    card.style.display = searchTerm ? 'none' : 'block';
                }
            });

            // Show/hide sections based on visible cards
            document.querySelectorAll('.faq-section').forEach(function(section) {
                var visibleCards = section.querySelectorAll('.faq-card[style="display: block;"], .faq-card:not([style])');
                var hasVisibleCards = Array.from(visibleCards).some(function(card) {
                    return card.style.display !== 'none';
                });
                section.style.display = hasVisibleCards || !searchTerm ? 'block' : 'none';
            });
        });

        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    var offset = 100;
                    var targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>