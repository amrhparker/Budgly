<?php
/* include db connection file */
include("dbconn.php");
/* capture values from HTML form */
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT username FROM users WHERE username = '$username'";
//echo $sql;
$query = mysqli_query($dbconn, $sql);

if (!$query) {
    die("Error: " . mysqli_error($dbconn));
}

$row = mysqli_num_rows($query);

if($row != 0){
    echo "The username is already existed";
        exit();
} else{
    /* execute SQL INSERT command */
    $sql2 = "INSERT INTO users (username, password)
    VALUES ('$username','$password')";
    
    if (mysqli_query($dbconn, $sql2) ) {
        echo "Succesfully registered!";
        echo json_encode(["status" => "success"]);
    } else {
        echo "Error: " . mysqli_error($dbconn);
        echo json_encode(["status" => "fail"]);
    }
}
/*close db connection */
mysqli_close($dbconn);
?>	