<?php
include '../dbconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OBBS | Administrator RequestForm</title>
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
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index2.html"><b style="color: #ff5b56">OBBS | </b>Request Form</a>
  </div>
  <?php
    if(isset($_POST['submit'])){
      $role = $_POST['role'];
      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $mail = $_POST['mail'];
      $phone = $_POST['phone'];
      $psword = $_POST['psword'];
      $reg_date = date("Y-m-d");
      $reg_status = 0;

      if ($_FILES['customFile']['size'] > 0) {
        $file_name = $role.'_'.$fname.'_'.$phone.'.pdf';
            // Upload the file to the server
            $target_dir = "uploads/";
            $target_file = $target_dir . $file_name;
            move_uploaded_file($_FILES['customFile']['tmp_name'], $target_file);
        
            // Update the patient record in the database
            $sql = "INSERT INTO reg_request(req_role,fname,lname,email, phone, pword, req_doc, req_status, reg_date) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'sssssssis',$role, $fname, $lname, $mail, $phone, $psword, $file_name, $reg_status, $reg_date);
            if(!empty($role) && !empty($fname) && !empty($lname)&& !empty($mail)&& !empty($phone)&& !empty($psword)){
              // Execute the statement
                mysqli_stmt_execute($stmt);
                // Check for errors
                if(mysqli_stmt_error($stmt)) {
                    // Display the error message with the styled alert
                    echo '<div class="alert bg-danger">Error while updating record, Try again later</div>';
                } else { 
                    // Display the success message with the styled alert
                    echo '<div class="alert bg-success">Your Request Successfully submitted. Keep posted on your mail for a reply soon</div>';  
                    // Redirect to the login page after 3 seconds
                    echo '<script>setTimeout(function() { window.location.href = "../index.php"; }, 3000);</script>'; 
                }
            } else {
                // // Display the error message with the styled alert
                echo '<div class="alert bg-danger">Make Sure all fields are filled in</div>';
                
            }
      }else{
        echo '<div class="alert bg-danger">You did not upload your Qualifications</div>';
      }

    }
  ?>
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Request Registration as Admin/officer</p>
      <form method="post" name="req_reg" id="req_reg" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <div class="input-group mb-3" name="role" id="role">
            <select name="role" id="role" class="form-control">
              <option value=" ">~Role~</option>
              <option value="admin">Administrator</option>
              <option value="bank_officer">Bank Officer</option>
            </select>
        </div>
        <span class="response" data-input="fname"></span>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="fname" placeholder="First name" onkeyup="validateInput('fname')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <span class="response" data-input="lname"></span>
          <div class="input-group mb-3">
              <input type="text" class="form-control" name="lname" placeholder="Last Name" onkeyup="validateInput('lname')">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
          </div>
          <span class="response" data-input="mail"></span>
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="mail" placeholder="Email" onkeyup="validateInput('mail')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <span class="response" data-input="phone"></span>
          <div class="input-group mb-3">
              <input type="tel" class="form-control" name="phone" placeholder="Phone" onkeyup="validateInput('phone')">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-phone"></span>
                </div>
              </div>
          </div>
          <div class="form-group">
            <label for="customFile">Upload Qualification Document</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="customFile" name="customFile" accept=".pdf">
              <label class="custom-file-label" for="customFile">PDF only</label>
            </div>
          </div>
          <span class="response" data-input="psword"></span>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="psword" onkeyup="validateInput('psword')">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="submit" id="regreqbtn" class="btn btn-danger btn-block">Request</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
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
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
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
    url: "regreq_validation.php",
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
