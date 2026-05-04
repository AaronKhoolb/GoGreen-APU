<!--
    Author: Damian Loh Yi Feng
    Date: 2025-12-30
    Description: Student Profile Page
-->
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='/GoGreen-APU/frontend/login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone_no   = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $course     = mysqli_real_escape_string($conn, $_POST['course']);
    
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

    $sql_update_user = "UPDATE users SET 
                        first_name = '$first_name', 
                        last_name = '$last_name', 
                        phone_no = '$phone_no', 
                        security_quest1 = '$sq1', security_ans1 = '$sa1', 
                        security_quest2 = '$sq2', security_ans2 = '$sa2', 
                        security_quest3 = '$sq3', security_ans3 = '$sa3' 
                        $password_sql 
                        WHERE id = $user_id";

    $result_user = mysqli_query($conn, $sql_update_user);
    
    $sql_update_student = "UPDATE students SET course = '$course' WHERE user_id = $user_id";
    $result_student = mysqli_query($conn, $sql_update_student);

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/profile/';
        $file_ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $new_filename = $user_id . '_' . time() . '.' . $file_ext;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_dir . $new_filename)) {
            $sql_pic = "UPDATE users SET avatar_path = '$new_filename' WHERE id = $user_id";
            mysqli_query($conn, $sql_pic);
        }
    }

    if ($result_user && $result_student) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
}

$sql_user = "SELECT * FROM users WHERE id = $user_id";
$res_user = mysqli_query($conn, $sql_user);
$data = mysqli_fetch_assoc($res_user);

$sql_student = "SELECT course FROM students WHERE user_id = $user_id";
$res_student = mysqli_query($conn, $sql_student);
$student_data = mysqli_fetch_assoc($res_student);

