<?php
// Include db connection file
include("dbconn.php");

// Capture values from POST request
$username = $_POST['username'];
$expense = $_POST['expense'];

// Query to get user_id from username
$sql_user = "SELECT user_id FROM users WHERE username = '$username'";
$result_user = mysqli_query($dbconn, $sql_user);

if ($result_user && mysqli_num_rows($result_user) > 0) {
    $row_user = mysqli_fetch_assoc($result_user);
    $user_id = $row_user['user_id'];

    // Query to insert new expense
    $sql_expense = "INSERT INTO expense (user_id, amount) VALUES ('$user_id', '$expense')";
    if (mysqli_query($dbconn, $sql_expense)) {
        echo json_encode(["status" => "success", "message" => "Expense added"]);
    } else {
        echo json_encode(["status" => "fail", "error" => mysqli_error($dbconn)]);
    }
} else {
    echo json_encode(["status" => "fail", "error" => "User not found"]);
}


// Close db connection
mysqli_close($dbconn);
?>
