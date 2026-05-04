 <!--
    Author: Chong Jun Yoong
    Date: 2026-1-8
    Description: Admin interface for editing created event collaborators.
-->
<?php
$root_path = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/';
include_once($root_path . '/includes/db_conn.php');


$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($event_id === 0 || $user_id === 0) {
    echo "<script>alert('Invalid ID'); window.location.href='index.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apkey = trim($_POST['apkey']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone_no = trim($_POST['phone_no']);

    $security_quest1 = $_POST['security_quest1'];
    $security_ans1 = $_POST['security_ans1'];
    $security_quest2 = $_POST['security_quest2'];
    $security_ans2 = $_POST['security_ans2'];
    $security_quest3 = $_POST['security_quest3'];
    $security_ans3 = $_POST['security_ans3'];

    $collab_type = $_POST['type'];
    $positions = trim($_POST['positions']) ?: null;
    $ngo_name = trim($_POST['ngo_name']) ?: null;

    $check_sql = "SELECT id FROM users WHERE apkey = ? AND id != ?";
    $stmt_check = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt_check, "si", $apkey, $user_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "<script>alert('APKey already exists for another user.'); window.history.back();</script>";
        exit;
    }

    $conn->begin_transaction();
    try {
        $password_sql = "";
        if (!empty($_POST['password'])) {
            $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $password_sql = ", password = '$password_hash'";
        }

        $sql_user = "UPDATE users SET 
            apkey = ?, 
            role = ?, 
            first_name = ?, 
            last_name = ?, 
            dob = ?, 
            gender = ?, 
            phone_no = ?, 
            security_quest1 = ?, security_ans1 = ?, 
            security_quest2 = ?, security_ans2 = ?, 
            security_quest3 = ?, security_ans3 = ?
            $password_sql
            WHERE id = ?";

        $stmt_user = mysqli_prepare($conn, $sql_user);
        mysqli_stmt_bind_param(
            $stmt_user,
            "sssssssssssssi",
            $apkey,
            $collab_type,
            $first_name,
            $last_name,
            $dob,
            $gender,
            $phone_no,
            $security_quest1,
            $security_ans1,
            $security_quest2,
            $security_ans2,
            $security_quest3,
            $security_ans3,
            $user_id
        );
        mysqli_stmt_execute($stmt_user);
        mysqli_stmt_close($stmt_user);


        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = $root_path . '/assets/images/profile/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
                chmod($upload_dir, 0777);
            }

            $file_tmp = $_FILES['profile_picture']['tmp_name'];
            $file_ext = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

            if (in_array($file_ext, $allowed_ext)) {
                $new_file_name = $user_id . '.' . $file_ext;
                $target_path = $upload_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $target_path)) {
                    $sql_avatar = "UPDATE users SET avatar_path = ? WHERE id = ?";
                    $stmt_avatar = mysqli_prepare($conn, $sql_avatar);
                    mysqli_stmt_bind_param($stmt_avatar, "si", $new_file_name, $user_id);
                    mysqli_stmt_execute($stmt_avatar);
                    mysqli_stmt_close($stmt_avatar);
                }
            }
        }

        $sql_collab = "UPDATE collaborators SET type = ?, positions = ?, ngo_name = ? WHERE user_id = ? AND event_id = ?";
        $stmt_collab = mysqli_prepare($conn, $sql_collab);
        mysqli_stmt_bind_param($stmt_collab, "sssii", $collab_type, $positions, $ngo_name, $user_id, $event_id);
        mysqli_stmt_execute($stmt_collab);
        mysqli_stmt_close($stmt_collab);

        $conn->commit();
        echo "<script>alert('User updated successfully!'); window.location.href='index.php?id=$event_id';</script>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
}

$fetch_sql = "SELECT u.*, c.type, c.positions, c.ngo_name 
              FROM users u 
              JOIN collaborators c ON u.id = c.user_id 
              WHERE u.id = ? AND c.event_id = ?";
$stmt_fetch = mysqli_prepare($conn, $fetch_sql);
mysqli_stmt_bind_param($stmt_fetch, "ii", $user_id, $event_id);
mysqli_stmt_execute($stmt_fetch);
$result_fetch = mysqli_stmt_get_result($stmt_fetch);
$data = mysqli_fetch_assoc($result_fetch);

if (!$data) {
    echo "<script>alert('User not found.'); window.location.href='index.php?id=$event_id';</script>";
    exit;
}

$sql = "SELECT * FROM events WHERE id = $event_id";
$result = mysqli_query($conn, $sql);
$event = $result ? mysqli_fetch_assoc($result) : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($root_path . '/includes/head.php'); ?>
    <title>Edit Collaborator | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
    <style>
        .form-hint {
            font-size: 13px;
            color: #aaa;
            margin: -10px 0 15px 0;
            padding-left: 5px;
        }

        .required-star {
            color: #f44336;
            margin-left: 3px;
        }
    </style>
</head>

