
<!DOCTYPE html>
<html lang="en">

<!-- Header -->
<?php include 'includes/header.php'?>
<!-- /.Header -->

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'includes/sidebar.php'?>
  <!-- /.Main Sidebar Container -->
  
  <?php

    // Retrieve the patient details from the database using prepared statements
    $sql = "SELECT * FROM donor WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the results and store the patient details in a variable
    if ($row = mysqli_fetch_assoc($result)) {
      $donor_details = $row;
    }
    
    // Close the statement and database connection
    mysqli_stmt_close($stmt);

  ?>
    <?php

    // Retrieve the patient details from the database using prepared statements
    $sql = "SELECT q1, q2, q3, q4, q5, q6, q7, q8, q9, q10 FROM questionnaire WHERE d_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the results and store the patient details in a variable
    if ($row = mysqli_fetch_assoc($result)) {
      $donor_quiz = $row;
    }
    // Close the statement and database connection
    mysqli_stmt_close($stmt);

  ?>
  <?php
  // Check if the form has been submitted
  if(isset($_POST['update-pi'])) {
    $donor_id = $_SESSION['id'];
    // Get the updated values from the form
    $blood_group = intval($_POST['blood_group']);
    $latitude = $_POST['lat'];
    $longitude = $_POST['long'];
    $d_status = 1;

    // Check if a medical condition was selected
    if($_POST['condition-select'] == 'yes') {
      // $has_condition = 1;
      $medical_condition = $_POST['condition'];
    } else {
      // $has_condition = 0;
      $medical_condition = "None";
    }
  if ($_FILES['customFile']['size'] > 0) {
    $file_name = 'donor_' . str_pad($_SESSION['id'], 7, '0', STR_PAD_LEFT) . '_' . time() . '.pdf';
    // Search for existing files with the same name pattern
    $existing_files = glob("uploads/donor_" . str_pad($_SESSION['id'], 7, '0', STR_PAD_LEFT) . '_*.pdf');


    // Delete any existing files
    foreach($existing_files as $existing_file) {
      unlink($existing_file);
    }
        // Upload the file to the server
        $target_dir = "uploads/";
        $target_file = $target_dir . $file_name;
        move_uploaded_file($_FILES['customFile']['tmp_name'], $target_file);
    
        // Update the patient record in the database
        $sql = "UPDATE donor SET blood_id = ?, d_cond = ?, d_lat = ?, d_lon = ?, d_report = ? ,d_status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isddsii", $blood_group, $medical_condition, $latitude, $longitude, $file_name,$d_status, $donor_id);
  }else{
    $sql = "UPDATE donor SET blood_id = ?, d_cond = ?, d_lat = ?, d_lon = ?, d_status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isddii", $blood_group, $medical_condition, $latitude, $longitude, $d_status, $donor_id);
  }
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if(mysqli_stmt_affected_rows($stmt) > 0) {
      echo '<meta http-equiv="refresh" content="2">';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Update failed. Please try again.</div>';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
  }
?>

<?php
  // Check if the form has been submitted
  if(isset($_POST['update-quiz'])) {
    // Get the updated values from the form
    $q1 = $_POST['q1'];
    $q2 = $_POST['q2'];
    $q3 = $_POST['q3'];
    $q4 = $_POST['q4'];
    $q5 = $_POST['q5'];
    $q6 = $_POST['q6'];
    $q7 = $_POST['q7'];
    $q8 = $_POST['q8'];
    $q9 = $_POST['q9'];
    $q10 = $_POST['q10'];
    $last_update_time = date('Y-m-d H:i:s');

      // Update the record in the questionnaire table
      $stmt = mysqli_prepare($conn, "UPDATE questionnaire SET q1 = ?, q2 = ?, q3 = ?, q4 = ?, q5 = ?, q6 = ?, q7 = ?, q8 = ?, q9 = ?, q10 = ?, last_update_time = ? WHERE user_type = ? AND d_id = ?");
      mysqli_stmt_bind_param($stmt, "ssssssssssssi", $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10,$last_update_time, $user_type, $d_id);
  
      // Set the parameters and execute the statement
      $user_type = 'donor';
      $d_id = $_SESSION['id'];
      mysqli_stmt_execute($stmt);
  
      // Check if the update was successful
      if(mysqli_stmt_affected_rows($stmt) > 0) {
        echo '<meta http-equiv="refresh" content="2">';
      } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Error updating quiz: " . mysqli_error($conn)."</div>";
      }
      
      // Close the statement
      mysqli_stmt_close($stmt);
    
  }
  
