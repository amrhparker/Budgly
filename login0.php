<?php
// Include db connection file
include("dbconn.php");

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$res = mysqli_query($dbconn, $sql) or die(mysqli_error($dbconn));

if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "fail"]);
}

// Close database connection
mysqli_close($dbconn);
?>