<body>
    <?php
    $page_name = 'event_collaborators';
    include($root_path . '/frontend/admin/sidebar.php');
    ?>

    <main>
        <?php include($root_path . '/frontend/admin/event/hero.php'); ?>
        <section class="page-content">
            <form action="" method="post" id="event-info-form" enctype="multipart/form-data">

                <div class="page-header">
                    <div class="header-title">
                        <h2>Edit Collaborator</h2>
                        <p style="color: #888; font-size: 14px; margin-top: 5px;">Event:
                            <strong><?php echo htmlspecialchars($event['title']); ?></strong>
                        </p>
                    </div>
                    <div class="header-actions">
                        <button type="button" class="btn-discard"
                            onclick="window.location.href='index.php?id=<?php echo $event_id; ?>'">
                            <span>Discard</span>
                        </button>
                        <button type="submit" class="btn-save">
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/person.svg" alt=""></span>
                        <h3>User Information</h3>
                    </div>
                    <div class="form-part-content">
                        <p class="form-hint">Editing user account details.</p>
                        <div style="display: flex; gap: 20px;">
                            <div class="form-field" style="flex:1;">
                                <label>APKey <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="apkey"
                                        value="<?php echo htmlspecialchars($data['apkey']); ?>" required>
                                </div>
                            </div>
                            <div class="form-field" style="flex:1;">
                                <label>Password (Leave blank to keep current)</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="password" name="password" placeholder="********">
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 20px;">
                            <div class="form-field" style="flex:1;">
                                <label>First Name <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="first_name"
                                        value="<?php echo htmlspecialchars($data['first_name']); ?>" required>
                                </div>
                            </div>
                            <div class="form-field" style="flex:1;">
                                <label>Last Name <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="last_name"
                                        value="<?php echo htmlspecialchars($data['last_name']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 20px;">
                            <div class="form-field" style="flex:1;">
                                <label>Date of Birth <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="date" name="dob" value="<?php echo htmlspecialchars($data['dob']); ?>"
                                        required>
                                </div>
                            </div>
                            <div class="form-field" style="flex:1;">
                                <label>Gender <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <select name="gender" required
                                        style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                        <option value="Male" style="color:black;" <?php if ($data['gender'] == 'Male')
                                            echo 'selected'; ?>>Male</option>
                                        <option value="Female" style="color:black;" <?php if ($data['gender'] == 'Female')
                                            echo 'selected'; ?>>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Phone Number <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="phone_no"
                                    value="<?php echo htmlspecialchars($data['phone_no']); ?>" required>
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Profile Picture</label>
                            <?php if (!empty($data['avatar_path'])): ?>
                                <div style="margin-bottom:10px;">
                                    <img src="<?php echo '/GoGreen-APU/assets/images/profile/' . $data['avatar_path']; ?>"
                                        style="width:50px; height:50px; border-radius:50%; object-fit:cover;">
                                    <span style="color:#888; font-size:12px; margin-left:10px;">Current Avatar</span>
                                </div>
                            <?php endif; ?>
                            <div class="txt-container glass-effect-border">
                                <input type="file" name="profile_picture" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $questions = [
                    "What is your mother's maiden name?",
                    "What is your favorite colour?",
                    "What is your first pet's name?",
                    "What is your Hometown's name?",
                    "What was the name of your best friend in elementary school?",
                    "Who was your childhood hero?",
                    "What was the model of your first car?",
                    "Where did you fly for your first airplane trip?"
                ];
                ?>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/lock.svg" alt=""></span>
                        <h3>Security Questions</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-field">
                            <label>Security Question 1 <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <select name="security_quest1" required
                                    style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                    <?php foreach ($questions as $q): ?>
                                        <option value="<?php echo $q; ?>" style="color:black;" <?php if ($data['security_quest1'] == $q)
                                               echo 'selected'; ?>>
                                            <?php echo $q; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="security_ans1"
                                    value="<?php echo htmlspecialchars($data['security_ans1']); ?>" required>
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Security Question 2 <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <select name="security_quest2" required
                                    style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                    <?php foreach ($questions as $q): ?>
                                        <option value="<?php echo $q; ?>" style="color:black;" <?php if ($data['security_quest2'] == $q)
                                               echo 'selected'; ?>>
                                            <?php echo $q; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="security_ans2"
                                    value="<?php echo htmlspecialchars($data['security_ans2']); ?>" required>
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Security Question 3 <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <select name="security_quest3" required
                                    style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                    <?php foreach ($questions as $q): ?>
                                        <option value="<?php echo $q; ?>" style="color:black;" <?php if ($data['security_quest3'] == $q)
                                               echo 'selected'; ?>>
                                            <?php echo $q; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="security_ans3"
                                    value="<?php echo htmlspecialchars($data['security_ans3']); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/person.3.svg" alt=""></span>
                        <h3>Collaborator Details</h3>
                    </div>
                    <div class="form-part-content">
                        <div class="form-field">
                            <label>Collaborator Type <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <select name="type" id="type" required onchange="toggleNGOField()"
                                    style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                    <option value="internal" style="color:black;" <?php if ($data['type'] == 'internal')
                                        echo 'selected'; ?>>Internal (APU Staff/Student)</option>
                                    <option value="external" style="color:black;" <?php if ($data['type'] == 'external')
                                        echo 'selected'; ?>>External (NGO/Organization)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-field">
                            <label>Position</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="positions"
                                    value="<?php echo htmlspecialchars($data['positions'] ?? ''); ?>"
                                    placeholder="e.g., Coordinator">
                            </div>
                        </div>
                        <div class="form-field" id="ngo-field-wrapper"
                            style="<?php echo ($data['type'] == 'external') ? 'display:block;' : 'display:none;'; ?>">
                            <label>NGO/Organization Name</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="ngo_name"
                                    value="<?php echo htmlspecialchars($data['ngo_name'] ?? ''); ?>"
                                    placeholder="e.g., WWF Malaysia">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <script>
        function toggleNGOField() {
            const type = document.getElementById('type').value;
            const ngoField = document.getElementById('ngo-field-wrapper');
            ngoField.style.display = (type === 'external') ? 'block' : 'none';
        }

        toggleNGOField();
    </script>
    <script src="/GoGreen-APU/assets/js/organizer/information.js"></script>
</body>

</html>