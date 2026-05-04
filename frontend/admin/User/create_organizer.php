<!--
	Author: Chong Jun Yoong
	Date: 2026-01-26
	Description: Let admin to create a new organizer account
-->
<?php ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
	<?php
	$clubs = [];
	$clubs_query = mysqli_query($conn, "SELECT id, name FROM clubs ORDER BY name ASC");
	if ($clubs_query && mysqli_num_rows($clubs_query) > 0) {
		while ($club = mysqli_fetch_assoc($clubs_query)) {
			$clubs[] = $club;
		}
	}
	?>
	<title>GoGreen@APU - Admin - Create Organizer</title>
	<link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
	<link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
	<style>
		.form-hint { font-size: 13px; color: #aaa; margin: -10px 0 15px 0; padding-left: 5px; }
		.required-star { color: #f44336; margin-left: 3px; }
	</style>
    
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$apkey = trim($_POST['apkey']);
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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

	$club_id = (int)$_POST['club_id'];
	$position = trim($_POST['position']);

	$role = 'organizer';

	if ($club_id <= 0) {
		echo "<script>alert('Please select a club.'); window.history.back();</script>";
		exit;
	}

	$stmt_check = mysqli_prepare($conn, 'SELECT id FROM users WHERE apkey = ? LIMIT 1');
	mysqli_stmt_bind_param($stmt_check, 's', $apkey);
	mysqli_stmt_execute($stmt_check);
	$result_check = mysqli_stmt_get_result($stmt_check);

	if (mysqli_num_rows($result_check) > 0) {
		echo "<script>alert('APKey already exists.'); window.history.back();</script>";
		exit;
	}

	$conn->begin_transaction();
	try {
		$sql_user = "INSERT INTO users 
			(apkey, password, role, first_name, last_name, avatar_path, dob, gender, phone_no,
			 security_quest1, security_ans1, security_quest2, security_ans2, security_quest3, security_ans3)
			VALUES (?, ?, ?, ?, ?, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt_user = mysqli_prepare($conn, $sql_user);
		if (!$stmt_user) throw new Exception('DB Prep Error (users): ' . mysqli_error($conn));

		mysqli_stmt_bind_param(
			$stmt_user,
			'ssssssssssssss',
			$apkey,
			$password,
			$role,
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
		);

		if (!mysqli_stmt_execute($stmt_user)) throw new Exception('Insert users failed: ' . mysqli_error($conn));
		$new_user_id = mysqli_insert_id($conn);
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
				$new_file_name = $new_user_id . '.' . $file_ext;
				$target_path = $upload_dir . $new_file_name;
				if (move_uploaded_file($file_tmp, $target_path)) {
					chmod($target_path, 0644);
					$stmt_avatar = mysqli_prepare($conn, 'UPDATE users SET avatar_path = ? WHERE id = ?');
					mysqli_stmt_bind_param($stmt_avatar, 'si', $new_file_name, $new_user_id);
					mysqli_stmt_execute($stmt_avatar);
					mysqli_stmt_close($stmt_avatar);
				}
			}
		}

		$stmt_org = mysqli_prepare($conn, 'INSERT INTO organizers (user_id, club_id, positions) VALUES (?, ?, ?)');
		if (!$stmt_org) throw new Exception('DB Prep Error (organizers): ' . mysqli_error($conn));
		mysqli_stmt_bind_param($stmt_org, 'iis', $new_user_id, $club_id, $position);
		if (!mysqli_stmt_execute($stmt_org)) throw new Exception('Insert organizers failed: ' . mysqli_error($conn));
		mysqli_stmt_close($stmt_org);

		$conn->commit();
		echo "<script>alert('Organizer created successfully!'); window.location.href='/GoGreen-APU/frontend/admin/User/create_organizer.php';</script>";
		exit;
	} catch (Exception $e) {
		$conn->rollback();
		echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
		exit;
	}
}
?>
<?php
	$page_name = 'user';
	include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
?>

