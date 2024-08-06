<?php
include("dbconn.php");
$username=$_POST['username']; //$username=user;
$sql="DELETE income FROM users WHERE username = '$username' ";
$res=mysqli_query($dbconn,$sql) or die(mysqli_error($dbconn));
if ($res==1){
    echo json_encode(["status" => "success", "message" => "Income deleted"]);
} else {
    echo json_encode(["status" => "fail", "error" => mysqli_error($dbconn)]);
}
mysqli_close($dbconn);
?>