<!--
    Author: Chong Ray Han
    Date: 2026-1-9
    Description: edit faq for admin 
-->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/auth/require_login.php';
include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php';

if (!isset($_GET['id'])) {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/index.php?error=missing_id');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM faq WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    header('Location: /GoGreen-APU/frontend/admin/system_setting/faq/index.php?error=not_found');
    exit;
}

$faq = mysqli_fetch_assoc($result);

$categories = [
    'general' => 'General Questions',
    'events' => 'Events & Registration',
    'account' => 'Account & Profile',
    'rewards' => 'Rewards & AP Coins'
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Edit FAQ</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
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
                <h1>Edit FAQ</h1>
                <p>Edit the frequently asked question.</p>
            </div>
        </div>

        <section class="page-content">
            <form action="/GoGreen-APU/actions/admin/faq/edit_faq.php" method="post" id="edit-faq-form">
                <input type="hidden" name="id" value="<?php echo $faq['id']; ?>">

                <div class="page-header">
                    <h2>FAQ Details</h2>
                    <div class="header-actions">
                        <a href="index.php" class="btn-discard">
                            <img src="/GoGreen-APU/assets/icons/x.circle.fill.svg" alt="">
                            <span>Cancel</span>
                        </a>
                        <button type="submit" class="btn-save">
                            <img src="/GoGreen-APU/assets/icons/square.and.pencil.svg" alt="">
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>

                <!-- Category Selection -->
                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/slider.horizontal.3.svg" alt=""></span>
                        <h3>Category</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-field">
                            <label for="category">Select Category</label>
                            <div class="txt-container glass-effect-border">
                                <select name="category" id="category" required>
                                    <?php foreach ($categories as $key => $label): ?>
                                        <option value="<?php echo $key; ?>" <?php echo ($faq['category'] === $key) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($label); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Question -->
                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt=""></span>
                        <h3>Question</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-field">
                            <label for="question">FAQ Question</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="question" id="question" value="<?php echo htmlspecialchars($faq['question']); ?>" placeholder="Enter the question..." required>
                                <button type="button" class="clear-btn" data-target="question">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Answer -->
                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/text.bubble.svg" alt=""></span>
                        <h3>Answer</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-field">
                            <label for="answer">FAQ Answer</label>
                            <div class="txt-container glass-effect-border">
                                <textarea name="answer" id="answer" rows="6" placeholder="Enter the answer..." required><?php echo htmlspecialchars($faq['answer']); ?></textarea>
                                <button type="button" class="clear-btn" data-target="answer">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <script>
        document.querySelectorAll('.clear-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const target = document.getElementById(targetId);
                if (target) {
                    target.value = '';
                    target.focus();
                }
            });
        });
    </script>
</body>

</html>