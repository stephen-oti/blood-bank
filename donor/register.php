<?php
include '../dbconfig.php';

$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OBBS | Donor Registration</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .alert {
    padding: 12px 16px;
    margin-bottom: 15px;
    transition: opacity 2s ease-in-out;
    opacity: 1;
    }
    .alert.hide {
      opacity: 0;
    }
  </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b style="color: #ff5b56">OBBS | </b>Donor Reg</a>
  </div>
  <?php
    if(isset($_POST['submit'])){
      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $mail = $_POST['mail'];
      $phone = $_POST['phone'];
      $dob = $_POST['dob'];
      $address = $_POST['address'];
      $county = strtoupper(trim($_POST['county']));
      $psword = $_POST['psword'];
      $gender = $_POST['gender'];
      
        // Create a mysqli connection
      $sql = "INSERT INTO donor(fname,lname,email,phone,bday,address,county,pword,gender) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
      // Prepare the statement
      $stmt = mysqli_prepare($conn, $sql);

      // Bind parameters
      mysqli_stmt_bind_param($stmt, 'sssssssss', $fname, $lname, $mail, $phone, $dob, $address, $county, $psword, $gender);
      
      if(!empty($fname) && !empty($lname)&& !empty($mail)&& !empty($phone)&& !empty($dob)&& !empty($address)&& !empty($county)&& !empty($psword)){
        // Execute the statement
          mysqli_stmt_execute($stmt);

          // Check for errors
          if(mysqli_stmt_error($stmt)) {
              // Display the error message with the styled alert
              echo '<div class="alert bg-danger">Error while updating Donor to the database</div>';
          } else {
            $d_id = mysqli_insert_id($conn);
            $user_type = 'donor';

            // Insert a new record into the questionnaire table with default values
            $stmnt = mysqli_prepare($conn, "INSERT INTO questionnaire (user_type, d_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10) VALUES (?, ?, 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no')");
            mysqli_stmt_bind_param($stmnt, "si", $user_type, $d_id);
            mysqli_stmt_execute($stmnt);
            if(mysqli_stmt_error($stmnt)){
              echo '<div class="alert bg-danger">User details could not be loaded to the quesstionnaire</div>';
            } else{
              
              // Display the success message with the styled alert
              echo '<div class="alert bg-success">Successful Registration</div>';

              // Redirect to the login page after 3 seconds
              echo '<script>setTimeout(function() { window.location.href = "login.php"; }, 3000);</script>';
            }
             
          }
          } else {
              // // Display the error message with the styled alert
              echo '<div class="alert bg-danger">Make Sure all fields are filled in</div>';
          }
    }
  ?>
  
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register as a Donor</p>
      <!-- This is where Response happens -->
      <form method="post" name="donor-register" id="donor-register" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <span class="response" data-input="fname"></span>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" onkeyup="validateInput('fname')">  
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>    
          </div>  
        </div>
        `<span class="response" data-input="lname"></span>`
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" onkeyup="validateInput('lname')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <select class="form-control" name="gender" id="gender">
              <option value="">~ Gender ~</option>
              <option value="male">Male</option>
              <option value="female">FeMale</option>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
        </div>
        <span class="response" data-input="mail"></span>
        <div class="input-group mb-3">
          <input type="email" class="form-control" id="mail" name="mail" placeholder="Email" onkeyup="validateInput('mail')">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <span class="response" data-input="phone"></span>
        <div class="input-group mb-3">
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone" onkeyup="validateInput('phone')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
        </div>
        <span class="response" data-input="dob"></span>
        <div class="input-group mb-3">
            <input type="date" class="form-control" id="dob" name="dob" placeholder="DOB" onchange="validateInput('dob')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-calendar"></span>
              </div>
            </div>
        </div>
        <span class="response" data-input="address"></span>
        <div class="input-group mb-3">
          <input class="form-control" id="address" name="address" placeholder="Provide Your address..." onkeyup="validateInput('address')">
        <!-- </textarea> -->
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-home"></span>
            </div>
          </div>
        </div>
        <span class="response" data-input="county"></span>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="county" name="county" placeholder="County" onkeyup="validateInput('county')">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
      </div>
      <span class="response" data-input="psword"></span>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="psword" name="psword" placeholder="Password" onkeyup="validateInput('psword')">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="submit" id="submit" class="btn btn-danger btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <a href="login.php" class="text-center">Already registered? </a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>
<script>
function validateInput(inputName) {
  var inputVal = $("input[name='" + inputName + "']").val();
  var responseSpan = $("span[data-input='" + inputName + "']");
  console.log(inputVal);
  $.ajax({
    url: "validation.php",
    type: "POST",
    data: {
      field: inputName,
      value: inputVal },
    success: function(response) {
      if (responseSpan.length) {
        responseSpan.html(response);
      }
    }
  });
}

</script>
</body>
</html>