<main>
	<section class="page-content">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="page-header">
				<div class="header-title">
					<h2>Create New Organizer</h2>
					<p style="color: #888; font-size: 14px; margin-top: 5px;">Fill in the organizer's account and details.</p>
				</div>
				<div class="header-actions">
					<button type="submit" class="btn-save">
						<span>Create Organizer</span>
					</button>
				</div>
			</div>

			<div class="form-part">
				<div class="form-part-header">
					<span><img src="/GoGreen-APU/assets/icons/user.svg" alt=""></span>
					<h3>User Information</h3>
				</div>
				<div class="form-part-content">
					<p class="form-hint">This will create a new organizer account in the system.</p>
					<div style="display: flex; gap: 20px;">
						<div class="form-field" style="flex:1;">
							<label>APKey <span class="required-star">*</span></label>
							<div class="txt-container glass-effect-border"><input type="text" name="apkey" placeholder="e.g., TP123456" required></div>
						</div>
						<div class="form-field" style="flex:1;">
							<label>Password <span class="required-star">*</span></label>
							<div class="txt-container glass-effect-border"><input type="password" name="password" placeholder="Enter password" required></div>
						</div>
					</div>

					<div style="display: flex; gap: 20px;">
						<div class="form-field" style="flex:1;">
							<label>First Name <span class="required-star">*</span></label>
							<div class="txt-container glass-effect-border"><input type="text" name="first_name" placeholder="First name" required></div>
						</div>
						<div class="form-field" style="flex:1;">
							<label>Last Name <span class="required-star">*</span></label>
							<div class="txt-container glass-effect-border"><input type="text" name="last_name" placeholder="Last name" required></div>
						</div>
					</div>

					<div style="display: flex; gap: 20px;">
						<div class="form-field" style="flex:1;">
							<label>Date of Birth <span class="required-star">*</span></label>
							<div class="txt-container glass-effect-border"><input type="date" name="dob" required></div>
						</div>
						<div class="form-field" style="flex:1;">
							<label>Gender <span class="required-star">*</span></label>
							<div class="txt-container glass-effect-border">
								<select name="gender" required style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
									<option value="Male" style="color:black;">Male</option>
									<option value="Female" style="color:black;">Female</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-field">
						<label>Phone Number <span class="required-star">*</span></label>
						<div class="txt-container glass-effect-border"><input type="text" name="phone_no" placeholder="e.g., 012-3456789" required></div>
					</div>

					<div class="form-field">
						<label>Profile Picture</label>
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
								<option value="" disabled selected>Select a question</option>
								<option value="What is your mother's maiden name?" style="color:black;">What is your mother's maiden name?</option>
								<option value="What is your favorite colour?" style="color:black;">What is your favorite colour?</option>
								<option value="What is your first pet's name?" style="color:black;">What is your first pet's name?</option>
								<option value="What is your Hometown's name?" style="color:black;">What is your Hometown's name?</option>
								<option value="What was the name of your best friend in elementary school?" style="color:black;">What was the name of your best friend in elementary school?</option>
								<option value="Who was your childhood hero?" style="color:black;">Who was your childhood hero?</option>
								<option value="What was the model of your first car?" style="color:black;">What was the model of your first car?</option>
								<option value="Where did you fly for your first airplane trip?" style="color:black;">Where did you fly for your first airplane trip?</option>
							</select>
						</div>
						<div class="txt-container glass-effect-border"><input type="text" name="security_ans1" placeholder="Answer" required></div>
					</div>

					<div class="form-field">
						<label>Security Question 2 <span class="required-star">*</span></label>
						<div class="txt-container glass-effect-border">
							<select name="security_quest2" required style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
								<option value="" disabled selected>Select a question</option>
								<option value="What is your mother's maiden name?" style="color:black;">What is your mother's maiden name?</option>
								<option value="What is your favorite colour?" style="color:black;">What is your favorite colour?</option>
								<option value="What is your first pet's name?" style="color:black;">What is your first pet's name?</option>
								<option value="What is your Hometown's name?" style="color:black;">What is your Hometown's name?</option>
								<option value="What was the name of your best friend in elementary school?" style="color:black;">What was the name of your best friend in elementary school?</option>
								<option value="Who was your childhood hero?" style="color:black;">Who was your childhood hero?</option>
								<option value="What was the model of your first car?" style="color:black;">What was the model of your first car?</option>
								<option value="Where did you fly for your first airplane trip?" style="color:black;">Where did you fly for your first airplane trip?</option>
							</select>
						</div>
						<div class="txt-container glass-effect-border"><input type="text" name="security_ans2" placeholder="Answer" required></div>
					</div>

					<div class="form-field">
						<label>Security Question 3 <span class="required-star">*</span></label>
						<div class="txt-container glass-effect-border">
							<select name="security_quest3" required style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
								<option value="" disabled selected>Select a question</option>
								<option value="What is your mother's maiden name?" style="color:black;">What is your mother's maiden name?</option>
								<option value="What is your favorite colour?" style="color:black;">What is your favorite colour?</option>
								<option value="What is your first pet's name?" style="color:black;">What is your first pet's name?</option>
								<option value="What is your Hometown's name?" style="color:black;">What is your Hometown's name?</option>
								<option value="What was the name of your best friend in elementary school?" style="color:black;">What was the name of your best friend in elementary school?</option>
								<option value="Who was your childhood hero?" style="color:black;">Who was your childhood hero?</option>
								<option value="What was the model of your first car?" style="color:black;">What was the model of your first car?</option>
								<option value="Where did you fly for your first airplane trip?" style="color:black;">Where did you fly for your first airplane trip?</option>
							</select>
						</div>
						<div class="txt-container glass-effect-border"><input type="text" name="security_ans3" placeholder="Answer" required></div>
					</div>
				</div>
			</div>

			<div class="form-part">
				<div class="form-part-header">
					<span><img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt=""></span>
					<h3>Organizer Details</h3>
				</div>
				<div class="form-part-content">
					<div class="form-field">
						<label>Club <span class="required-star">*</span></label>
						<div class="txt-container glass-effect-border">
							<select name="club_id" required style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
								<option value="" style="color:black;">Select Club</option>
								<?php foreach ($clubs as $club): ?>
									<option value="<?php echo $club['id']; ?>" style="color:black;"><?php echo $club['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-field">
						<label>Position <span class="required-star">*</span></label>
						<div class="txt-container glass-effect-border"><input type="text" name="position" placeholder="e.g., President" required></div>
					</div>
				</div>
			</div>
		</form>
	</section>
</main>

<script src="/GoGreen-APU/assets/js/organizer/information.js"></script>
</body>
</html>