if ($student_data) {
    $data['course'] = $student_data['course'];
} else {
    $data['course'] = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>My Profile | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
    <style>
    body {
        margin: 0;
        min-height: 100vh;
        background-color: #000; 
        font-family: 'Poppins', sans-serif;
        color: #fff;
    }
        
    main {
        width: 100%;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 100px 20px 60px 20px; 
        box-sizing: border-box;
    }

    .page-content {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .header-container {
        display: flex;
        justify-content: space-between; 
        align-items: flex-end;
        margin-bottom: 30px;
        flex-wrap: wrap; 
        gap: 20px;
    }

    .header-title h2 {
        margin: 0 0 5px 0;
        font-size: 28px;
    }
    .header-title p {
        margin: 0;
        color: #888; 
        font-size: 14px;
    }
    
    .header-actions {
        display: flex;
        gap: 15px;
    }

    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 24px;
        height: 50px; 
        min-width: 150px; 
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: 0.2s;
        box-sizing: border-box;
        font-size: 1rem;
    }
    
    .btn-action img {
        width: 20px;
        height: 20px;
        object-fit: contain;
        margin-right: 8px;
    }

    .btn-discard {
        background: rgba(244, 67, 54, 0.15);
        border-color: rgba(244, 67, 54, 0.3);
        border-radius: 25px;
        color: #ff5252;
    }
    .btn-discard:hover {
        background: rgba(244, 67, 54, 0.25);
    }

    .btn-save {
        background: rgba(74, 222, 128, 0.15);
        border-color: rgba(74, 222, 128, 0.3);
        color: #4ade80;
    }
    .btn-save:hover {
        background: rgba(74, 222, 128, 0.25);
    }

    .form-part {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .form-part-header {
        padding: 20px 25px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(0,0,0,0.2);
    }

    .form-part-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .form-part-content {
        padding: 25px;
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-field {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-field label {
        font-size: 0.9rem;
        color: #ccc;
    }

    .txt-container {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 12px 15px;
        transition: 0.3s;
    }
    
    .txt-container:focus-within {
        border-color: #4ade80;
    }

    .txt-container input, .txt-container select {
        background: transparent !important;
        color: white;
        border: none;
        outline: none;
        width: 100%;
        font-size: 1rem;
    }

    .readonly-box { 
        background: rgba(255, 255, 255, 0.05) !important; 
        color: #888 !important; 
        cursor: not-allowed; 
    }
    .required-star { 
        color: #f44336; 
        margin-left: 3px; 
    }
    
    .profile-img-preview { 
        width: 100px; 
        height: 100px; 
        border-radius: 50%; 
        object-fit: cover; 
        border: 2px solid #4ade80; 
    }
    
    .profile-section {
        display: flex; 
        align-items: center; 
        gap: 30px;
    }

    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus, 
    input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px #1a1a1a inset !important;
        -webkit-text-fill-color: white !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    @media screen and (max-width: 768px) {
        main {
            padding: 80px 15px 40px 15px; 
        }

        .header-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .header-actions {
            width: 100%;
            justify-content: space-between;
        }
        
        .btn-action {
            flex: 1; 
            min-width: 0;
            padding: 0 10px;
            font-size: 0.9rem;
        }

        .form-row {
            flex-direction: column; 
            gap: 20px;
            margin-bottom: 20px;
        }

        .profile-section {
            flex-direction: column;
            text-align: center;
        }
        .profile-img-preview {
            margin-bottom: 10px;
        }
    }
    </style>
</head>
<body>
    <?php
    $page_name = 'profile';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/student/nav.php'); 
    ?>

    <main>
        <section class="page-content">
            <form action="" method="post" enctype="multipart/form-data">
                
                <div class="header-container">
                    <div class="header-title">
                        <h2>My Profile</h2>
                        <p>Manage your personal information and account security</p>
                    </div>
                    
                    <div class="header-actions">
                        <a href="/GoGreen-APU/frontend/student/index.php" class="btn-action btn-discard">
                            <img src="/GoGreen-APU/assets/icons/x.circle.fill.svg" alt="X">
                            <span>Cancel</span>
                        </a>
                            
                        <button type="submit" class="btn-action btn-save">
                            <img src="/GoGreen-APU/assets/icons/plus.app.fill.svg" alt="Save">
                            <span>Save Profile</span>
                        </button>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/user.svg" alt=""></span>
                        <h3>Profile Picture</h3>
                    </div>
                    <div class="form-part-content profile-section">
                        <?php $avatar = !empty($data['avatar_path']) ? $data['avatar_path'] : 'default.png'; ?>
                        <img src="/GoGreen-APU/assets/images/profile/<?php echo $avatar; ?>" class="profile-img-preview">
                        <div class="form-field" style="flex:1; width:100%;">
                            <label>Upload New Picture</label>
                            <div class="txt-container glass-effect-border">
                                <input type="file" name="profile_picture" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt=""></span>
                        <h3>Basic Information</h3>
                    </div>
                    <div class="form-part-content">
                        <div class="form-row">
                            <div class="form-field">
                                <label>TP Number (Read-only)</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" class="readonly-box" value="<?php echo $data['apkey']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-field">
                                <label>New Password</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="password" name="password" placeholder="Leave blank to keep current">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <label>First Name <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="first_name" value="<?php echo $data['first_name']; ?>" required>
                                </div>
                            </div>
                            <div class="form-field">
                                <label>Last Name <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="last_name" value="<?php echo $data['last_name']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <label>Phone Number <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="phone_no" value="<?php echo $data['phone_no']; ?>" required>
                                </div>
                            </div>
                            <div class="form-field">
                                <label>Course <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="course" value="<?php echo $data['course']; ?>" required>
                                </div>
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
                        <div class="form-field" style="margin-bottom: 20px;">
                            <label>Security Question <?php echo $i; ?> <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <select name="security_quest<?php echo $i; ?>" required>
                                    <option value="<?php echo $data['security_quest'.$i]; ?>" style="color:black;"><?php echo $data['security_quest'.$i]; ?></option>
                                    <option value="What is your mother's maiden name?" style="color:black;">What is your mother's maiden name?</option>
                                    <option value="What is your favorite colour?" style="color:black;">What is your favorite colour?</option>
                                    <option value="What is your first pet's name?" style="color:black;">What is your first pet's name?</option>
                                    <option value="What is your Hometown's name?" style="color:black;">What is your Hometown's name?</option>
                                </select>
                            </div>
                            <div class="txt-container glass-effect-border" style="margin-top: 10px;">
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