<?php
// Include db connection file
include("dbconn.php");
// Capture values from POST request
$username='user';

// Query to get user_id from username
$sql1 = "SELECT user_id FROM users WHERE username = '$username'";
$result1 = mysqli_query($dbconn, $sql1) or die(mysqli_error($dbconn));

if ($result1 && mysqli_num_rows($result1) > 0) {
    $row_user = mysqli_fetch_assoc($result1);
    $user_id = $row_user['user_id'];

    // Query to get all expenses for the user
    $sql2 = "SELECT * FROM expense WHERE user_id = '$user_id'";
    $result2 = mysqli_query($dbconn, $sql2) or die(mysqli_error($dbconn));

    $json = [];
    while ($r = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
        $json[] = $r;
    }
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
    mysqli_free_result($result2);
} else {
    echo json_encode(["status" => "fail", "error" => "User not found"]);
}
mysqli_free_result($result1);
// Close db connection
mysqli_close($dbconn);
?>
