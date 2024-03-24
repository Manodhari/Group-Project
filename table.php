<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parking System Status</title>
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
<h2>Parking System Slot Status</h2>
<table id="slotTable">
    <thead>
        <tr>
            <th>Slot</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
      
    </tbody>
</table>

<h2>Parking System User Status</h2>
<table id="userTable">
    <thead>
        <tr>
            <th>User</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
       
    </tbody>
</table>

<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "YOUR_API_KEY",
        authDomain: "parkingsysystem-e29b4.firebaseapp.com",
        databaseURL: "https://parkingsysystem-e29b4-default-rtdb.firebaseio.com",
        projectId: "parkingsysystem-e29b4",
        storageBucket: "parkingsysystem-e29b4.appspot.com",
        messagingSenderId: "232519263309",
        appId: "1:232519263309:web:c1c014eb77bbe0e5e62804"
    };

    firebase.initializeApp(firebaseConfig);

    var dbRef = firebase.database().ref();
    var sentUsers = {};

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

               
                if (status === 'STARTED' && !sentUsers[user]) {
                    sendUserDataToPHP(user, 'start_time');
                    sentUsers[user] = true; 
                } else if (status === 'END' && sentUsers[user]) {
                    sendUserDataToPHP(user, 'end_time');
                    sentUsers[user] = false; 
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
        fetch('api/vehicalsentrance.php', {
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
        fetch('api/parkingslot.php', {
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
