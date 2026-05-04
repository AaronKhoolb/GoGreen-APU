<!-- 
Author: Chong Ray Han
Date: 2025-12-29
Description: Contact Us guest page.
  -->

<?php include  $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/nav.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/guest/contact_us.css">
</head>

<body class="contact-page">
    <?php
    $page_name = 'contact';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/guest/nav.php');
    ?>

    <div class="main-content">
        <!-- Hero Section -->
        <section class="contact-hero">
            <h1>Get in <span>Touch</span></h1>
            <p>Have questions or suggestions? We'd love to hear from you. Reach out to the GoGreen@APU team.</p>
        </section>

        <!-- Main Content -->
        <div class="contact-content">
            <!-- Contact Info -->
            <div class="contact-info-section">
                <div class="contact-card">
                    <h2>Contact Info</h2>
                    <ul class="info-list">
                        <li class="info-item">
                            <img class="icon" src="/GoGreen-APU/assets/icons/mappin.and.ellipse.svg" alt="">
                            <span>Asia Pacific University (APU),<br>Technology Park Malaysia,<br>Bukit Jalil, 57000
                                Kuala Lumpur</span>
                        </li>
                        <li class="info-item">
                            <img class="icon" src="/GoGreen-APU/assets/icons/envelope.svg" alt="">
                            <a href="mailto:gogreen@apu.edu.my">gogreen@apu.edu.my</a>
                        </li>
                        <li class="info-item">
                            <img class="icon" src="/GoGreen-APU/assets/icons/social/phone.svg" alt="">
                            <a href="tel:+60389961000">+603 8996 1000</a>
                        </li>
                    </ul>

                </div>

                
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.146607567793!2d101.70016431475704!3d3.055405697775086!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc35c9ba3b8a63%3A0x6b30171321727768!2sAsia%20Pacific%20University%20of%20Technology%20%26%20Innovation%20(APU)!5e0!3m2!1sen!2smy!4v1645000000000!5m2!1sen!2smy"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>
</body>

</html>