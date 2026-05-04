<!-- 
Author: Chong Ray Han
Date: 2025-12-29
Description: Login Page, backend: login_process.php
  -->
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/auth/auth.css">
</head>

<body>
    <form action="/GoGreen-APU/actions/login_process.php" method="POST">
        <div class="middle">
            <div class="title">
                <h2>GoGreen @ APU</h2>
            </div>

            <div class="main_card">
                <h1>Welcome Back!</h1>
                <p>Enter your credentials to access your account.</p>

                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>

                <div class="input-group">
                    <label>APKey</label>
                    <input class="input-box" type="text" name="apkey" required placeholder="Enter APKey">
                </div>

                <div class="input-group">
                    <div class="password-group">
                        <label>Password</label>
                        <a href="reset-pass.php">Forgot password?</a>
                    </div>
                    <input class="input-box" type="password" name="password" required placeholder="Enter Password">
                </div>

                <button type="submit" name="login_btn" class="btn-submit">Login</button>
                <p>
                    Don't have an account? <a href="register.php">Sign up for free</a>
                </p>
            </div>
        </div>
    </form>

</body>

</html>