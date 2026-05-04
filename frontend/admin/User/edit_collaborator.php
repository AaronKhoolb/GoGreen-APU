<!--
    Author: Chong Jun Yoong
    Date: 2026-01-26
    Description: Let Admin Edit Collaborator Page
-->
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_id === 0) {
    echo "<script>alert('Invalid ID'); window.location.href='index.php';</script>";
    exit;
}

$clubs = [];
$clubs_query = mysqli_query($conn, "SELECT id, name FROM clubs ORDER BY name ASC");
if ($clubs_query && mysqli_num_rows($clubs_query) > 0) {
    while ($club = mysqli_fetch_assoc($clubs_query)) {
        $clubs[] = $club;
    }
}

$events = [];
$events_query = mysqli_query($conn, "SELECT e.id, e.title, e.club_id FROM events e ORDER BY e.club_id ASC, e.title ASC");
if ($events_query && mysqli_num_rows($events_query) > 0) {
    while ($ev = mysqli_fetch_assoc($events_query)) {
        $events[] = $ev;
    }
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

    $event_id = (int)$_POST['event_id'];
    $collab_type = $_POST['type'];
    $positions = trim($_POST['positions']) ?: null;
    $ngo_name = trim($_POST['ngo_name']) ?: null;

    if ($event_id <= 0) {
        echo "<script>alert('Please select an event.'); window.history.back();</script>";
        exit;
    }

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
        $params = [];
        $types = "";
        
        if (!empty($_POST['password'])) {
            $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $password_sql = ", password = ?";
            $params[] = $password_hash;
            $types .= "s";
        }

        $sql_user = "UPDATE users SET 
            apkey = ?, 
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
        
        $bind_params = [
            $apkey,
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
            $security_ans3
        ];
        
        if (!empty($_POST['password'])) {
            $bind_params[] = $password_hash;
        }
        
        $bind_params[] = $user_id;
        
        $bind_types = "ssssssssssss" . $types . "i";
        mysqli_stmt_bind_param($stmt_user, $bind_types, ...$bind_params);
        mysqli_stmt_execute($stmt_user);
        mysqli_stmt_close($stmt_user);

        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/assets/images/profile/';
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
                    chmod($target_path, 0644);
                    $sql_avatar = "UPDATE users SET avatar_path = ? WHERE id = ?";
                    $stmt_avatar = mysqli_prepare($conn, $sql_avatar);
                    mysqli_stmt_bind_param($stmt_avatar, "si", $new_file_name, $user_id);
                    mysqli_stmt_execute($stmt_avatar);
                    mysqli_stmt_close($stmt_avatar);
                }
            }
        }

        $sql_collaborator = "UPDATE collaborators SET event_id = ?, type = ?, positions = ?, ngo_name = ? WHERE user_id = ?";
        $stmt_collaborator = mysqli_prepare($conn, $sql_collaborator);
        mysqli_stmt_bind_param($stmt_collaborator, "isssi", $event_id, $collab_type, $positions, $ngo_name, $user_id);
        mysqli_stmt_execute($stmt_collaborator);
        mysqli_stmt_close($stmt_collaborator);

        $conn->commit();
        echo "<script>alert('Collaborator updated successfully!'); window.location.href='index.php';</script>";
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
        exit;
    }
}

$fetch_sql = "SELECT u.*, c.event_id, c.type, c.positions, c.ngo_name, e.club_id 
              FROM users u 
              JOIN collaborators c ON u.id = c.user_id 
              LEFT JOIN events e ON c.event_id = e.id
              WHERE u.id = ?";
