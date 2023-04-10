<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
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
              <li class="breadcrumb-item"><a href="#">Blood Bank</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<?php
      // Check if the form has been submitted
      if(isset($_POST['update-bank-profile'])) {
        // Get the updated values from the form
        $bankname = $_POST['bankname'];
        $mail = $_POST['bankmail'];
        $phone = $_POST['bankphone'];
        $address = $_POST['bankaddress'];
        $county = strtoupper(trim($_POST['bankcounty']));
        $lat = $_POST['banklat'];
        $lon = $_POST['banklon'];
        $bankid = $_POST['bankid'];
          // Update the record in the Blood bank table
          $stmt = mysqli_prepare($conn, "UPDATE blood_bank SET bank_name = ?, email = ?, phone = ?, address = ?, county = ?, lat= ?, lon = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "sssssddi", $bankname, $mail, $phone, $address, $county, $lat, $lon, $bankid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Blood Bank Profile Updated Successfully</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error updating Blood Bank: " . mysqli_error($conn)."</div>";
          }
          
          // Close the statement
          mysqli_stmt_close($stmt);
        
      }
?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">
  
              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="../dist/img/bank-avatar.png"
                         alt="User profile picture">
                  </div>
  
                  <h3 class="profile-username text-center">Blood Bank</h3>
  
                  <p class="text-muted text-center"><?php echo $bank_details['bank_name'];?></p>
                  
                  <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-default"><i class="fas fa-edit"></i><b> Update Profile</b></a>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <!-- <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Statistics</a></li> -->
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Current Information</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Site Location</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">

                    <!-- /.tab-pane -->
                    <div class="active tab-pane" id="activity">
                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                          <div class="info-box">
                            <div class="info-box-content">
                              <strong class="info-box-text"><i class="fas fa-envelope mr-1"></i> Email</strong>
                              <span class="info-box-number text-muted"><?php echo $bank_details['email'];?></span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                          <div class="info-box">
                            <div class="info-box-content">
                              <strong class="info-box-text"><i class="fas fa-address-book mr-1"></i> Address</strong>
                              <span class="info-box-number text-muted"><?php echo $bank_details['address'];?></span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- Post -->
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                          <div class="info-box">
                            <div class="info-box-content">
                              <strong class="info-box-text"><i class="fas fa-phone mr-1"></i> Phone</strong>
                              <span class="info-box-number text-muted"><?php echo $bank_details['phone'];?></span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                          <div class="info-box">
                            <div class="info-box-content">
                              <strong class="info-box-text"><i class="fas fa-map-pin mr-1"></i> County</strong>
                              <span class="info-box-number text-muted"><?php echo $bank_details['county'];?></span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- Post -->
                      </div>
                    </div>
                    <!-- /.tab-pane -->
  
                    <div class="tab-pane" id="settings">
                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5374.699792734222!2d34.596565374292375!3d-0.005905390202308548!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182aa9f1efed77e9%3A0xb9c8a555cc010ad6!2sMaseno%20University-Kisumu%20Campus!5e0!3m2!1sen!2ske!4v1676045331090!5m2!1sen!2ske" frameborder="0" style="border:0; width: 100%; height: 250px;" allowfullscreen></iframe>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.nav-tabs-custom -->
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
        <form method="post" name="update-bank-profile" role="update-bank-profile" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden"  name="bankid" value="<?php echo $bank_details['id'] ? $bank_details['id'] : '' ?>">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="bankname" placeholder="Blood Bank name" value="<?php echo $bank_details['bank_name'] ? $bank_details['bank_name'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" class="form-control" name="bankmail" placeholder="Blood Bank Email" value="<?php echo $bank_details['email'] ? $bank_details['email'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
                <input type="tel" class="form-control" name="bankphone" placeholder="Phone" value="<?php echo $bank_details['phone'] ? $bank_details['phone'] : '' ?>">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
            </div>
            <div class="input-group mb-3">
              <textarea class="form-control" placeholder="Blood Bank Address..." style="resize:none;" name="bankaddress" id="bankaddress" cols="30">
              <?php echo $bank_details['address'] ? $bank_details['address'] : '' ?>
            </textarea>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-university"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="bankcounty" placeholder="County" value="<?php echo $bank_details['county'] ? $bank_details['county'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-globe"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="banklat" placeholder="Latitude" value="<?php echo $bank_details['lat'] ? $bank_details['lat'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-globe"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="banklon" placeholder="Logitude" value="<?php echo $bank_details['lon'] ? $bank_details['lon'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-globe"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="update-bank-profile" class="btn btn-success btn-block">Update</button>
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

  <!-- /.modal -->

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- /.Footer -->

</div>
<!-- ./wrapper -->

</body>
</html>
