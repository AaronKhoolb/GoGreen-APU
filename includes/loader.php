<!--
    Author: Khoo Lay Bin
    Date: 2025-11-20
    Description: loading screen that will be included in head.php so that affected on all pages
-->

<link rel="stylesheet" href="/GoGreen-APU/assets/css/global/loader.css">

<div id="loader">
    <img class="logo" src="/GoGreen-APU/assets/images/logo/GoGreen@APU icon.svg" alt="GoGreen Logo">
    <img class="loader" src="/GoGreen-APU/assets/images/loader/loader.webp" alt="Loading...">
</div>

<script>
    window.addEventListener("load", function() {
        setTimeout(function() {
            document.getElementById("loader").classList.add("hide");
        }, 1000);
    });
</script>