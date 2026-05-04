<!--
    Author: Chong Ray Han
    Date: 2026-01-30
    Description: Global footer component for GoGreen@APU
-->

<link rel="stylesheet" href="/GoGreen-APU/assets/css/global/footer.css">

<footer class="site-footer">
    <div class="footer-container">
        <!-- Footer Top Section -->
        <div class="footer-top">
            <!-- Brand Section -->
            <div class="footer-brand">
                <img src="/GoGreen-APU/assets/images/logo/GoGreen@APU logo.svg" alt="GoGreen@APU" class="footer-logo">
                <p class="footer-tagline">Making sustainability a campus lifestyle. Join us in creating a greener future for APU.</p>

                <!-- Social Media Links -->
                <div class="footer-social">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Facebook">
                        <img src="/GoGreen-APU/assets/icons/social/facebook-svgrepo-com.svg" alt="Facebook">
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Instagram">
                        <img src="/GoGreen-APU/assets/icons/social/instagram-167-svgrepo-com.svg" alt="Instagram">
                    </a>
                    <a href="https://discord.com" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Discord">
                        <img src="/GoGreen-APU/assets/icons/social/discord-svgrepo-com.svg" alt="Discord">
                    </a>
                    <a href="https://wa.me/60123456789" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="WhatsApp">
                        <img src="/GoGreen-APU/assets/icons/social/whatsapp-svgrepo-com.svg" alt="WhatsApp">
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-links-section">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="/GoGreen-APU/frontend/guest/explore/index.php">Explore Events</a></li>
                    <li><a href="/GoGreen-APU/frontend/guest/about_us/index.php">About Us</a></li>
                    <li><a href="/GoGreen-APU/frontend/guest/faq/index.php">FAQ</a></li>
                    <li><a href="/GoGreen-APU/auth/login.php">Login</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div class="footer-links-section">
                <h4 class="footer-heading">Resources</h4>
                <ul class="footer-links">
                    <li><a href="/GoGreen-APU/frontend/guest/privacy_policy/index.php">Privacy Policy</a></li>
                    <li><a href="/GoGreen-APU/frontend/guest/contact_us/index.php">Contact Us</a></li>
                    <li><a href="https://www.apu.edu.my" target="_blank" rel="noopener noreferrer">APU Website</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-links-section footer-contact">
                <h4 class="footer-heading">Contact Us</h4>
                <div class="contact-info">
                    <div class="contact-item">
                        <img src="/GoGreen-APU/assets/icons/mappin.and.ellipse.svg" alt="Location" class="contact-icon">
                        <span>Technology Park Malaysia,<br>Bukit Jalil, 57000 KL</span>
                    </div>
                    <div class="contact-item">
                        <img src="/GoGreen-APU/assets/icons/envelope.svg" alt="Email" class="contact-icon">
                        <a href="mailto:gogreen@apu.edu.my">gogreen@apu.edu.my</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="footer-divider"></div>

        <!-- Footer Bottom -->  
        <div class="footer-bottom">
            <p class="footer-copyright">© <?php echo date('Y'); ?> GoGreen@APU. All rights reserved.</p>
        </div>
    </div>
</footer>