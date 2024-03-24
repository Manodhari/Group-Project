<?php

include '../func/conn.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();

    $email = $_POST['email'];
    $password = $_POST['password'];
    $label = $_POST['label'];

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "";
    $result = null;

    if ($label == 'admin') {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
  
        if (!$result) {
          
            $response['success'] = false;
            $response['message'] = "Error executing query: " . $conn->error;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit(); 
        }
    } else {
       
        $response['success'] = false;
        $response['message'] = "Invalid user label.";
        header('Content-Type: application/json');
        echo json_encode($response);
        exit(); 
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['label'] = $label;
            $_SESSION['user_id'] = $row['id'];
            $response['success'] = true;
            $response['message'] = "Login successful.";
        } else {
            $response['success'] = false;
            $response['message'] = "Incorrect username or password.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Incorrect username or password.";
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
