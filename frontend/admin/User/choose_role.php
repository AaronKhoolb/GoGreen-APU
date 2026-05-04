<!--
    Author: Chong Jun Yoong
    Date: 2026-1-26
    Description: Admin choose role for new user account
-->
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>GoGreen@APU - Admin - Create User</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/auth/auth.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/admin/choose_role.css">
</head>
<body>
    <form>
        <div class="middle">
            <div class="title">
                <h2>GoGreen @ APU</h2>
            </div>

            <div class="main_card">
                <h1>Create New User</h1>
                <p>Select the role for the new user account</p>

                <div class="role-options">
                    <div class="role-option">
                        <a href="/GoGreen-APU/frontend/admin/User/create_student.php" style="display: flex; align-items: center; gap: 16px; width: 100%;">
                            <div class="role-icon">
                                <img src="/GoGreen-APU/assets/icons/person.3.fill.svg" alt="Student">
                            </div>
                            <div class="role-info">
                                <h3>Student</h3>
                                <p>Create a student account</p>
                            </div>
                        </a>
                    </div>

                    <div class="role-option">
                        <a href="/GoGreen-APU/frontend/admin/User/create_organizer.php" style="display: flex; align-items: center; gap: 16px; width: 100%;">
                            <div class="role-icon">
                                <img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt="Organizer">
                            </div>
                            <div class="role-info">
                                <h3>Organizer</h3>
                                <p>Create an event organizer account</p>
                            </div>
                        </a>
                    </div>

                    <div class="role-option">
                        <a href="/GoGreen-APU/frontend/admin/User/create_collaborator.php" style="display: flex; align-items: center; gap: 16px; width: 100%;">
                            <div class="role-icon">
                                <img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt="Collaborator">
                            </div>
                            <div class="role-info">
                                <h3>Collaborator</h3>
                                <p>Create an event collaborator account</p>
                            </div>
                        </a>
                    </div>
                </div>

                <button type="button" onclick="window.history.back()" class="btn-prev" style="width: 100%; margin-top: 25px;">
                    <span>Back</span>
                </button>
            </div>
        </div>
    </form>
</body>
</html>
