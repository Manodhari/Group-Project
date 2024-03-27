<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parking System Status</title>
<link href="style.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
</head>
<body>
<div class="container">
<nav class="navbar navbar-expand-lg bg-body-nav" style="margin: 10px; border-radius: 10px">
  <div class="container-fluid">
    <img src="../img/Logo.png" style="width: auto; height: 50px; padding: 10px">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="home.php" style="margin: 0 10px; color:white">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="paybill.php" style="margin: 0 10px;color:white " >Pay Bill</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="reports.php" style="margin: 0 10px; color:white">Reports</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="logout.php"  aria-disabled="true" style="margin: 0 10px; color:white">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<br>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Report Generator</h5>
                    <form id="parkingForm"> 

                        <div class="mb-3">
                            <label for="reportType" class="form-label">Report Type</label>
                            <select class="form-select" id="reportType" required>
                                <option value="" selected disabled>Select Report Type</option>
                                <option value="slot_change">Slot Change Reports</option>
                                <option value="vehicle">Vehicle Reports</option>
                                <option value="price">Price Report</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <select class="form-select" id="duration" required>
                                <option value="" selected disabled>Select Duration</option>
                                <option value="weekly">Weekly</option>
                                <option value="daily">Daily</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="width: 146px; height: 40px;">Generate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>



<script>
   document.getElementById('parkingForm').addEventListener('submit', function(event) {
    event.preventDefault(); 

    var reportType = document.getElementById('reportType').value;
    var duration = document.getElementById('duration').value;

    var formData = new FormData();
    formData.append('reportType', reportType);
    formData.append('duration', duration);

    fetch('../api/report.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        console.log(data);
       
        switch (reportType) {
            case 'slot_change':
                generateCSV(data, 'Slot Change Report');
                break;
            case 'vehicle':
                generateCSV(data, 'Vehicle Report');
                break;
            case 'price':
                generateCSV(data, 'Price Report');
                break;
            default:
                alert('Invalid report type');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.');
    });
});

function generateCSV(data, title) {
    let csvContent = "data:text/csv;charset=utf-8,";


    let headers = Object.keys(data.reportData[0]);
    csvContent += headers.join(",") + "\r\n";

 
    data.reportData.forEach(row => {
        let values = headers.map(header => row[header]);
        csvContent += values.join(",") + "\r\n";
    });

   
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", title + ".csv");
    document.body.appendChild(link);
    
   
    link.click();
}
</script>


</body>
</html>

