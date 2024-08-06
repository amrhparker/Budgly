<?php
// Include db connection file
include("dbconn.php");

// Capture values from POST request
$username= $_POST['username'];
$income = $_POST['income'];

// Query to get user_id from username
$sql1 = "SELECT user_id FROM users WHERE username = '$username'";
$result1 = mysqli_query($dbconn, $sql1) or die(mysqli_error($dbconn));

if ($result1 && mysqli_num_rows($result1) > 0) {
    $row_user = mysqli_fetch_assoc($result1);
    $user_id = $row_user['user_id'];
    // Query to update weekly income
    $sql_income = "UPDATE users SET income = '$income' WHERE user_id = '$user_id'";
    if (mysqli_query($dbconn, $sql_income)) {
        echo json_encode(["status" => "success", "message" => "Iincome updated"]);
    } else {
        echo json_encode(["status" => "fail", "error" => mysqli_error($dbconn)]);
    }
} else {
    echo json_encode(["status" => "fail", "error" => "User not found"]);
}


// Close db connection
mysqli_close($dbconn);
?>
