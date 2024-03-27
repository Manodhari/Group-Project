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
          <a class="nav-link active" aria-current="page" href="#" style="margin: 0 10px; color:white">Home</a>
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
<div class="row">
<div class="card">
    <div class="card-body">
        <h6 class="card-title" style="color: rgb(189, 2, 2)"><b>Parking System Slot Status</b></h6>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="slotTable">
                <thead class="table-dark">
                    <tr>
                        <th>Slot</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="slotTableBody">
                    <!-- Slot data will be inserted here dynamically -->
                </tbody>
            </table>
        </div>

        <h6 class="card-title" style="color: rgb(189, 2, 2)"><b>Parking System User Status</b></h6>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="userTable">
                <thead class="table-dark">
                    <tr>
                        <th>User</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <!-- User data will be inserted here dynamically -->
                </tbody>
            </table>
        </div>
    </div>
</div>


</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
<script>
var firebaseConfig = {
    apiKey: "AIzaSyBdmwjLd21IhrOJN6ngHbw5BRSpun_MUK0",

    authDomain: "parkingsystem-46aec.firebaseapp.com",

    projectId: "parkingsystem-46aec",

    storageBucket: "parkingsystem-46aec.appspot.com",

    messagingSenderId: "1055260995905",

    appId: "1:1055260995905:web:36c68085802b81b5b631c0"

};


    firebase.initializeApp(firebaseConfig);

    var dbRef = firebase.database().ref();
    var sentUsers = {}; // To keep track of users for whom data has already been sent

    function renderTables(data) {
        renderSlotTable(data);
        renderUserTable(data);
    }

    function renderSlotTable(data) {
        var slotTableBody = document.querySelector('#slotTable tbody');
        slotTableBody.innerHTML = ''; 

        for (var key in data) {
            if (key.startsWith('SLOT')) {
                var slot = key;
                var status = data[slot];
                
                var row = `
                    <tr>
                        <td>${slot}</td>
                        <td>${status}</td>
                    </tr>
                `;
                slotTableBody.innerHTML += row;

                // Send slot status to api/parkingslot.php
                sendSlotStatusToPHP(slot, status);
            }
        }
    }

    function renderUserTable(data) {
        var userTableBody = document.querySelector('#userTable tbody');
        userTableBody.innerHTML = ''; 

        for (var key in data) {
            if (key.startsWith('User_No_')) {
                var user = key;
                var status = data[user].Status;
                
                var row = `
                    <tr>
                        <td>${user}</td>
                        <td>${status}</td>
                    </tr>
                `;
                userTableBody.innerHTML += row;

                // Check if the user status has changed to "STARTED" or "END"
                if (status === 'STARTED' && !sentUsers[user]) {
                    sendUserDataToPHP(user, 'start_time');
                    sentUsers[user] = true; // Mark the user as sent
                } else if (status === 'END' && sentUsers[user]) {
                    sendUserDataToPHP(user, 'end_time');
                    sentUsers[user] = false; // Mark the user as not sent
                }
            }
        }
    }

    function sendUserDataToPHP(user, timeType) {
        var currentTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
        var params = new URLSearchParams();
        params.append('user', user);
        params.append('timeType', timeType);
        params.append(timeType, currentTime);
        console.log(params);
        fetch('../api/vehicalsentrance.php', {
            method: 'POST',
            body: params
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function sendSlotStatusToPHP(slot, status) {
        var currentTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
        var params = new URLSearchParams();
        
        params.append('slot', slot);
        params.append('status', status);
        params.append('change_time', currentTime);
        console.log(params);
        fetch('../api/parkingslot.php', {
            method: 'POST',
            body: params
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    dbRef.on('value', function(snapshot) {
        var data = snapshot.val();
        renderTables(data);
    });
</script>
</body>
</html>
