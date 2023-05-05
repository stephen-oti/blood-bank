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
            <h1>Appealing Banks</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Donor</a></li>
              <li class="breadcrumb-item active">Bank Appeals</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
      if(isset($_POST['donate-appeal'])) {
          
        // Get the updated values from the form
        $appealid = $_POST['appid'];
        $bankid = $_POST['bankid'];
        $reqdate = date("Y-m-d");
        $donor_id = $donor_details['id'];
        $donorblood = $donor_details['blood_id'];
        $status = 0;
        $dontype = 0;
        
      
        // Update the patient record in the database
        $sql = "INSERT INTO donor_donation(bank_id, bank_app_id, donor_id, req_date, don_status, don_type, blood_id) VALUES(?, ?, ?, ?, ?, ?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiisiii", $bankid, $appealid, $donor_id, $reqdate, $status, $dontype, $donorblood);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_error($stmt)) {
            // Display the error message with the styled alert
            echo '<div class="alert bg-danger">Error while inserting record, Try again later. ERROR ' . mysqli_error($conn).'</div>';
        } else { 
            // Display the success message with the styled alert
            echo '<div class="alert bg-success">Blood Donation Request Successfully submitted</div>'; 
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
                <!-- /.card -->
                
              <?php if($availability > 0){?>
                <div class="callout callout-danger">
                  <h5><i class="fas fa-hourglass-half"></i> Pending Donation: </h5>
                      You Already have a pending Application thus You can only see but may not apply for more donations
                </div>
              <?php } ?>

              <?php if($days > 2 || $qdate == null){ ?>
                <div class="callout callout-warning">
                  <h5><i class="fas fa-clock"></i> Questionnaire Update: <span class="badge badge-danger"><?php echo ($qdate == null)? "First Time Update":"$days Days Ago" ?></span></h5>
                      You must update The questionnaire atleast 2 days before making a donation request
                </div>
              <?php } ?>
              <?php if($donor_details['donation_days'] < 0){ ?>
                <div class="callout callout-warning">
                <h5><i class="fas fa-history"></i> Donation Time: <span class="badge badge-danger"><?php echo abs($donor_details['donation_days']); ?> Days  to go</span></h5>
                  You can only donate once after every 56 days, Your last Donation was <b><?php echo  $donor_details['d_next']; ?></b> you've got <b><?php echo abs($donor_details['donation_days']); ?> </b>more days to go
              </div>
              <?php } ?>
              
              <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                  <small style="font-size: small; color:red; font-style: italic; font-weight: 800;">(See Banks Requesting for Blood similar to yours blood group)</small>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Date created</th>
                      <th>Address</th>
                      <th>Contact</th>
                      <th>Blood</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $donor_status = $donor_details['d_status'];
                    if($donor_status != null){
                        if($blood_id == 7 || $blood_id == 8){
                        $sql = "SELECT bank_appeals.id, app_date, tgt_units, coll_units, app_status, blood_id, blood_type.`b_name`, bank_appeals.`bank_id`, blood_bank.`bank_name`, blood_bank.`address`, blood_bank.`email`, blood_bank.`phone`, blood_bank.`county`, (tgt_units - coll_units) AS difference
                                FROM bank_appeals LEFT OUTER JOIN blood_type ON bank_appeals.`blood_id` = blood_type.`id` 
                                JOIN blood_bank ON blood_bank.`id` = bank_appeals.`bank_id`
                                WHERE blood_type.`rhesus` = '$donor_rhesus' 
                                AND  bank_appeals.`app_status` != 2 
                                AND blood_bank.`bank_status` = 1 
                                AND bank_appeals.`id` NOT IN (
                                    SELECT bank_app_id 
                                    FROM donor_donation 
                                    WHERE donor_id = $donor_id AND bank_app_id IS NOT NULL
                                )
                                HAVING difference > 0";
                      }else{
                        $sql = "SELECT bank_appeals.id, app_date, tgt_units, coll_units, app_status, blood_id, blood_type.`b_name`, bank_appeals.`bank_id`, blood_bank.`bank_name`, blood_bank.`address`, blood_bank.`email`, blood_bank.`phone`, blood_bank.`county`, (tgt_units - coll_units) AS difference
                                FROM bank_appeals LEFT OUTER JOIN blood_type ON bank_appeals.`blood_id` = blood_type.`id` 
                                JOIN blood_bank ON blood_bank.`id` = bank_appeals.`bank_id`
                                WHERE blood_type.`id` = $blood_id 
                                AND  bank_appeals.`app_status` != 2 
                                AND blood_bank.`bank_status` = 1
                                AND bank_appeals.`id` NOT IN (
                                    SELECT bank_app_id 
                                    FROM donor_donation 
                                    WHERE donor_id = $donor_id AND bank_app_id IS NOT NULL
                                )
                                HAVING difference > 0";
                      }
                        // Prepare a select statement
                        $stmt = mysqli_prepare($conn, $sql);

                        // Execute the statement
                        mysqli_stmt_execute($stmt);

                        // Bind the result variables
                        mysqli_stmt_bind_result($stmt, $id, $appdate, $target, $collected, $app_status, $blood_id, $blood_name,$bank_id,$bank_name, $bank_address, $bank_mail, $bank_phone, $bank_county, $difference);
                    
                    

                        // Loop through the results and create table rows
                        $count = 1;
                        while (mysqli_stmt_fetch($stmt)) {
                    ?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $bank_name; ?></td>
                      <td><?php echo $appdate; ?></td>
                      <td><?php echo $bank_address; ?><br><?php echo $bank_county; ?></td>                                    
                      <td><b class="text-muted">mail: </b><?php echo $bank_mail; ?><br><b class="text-muted">contact: </b><?php echo $bank_phone; ?></td>
                      <td><b class="text-danger"><?php echo $target; ?><br><?php echo $blood_name; ?></b></td>
                      <td> 
                        <a class="btn btn-danger btn-sm btn-donate <?php echo ($availability > 0 || $days > 2 || $qdate == null || $donor_details['donation_days'] < 0)? 'disabled': ''; ?>" href="#" data-toggle="modal" data-target="#modal-pi" data-id='<?php echo $id; ?>' bank-name = '<?php echo $bank_name; ?>' bank-id ='<?php echo $bank_id; ?>'>
                            <i class="fas fa-hand-holding-heart"></i> 
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
                      }
                    ?>
                    
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Date created</th>
                      <th>Address</th> 
                      <th>Contact</th>
                      <th>Blood</th>
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
  <!-- /.modal -->

  <!-- /.modal -->

  <div class="modal fade" id="modal-pi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Donation Form</h4>
          <button type="button" class="close" style="outline:none" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" name="donor-appeal" role="donor-appeal" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="input-group mb-3">
              <input type="hidden" name="appid" id="appid">
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
              <h2 class="text-center"><span id="appbank" style="text-transform: uppercase;"></span></h2>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="donate-appeal" class="btn btn-success btn-block">Donate</button>

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
    var app_id = button.getAttribute('data-id');
    var bank_id = button.getAttribute('bank-id');
    var app_bank = button.getAttribute('bank-name');
    $('#appid').val(app_id);
    $('#bankid').val(bank_id);
    $('#appbank').html(app_bank);
  });
});
</script>
</body>
</html>
