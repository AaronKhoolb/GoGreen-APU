<!-- 
    Author: Khoo Lay Bin
    Date: 2025-11-5
    Description: certificate layout use for guest preview and student preview
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
            <span class="name-text">
                <?php echo htmlspecialchars($cert_recipient_name); ?>
            </span>
            
            <div class="name-underline"></div>
        </div>

        <p class="cert-reason">For successfully participating in</p>

        <h2 class="event-title">
            <?php echo htmlspecialchars($cert_event_title); ?>
        </h2>

        <p class="cert-date">
            <?php echo htmlspecialchars($cert_date); ?>
        </p>
    <div class="cert-border"></div>
</div>