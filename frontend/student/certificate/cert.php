<!-- 
    Author: Khoo Lay Bin
    Date: 2025-11-5
    Description: certificate layout use for student certificate page
-->

<div class="certificate-inner">
    <header class="cert-header">
        <div class="logo-gogreen">
            <img src="<?php echo $logo_path; ?>" alt="GoGreen APU">
        </div>

        <div class="club-identity">
            <div class="club-logo">
                <img src="<?php echo $club_logo_path; ?>" alt="<?php echo htmlspecialchars($club_name); ?>">
            </div>
            <div class="club-name-text">
                <?php echo htmlspecialchars($club_name); ?>
            </div>
        </div>
    </header>

    
    <div class="cert-body">
        <h1 class="cert-title">CERTIFICATE</h1>

        <p class="cert-presentation">This certificate is proudly presented to</p>

        <div class="recipient-name">
            <span class="name-text"><?php echo htmlspecialchars($cert_recipient_name); ?></span>
            <div class="name-underline"></div>
        </div>

        <p class="cert-reason">For successfully participating in</p>

        <h2 class="event-title"><?php echo htmlspecialchars($cert_event_title); ?></h2>

        <p class="cert-date"><?php echo htmlspecialchars($cert_date); ?></p>
    </div>

    
    <footer class="cert-footer">
        <div class="cert-id-container">
            <span class="cert-id-value"><?php echo htmlspecialchars($cert_id); ?></span>
        </div>

        <div class="signature-container">
            <div class="signature-image">
                <img src="<?php echo $signature_path; ?>" alt="Signature" onerror="this.style.display='none'">
            </div>
            <div class="signature-line"></div>
            <p class="signature-label">Signature</p>
        </div>
    </footer>

    
    <div class="cert-border"></div>
</div>