$stmt_fetch = mysqli_prepare($conn, $fetch_sql);
mysqli_stmt_bind_param($stmt_fetch, "i", $user_id);
mysqli_stmt_execute($stmt_fetch);
$result_fetch = mysqli_stmt_get_result($stmt_fetch);
$data = mysqli_fetch_assoc($result_fetch);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>GoGreen@APU - Admin - Edit Collaborator</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
    <style>
        .form-hint { font-size: 13px; color: #aaa; margin: -10px 0 15px 0; padding-left: 5px; }
        .required-star { color: #f44336; margin-left: 3px; }
    </style>
</head>
<body>
<?php
    $page_name = 'user';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
?>

<main>
    <section class="page-content">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="page-header">
                <div class="header-title">
                    <h2>Edit Collaborator</h2>
                    <p style="color: #888; font-size: 14px; margin-top: 5px;">Update collaborator account and details.</p>
                </div>
                <div class="header-actions">
                    <button type="submit" class="btn-save">
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
                            <label>APKey <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border"><input type="text" name="apkey" value="<?php echo htmlspecialchars($data['apkey']); ?>" required></div>
                        </div>
                        <div class="form-field" style="flex:1;">
                            <label>Password</label>
                            <div class="txt-container glass-effect-border"><input type="password" name="password" placeholder="Leave blank to keep current"></div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <div class="form-field" style="flex:1;">
                            <label>First Name <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border"><input type="text" name="first_name" value="<?php echo htmlspecialchars($data['first_name']); ?>" required></div>
                        </div>
                        <div class="form-field" style="flex:1;">
                            <label>Last Name <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border"><input type="text" name="last_name" value="<?php echo htmlspecialchars($data['last_name']); ?>" required></div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <div class="form-field" style="flex:1;">
                            <label>Date of Birth <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border"><input type="date" name="dob" value="<?php echo htmlspecialchars($data['dob']); ?>" required></div>
                        </div>
                        <div class="form-field" style="flex:1;">
                            <label>Gender <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <select name="gender" required style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                    <option value="Male" <?php if($data['gender'] == 'Male') echo 'selected'; ?> style="color:black;">Male</option>
                                    <option value="Female" <?php if($data['gender'] == 'Female') echo 'selected'; ?> style="color:black;">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <label>Phone Number <span class="required-star">*</span></label>
                        <div class="txt-container glass-effect-border"><input type="text" name="phone_no" value="<?php echo htmlspecialchars($data['phone_no']); ?>" required></div>
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
                        <div class="txt-container glass-effect-border"><input type="file" name="profile_picture" accept="image/*"></div>
                    </div>
                </div>
            </div>

            <div class="form-part">
                <div class="form-part-header">
                    <span><img src="/GoGreen-APU/assets/icons/lock.fill.svg" alt=""></span>
                    <h3>Security Questions</h3>
                </div>
                <div class="form-part-content">
                    <div class="form-field">
                        <label>Security Question 1 <span class="required-star">*</span></label>
                        <div class="txt-container glass-effect-border">
                            <select name="security_quest1" required style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                <option value="What is your mother's maiden name?" <?php if($data['security_quest1'] == "What is your mother's maiden name?") echo 'selected'; ?> style="color:black;">What is your mother's maiden name?</option>
                                <option value="What is your favorite colour?" <?php if($data['security_quest1'] == "What is your favorite colour?") echo 'selected'; ?> style="color:black;">What is your favorite colour?</option>
                                <option value="What is your first pet's name?" <?php if($data['security_quest1'] == "What is your first pet's name?") echo 'selected'; ?> style="color:black;">What is your first pet's name?</option>
                                <option value="What is your Hometown's name?" <?php if($data['security_quest1'] == "What is your Hometown's name?") echo 'selected'; ?> style="color:black;">What is your Hometown's name?</option>
                                <option value="What was the name of your best friend in elementary school?" <?php if($data['security_quest1'] == "What was the name of your best friend in elementary school?") echo 'selected'; ?> style="color:black;">What was the name of your best friend in elementary school?</option>
                                <option value="Who was your childhood hero?" <?php if($data['security_quest1'] == "Who was your childhood hero?") echo 'selected'; ?> style="color:black;">Who was your childhood hero?</option>
                                <option value="What was the model of your first car?" <?php if($data['security_quest1'] == "What was the model of your first car?") echo 'selected'; ?> style="color:black;">What was the model of your first car?</option>
                                <option value="Where did you fly for your first airplane trip?" <?php if($data['security_quest1'] == "Where did you fly for your first airplane trip?") echo 'selected'; ?> style="color:black;">Where did you fly for your first airplane trip?</option>
                            </select>
                        </div>
                        <div class="txt-container glass-effect-border"><input type="text" name="security_ans1" value="<?php echo htmlspecialchars($data['security_ans1']); ?>" required></div>
                    </div>

                    <div class="form-field">
                        <label>Security Question 2 <span class="required-star">*</span></label>
                        <div class="txt-container glass-effect-border">
                            <select name="security_quest2" required style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                <option value="What is your mother's maiden name?" <?php if($data['security_quest2'] == "What is your mother's maiden name?") echo 'selected'; ?> style="color:black;">What is your mother's maiden name?</option>
                                <option value="What is your favorite colour?" <?php if($data['security_quest2'] == "What is your favorite colour?") echo 'selected'; ?> style="color:black;">What is your favorite colour?</option>
                                <option value="What is your first pet's name?" <?php if($data['security_quest2'] == "What is your first pet's name?") echo 'selected'; ?> style="color:black;">What is your first pet's name?</option>
                                <option value="What is your Hometown's name?" <?php if($data['security_quest2'] == "What is your Hometown's name?") echo 'selected'; ?> style="color:black;">What is your Hometown's name?</option>
                                <option value="What was the name of your best friend in elementary school?" <?php if($data['security_quest2'] == "What was the name of your best friend in elementary school?") echo 'selected'; ?> style="color:black;">What was the name of your best friend in elementary school?</option>
                                <option value="Who was your childhood hero?" <?php if($data['security_quest2'] == "Who was your childhood hero?") echo 'selected'; ?> style="color:black;">Who was your childhood hero?</option>
                                <option value="What was the model of your first car?" <?php if($data['security_quest2'] == "What was the model of your first car?") echo 'selected'; ?> style="color:black;">What was the model of your first car?</option>
                                <option value="Where did you fly for your first airplane trip?" <?php if($data['security_quest2'] == "Where did you fly for your first airplane trip?") echo 'selected'; ?> style="color:black;">Where did you fly for your first airplane trip?</option>
                            </select>
                        </div>
                        <div class="txt-container glass-effect-border"><input type="text" name="security_ans2" value="<?php echo htmlspecialchars($data['security_ans2']); ?>" required></div>
                    </div>

                    <div class="form-field">
                        <label>Security Question 3 <span class="required-star">*</span></label>
                        <div class="txt-container glass-effect-border">
                            <select name="security_quest3" required style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                <option value="What is your mother's maiden name?" <?php if($data['security_quest3'] == "What is your mother's maiden name?") echo 'selected'; ?> style="color:black;">What is your mother's maiden name?</option>
                                <option value="What is your favorite colour?" <?php if($data['security_quest3'] == "What is your favorite colour?") echo 'selected'; ?> style="color:black;">What is your favorite colour?</option>
                                <option value="What is your first pet's name?" <?php if($data['security_quest3'] == "What is your first pet's name?") echo 'selected'; ?> style="color:black;">What is your first pet's name?</option>
                                <option value="What is your Hometown's name?" <?php if($data['security_quest3'] == "What is your Hometown's name?") echo 'selected'; ?> style="color:black;">What is your Hometown's name?</option>
                                <option value="What was the name of your best friend in elementary school?" <?php if($data['security_quest3'] == "What was the name of your best friend in elementary school?") echo 'selected'; ?> style="color:black;">What was the name of your best friend in elementary school?</option>
                                <option value="Who was your childhood hero?" <?php if($data['security_quest3'] == "Who was your childhood hero?") echo 'selected'; ?> style="color:black;">Who was your childhood hero?</option>
                                <option value="What was the model of your first car?" <?php if($data['security_quest3'] == "What was the model of your first car?") echo 'selected'; ?> style="color:black;">What was the model of your first car?</option>
                                <option value="Where did you fly for your first airplane trip?" <?php if($data['security_quest3'] == "Where did you fly for your first airplane trip?") echo 'selected'; ?> style="color:black;">Where did you fly for your first airplane trip?</option>
                            </select>
                        </div>
                        <div class="txt-container glass-effect-border"><input type="text" name="security_ans3" value="<?php echo htmlspecialchars($data['security_ans3']); ?>" required></div>
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
                        <label>Club <span class="required-star">*</span></label>
                        <div class="txt-container glass-effect-border">
                            <select id="club_id" onchange="updateEventOptions()" style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                <option value="" style="color:black;">Select Club</option>
                                <?php foreach ($clubs as $club): ?>
                                    <option value="<?php echo $club['id']; ?>" <?php if($data['club_id'] == $club['id']) echo 'selected'; ?> style="color:black;"><?php echo $club['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-field">
                        <label>Event <span class="required-star">*</span></label>
                        <div class="txt-container glass-effect-border">
                            <select id="event_id" name="event_id" required style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                <option value="" style="color:black;">Select Event</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-field">
                        <label>Collaborator Type <span class="required-star">*</span></label>
                        <div class="txt-container glass-effect-border">
                            <select name="type" id="type" required onchange="toggleNGOField()" style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                <option value="internal" <?php if($data['type'] == 'internal') echo 'selected'; ?> style="color:black;">Internal (APU Staff/Student)</option>
                                <option value="external" <?php if($data['type'] == 'external') echo 'selected'; ?> style="color:black;">External (NGO/Organization)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-field">
                        <label>Position</label>
                        <div class="txt-container glass-effect-border"><input type="text" name="positions" value="<?php echo htmlspecialchars($data['positions'] ?? ''); ?>" placeholder="e.g., Coordinator, Volunteer Lead, etc."></div>
                    </div>

                    <div class="form-field" id="ngo-field-wrapper" style="display:<?php echo ($data['type'] == 'external') ? 'block' : 'none'; ?>;">
                        <label>NGO/Organization Name</label>
                        <div class="txt-container glass-effect-border"><input type="text" name="ngo_name" value="<?php echo htmlspecialchars($data['ngo_name'] ?? ''); ?>" placeholder="e.g., WWF Malaysia"></div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>

<script>
    const eventsData = <?php echo json_encode($events); ?>;
    const currentEventId = <?php echo $data['event_id']; ?>;

    function updateEventOptions() {
        const clubId = document.getElementById('club_id').value;
        const eventSelect = document.getElementById('event_id');
        eventSelect.innerHTML = '<option value="" style="color:black;">Select Event</option>';
        eventSelect.disabled = !clubId;

        if (clubId) {
            const filteredEvents = eventsData.filter(ev => ev.club_id == clubId);
            filteredEvents.forEach(event => {
                const option = document.createElement('option');
                option.value = event.id;
                option.textContent = event.title;
                option.style.color = 'black';
                if (event.id == currentEventId) {
                    option.selected = true;
                }
                eventSelect.appendChild(option);
            });
        }
    }

    function toggleNGOField() {
        const type = document.getElementById('type').value;
        const ngoField = document.getElementById('ngo-field-wrapper');
        ngoField.style.display = (type === 'external') ? 'block' : 'none';
    }

    window.addEventListener('DOMContentLoaded', function() {
        updateEventOptions();
    });
</script>
<script src="/GoGreen-APU/assets/js/organizer/information.js"></script>
</body>
</html>
