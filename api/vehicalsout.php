<?php

include '../func/conn.php';

function updateEndTime($conn, $user) {
    $currentTime = date("Y-m-d H:i:s");
    $sql = "UPDATE vehicalsdetails SET end_time = '$currentTime' WHERE user_id = '$user' AND end_time = '0000-00-00 00:00:00'";

    if ($conn->query($sql) === TRUE) {
        return array("success" => true, "message" => "End time updated successfully for user: $user");
    } else {
        return array("success" => false, "message" => "Error updating end time: " . $conn->error);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["user"])) {
        $user = $_POST["user"];
        $response = updateEndTime($conn, $user);
        echo json_encode($response);
    } else {
        $response = array("success" => false, "message" => "Error: Required parameters are missing.");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "message" => "Error: Invalid request method.");
    echo json_encode($response);
}

$conn->close();

?>
