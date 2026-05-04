<!-- 
Author: Chong Ray Han
Date: 2025-12-29
Description: reset-password Page
  -->

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

$step = 1;
$apkey = '';
$error = '';
$questions = [];

if (isset($_GET['error'])) {
    $error = $_GET['error'];
}

if (isset($_GET['apkey']) && !empty($_GET['apkey'])) {
    $apkey = mysqli_real_escape_string($conn, $_GET['apkey']);

    // Check if user exists and fetch questions
    $sql = "SELECT security_quest1, security_quest2, security_quest3 FROM users WHERE apkey = '$apkey'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $questions = $row;
        $step = 2;
    } else {
        $error = "User not found with APKey: " . htmlspecialchars($_GET['apkey']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/auth/auth.css">
</head>

<body>
    <div class="middle">
        <div class="title">
            <h2>GoGreen @ APU</h2>
        </div>

        <div class="main_card">
            <h1>Reset Password</h1>

            <?php if (!empty($error)) { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } ?>

            <?php if ($step == 1) { ?>
                <p>Enter your APKey to continue.</p>
                <form action="reset-pass.php" method="GET">
                    <div class="input-group">
                        <label>APKey</label>
                        <input class="input-box" type="text" name="apkey" required
                            placeholder="Enter APKey (e.g. TP012345)">
                    </div>
                    <button type="submit" class="btn-submit">Next</button>
                    <p>
                        Return to <a href="login.php">Login</a>
                    </p>
                </form>
            <?php } else { ?>
                <p>Answer the security questions to reset your password.</p>
                <form action="/GoGreen-APU/actions/reset_pass_process.php" method="POST">
                    <input type="hidden" name="apkey" value="<?php echo htmlspecialchars($apkey); ?>">

                    <div class="input-group">
                        <label><?php echo !empty($questions['security_quest1']) ? htmlspecialchars($questions['security_quest1']) : 'Security Question 1'; ?></label>
                        <input class="input-box" type="text" name="ans1" required placeholder="Your Answer">
                    </div>

                    <div class="input-group">
                        <label><?php echo !empty($questions['security_quest2']) ? htmlspecialchars($questions['security_quest2']) : 'Security Question 2'; ?></label>
                        <input class="input-box" type="text" name="ans2" required placeholder="Your Answer">
                    </div>

                    <div class="input-group">
                        <label><?php echo !empty($questions['security_quest3']) ? htmlspecialchars($questions['security_quest3']) : 'Security Question 3'; ?></label>
                        <input class="input-box" type="text" name="ans3" required placeholder="Your Answer">
                    </div>

                    <div class="input-group">
                        <label>New Password</label>
                        <input class="input-box" type="password" name="new_password" required
                            placeholder="Enter New Password">
                    </div>

                    <button type="submit" name="reset_btn" class="btn-submit">Reset Password</button>
                    <p>
                        <a href="reset-pass.php">Back</a>
                    </p>
                </form>
            <?php } ?>
        </div>
    </div>
</body>

</html>