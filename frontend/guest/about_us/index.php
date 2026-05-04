<!-- 
Author: Chong Ray Han
Date: 2025-12-29
Description: about us Page
  -->
<?php include  $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/nav.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/guest/about_us.css">
</head>

<body class="about-page">
    <?php
    $page_name = 'about';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/guest/nav.php');
    ?>

    <div class="main-content">
        <!-- Hero Section -->
        <section class="about-hero">
            <h1>About <span>Us</span></h1>
            <p>Empowering the APU community to build a sustainable future through innovation, action, and education.</p>
        </section>

        <!-- Main Content -->
        <div class="about-content">
            <!-- Sidebar Navigation -->
            <aside class="about-sidebar">
                <div class="sidebar-card">
                    <p class="sidebar-header">On this page</p>
                    <ul class="nav-list">
                        <li>
                            <a href="#story" class="nav-item active">
                                <img class="icon" src="/GoGreen-APU/assets/icons/book.closed.svg" alt="">
                                <span>Our Story</span>
                            </a>
                        </li>
                        <li>
                            <a href="#mission" class="nav-item">
                                <img class="icon" src="/GoGreen-APU/assets/icons/target.svg" alt="">
                                <span>Mission & Vision</span>
                            </a>
                        </li>
                        <li>
                            <a href="#impact" class="nav-item">
                                <img class="icon" src="/GoGreen-APU/assets/icons/chart.bar.xaxis.svg" alt="">
                                <span>Our Impact</span>
                            </a>
                        </li>
                        <li>
                            <a href="#join" class="nav-item">
                                <img class="icon" src="/GoGreen-APU/assets/icons/person.badge.plus.svg"
                                    alt="">
                                <span>Join Us</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- About Sections -->
            <main class="about-main">
                <!-- Our Story -->
                <section id="story">
                    <div class="section-header">
                        <h2 class="section-title">Our Story</h2>
                        <div class="section-line"></div>
                    </div>
                    <div class="about-card">
                        <div class="about-text">
                            <p>GoGreen@APU started as a small initiative by a group of students passionate about
                                environmental sustainability. What began as a simple recycling campaign has grown into a
                                campus-wide movement connecting students, staff, and faculty.</p>
                            <p>We believe that technology and sustainability go hand in hand. By leveraging APU's
                                strength in technology, we've developed this platform to gamify green habits, making it
                                easier and more rewarding for everyone to contribute to a healthier planet.</p>
                        </div>
                    </div>
                </section>

                <!-- Mission & Vision -->
                <section id="mission">
                    <div class="section-header">
                        <h2 class="section-title">Mission & Vision</h2>
                        <div class="section-line"></div>
                    </div>
                    <div class="mv-grid">
                        <div class="mv-card">
                            <div class="mv-icon-wrapper">
                                <img class="icon" src="/GoGreen-APU/assets/icons/leaf.svg" alt="">
                            </div>
                            <h3>Our Mission</h3>
                            <p>To cultivate a culture of sustainability within the APU community by providing accessible
                                tools, education, and incentives for eco-friendly actions.
                            </p>
                        </div>
                        <div class="mv-card">
                            <div class="mv-icon-wrapper">
                                <img class="icon" src="/GoGreen-APU/assets/icons/lightbulb.svg" alt="">
                            </div>
                            <h3>Our Vision</h3>
                            <p>A zero-waste, carbon-neutral campus where every student is an active participant in
                                global environmental stewardship.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Our Impact -->
                <section id="impact">
                    <div class="section-header">
                        <h2 class="section-title">Our Impact</h2>
                        <div class="section-line"></div>
                    </div>
                    <div class="about-card">
                        <div class="about-text">
                            <p>Since our launch, the GoGreen@APU community has made significant strides in reducing our
                                footprint. Together, we've organized beach cleanups, tree planting drives, and e-waste
                                collection campaigns.
                            </p>
                        </div>
                        <div class="stats-grid">
                            <div class="stat-card">
                                <span class="stat-number">2,500+</span>
                                <span class="stat-label">Active Members</span>
                            </div>
                            <div class="stat-card">
                                <span class="stat-number">150+</span>
                                <span class="stat-label">Events Hosted</span>
                            </div>
                            <div class="stat-card">
                                <span class="stat-number">5,000kg</span>
                                <span class="stat-label">Waste Recycled</span>
                            </div>
                        </div>
                    </div>
                </section>

                
                <section id="join">
                    <div class="cta-container">
                        <h2>Ready to Make a Difference?</h2>
                        <p>Join thousands of other APU students in our mission to create a greener future. Sign up
                            today, participate in events, and earn rewards for your impact.</p>
                        <a href="/GoGreen-APU/frontend/auth/register.php" class="cta-btn">
                            <span>Join the Movement</span>
                            <img class="icon" src="/GoGreen-APU/assets/icons/arrow.right.svg" alt="">
                        </a>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>

    <script>
        
        document.querySelectorAll('.nav-item').forEach(function(item) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                var targetId = this.getAttribute('href');
                var target = document.querySelector(targetId);

                
                document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');

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

        
        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -60% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    document.querySelectorAll('.nav-item').forEach(link => {
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