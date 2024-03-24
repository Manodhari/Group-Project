<?php

include '../func/conn.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $response = array();

  
    $entranceId = $_POST['entranceId'];
    $hourlyCost = $_POST['hourlyCost'];

   
    switch ($entranceId) {
        case 1:
            $userNumber = "User_No_1";
            break;
        case 2:
            $userNumber = "User_No_2";
            break;
        case 3:
            $userNumber = "User_No_3";
            break;
        case 4:
            $userNumber = "User_No_4";
            break;
        default:
        
            $response['success'] = false;
            $response['message'] = "Invalid entrance ID.";
            echo json_encode($response);
            exit(); 
    }

   
    $sql = "SELECT start_time, end_time FROM vehicalsdetails WHERE user_id = '$userNumber' ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

   
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $startTime = $row['start_time'];
        $endTime = $row['end_time'];

      
        if ($startTime != 0 && $endTime != 0) {
           
            $timeDiffInSeconds = strtotime($endTime) - strtotime($startTime);
            $timeDiffInHours = $timeDiffInSeconds / (60 * 60); 

     
            $totalCost = $timeDiffInHours * $hourlyCost;

            
            $response['success'] = true;
            $response['totalCost'] = $totalCost;
            echo json_encode($response);
        } else {
        
            $response['success'] = false;
            $response['message'] = "Start time or end time not available.";
            echo json_encode($response);
        }
    } else {
      
        $response['success'] = false;
        $response['message'] = "No records found for the user.";
        echo json_encode($response);
    }
} else {
    
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
    echo json_encode($response);
}
?>
