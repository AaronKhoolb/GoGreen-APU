<!-- 
Author: Chong Ray Han
Date: 2025-12-29
Description: redirect user after login to dashboard based on role
-->
<?php

function redirectUserByRole($role)
{
    if ($role === 'admin') {
        header("Location: /GoGreen-APU/frontend/admin/index.php");
    } else if ($role === 'organizer') {
        header("Location: /GoGreen-APU/frontend/organizer/my_events/index.php");
    } else if ($role === 'student') {
        header("Location: /GoGreen-APU/frontend/student/index.php");
    } else if ($role === 'collaborator') {
        header("Location: /GoGreen-APU/frontend/collaborator/index.php");
    } else {
        header("Location: /GoGreen-APU/index.php");
    }
    exit();
}

?>