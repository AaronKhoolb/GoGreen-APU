<?php
/*
    Author: Khoo Lay Bin
    Date: 2025-12-19
    Description: - Database connection credentials that will be included in head.php so that it can be used in all pages
                 - Database hosted on server, usable without local DB
*/

$servername = "127.0.0.1:3306";
$username = "your_db_user";
$password = "your_db_password";
$dbname = "rwdd";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>