?>
<?php
  if(isset($_POST['update-profile'])) {
    $donor_id = $_SESSION['id'];
    // Get the updated values from the form
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mail = $_POST['mail'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $county = strtoupper(trim($_POST['county']));
    $psword = $_POST['psword'];
    $gender = $_POST['gender'];
  
    // Update the patient record in the database
    $sql = "UPDATE donor SET fname = ?, lname = ?, email = ?, phone = ?, bday = ?, address = ?, county = ?, pword = ?, gender = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssssi", $fname, $lname, $mail, $phone, $dob, $address, $county, $psword, $gender, $donor_id);
    mysqli_stmt_execute($stmt);
  
    // Check if the update was successful
    if(mysqli_stmt_affected_rows($stmt) > 0) {
      echo '<meta http-equiv="refresh" content="2">';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Update failed. Please try again.</div>';
    }
  
    // Close the statement
    mysqli_stmt_close($stmt);
  }
?>

  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Donor</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-hand-holding-heart"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">My Donations</span>
                  <span class="info-box-number">7</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-calendar-alt"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Recommended Next Donation</span>
                  <span class="info-box-number"><?php if($donor_details['d_next'] == Null) { 
                    echo "Pending first Donation";
                  } else {
                    echo $donor_details['d_next'];
                  }
                    ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-fire"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Blood Group</span>
                  <span class="info-box-number"><?php if($donor_details['blood_id'] == Null) { 
                    echo "Pending Update";
                  } else {
                    if($donor_details['blood_id'] != NUll){
                      $sql = "SELECT id, b_name FROM blood_type WHERE id = ?";
                      $stmt = mysqli_prepare($conn, $sql);
                      mysqli_stmt_bind_param($stmt, "i", $donor_details['blood_id']);
                      mysqli_stmt_execute($stmt);
                      mysqli_stmt_bind_result($stmt, $id, $bname);
                      mysqli_stmt_fetch($stmt);
                      mysqli_stmt_close($stmt);
                      echo $bname;
                     }
                  }
                    ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        <div class="row">
          <div class="col-md-6">

            <!-- Profile Image -->
            <div class="card card-danger card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="../dist/img/donor-avatar.jpeg"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo strtoupper($donor_details['lname']).", ".$donor_details['fname'];?></h3>

                <p class="text-muted text-center">Donor</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Gender</b><a class="float-right"><?php echo $donor_details['gender'];?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Date of Birth</b> <a class="float-right"><?php echo $donor_details['bday'];?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Mail</b><a class="float-right"><?php echo $donor_details['email'];?></a>
                  </li>
                </ul>

                <!-- <a href="#" class="btn btn-success btn-block"><i class="fas fa-edit"></i><b>&nbsp;Update profile</b></a> -->
                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-default">
                  <i class="fas fa-edit"></i> Update Profile
                </button>
              </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
         
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-6 card card-danger">
            <div class="card-header">
              <h3 class="card-title">Personal Information</h3>
              <div class="float-right"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#modal-pi"><i class="fas fa-edit"></i><b>&nbsp;Edit</b></a></div>
              
              
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <strong><i class="fas fa-phone mr-1 text-danger"></i> Contact</strong>

              <p class="text-muted"><?php echo $donor_details['phone'];?></p>
              <hr>

              <strong><i class="fas fa-file-medical-alt mr-1 text-danger"></i> Medical Condition</strong>

              <p class="text-muted"><?php echo $donor_details['d_cond'];?></p>

              <hr>

              <strong><i class="fas fa-map-marker-alt mr-1 text-danger"></i> Physical Address</strong>
                <address class="text-muted">
                  <strong><?php echo $donor_details['fname']." ".$donor_details['lname'];?></strong><br>
                  P.O. Box. <?php echo $donor_details['address'];?><br>
                  <?php echo $donor_details['county'];?>, KENYA<br>
                </address>
                <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal-qedit">
                  <i class="fas fa-edit"></i> Update/Fill Questionnaire
                </button>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update profile</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="post" name="donor-update" id="donor-update" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <span class="response" data-input="fname"></span>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" onkeyup="validateInput('fname')" value="<?php echo $donor_details['fname'] ? $donor_details['fname'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <span class="response" data-input="lname"></span>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" onkeyup="validateInput('lname')" value="<?php echo $donor_details['lname'] ? $donor_details['lname'] : '' ?>">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <select class="form-control" name="gender" id="gender">
                    <option value="">~ Gender ~</option>
                    <option value="male" <?php echo ($donor_details['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($donor_details['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                </select>           
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
            </div>
            <span class="response" data-input="mail"></span>
            <div class="input-group mb-3">
              <input type="email" class="form-control" id="mail" name="mail" placeholder="Email" onkeyup="validateInput('mail')" value="<?php echo $donor_details['email'] ? $donor_details['email'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <span class="response" data-input="phone"></span>
            <div class="input-group mb-3">
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone" onkeyup="validateInput('phone')" value="<?php echo $donor_details['phone'] ? $donor_details['phone'] : '' ?>">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
            </div>
            <span class="response" data-input="dob"></span>
            <div class="input-group mb-3">
                <input type="date" class="form-control" id="dob" name="dob" placeholder="DOB" onchange="validateInput('dob')" value="<?php echo $donor_details['bday'] ? $donor_details['bday'] : '' ?>">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-calendar"></span>
                  </div>
                </div>
            </div>
            <span class="response" data-input="address"></span>
            <div class="input-group mb-3">
              <input class="form-control" id="address" name="address" placeholder="Provide Your address..." onkeyup="validateInput('address')" value="<?php echo $donor_details['address'] ? $donor_details['address'] : '' ?>">
            <!-- </textarea> -->
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-home"></span>
                </div>
              </div>
            </div>
            <span class="response" data-input="county"></span>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="county" name="county" placeholder="County" onkeyup="validateInput('county')" value="<?php echo $donor_details['county'] ? $donor_details['county'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
          </div>
          <span class="response" data-input="psword"></span>
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="psword" name="psword" placeholder="Password" onkeyup="validateInput('psword')" value="<?php echo $donor_details['pword']; ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="update-profile" id="submit" class="btn btn-success btn-block">Update</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  

  <div class="modal fade" id="modal-pi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update personal Info</h4>
          <button type="button" class="close" style="outline:none" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form name="donor-pi" id="donor-pi" method="post" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <label for="">Health Details <span style="font-size: small; color:red; font-style: italic;">(Provide accurate/verifiable details to qualify)</span></label>
                <?php
                    // Retrieve the list of blood types from the database using a prepared statement
                    $sql = "SELECT id, b_name FROM blood_type";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $id, $bname);

                    // Fetch the results and store them in an array
                    $blood_types = array();
                    while (mysqli_stmt_fetch($stmt)) {
                        $blood_types[] = array('id' => $id, 'b_name' => $bname);
                    }

                    // Close the statement
                    mysqli_stmt_close($stmt);
                ?>

              <div class="input-group mb-3">
                <select name="blood_group" id="blood_group" class="form-control" required>
                  <option value="">~ Select Blood Group ~</option>
                  <?php foreach ($blood_types as $blood_type): ?>
                    <option value="<?php echo $blood_type['id']; ?>" <?php echo ($donor_details['blood_id'] == $blood_type['id']) ? 'selected' : ''; ?>>
                      <?php echo $blood_type['b_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                
                <!-- </div> -->
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-users"> Blood group</span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <select name="condition-select" name="condition-select" id="condition-select" class="form-control" required>
                  <option value="">~Any Pre-existing medical condition~</option>
                  <option value="None">No</option>
                  <option value="yes">Yes</option>
                </select>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-pills"> Condition</span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3" id="condition-div" style="display: none;">
                <textarea class="form-control" name="condition" placeholder="Briefly describe the medical condition..." style="resize:none;" name="condition" id="condition" cols="30"><?php echo $donor_details['d_cond'] ? $donor_details['d_cond'] : '' ?></textarea>
              </div>
              <span id="fileResponse"></span>
              <div class="form-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="customFile" id="customFile" accept=".pdf" value="<?php echo $donor_details['d_report'] ? $donor_details['d_report'] : '' ?>">
                  <label class="custom-file-label" for="customFile"> <?php echo $donor_details['d_report'] ? $donor_details['d_report'] : '~Upload PDF medical report~' ?></label>
                </div>
              </div>
              <label for="location">Location Details <span style="font-size: small; color:red; font-style: italic;">(Get details using Google Maps and paste here)</span></label>
              <span class="response" data-input="lat"></span>
              <div class="input-group mb-3">
                  <input type="text" class="form-control" name="lat" id="lat" placeholder="Latitude" onkeyup="validateInput('lat')" value="<?php echo $donor_details['d_lat'] ? $donor_details['d_lat'] : '' ?>" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-globe"> Latitude</span>
                    </div>
                  </div>
              </div>
              <span class="response" data-input="long"></span>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="long" id="long" placeholder="Longitude" onkeyup="validateInput('long')" value="<?php echo $donor_details['d_lon'] ? $donor_details['d_lon'] : '' ?>" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-globe"> Longitude</span>
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-8">
                  
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="update-pi" id="update-pi" class="btn btn-success btn-block">Update</button>
                </div>
                <!-- /.col -->
              </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <div class="modal fade" id="modal-qedit">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Questionnaire</h4>
          <button type="button" class="close" style="outline:none" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" name="donor-quiz" id="donor-quiz" method="post" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group row">
              <label class="col-sm-9 col-form-label">Have you traveled outside the country in the past 28 days?</label>
              <div class="col-sm-3">
              <select name="q1" id="q1" class="form-control">
                <option value="no" <?php echo ($donor_quiz['q1'] == 'no') ? 'selected' : ''; ?>>No</option>
                <option value="yes" <?php echo ($donor_quiz['q1'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
              </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-9 col-form-label">Have you had any tattoos or body piercings in the past 12 months?</label>
              <div class="col-sm-3">
              <select name="q2" id="q2" class="form-control">
                <option value="no" <?php echo ($donor_quiz['q2'] == 'no') ? 'selected' : ''; ?>>No</option>
                <option value="yes" <?php echo ($donor_quiz['q2'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
              </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-9 col-form-label">Have you had a fever or been sick in the past 48 hours?</label>
              <div class="col-sm-3">
              <select name="q3" id="q3" class="form-control">
                <option value="no" <?php echo ($donor_quiz['q3'] == 'no') ? 'selected' : ''; ?>>No</option>
                <option value="yes" <?php echo ($donor_quiz['q3'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
              </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-9 col-form-label">Have you ever tested positive for HIV/AIDS or other STIs?</label>
              <div class="col-sm-3">
              <select name="q4" id="q4" class="form-control">
                <option value="no" <?php echo ($donor_quiz['q4'] == 'no') ? 'selected' : ''; ?>>No</option>
                <option value="yes" <?php echo ($donor_quiz['q4'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
              </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-9 col-form-label">Have you ever used intravenous drugs, or shared needles with anyone?</label>
              <div class="col-sm-3">
              <select name="q5" id="q5" class="form-control">
                <option value="no" <?php echo ($donor_quiz['q5'] == 'no') ? 'selected' : ''; ?>>No</option>
                <option value="yes" <?php echo ($donor_quiz['q5'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
              </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-9 col-form-label">Have you ever been diagnosed with hepatitis or jaundice?</label>
              <div class="col-sm-3">
              <select name="q6" id="q6" class="form-control">
                <option value="no" <?php echo ($donor_quiz['q6'] == 'no') ? 'selected' : ''; ?>>No</option>
                <option value="yes" <?php echo ($donor_quiz['q6'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
              </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-9 col-form-label">Have you had sexual contact with anyone who has tested positive for HIV or hepatitis?</label>
              <div class="col-sm-3">
              <select name="q7" id="q7" class="form-control">
                <option value="no" <?php echo ($donor_quiz['q7'] == 'no') ? 'selected' : ''; ?>>No</option>
                <option value="yes" <?php echo ($donor_quiz['q7'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
              </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-9 col-form-label">Have you received a blood transfusion or organ transplant in the past 12 months?</label>
              <div class="col-sm-3">
              <select name="q8" id="q8" class="form-control">
                <option value="no" <?php echo ($donor_quiz['q8'] == 'no') ? 'selected' : ''; ?>>No</option>
                <option value="yes" <?php echo ($donor_quiz['q8'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
              </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-9 col-form-label">Have you ever been diagnosed with a bleeding disorder or taken blood thinners?</label>
              <div class="col-sm-3">
                <select name="q9" id="q9" class="form-control">
                  <option value="no" <?php echo ($donor_quiz['q9'] == 'no') ? 'selected' : ''; ?>>No</option>
                  <option value="yes" <?php echo ($donort_quiz['q9'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-9 col-form-label">Are you a lactating mother or have you given birth recently?</label>
              <div class="col-sm-3">
              <select name="q10" id="q10" class="form-control">
                <option value="no" <?php echo ($donor_quiz['q10'] == 'no') ? 'selected' : ''; ?>>No</option>
                <option value="yes" <?php echo ($donor_quiz['q10'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
              </select>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="update-quiz" class="btn btn-success btn-block">Update</button>

              </div>
              <!-- /.col -->
            </div>
            <!-- /.card-footer -->
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- /.Footer -->

</div>
<!-- ./wrapper -->
<script>
  const conditionSelect = document.getElementById('condition-select');
  const conditionDiv = document.getElementById('condition-div');
  const condition = document.getElementById('condition');

  conditionSelect.addEventListener('change', function() {
    if (conditionSelect.value === 'yes') {
      conditionDiv.style.display = 'block';
      condition.required = true;
    } else {
      conditionDiv.style.display = 'none';
      condition.required = false;
    }
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
<script>
// Get the file input element
const fileInput = document.getElementById('customFile');

// Get the submit button element
const submitBtn = document.getElementById('update-pi');

// Get the response element
const response = document.getElementById('fileResponse');

// Add event listener for when the file input changes
fileInput.addEventListener('change', function() {
    // Get the selected file
    const file = fileInput.files[0];

    // Check if file is a PDF
    if (file && file.type !== 'application/pdf') {
        // Display error message
        response.innerHTML = '<span class="text-danger">Only PDF files are allowed</span>';

        // Disable submit button
        submitBtn.disabled = true;

        // Clear file input
        fileInput.value = '';
    } else {
        // Clear any error messages
        response.innerHTML = '';

        // Enable submit button
        submitBtn.disabled = false;
    }
});

// Add event listener for when the file input is cancelled
fileInput.addEventListener('click', function() {
    // Clear any error messages
    response.innerHTML = '';

    // Clear file input
    fileInput.value = '';
});
</script>
<?php if($donor_details['d_status'] != 1){ ?>
<script>
  $(document).ready(function() {
  $('#modal-pi').modal('show');
});
</script>
<?php } ?>
</body>
</html>
