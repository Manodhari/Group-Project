<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park Manager</title>
    <link rel="icon" href="img/logo/Logo web.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/logo/icon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="container">
    <div class="container pt-4">
        <div class="d-flex justify-content-center">
            <img src="img/Logo.png" style="width: auto; height: 50px;">
        </div>
    </div>



    <Div class="p-3"></Div>


    <div class="row">

        <div class="col-12">


            <div class="d-flex justify-content-around container">
                <button type="button" class="btn btn-block"> <i class="fas fa-arrow-right "></i></button>
                <button type="button" class="btn btn-block"> <i class="fas fa-arrow-right "></i></button>
                <button type="button" class="btn btn-block"> <i class="fas fa-arrow-right "></i></button>


            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-up "></i></button>
                <button type="button" class="btn btn-secondary m-1" id="slot1">L1</button>
                <button type="button" class="btn btn-secondary m-1">L2</button>
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-down "></i></button>
                <button type="button" class="btn btn-secondary m-1">S1</button>
                <button type="button" class="btn btn-secondary m-1">S2</button>
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-down "></i></button>
                <button type="button" class="btn btn-secondary m-1">R1</button>
                <button type="button" class="btn btn-secondary m-1">R2</button>
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-down "></i></button>
            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-up "></i></button>
                <button type="button" class="btn btn-secondary m-1">L3</button>
                <button type="button" class="btn btn-secondary m-1">L4</button>
                <button type="button" class="btn btn-light"><i class="fas fa-arrow-down "></i></button>
                <button type="button" class="btn btn-secondary m-1">S3</button>
                <button type="button" class="btn btn-secondary m-1" id="slot2">S4</button>
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-down "></i></button>
                <button type="button" class="btn btn-secondary m-1">R3</button>
                <button type="button" class="btn btn-secondary m-1">R4</button>
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-down "></i></button>
            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-up "></i></button>
                <button type="button" class="btn btn-secondary m-1">L5</button>
                <button type="button" class="btn btn-secondary m-1">L6</button>
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-down "></i></button>
                <button type="button" class="btn btn-secondary m-1" id="slot3">S5</button>
                <button type="button" class="btn btn-secondary m-1" id="slot4">S6</button>
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-down "></i></button>
                <button type="button" class="btn btn-secondary m-1">R5</button>
                <button type="button" class="btn btn-secondary m-1">R6</button>
                <button type="button" class="btn btn-light "><i class="fas fa-arrow-down "></i></button>
            </div>

            <div class="d-flex justify-content-around container">
                <button type="button" class="btn btn-block"> <i class="fas fa-arrow-left "></i></button>
                <button type="button" class="btn btn-block"> <i class="fas fa-arrow-left "></i></button>
                <button type="button" class="btn btn-block"> <i class="fas fa-arrow-left "></i></button>


            </div>


        </div>

    </div>

    <div>
    </div>


    <div class="pt-4">
        <div class="">
            <div class="row">
                <div class="col-4">
                    <div class="row" style="padding: 38px;">
                        <div class="col-lg-6" style="width: 16%;">
                            <img id="upArrow" src="img/up-black.png"
                                style="width: auto; height: 100px; padding-left: 30px;">
                        </div>
                        <div class="col-lg-6" style="width: 16%;">
                            <img id="downArrow" src="img/down-black.png"
                                style="width: auto; height: 100px; padding-left: 30px;">
                        </div>
                    </div>


                </div>
                <div class="col-8">


                    <div class="row "
                        style="background-color: rgba(235, 235, 235, 0.63); border-radius: 10px; padding: 20px;">


                        <div class="col-6" style="padding-right: 30px;">
                            <h5 class="text-end" style="margin-bottom: -10px;">Booked</h5>
                            <h1 class="text-end booked-slot" style="font-size: 80px; color: rgb(189, 2, 2);">00</h1>
                        </div>

                        <div class="col-6" style="padding-right: 30px;">
                            <h5 class="text-end" style="margin-bottom: -10px;">Available</h5>
                            <h1 class="text-end available-slot" style="font-size: 80px;">18</h1>
                        </div>


                    </div>

                </div>

            </div>
        </div>


    </div>

    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
    <script src="js/script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>