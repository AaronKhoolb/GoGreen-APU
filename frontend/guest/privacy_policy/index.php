<!-- 
Author: Chong Ray Han
Date: 2025-01-28
Description: Privacy Policy page. 
  -->

<?php include  $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/nav.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/guest/privacy_policy.css">
</head>

<body class="privacy-page">
    <?php
    $page_name = 'privacy';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/guest/nav.php');
    ?>

    <div class="main-content">
        <!-- Hero Section -->
        <section class="privacy-hero">
            <h1>Privacy <span>Policy</span></h1>
            <p>We value your trust and are committed to protecting your personal information. Learn how we handle your
                data at GoGreen@APU.</p>
        </section>

        <!-- Main Content -->
        <div class="privacy-content">
            <!-- Sidebar Navigation -->
            <aside class="privacy-sidebar">
                <div class="sidebar-card">
                    <p class="sidebar-header">Table of Contents</p>
                    <ul class="toc-list">
                        <li>
                            <a href="#introduction" class="toc-item active" data-section="introduction">
                                <img class="icon" src="/GoGreen-APU/assets/icons/info.circle.svg" alt="">
                                <span>Introduction</span>
                            </a>
                        </li>
                        <li>
                            <a href="#collection" class="toc-item" data-section="collection">
                                <img class="icon" src="/GoGreen-APU/assets/icons/person.3.svg" alt="">
                                <span>Data Collection</span>
                            </a>
                        </li>
                        <li>
                            <a href="#usage" class="toc-item" data-section="usage">
                                <img class="icon" src="/GoGreen-APU/assets/icons/leaf.svg" alt="">
                                <span>Data Usage</span>
                            </a>
                        </li>
                        <li>
                            <a href="#contact" class="toc-item" data-section="contact">
                                <img class="icon" src="/GoGreen-APU/assets/icons/text.bubble.svg" alt="">
                                <span>Contact Us</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Card -->
                <div class="contact-card" style="margin-top: 20px;">
                    <div class="icon-wrapper">
                        <img class="icon" src="/GoGreen-APU/assets/icons/text.bubble.svg" alt="">
                    </div>
                    <h3>Have Questions?</h3>
                    <p>If you have any concerns about our privacy practices, please reach out to us.</p>
                    <a href="mailto:privacy@apu.edu.my" class="contact-btn">
                        <span>Contact Privacy Team</span>
                    </a>
                </div>
            </aside>

            <!-- Privacy Sections -->
            <main class="privacy-main">
                <!-- Introduction Section -->
                <section id="introduction" class="privacy-section">
                    <div class="section-header">
                        <h2 class="section-title">Introduction</h2>
                        <div class="section-line"></div>
                    </div>
                    <div class="privacy-card">
                        <h3>Welcome to GoGreen@APU</h3>
                        <div class="privacy-text">
                            <p>At GoGreen@APU, we respect your privacy and are committed to protecting your personal
                                data. This Privacy Policy outlines how we collect, use, disclose, and safeguard your
                                information when you visit our website and use our services.</p>
                            <p>We process your personal data in accordance with the Personal Data Protection Act 2010
                                (PDPA) of Malaysia and other applicable data protection laws. By using our platform, you
                                consent to the data practices described in this policy.</p>
                        </div>
                    </div>
                </section>

                <!-- Data Collection Section -->
                <section id="collection" class="privacy-section">
                    <div class="section-header">
                        <h2 class="section-title">Information We Collect</h2>
                        <div class="section-line"></div>
                    </div>
                    <div class="privacy-card">
                        <h3>Personal Identification Information</h3>
                        <div class="privacy-text">
                            <p>We may collect personal identification information from Users in a variety of ways,
                                including, but not limited to, when Users visit our site, register on the site,
                                subscribe to the newsletter, and in connection with other activities, services,
                                features, or resources we make available on our Site. Users may be asked for, as
                                appropriate:</p>
                            <ul>
                                <li><strong>Identity Data:</strong> Name, Student ID (TP Number), and profile
                                    photograph.</li>
                                <li><strong>Contact Data:</strong> Email address and phone number.</li>
                                <li><strong>Academic Data:</strong> Course information and intake codes.</li>
                                <li><strong>Usage Data:</strong> Information about how you use our website, events
                                    attended, and rewards redeemed.</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Data Usage Section -->
                <section id="usage" class="privacy-section">
                    <div class="section-header">
                        <h2 class="section-title">How We Use Your Information</h2>
                        <div class="section-line"></div>
                    </div>
                    <div class="privacy-card">
                        <h3>Purpose of Processing</h3>
                        <div class="privacy-text">
                            <p>GoGreen@APU collects and uses Users personal information for the following purposes:</p>
                            <ul>
                                <li><strong>To personalize user experience:</strong> We may use information in the
                                    aggregate to understand how our Users as a group use the services and resources
                                    provided on our Site.</li>
                                <li><strong>To improve our Site:</strong> We continually strive to improve our website
                                    offerings based on the information and feedback we receive from you.</li>
                                <li><strong>To administer events and rewards:</strong> To manage your registration for
                                    events, track your AP Coins, and facilitate reward redemptions.</li>
                                <li><strong>To send periodic emails:</strong> The email address Users provide for order
                                    processing, will only be used to send them information and updates pertaining to
                                    their order. It may also be used to respond to their inquiries, and/or other
                                    requests or questions.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="privacy-card" style="margin-top: 12px;">
                        <h3>Data Security</h3>
                        <div class="privacy-text">
                            <p>We adopt appropriate data collection, storage, and processing practices and security
                                measures to protect against unauthorized access, alteration, disclosure, or destruction
                                of your personal information, username, password, transaction information, and data
                                stored on our Site.</p>
                        </div>
                    </div>
                </section>

                <!-- Contact Section -->
                <section id="contact" class="privacy-section">
                    <div class="section-header">
                        <h2 class="section-title">Contact Us</h2>
                        <div class="section-line"></div>
                    </div>
                    <div class="privacy-card">
                        <h3>Get in Touch</h3>
                        <div class="privacy-text">
                            <p>If you have any questions about this Privacy Policy, the practices of this site, or your
                                dealings with this site, please contact us at:</p>
                            <p>
                                <strong>GoGreen@APU Team</strong><br>
                                Asia Pacific University of Technology & Innovation (APU)<br>
                                Technology Park Malaysia<br>
                                Bukit Jalil, Kuala Lumpur 57000<br>
                                Malaysia
                            </p>
                            <p>Email: <a href="mailto:privacy@apu.edu.my"
                                    style="color: var(--green-primary); text-decoration: none;">privacy@apu.edu.my</a>
                            </p>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>

    <script>
        // TOC Navigation Active State
        document.querySelectorAll('.toc-item').forEach(function(item) {
            item.addEventListener('click', function(e) {
                // Remove active class from all items
                document.querySelectorAll('.toc-item').forEach(function(i) {
                    i.classList.remove('active');
                });
                // Add active to clicked item
                this.classList.add('active');
            });
        });

        // Smooth scroll offset for fixed header
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

        // Form active state on scroll (Intersection Observer)
        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -60% 0px', // Activate when section is near top
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    document.querySelectorAll('.toc-item').forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === '#' + id) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        }, observerOptions);

        document.querySelectorAll('section[id]').forEach((section) => {
            observer.observe(section);
        });
    </script>
</body>

</html>