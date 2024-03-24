<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warden Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">

</head>
<body class="login-body">
    <div class="container">
      <div class="login-container">
      <div class="d-flex justify-content-center">
            <img src="../img/Logo.png" style="width: auto; height: 60px;">
        </div>
        <br>
        <form id="loginForm">
          <div class="mb-3">
            <label for="username" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" placeholder="Enter your Email">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter your password">
          </div>
          <div class="d-grid justify-content-center">
            <button type="submit" class="btn btn-primary " style="  width: 146px;
  height: 40px;">Login</button>
          </div>
        </form>
      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
  $(document).ready(function() {
    $('#loginForm').submit(function(event) {
      event.preventDefault();
      
      var email = $('#email').val(); 
      var password = $('#password').val();
   
      $.ajax({
        type: 'POST',
        url: '../api/login.php',
        data: {
          email: email, 
          password: password,
          label: 'admin' 
        },
        success: function(response) {
          console.log(response);
          if (response.success) {
            window.location.href = 'home.php';
          } else {
            alert(response.message);
          }
        }
      });
    });
  });
</script>

  </body>
</html>
