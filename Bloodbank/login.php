<?php include '../dbconfig.php';?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OBBS | Blood Bank Log in</title>
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
    <a href="../../index2.html"><b style="color: #ff5b56">OBBS | </b>Blood Bank</a>
  </div>

  <?php
    if(isset($_POST['officer-login'])){
      $mail = $_POST['officermail'];
      $psword = $_POST['officerpsword'];
      $bank_id = $_POST['bank'];
      $status = 2;
      // echo "$mail, $psword, $bank_id";
      
      // Create a mysqli connection
      $sql = "SELECT id FROM officer WHERE email = ? AND pword = ? AND o_status != ?";
      // Prepare the statement
      $stmt = mysqli_prepare($conn, $sql);
      
      // Bind parameters
      mysqli_stmt_bind_param($stmt, 'ssi', $mail, $psword, $status);
      
      // Execute the statement
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      
      $num_rows = mysqli_stmt_num_rows($stmt);
      if($num_rows > 0){
          mysqli_stmt_bind_result($stmt, $officer_id);
          mysqli_stmt_fetch($stmt);
          // Create a mysqli connection
          $sql2 = "SELECT id FROM blood_bank WHERE officer_id = ? AND bank_status != ?";
          // Prepare the statement
          $stmt2 = mysqli_prepare($conn, $sql2);
          
          // Bind parameters
          mysqli_stmt_bind_param($stmt2, 'ii', $officer_id, $status);
          
          // Execute the statement
          mysqli_stmt_execute($stmt2);
          mysqli_stmt_store_result($stmt2);
          $num_banks = mysqli_stmt_num_rows($stmt2);

          if($num_banks > 0){
              
            mysqli_stmt_bind_result($stmt2, $bank_id);
            mysqli_stmt_fetch($stmt2);

            // Start a session
            session_start();
            
            // Set session variables
            $_SESSION['officer_id'] = $officer_id;
            $_SESSION['bank_id'] = $bank_id;
            
            // Redirect to the user's profile page
            echo '<div class="alert bg-success">Login Successful</div>';

            // Redirect to the login page after 3 seconds
            echo '<script>setTimeout(function() { window.location.href = "index.php"; }, 3000);</script>';
          }else{
            // Display the error message with the styled alert
            echo '<div class="alert bg-danger">Permission Denied for the selected Bank </div>'; 
          }
          
          mysqli_stmt_close($stmt2);
        } else {
          // Display the error message with the styled alert
          echo '<div class="alert bg-danger">Invalid Email or Password' . mysqli_error($conn).'</div>';
      }

      // Close the statement
      mysqli_stmt_close($stmt);
    }
    ?>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="post" name="officer-login" id="officer-login" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php
          include '../dbconfig.php';
          // Retrieve the list of blood types from the database using a prepared statement
            $sql = "SELECT id, bank_name FROM blood_bank WHERE officer_id IS NOT NULL AND bank_status != 2;";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $bankid, $bankname);
            
            // Fetch the results and store them in an array
            $banks = array();
            while (mysqli_stmt_fetch($stmt)) {
                $banks[] = array('id' => $bankid, 'bank_name' => $bankname);
            }
            
            // Close the statement
            mysqli_stmt_close($stmt);
        ?>
        <div class="input-group mb-3">
          <select name="bank" id="bank" class="form-control" >
              <option value="">~Select blood Bank~</option>
              <?php foreach ($banks as $bank): ?>
                <option value="<?php echo $bank['id']; ?>"><?php echo $bank['bank_name']; ?></option> 
              <?php endforeach; ?>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-university"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="officermail" class="form-control" placeholder="Admin Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="officerpsword" class="form-control" placeholder="Admin Password">
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
            <button type="submit" name="officer-login" class="btn btn-danger btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
      <p class="mb-0">
        <a href="../RegistrationReq/requestreg.php" class="text-center">Request Registration as Bank Officer?</a>
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
