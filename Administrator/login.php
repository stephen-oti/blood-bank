<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OBBS | Admin Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../index.html"><b style="color: #ff5b56">OBBS | </b>Administrator</a>
  </div>
    <?php
  include '../dbconfig.php';
  if(isset($_POST['admin-login'])){
      $mail = $_POST['mail'];
      $psword = $_POST['psword'];
      
      // Create a mysqli connection
      $sql = "SELECT id, a_role FROM admin WHERE email=? AND pword=? AND admin_status = 1";
      // Prepare the statement
      $stmt = mysqli_prepare($conn, $sql);
      
      // Bind parameters
      mysqli_stmt_bind_param($stmt, 'ss', $mail, $psword);
      
      // Execute the statement
      mysqli_stmt_execute($stmt);
      
      // Bind the results
      mysqli_stmt_bind_result($stmt, $id, $role);
      
      // Fetch the results
      mysqli_stmt_fetch($stmt);
      
      // Close the statement
      mysqli_stmt_close($stmt);
      
      // Check if the user exists
      if(isset($id)){
          // Start a session
          session_start();
          
          // Set session variables
          $_SESSION['admin_id'] = $id;
          $_SESSION['role'] = $role;

          // Redirect to the user's profile page
          echo '<div class="alert bg-success">Login Successful</div>';

          // Redirect to the login page after 3 seconds
          echo '<script>setTimeout(function() { window.location.href = "index.php"; }, 3000);</script>';
      } else {
          // Display the error message with the styled alert
          echo '<div class="alert bg-danger">Invalid Email or Password</div>';
      }
    }
    ?>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your Administrator session</p>

      <form  method="post" name="admin-login" id="admin-login" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="input-group mb-3">
          <input type="email" name="mail" class="form-control" placeholder="Admin Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name = "psword" class="form-control" placeholder="Admin Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" required>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="admin-login" class="btn btn-danger btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
      <p class="mb-0">
        <a href="../RegistrationReq/requestreg.php" class="text-center">Request as Administrator Registration</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>
