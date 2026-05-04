 <!--
    Author: Chong Jun Yoong
    Date: 2026-1-8
    Description: Admin interface for managing event certificate settings.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Certificate - My Events | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/certificate.css">
</head>

<body>
    <?php
    $page_name = 'event_certificate';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');

    $event_id = intval($_GET['id']);

    $cert_sql = "SELECT * FROM certificate WHERE event_id = $event_id";
    $cert_result = mysqli_query($conn, $cert_sql);
    $certificate = mysqli_fetch_assoc($cert_result);

    $signature_path = '/GoGreen-APU/uploads/cert_seals/' . $certificate['signature_path'];
    ?>

    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/event/hero.php'); ?>

        <section class="page-content">

            <form action="/GoGreen-APU/actions/organizer/my_events/certificate.php" method="post"
                enctype="multipart/form-data">
                <div class="page-header">
                    <h2>Certificate Settings</h2>
                    <div class="header-actions">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                        <a href="/GoGreen-APU/frontend/admin/event/certificate/preview.php?id=<?php echo $event_id; ?>"
                            class="btn-preview glass-effect-border">
                            <img src="/GoGreen-APU/assets/icons/eye.svg" alt="">
                            <span>Preview Certificate</span>
                        </a>
                        <button type="submit" class="btn-save" value="Save">
                            <img src="/GoGreen-APU/assets/icons/text.document.svg" alt="">
                            <span>Save</span>
                        </button>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/certificate.svg" alt=""></span>
                        <h3>Signature</h3>
                    </div>

                    <div class="form-part-content">
                        <?php if ($certificate): ?>
                            <div class="form-field">
                                <label>Current Signature</label>
                                <div class="signature-preview-box">
                                    <img src="<?php echo $signature_path; ?>" alt="Current Signature">
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="form-field">
                                <label>Current Signature</label>
                                <p class="no-signature-text">No signature uploaded yet.</p>
                            </div>
                        <?php endif; ?>

                        <div class="form-field">
                            <label for="signature">Upload Signature</label>
                            <div class="txt-container glass-effect-border">
                                <input type="file" name="signature" id="signature" accept="image/*">
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </section>
    </main>
</body>

</html>