<?php

$response = array(); 
include '../func/conn.php';

function insertUserEntry($conn, $user, $timeType, $time) {
    $response = array(); // Initialize $response within the function

    if ($timeType == 'start_time') {
        $sql = "INSERT INTO vehicalsdetails (user_id, start_time) VALUES ('$user', '$time')";
        if ($conn->query($sql) === TRUE) {
            $response = array("success" => true, "message" => "User entry details inserted successfully.");
        } else {
            $response = array("success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error);
        }
    } elseif ($timeType == 'end_time') {
        $checkSql = "SELECT * FROM vehicalsdetails WHERE user_id = '$user' AND end_time = '0000-00-00 00:00:00' ORDER BY start_time ASC LIMIT 1";
        $result = $conn->query($checkSql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $updateSql = "UPDATE vehicalsdetails SET end_time = '$time' WHERE user_id = '$user' AND end_time = '0000-00-00 00:00:00' AND start_time = '{$row['start_time']}'";
            if ($conn->query($updateSql) === TRUE) {
                $response = array("success" => true, "message" => "End time updated successfully for user: $user");
            } else {
                $response = array("success" => false, "message" => "Error updating end time: " . $conn->error);
            }
        } else {
            $response = array("success" => true, "message" => "End time already set for user: $user");
        }
    } else {
        $response = array("success" => false, "message" => "Invalid time type.");
    }

    return $response;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $timeType = $_POST["timeType"]; 
    $time = $_POST[$timeType]; 

    $response = insertUserEntry($conn, $user, $timeType, $time);
    echo json_encode($response);
} else {
    $response = array("success" => false, "message" => "Error: Invalid request method.");
    echo json_encode($response);
}

$conn->close();

?>
