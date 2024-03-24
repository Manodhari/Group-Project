<?php

include '../func/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["slot"]) && isset($_POST["change_time"])) {

        $slotId = $_POST["slot"]; 
        $status = $_POST["status"];
        $changeTime = $_POST["change_time"]; 
        
      
        $changeTimeFormatted = date('Y-m-d H:i:s', strtotime($changeTime));

  
        $insertSql = "INSERT INTO slots (slot_id,status,`Change_time`) VALUES ('$slotId','$status', '$changeTimeFormatted')";

        if ($conn->query($insertSql) === TRUE) {
            $response = array("success" => true, "message" => "Slot inserted successfully.");
            echo json_encode($response);
        } else {
            $response = array("success" => false, "message" => "Error inserting slot: " . $conn->error);
            echo json_encode($response);
        }
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
