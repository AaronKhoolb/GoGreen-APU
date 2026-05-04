<!--
    Author: Khoo Lay Bin
    Date: 2025-12-19
    Description: will be included in all pages
                 - session check
                 - auth check
                 - database connection
                 - meta tags (charset, viewport, ico, SEO, OG)
                 - link all global css and font
                 - script (clear_input)
-->

<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/session.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/auth_check.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');
?>


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<?php
    $default_title = 'GoGreen@APU';
    $default_description = 'GoGreen@APU - Your campus sustainability platform. Discover eco-friendly events, join green initiatives, and make a positive impact on our environment.';
    
    $page_title = isset($og_title) ? $og_title : $default_title;
    $page_description = isset($og_description) ? $og_description : $default_description;
    $logo_url = 'https://' . $_SERVER['HTTP_HOST'] . '/GoGreen-APU/assets/images/logo/defaults/GoGreen@APU icon.svg';
?>

<title><?php echo htmlspecialchars($page_title); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
<meta name="author" content="Khoo Lay Bin, Chong Jun Yoong, Chong Ray Han, Damian Loh Yi Feng">
<meta name="copyright" content="© 2026 GoGreen@APU">


<meta name="theme-color" content="black">

<meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
<meta property="og:image" content="<?php echo $logo_url; ?>">
<meta property="og:type" content="website">



<link rel="icon" href="/GoGreen-APU/assets/images/logo/favicon.ico">


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">


<link rel="stylesheet" href="/GoGreen-APU/assets/css/global/global.css">
<link rel="stylesheet" href="/GoGreen-APU/assets/css/global/frosted_glass.css">
<link rel="stylesheet" href="/GoGreen-APU/assets/css/global/checkbox_switch.css">
<link rel="stylesheet" href="/GoGreen-APU/assets/css/global/form.css">
<link rel="stylesheet" href="/GoGreen-APU/assets/css/global/clear_input.css">
<link rel="stylesheet" href="/GoGreen-APU/assets/css/global/txt.css">
<link rel="stylesheet" href="/GoGreen-APU/assets/css/global/table.css">


<script src="/GoGreen-APU/assets/js/global/clear_input.js"></script>


<?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/loader.php'); ?>