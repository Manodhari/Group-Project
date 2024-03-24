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
<link href="../css/style.css" rel="stylesheet">
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
                    <h5 class="card-title text-center">Parking Fee Calculator</h5>
                    <form id="parkingForm"> 

                        <div class="mb-3">
                            <label for="entranceId" class="form-label">RFID ID</label>
                            <input type="text" class="form-control" id="entranceId" placeholder="Enter Entrance ID" required>
                        </div>
                        <div class="mb-3">
                            <label for="hourlyCost" class="form-label">Per Hour Cost</label>
                            <input type="number" class="form-control" id="hourlyCost" placeholder="Enter Per Hour Cost" required>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="width: 146px; height: 40px;">Calculate</button>
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

<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="receiptModalLabel">Bill Receipt</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="receiptBody">

      </div>
    </div>
  </div>
</div>

<script>
    document.getElementById('parkingForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        var entranceId = document.getElementById('entranceId').value;
        var hourlyCost = document.getElementById('hourlyCost').value;

        var formData = new FormData();
        formData.append('entranceId', entranceId);
        formData.append('hourlyCost', hourlyCost);

        fetch('../api/billcal.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) 
        .then(data => {
            console.log(data);
            if(data.success) {
           
                displayReceipt(data.totalCost.toFixed(2)); 
            } else {
              
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
           
            alert('An error occurred. Please try again later.');
        });
    });

    function displayReceipt(totalCost) {
       
        var receiptHTML = `
            <p><strong>Total Cost:</strong> $${totalCost}</p>
            <p>Thank you for using our parking system!</p>
        `;

        
        var receiptBody = document.getElementById('receiptBody');
        receiptBody.innerHTML = receiptHTML;

       
        var receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
        receiptModal.show();
    }
</script>



</body>
</html>
