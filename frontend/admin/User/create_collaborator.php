<!--
	Author: Chong Jun Yoong
	Date: 2026-01-26
	Description: Admin page to create a new Collaborator account.
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

	$events = [];
	$events_query = mysqli_query($conn, "SELECT e.id, e.title, e.club_id FROM events e ORDER BY e.club_id ASC, e.title ASC");
	if ($events_query && mysqli_num_rows($events_query) > 0) {
		while ($ev = mysqli_fetch_assoc($events_query)) {
			$events[] = $ev;
		}
	}
	?>
	<title>GoGreen@APU - Admin - Create Collaborator</title>
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

	$event_id = (int)$_POST['event_id'];
	$collab_type = $_POST['type'];
	$positions = trim($_POST['positions']) ?: null;
	$ngo_name = trim($_POST['ngo_name']) ?: null;

	$role = 'collaborator';

	if ($event_id <= 0) {
		echo "<script>alert('Please select an event.'); window.history.back();</script>";
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

		$stmt_collab = mysqli_prepare($conn, 'INSERT INTO collaborators (user_id, event_id, type, positions, ngo_name) VALUES (?, ?, ?, ?, ?)');
		if (!$stmt_collab) throw new Exception('DB Prep Error (collaborators): ' . mysqli_error($conn));
		mysqli_stmt_bind_param($stmt_collab, 'iisss', $new_user_id, $event_id, $collab_type, $positions, $ngo_name);
		if (!mysqli_stmt_execute($stmt_collab)) throw new Exception('Insert collaborators failed: ' . mysqli_error($conn));
		mysqli_stmt_close($stmt_collab);

		$conn->commit();
		echo "<script>alert('Collaborator created successfully!'); window.location.href='/GoGreen-APU/frontend/admin/User/create_collaborator.php';</script>";
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
					<h2>Create New Collaborator</h2>
					<p style="color: #888; font-size: 14px; margin-top: 5px;">Assign to an event and set collaborator details.</p>
				</div>
				<div class="header-actions">
					<button type="submit" class="btn-save">
						<span>Create Collaborator</span>
					</button>
				</div>
			</div>

			<div class="form-part">
				<div class="form-part-header">
					<span><img src="/GoGreen-APU/assets/icons/user.svg" alt=""></span>
					<h3>User Information</h3>
				</div>
				<div class="form-part-content">
					<p class="form-hint">This will create a new user account in the system.</p>
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
								<option value="<?php echo $club['id']; ?>" style="color:black;"><?php echo $club['name']; ?></option>
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
								<option value="internal" style="color:black;">Internal (APU Staff/Student)</option>
								<option value="external" style="color:black;">External (NGO/Organization)</option>
							</select>
						</div>
					</div>
					<div class="form-field">
						<label>Position</label>
						<div class="txt-container glass-effect-border"><input type="text" name="positions" placeholder="e.g., Coordinator, Volunteer Lead, etc."></div>
					</div>
					<div class="form-field" id="ngo-field-wrapper" style="display:none;">
						<label>NGO/Organization Name</label>
						<div class="txt-container glass-effect-border"><input type="text" name="ngo_name" placeholder="e.g., WWF Malaysia"></div>
					</div>
				</div>
			</div>
		</form>
	</section>
</main>

<script>
	const eventsData = <?php echo json_encode($events); ?>;

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
				eventSelect.appendChild(option);
			});
		}
	}

	function toggleNGOField() {
		const type = document.getElementById('type').value;
		const ngoField = document.getElementById('ngo-field-wrapper');
		ngoField.style.display = (type === 'external') ? 'block' : 'none';
	}
</script>
<script src="/GoGreen-APU/assets/js/organizer/information.js"></script>
</body>

</html>
