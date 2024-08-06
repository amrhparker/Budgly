<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "budgly";

// Create connection
$dbconn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
} 

?>
