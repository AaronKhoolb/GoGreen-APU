<?php
/**
 * Author: Damian Loh Yi Feng
 * Date: 2026-01-30
 * Description: Student attendance check-in page 
 */
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /GoGreen-APU/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = mysqli_real_escape_string($conn, $_POST['code']);

    if(!empty($code)) {
        $event_sql = "SELECT id, title, coins_earned FROM events WHERE attendance_code = '$code' LIMIT 1";
        $event_result = mysqli_query($conn, $event_sql);

        if (mysqli_num_rows($event_result) > 0) {
            $event_data = mysqli_fetch_assoc($event_result);
            $event_id = $event_data['id'];
            $event_title = $event_data['title'];
            $coins = $event_data['coins_earned'];

            $participant_sql = "SELECT id, status FROM event_participants 
                                WHERE event_id = '$event_id' 
                                AND user_id = '$user_id' 
                                LIMIT 1";
            $participant_result = mysqli_query($conn, $participant_sql);

            if (mysqli_num_rows($participant_result) > 0) {
                $p_data = mysqli_fetch_assoc($participant_result);

                if ($p_data['status'] != 'attended') {
                    $row_id = $p_data['id'];
                    $update_status = "UPDATE event_participants 
                                      SET status = 'attended', 
                                          check_in_time = NOW(), 
                                          coins_earned = '$coins', 
                                          marked_by = '$user_id' 
                                      WHERE id = '$row_id'";
                    mysqli_query($conn, $update_status);

                    $update_coins = "UPDATE students 
                                     SET ap_coins = ap_coins + '$coins' 
                                     WHERE user_id = '$user_id'";
                    mysqli_query($conn, $update_coins);

                    $success = "Verified! You checked in for '$event_title' and got $coins AP!";
                } else {
                    $error = "You have already used this code!";
                }
            } else {
                $error = "You are not registered for this event.";
            }
        } else {
            $error = "Invalid 3-digit code. Please check again.";
        }
    } else {
        $error = "Please enter the code.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mark Attendance | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/nav.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/frosted_glass.css">
    <style>
        body {
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            font-family: sans-serif;
        }
        main {
            width: 100%;
            padding: 20px;
            margin-top: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .attendance-card {
            width: 100%;
            max-width: 420px;
            padding: 50px 30px;
            border-radius: 28px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 25px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .code-input {
            width: 100%;
            max-width: 250px; 
            background: rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 15px;
            font-size: 3rem;
            color: #4ade80;
            text-align: center;
            letter-spacing: 25px;
            transition: all 0.3s ease;
            outline: none;
        }
        .code-input:focus {
            border-color: #4ade80;
            background: rgba(0, 0, 0, 0.5);
        }
        .submit-btn {
            margin-top: 30px;
            width: 100%;
            max-width: 250px;
            padding: 15px; 
            border-radius: 15px; 
            border: none; 
            background: #4ade80; 
            color: #000; 
            font-weight: 800; 
            font-size: 1rem; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .submit-btn:hover { 
            background-color: #fff; 
        }
        .msg { 
            padding: 12px; 
            width: 100%; 
            border-radius: 8px; 
            font-size: 0.9rem; 
        }
        .err { 
            background: rgba(255, 50, 50, 0.2); 
            color: #ff9999; 
            border: 1px solid rgba(255, 50, 50, 0.3);
        }
        .ok { 
            background: rgba(50, 255, 50, 0.2); 
            color: #99ff99; 
            border: 1px solid rgba(50, 255, 50, 0.3);
        }

        @media (max-width: 768px) { 
            main { margin-top: 60px; padding: 20px; } 
            .attendance-card { padding: 40px 20px; }
            h1 { font-size: 1.6rem; }
            .code-input { font-size: 2.5rem; letter-spacing: 15px; }
        }
    </style>
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/nav.php'); ?>
    
    <main>
        <div class="attendance-card">
            <h1 style="color: white; margin: 10px 0 0 0;">Attendance Check-In</h1>
            <p style="color: #ccc; font-size: 0.9rem; margin-top: 0;">Enter the 3-digit event code</p>
            
            <?php if($error): ?>
                <div class="msg err"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="msg ok"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="text" name="code" class="code-input" placeholder="000" maxlength="3" required autocomplete="off">
                <button type="submit" class="submit-btn">Verify Code</button>
            </form>

            <a href="/GoGreen-APU/frontend/student/index.php" style="margin-top: 25px; color: #888; text-decoration: none; font-size: 0.85rem; transition: color 0.3s;">
                Cancel & Go Back
            </a>
        </div>
    </main>
</body>
</html>