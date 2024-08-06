<?php
// Include db connection file
include("dbconn.php");

// Capture values from POST request
$post_data = json_decode(file_get_contents("php://input"), true);

// Debug: Log received raw POST data
error_log("Received raw POST data: " . file_get_contents("php://input"));

if (isset($post_data['username'])) {
    $username = $post_data['username'];
    
    // Debug: Log received username
    error_log("Received username: $username");

    // Query to get user_id from username
    $sql_user = "SELECT user_id FROM users WHERE username = '$username'";
    $result_user = mysqli_query($dbconn, $sql_user);

    if ($result_user && mysqli_num_rows($result_user) > 0) {
        $row_user = mysqli_fetch_assoc($result_user);
        $user_id = $row_user['user_id'];

        // Debug: Log retrieved user_id
        error_log("Retrieved user_id: $user_id");

        // Initialize summary variables
        $total_income = 0;
        $total_expenses = 0;

        // Query to get all expenses for the user
        $sql_expenses = "SELECT amount, type FROM expense WHERE user_id = '$user_id'";
        $result_expenses = mysqli_query($dbconn, $sql_expenses);

        if ($result_expenses) {
            // Iterate through the results and calculate totals
            while ($row_expenses = mysqli_fetch_assoc($result_expenses)) {
                if ($row_expenses['type'] == 'income') {
                    $total_income += $row_expenses['amount'];
                } else if ($row_expenses['type'] == 'expense') {
                    $total_expenses += $row_expenses['amount'];
                }
            }

            // Calculate the balance
            $balance = $total_income - $total_expenses;

            // Return the summary as JSON
            echo json_encode([
                "status" => "success",
                "total_income" => $total_income,
                "total_expenses" => $total_expenses,
                "balance" => $balance
            ]);
        } else {
            // Query failed
            echo json_encode(["status" => "fail", "error" => mysqli_error($dbconn)]);
        }
    } else {
        // User not found or query failed
        echo json_encode(["status" => "fail", "error" => "User not found"]);
    }
} else {
    // Username not provided
    echo json_encode(["status" => "fail", "error" => "Username not provided"]);
}

// Close db connection
mysqli_close($dbconn);
?>
