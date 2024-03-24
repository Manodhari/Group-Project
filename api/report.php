<?php
include '../func/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();

    $reportType = $_POST['reportType'];
    $duration = $_POST['duration'];

    $reportData = array();

    switch ($reportType) {
        case 'slot_change':
            switch ($duration) {
                case 'daily':

                    $sql = "SELECT * FROM slots WHERE DATE(Change_time) = CURDATE()";
                    break;
                case 'weekly':
               
                    $sql = "SELECT * FROM slots WHERE YEARWEEK(Change_time) = YEARWEEK(CURDATE())";
                    break;
                case 'monthly':
               
                    $sql = "SELECT * FROM slots WHERE YEAR(Change_time) = YEAR(CURDATE()) AND MONTH(Change_time) = MONTH(CURDATE())";
                    break;
                default:
                    $response['success'] = false;
                    $response['message'] = "Invalid duration.";
                    echo json_encode($response);
                    exit();
            }
            break;
        case 'vehicle':
            switch ($duration) {
                case 'daily':
            
                    $sql = "SELECT * FROM vehicalsdetails WHERE DATE(start_time) = CURDATE()";
                    break;
                case 'weekly':
      
                    $sql = "SELECT * FROM vehicalsdetails WHERE YEARWEEK(start_time) = YEARWEEK(CURDATE())";
                    break;
                case 'monthly':
        
                    $sql = "SELECT * FROM vehicalsdetails WHERE YEAR(start_time) = YEAR(CURDATE()) AND MONTH(start_time) = MONTH(CURDATE())";
                    break;
                default:
                    $response['success'] = false;
                    $response['message'] = "Invalid duration.";
                    echo json_encode($response);
                    exit();
            }
            break;
        case 'price':
            switch ($duration) {
                case 'daily':
                
                    $sql = "SELECT * FROM vehicalsdetails WHERE DATE(start_time) = CURDATE()";
                    break;
                case 'weekly':
                  
                    $sql = "SELECT * FROM vehicalsdetails WHERE YEARWEEK(start_time) = YEARWEEK(CURDATE())";
                    break;
                case 'monthly':
                 
                    $sql = "SELECT * FROM vehicalsdetails WHERE YEAR(start_time) = YEAR(CURDATE()) AND MONTH(start_time) = MONTH(CURDATE())";
                    break;
                default:
                    $response['success'] = false;
                    $response['message'] = "Invalid duration.";
                    echo json_encode($response);
                    exit();
            }
            break;
        default:
            $response['success'] = false;
            $response['message'] = "Invalid report type.";
            echo json_encode($response);
            exit();
    }

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reportData[] = $row;
        }
        $response['success'] = true;
        $response['reportData'] = $reportData;
        echo json_encode($response);
    } else {
        $response['success'] = false;
        $response['message'] = "No records found for the selected duration.";
        echo json_encode($response);
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
    echo json_encode($response);
}
?>
