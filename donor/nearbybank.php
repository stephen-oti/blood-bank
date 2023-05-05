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
            <h1>Search Nearby Banks</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Donor</a></li>
              <li class="breadcrumb-item active">NearBy Banks</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
      if(isset($_POST['donate-nearby-bank'])) {
          
        // Get the updated values from the form
        $bankid = $_POST['bankid'];
        $reqdate = date("Y-m-d");
        $donor_id = $donor_details['id'];
        $donorblood = $donor_details['blood_id'];
        $status = 0;
        $dontype = 1;
        
      
        // Update the patient record in the database
        $sql = "INSERT INTO donor_donation(bank_id, donor_id, req_date, don_status, don_type, blood_id) VALUES(?, ?, ?, ?, ?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iisiii", $bankid, $donor_id, $reqdate, $status, $dontype, $donorblood);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_error($stmt)) {
            // Display the error message with the styled alert
            echo '<div class="alert bg-danger">Error while Making Donation Request, Try again later. ERROR ' . mysqli_error($conn).'</div>';
        } else { 
            // Display the success message with the styled alert
            echo '<div class="alert bg-success">Blood Donation Request Successfully Submitted</div>';
            echo '<meta http-equiv="refresh" content="2">';

        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
      }
    ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <?php if($availability > 0){ ?>
                <div class="callout callout-danger">
                  <h5><i class="fas fa-hourglass-half"></i> Pending Donation: </h5>
                      You Already have a pending Application thus You can only see but may not apply for more donations
                </div>
              <?php } ?>

              <?php if($days > 2 || $qdate == null){ ?>
                <div class="callout callout-warning">
                  <h5><i class="fas fa-clock"></i> Questionnaire Update: <span class="badge badge-danger"><?php echo ($qdate == null)? "First Time Update":"$days Days Ago" ?></span></h5>
                      <?php echo ($qdate == null)? "To Apply for blood Donation Requests Kindly Update questionnaire in the <a class = 'btn btn-primary' href = 'index.php' >Dashboard<a>":" You must update The questionnaire atleast 2 days before making a donation request" ?>
                </div>
              <?php } ?>
              <?php if($donor_details['donation_days'] < 0){ ?>
                <div class="callout callout-warning">
                <h5><i class="fas fa-history"></i> Donation Time: <span class="badge badge-danger"><?php echo abs($donor_details['donation_days']); ?> Days  to go</span></h5>
                  You can only donate once after every 56 days, Your last Donation was <b><?php echo  $donor_details['d_next']; ?></b> you've got <b><?php echo abs($donor_details['donation_days']); ?> </b>more days to go
              </div>
              <?php } ?>

              <?php if($donor_details['d_lat'] == null || $donor_details['d_lon'] == null){ ?>
              <div class="callout callout-warning">
                <h5><i class="fas fa-clock"></i> Location Update</h5>
                    <?php echo "You've not updated your Location details";
                    // echo " <button type='button' class='btn btn-danger pulse' data-toggle='modal' data-target='#modal-location' onclick='updateLocation()'><i class='fas fa-map-marker-alt'></i> Update Location</button>"?>
              </div>
          <?php } ?>

              <!-- /.card -->
              <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                  <small style="font-size: small; color:red; font-style: italic; font-weight: 800;">(List generated based on the current location provided)</small>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Contact</th>
                      <th>Distance(KM)</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $donor_status = $donor_details['d_status'];
                    if(($donor_status == 1) && !($donor_details['d_lat'] == null || $donor_details['d_lon'] == null)){
                      $donor_lat = $donor_details['d_lat'];
                      $donor_lon = $donor_details['d_lon'];
                        $sql = "SELECT id, bank_name, email, phone, address, county, lat, lon,
                                6371 * 2* ASIN(
                                  SQRT(
                                  POWER(SIN((lat - $donor_lat)* PI()/180/2), 2)+
                                  COS($donor_lat * PI()/180) * COS(lat * PI()/180)*
                                  POWER(SIN((lon - $donor_lon) * PI()/180/2),2)
                                  )
                                  ) AS distance
                                  FROM blood_bank WHERE bank_status = 1 ORDER BY distance DESC;";
                      
                        // Prepare a select statement
                        $stmt = mysqli_prepare($conn, $sql);

                        // Execute the statement
                        mysqli_stmt_execute($stmt);

                        // Bind the result variables
                        mysqli_stmt_bind_result($stmt, $id, $bankname, $email, $phone, $address, $county, $lat, $lon, $distance);

                        // Loop through the results and create table rows
                        $count = 1;
                        while (mysqli_stmt_fetch($stmt)) {
                    ?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $bankname; ?></td>
                      <td><?php echo $address; ?><br><?php echo $county; ?></td>
                      <td><b class="text-muted">mail: </b><?php echo $email; ?><br><b class="text-muted">contact: </b><?php echo $phone; ?></td>
                      <td><?php echo ($distance == Null)? "No coordinates": round($distance, 4); ?></td>
                      <td>
                        <a class="btn btn-danger btn-sm btn-donate <?php echo ($availability > 0 || $days > 2 || $qdate == null || $donor_details['donation_days'] < 0)? 'disabled': ''; ?>" href="#" data-toggle="modal" data-target="#modal-donate" data-id='<?php echo $id; ?>' bank-name = '<?php echo $bankname; ?>'>
                          <i class="fas fa-hand-holding-heart">
                          </i>
                          <?php echo ($availability > 0 || $days > 2 || $qdate == null || $donor_details['donation_days'] < 0)? 'Donation not possible': 'Donate'; ?>
                      </a>
                      </td>
                    </tr>

                    <?php
                      $count++;
                        }
                        // Close the statement and database connection
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                      }else{
                        echo "No data to Show, Update your Details to see Nearby Banks";
                      }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Address</th>
                      <th>Contact</th>
                      <th>Distance(KM)</th>
                      <th>Action</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="modal-donate">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Donation Form</h4>
          <button type="button" class="close" style="outline:none" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" name="donate-nearby-bank" role="donate-nearby-bank" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="input-group mb-3">
              <input type="hidden" name="bankid" id="bankid">
              <!-- <input type="text" class="form-control" name="" placeholder="First name"> -->
              <select name="blood" class="form-control" disabled>
                <option value=""><?php echo $donor_blood['b_name']; ?></option>
              </select>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-users"> Blood group</span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <span class="text-danger">Donate to.... </span>
              <h2 class="text-center"><span id="bankname" style="text-transform: uppercase;"></span></h2>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="donate-nearby-bank" class="btn btn-success btn-block">Donate</button>

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

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- /.Footer -->

</div>
<!-- ./wrapper -->
<script>
var donatebtn = document.querySelectorAll('.btn-donate');

donatebtn.forEach(function(button) {
button.addEventListener('click', function() {
  var bank_id = button.getAttribute('data-id');
  var bank_name = button.getAttribute('bank-name');
  $('#bankid').val(bank_id);
  $('#bankname').html(bank_name);
});
});
</script>

</body>
</html>
