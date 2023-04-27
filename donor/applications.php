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
            <h1>Donation Application Requests</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Donor</a></li>
              <li class="breadcrumb-item active">My donation</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <!-- /.card -->
              <?php
                if(isset($_POST['cancel-request'])) {
                  // Get the updated values from the form
                  $appid = $_POST['appid'];
                  $status = 3;
                    // Update the record in the Blood Bank table
                    $stmt = mysqli_prepare($conn, "UPDATE donor_donation SET don_status = ? WHERE id = ?");
                    mysqli_stmt_bind_param($stmt, "ii", $status, $appid);
                    mysqli_stmt_execute($stmt);
                    // Check if the update was successful
                    if(mysqli_stmt_affected_rows($stmt) > 0) {
                      echo '<div class="alert bg-success">Donation Cancelling Request Successful</div>';  
                      echo '<meta http-equiv="refresh" content="2">';
                    } else {
                      echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Canceling Donation Request: " . mysqli_error($conn)."</div>";
                    }
                    
                    // Close the statement
                    mysqli_stmt_close($stmt);
                  
                }
                
              ?>
              <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Blood bank</th>
                      <th>Date</th>
                      <th>Contact</th>
                      <th>Status</th>
                      <th>Comments</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $donor_id = $donor_details['id'];
                        $sql = " SELECT donor_donation.`id`, donor_donation.`req_date`,donor_donation.`don_status`, donor_donation.`comment`,
                                  blood_bank.`bank_name`, blood_bank.`email`, blood_bank.`phone` 
                                  FROM donor_donation 
                                  LEFT OUTER JOIN blood_bank ON donor_donation.`bank_id` = blood_bank.`id`
                                  JOIN donor ON donor_donation.`donor_id` = donor.`id`
                                  WHERE donor_donation.`donor_id` = $donor_id
                                  ORDER BY req_date DESC";
                      
                        // Prepare a select statement
                        $stmt = mysqli_prepare($conn, $sql);

                        // Execute the statement
                        mysqli_stmt_execute($stmt);

                        // Bind the result variables
                        mysqli_stmt_bind_result($stmt, $id, $reqdate, $donationstatus, $comment, $bankname, $bankmail, $bankphone);

                        // Loop through the results and create table rows
                        $count = 1;
                        while (mysqli_stmt_fetch($stmt)) {
                    ?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $bankname; ?></td>
                      <td><?php echo $reqdate; ?></td>
                      <td><b class="text-muted">mail: </b><?php echo $bankmail; ?><br><b class="text-muted">contact: </b><?php echo $bankphone; ?></td>
                      <td class="project-state"><?php 
                        if($donationstatus == 0){ 
                          echo "<span class='badge badge-warning'>Pending Approval</span>";
                        }else if($donationstatus == 1){
                          echo "<span class='badge badge-success'>Pending Donation</span>";
                        }else if($donationstatus == 2){
                          echo "<span class='badge badge-danger'>Donation Denied</span>";
                        }else if($donationstatus == 3){
                          echo "<span class='badge badge-danger'>Donation Cancelled</span>";
                        }else{
                          echo "<span class='badge badge-success'>Donation Completed</span>";
                        }
                      ?> 
                      </td>
                      <td>
                        <!-- <a class="btn btn-info btn-sm" href="#">
                          <i class="fas fa-eye">
                          </i> 
                          View     
                      </a> -->
                        <?php
                        if($donationstatus == 0){ 
                        ?>
                          <a class="btn btn-danger btn-sm btn-cancel" href="#" href="#" data-toggle="modal" data-target="#modal-cancel" data-id='<?php echo $id;?>' bank-name = '<?php echo $bankname;?>' req-date = '<?php echo $reqdate;?>'>
                                <i class="fas fa-times">
                                </i>
                                Cancel Donation
                            </a> 
                        <?php
                        }else if($donationstatus == 1){
                          echo "Visit the donation center";
                        }else if($donationstatus == 2){
                          echo "$comment";
                        }else if($donationstatus == 3){
                          echo "You cancelled this Request";
                        }else{
                          echo "Donation Completed sucessfully";
                        }
                        ?>
                      </td>
                    </tr>
                    <?php
                      $count++;
                        }
                        // Close the statement and database connection
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                    ?>

                    </tbody>
                    <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Blood bank</th>
                      <th>Date</th>
                      <th>Contact</th>
                      <th>Status</th>
                      <th>Comments</th>
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

  <div class="modal fade" id="modal-cancel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cancel Request?</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Cancelling....
        <h3 class="text-center"><span id="reqdate"></span> <span class="text-danger  fas fa-arrows-alt-h"></span> <span id="bankname" style="text-transform: uppercase;"></span></h3>
        </div>
        <form method="post" name="cancel-request" role="cancel-request" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="appid" id="appid">
          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="cancel-request" class="btn btn-danger btn-block">Cancel Donation Request</button>
          </div>
        </form>
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
    var cancelbtn = document.querySelectorAll('.btn-cancel');

  cancelbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var app_id = button.getAttribute('data-id');
    var app_bank = button.getAttribute('bank-name');
    var req_date = button.getAttribute('req-date');
    $('#appid').val(app_id);
    $('#bankname').html(app_bank );
    $('#reqdate').html(req_date);
  });
});
</script>
</body>
</html>
