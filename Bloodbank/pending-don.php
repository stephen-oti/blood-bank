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
        <h1>Pending Requests</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Donation Requests</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
      if(isset($_POST['add-donation'])) {
        // Get the updated values from the form
        $donation_id = $_POST['donation-id'];
        $donor_id = $_POST['donor-id'];
        $donation_date = date("Y-m-d");
        $bank_appeal_id = $_POST['bank-appeal-id'];
        $donor_blood = $_POST['donor-blood'];
        $quantity = $_POST['quantity'];
        $donation_type = $_POST['donation-type'];
        $bank_id = $bank_details['id'];
        $pouch_status = 1;
        $donation_status = 4;
        $next_donation = date('Y-m-d', strtotime($donation_date.'+ 56 days'));



        if($donation_type == 0){
          $sql2 = "UPDATE bank_appeals SET coll_units = coll_units + ? WHERE id = ?";
          $stmnt = mysqli_prepare($conn, $sql2);
          mysqli_stmt_bind_param($stmnt, "ii", $quantity, $bank_appeal_id);
          mysqli_stmt_execute($stmnt);
          if(mysqli_stmt_error($stmnt)){
            echo '<div class="alert bg-danger">Error while Updating Appeal Record Blood Unit' . mysqli_error($conn).'</div>';
          }else{
            echo '<div class="alert bg-success">Bank Appeal Successfully updated</div>';
          }
        }

        $sql = "INSERT INTO pouch(donor_id, blood_id, units, fill_date, pouch_status, bank_id, donation_id)
                VALUES(?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiisiii", $donor_id, $donor_blood, $quantity, $donation_date, $pouch_status,$bank_id, $donation_id);
        mysqli_stmt_execute($stmt);
        // Check for errors
        if(mysqli_stmt_error($stmt)) {
          // Display the error message with the styled alert
          echo '<div class="alert bg-danger">Error while Inserting Blood Unit' . mysqli_error($conn).'</div>';
        }else{
          $pouch_id = mysqli_insert_id($conn);
          $sql3 = "UPDATE donor_donation SET don_status = ?, quantity = ?, don_date = ? WHERE id = ?";
          $stmnt2 = mysqli_prepare($conn, $sql3);
          mysqli_stmt_bind_param($stmnt2, "iisi", $donation_status, $quantity, $donation_date, $donation_id);
          mysqli_stmt_execute($stmnt2);
          if(mysqli_stmt_error($stmnt2)){
            echo '<div class="alert bg-danger">Error Uupdating The donation' . mysqli_error($conn).'</div>';
          }else{
            $sql4 = "UPDATE donor SET d_next = ? WHERE id = ?";
            $stmnt4 = mysqli_prepare($conn, $sql4);
            mysqli_stmt_bind_param($stmnt4, "si", $next_donation, $donor_id);
            mysqli_stmt_execute($stmnt4);
            if(mysqli_stmt_error($stmnt4)){
              '<div class="alert bg-danger">Error Updating Donor Records' . mysqli_error($conn).'</div>';
            }else{
              echo '<div class="alert bg-success">Donation Successfull. Blood Stored in Pouch <b>'.$pouch_id.'</b></div>';
              echo '<meta http-equiv="refresh" content="2">';
            }
          }
          
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

                <div class="card">  
                    <div class="card-header">
                        <h3>Approved Donation Requests</h3>
                    </div> 
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Blood</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $bank_id = $bank_details['id'];
                            $sql = "SELECT donor_donation.`id`, donor_donation.`req_date`,donor_donation.`bank_app_id`, donor_donation.`donor_id`, donor_donation.`blood_id`, donor_donation.`don_type`,donor_donation.`don_status`,
                                    donor.`fname`, donor.`lname`, donor.`email`, donor.`address`, donor.`phone`, blood_type.`b_name`
                                    FROM donor_donation 
                                    LEFT OUTER JOIN donor ON donor_donation.`donor_id` = donor.`id`
                                    JOIN blood_type ON donor.`blood_id` = blood_type.`id`
                                    WHERE donor_donation.`don_status` = 1  AND donor_donation.`bank_id` = $bank_id";
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $donation_id, $req_date, $bank_app_id, $donor_id, $donor_blood_id, $donation_type, $don_status, $don_fname, $don_lname, $don_email, $don_address, $don_phone, $don_blood_name);
    
                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo ($donation_type == 0)?"Bank Appeal":"Nearby Bank" ?></td>
                        <td><?php echo "$don_fname $don_lname"; ?></td>
                        <td><?php echo $don_address; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $don_email; ?><br><b class="text-muted">contact: </b><?php echo $don_phone; ?></td>
                        <td><b class="text-danger"><?php echo $don_blood_name; ?></b></td>
                        <td>
                          <a class="btn btn-primary btn-sm btn-donation" href="#" data-toggle="modal" data-target="#modal-complete"
                            donation-id = '<?php echo $donation_id; ?>'
                            donor-id = '<?php echo $donor_id; ?>'
                            bank-app-id = '<?php echo $bank_app_id; ?>'
                            blood-id = '<?php echo $donor_blood_id; ?>'
                            donation-type = '<?php echo $donation_type; ?>'
                          >
                            <i class="fas fa-check"></i>
                            Donation Complete
                          </a>
                        </td>
                        </tr>
                        <?php
                          $count++;
                            }
                            // Close the statement and database connection
                            mysqli_stmt_close($stmt);
                            // mysqli_close($conn);
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Name</th>
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
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-complete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Accept Donation</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
          <form  method="post" name="add-donation" role="add-donation" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="">Collected Units</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="eg. 10 units" required>
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="donation-id" name="donation-id">
                <input type="hidden" class="form-control" id="donor-id" name="donor-id">
                <input type="hidden" class="form-control" id="bank-appeal-id" name="bank-appeal-id">
                <input type="hidden" class="form-control" id="donor-blood" name="donor-blood">
                <input type="hidden" class="form-control" id="donation-type" name="donation-type">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="add-donation" class="btn btn-success btn-block">Add To bank</button>
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
  var donationbtn = document.querySelectorAll('.btn-donation');

  donationbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var donation_id = button.getAttribute('donation-id');
    var donor_id = button.getAttribute('donor-id');
    var bank_appeal = button.getAttribute('bank-app-id');
    var blood_id = button.getAttribute('blood-id');
    var don_type = button.getAttribute('donation-type');

    $('#donation-id').val(donation_id);
    $('#donor-id').val(donor_id);
    $('#bank-appeal-id').val(bank_appeal);
    $('#donor-blood').val(blood_id);
    $('#donation-type').val(don_type);

  });
});
</script>
</body>
</html>
