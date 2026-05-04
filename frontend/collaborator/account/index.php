<!--
    Author: Damian Loh Yi Feng
    Date: 2025-12-28
    Description: Admin Account Management Page
-->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/GoGreen-APU/includes/head.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='/GoGreen-APU/auth/login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$page_name = "user"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone_no   = mysqli_real_escape_string($conn, $_POST['phone_no']);
    
    $sq1 = mysqli_real_escape_string($conn, $_POST['security_quest1']);
    $sa1 = mysqli_real_escape_string($conn, $_POST['security_ans1']);
    $sq2 = mysqli_real_escape_string($conn, $_POST['security_quest2']);
    $sa2 = mysqli_real_escape_string($conn, $_POST['security_ans2']);
    $sq3 = mysqli_real_escape_string($conn, $_POST['security_quest3']);
    $sa3 = mysqli_real_escape_string($conn, $_POST['security_ans3']);

    $password_sql = "";
    if (!empty($_POST['password'])) {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_sql = ", password = '$password_hash'";
    }

    $sql_update = "UPDATE users SET 
                   first_name = '$first_name', 
                   last_name = '$last_name', 
                   phone_no = '$phone_no', 
                   security_quest1 = '$sq1', security_ans1 = '$sa1', 
                   security_quest2 = '$sq2', security_ans2 = '$sa2', 
                   security_quest3 = '$sq3', security_ans3 = '$sa3' 
                   $password_sql 
                   WHERE id = $user_id";

    $user_updated = mysqli_query($conn, $sql_update);

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/profile/';
        $file_ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array(strtolower($file_ext), $allowed)) {
            $new_name = $user_id . '_' . time() . '.' . $file_ext;
            
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_dir . $new_name)) {
                $sql_pic = "UPDATE users SET avatar_path = '$new_name' WHERE id = $user_id";
                mysqli_query($conn, $sql_pic);
                $_SESSION['avatar_path'] = $new_name;
            }
        }
    }

    if ($user_updated) {
        echo "<script>alert('Admin profile updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Update failed. Please try again.');</script>";
    }
}

$sql_fetch = "SELECT * FROM users WHERE id = $user_id";
$res_fetch = mysqli_query($conn, $sql_fetch);
$data = mysqli_fetch_assoc($res_fetch);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>GoGreen@APU - Edit Admin Profile</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
    <style>
        main { display: flex; flex-direction: column; align-items: center; padding: 20px 20px 60px 20px; min-height: 100vh; box-sizing: border-box; }
        .page-content { width: 100%; max-width: 900px; }
        .required-star { color: #f44336; margin-left: 3px; }
        .readonly-box { background: rgba(255, 255, 255, 0.05) !important; color: #888 !important; cursor: not-allowed; }
        input:-webkit-autofill { -webkit-box-shadow: 0 0 0 30px #1a1a1a inset !important; -webkit-text-fill-color: white !important; }
    </style>
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php'); ?>

    <main>
        <section class="page-content">
            <form action="" method="post" enctype="multipart/form-data">
                
                <div class="page-header">
                    <div class="header-title">
                        <h2>Admin Account</h2>
                        <p style="color: #888; font-size: 14px; margin-top: 5px;">Update your administrative identity and security.</p>
                    </div>
                    <div class="header-actions">
                        <button type="submit" class="btn-save">
                            <img src="/GoGreen-APU/assets/icons/plus.app.fill.svg" alt="" style="width:20px; margin-right:8px;">
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/user.svg" alt=""></span>
                        <h3>User Information</h3>
                    </div>
                    <div class="form-part-content">
                        <div style="display: flex; gap: 20px;">
                            <div class="form-field" style="flex:1;">
                                <label>APKey (Read-only)</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" class="readonly-box" value="<?php echo htmlspecialchars($data['apkey']); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-field" style="flex:1;">
                                <label>New Password</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="password" name="password" placeholder="Leave blank to keep current">
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 20px;">
                            <div class="form-field" style="flex:1;">
                                <label>First Name <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($data['first_name']); ?>" required>
                                </div>
                            </div>
                            <div class="form-field" style="flex:1;">
                                <label>Last Name <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($data['last_name']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 20px;">
                            <div class="form-field" style="flex:1;">
                                <label>Date of Birth</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" class="readonly-box" value="<?php echo htmlspecialchars($data['dob']); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-field" style="flex:1;">
                                <label>Gender</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" class="readonly-box" value="<?php echo htmlspecialchars($data['gender']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Phone Number <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="phone_no" value="<?php echo htmlspecialchars($data['phone_no']); ?>" required>
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Profile Picture</label>
                            <div style="display:flex; align-items:center; gap:15px; margin-bottom:10px;">
                                <?php $avatar = !empty($data['avatar_path']) ? $data['avatar_path'] : 'profile.jpg'; ?>
                                <img src="/GoGreen-APU/assets/images/profile/<?php echo $avatar; ?>" style="width:60px; height:60px; border-radius:50%; object-fit:cover; border:2px solid #4ade80;">
                                <span style="color:#666; font-size:12px;">Square image recommended</span>
                            </div>
                            <div class="txt-container glass-effect-border">
                                <input type="file" name="profile_picture" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/lock.fill.svg" alt=""></span>
                        <h3>Security Questions</h3>
                    </div>
                    <div class="form-part-content">
                        <?php for($i=1; $i<=3; $i++) { ?>
                        <div class="form-field">
                            <label>Security Question <?php echo $i; ?> <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <select name="security_quest<?php echo $i; ?>" required style="background:transparent; color:white; border:none; width:100%; padding:10px; outline:none;">
                                    <option value="<?php echo $data['security_quest'.$i]; ?>" style="color:black;"><?php echo $data['security_quest'.$i]; ?></option>
                                    <option value="What is your mother's maiden name?" style="color:black;">What is your mother's maiden name?</option>
                                    <option value="What is your favorite colour?" style="color:black;">What is your favorite colour?</option>
                                    <option value="What is your first pet's name?" style="color:black;">What is your first pet's name?</option>
                                    <option value="What is your Hometown's name?" style="color:black;">What is your Hometown's name?</option>
                                </select>
                            </div>
                            <div class="txt-container glass-effect-border" style="margin-top:10px;">
                                <input type="text" name="security_ans<?php echo $i; ?>" value="<?php echo $data['security_ans'.$i]; ?>" required>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>
</html>