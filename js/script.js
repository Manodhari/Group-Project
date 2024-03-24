
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

dbRef.on('value', function (snapshot) {
    var slotsData = snapshot.val();
    updateCards(slotsData);
    updateStatus(slotsData);
});

function updateCards(slotsData) {
    var availableCount = 0;
    var bookedCount = 0;
    var totalCount = 0;

    for (var key in slotsData) {
        totalCount++;
        if (slotsData[key] === 'AVAILABLE') {
            availableCount++;
        } else if (slotsData[key] === 'BOOKED') {
            bookedCount++;
        }
        var slotId = key.split(' ')[1];
        var status = slotsData[key];
        var colorClass = (status === 'AVAILABLE') ? 'btn-secondary' : 'btn-success';

        var card = document.getElementById('slot' + slotId);
        if (card) {
            card.className = 'btn m-1 ' + colorClass;
        }
    }

    var availableSlot = document.querySelector('.available-slot');
    if (availableSlot) {
        availableSlot.textContent = availableCount;
    }

    var bookedSlot = document.querySelector('.booked-slot');
    if (bookedSlot) {
        bookedSlot.textContent = bookedCount;
    }
}

var previousStatuses = {};

function updateStatus(slotsData) {
    for (var key in slotsData) {
        if (key.includes("User_No_")) {
            var statusObj = slotsData[key];
            var status = statusObj.Status;

            if (!previousStatuses[key] || previousStatuses[key] !== status) {
                previousStatuses[key] = status;

                var upArrowImg = document.getElementById('upArrow');
                var downArrowImg = document.getElementById('downArrow');

                if (status === "STARTED") {
                    if (upArrowImg && upArrowImg.src !== "img/up-red.png") {
                        upArrowImg.src = "img/up-red.png";
                    }
                    if (downArrowImg && downArrowImg.src !== "img/down-black.png") {
                        downArrowImg.src = "img/down-black.png";
                    }

                    setTimeout(function () {
                        if (upArrowImg) {
                            upArrowImg.src = "img/up-black.png";
                        }
                    }, 2000);
                } else if (status === "END") {
                    if (downArrowImg && downArrowImg.src !== "img/down-red.png") {
                        downArrowImg.src = "img/down-red.png";
                        setTimeout(function () {
                            if (downArrowImg) {
                                downArrowImg.src = "img/down-black.png";
                            }
                        }, 2000);
                    }
                    if (upArrowImg && upArrowImg.src !== "img/up-black.png") {
                        upArrowImg.src = "img/up-black.png";
                    }
                } else {
                    if (upArrowImg && upArrowImg.src !== "img/up-black.png") {
                        upArrowImg.src = "img/up-black.png";
                    }
                    if (downArrowImg && downArrowImg.src !== "img/down-black.png") {
                        downArrowImg.src = "img/down-black.png";
                    }
                }

                console.log(key);
                console.log("Status: " + status);
            }
        }
    }
}
