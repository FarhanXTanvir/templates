<?php
$DB_HOST = 'localhost';
$DB_USER = 'root';  // default, change if you have set a different username
$DB_PASS = ''; // default, change if you have set a different password
$DB_NAME = 'database_name'; // change to your database name

// Check connection
$con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); 

// Set character set to utf8mb4
mysqli_set_charset($con, 'utf8');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
return $con;