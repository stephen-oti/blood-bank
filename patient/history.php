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
            <h1>My History : <small class="text-danger text-bold"><?php echo (isset($_GET['appeal']))? strtoupper($_GET['appeal']) :"All"; ?></small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Patient</a></li>
              <li class="breadcrumb-item active">My History</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
      if(isset($_POST['cancel-request'])) {
          // Get the updated values from the form
          $appid = $_POST['appid'];
          $status = 3;
            // Update the record in the Blood Bank table
            $stmt = mysqli_prepare($conn, "UPDATE patient_appeal SET app_status = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ii", $status, $appid);
            mysqli_stmt_execute($stmt);
            // Check if the update was successful
            if(mysqli_stmt_affected_rows($stmt) > 0) {
              echo '<div class="alert bg-success">Appeal Cancelling Request Successful</div>';  
              echo '<meta http-equiv="refresh" content="2">';
            } else {
              echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Canceling Appeal Request: " . mysqli_error($conn)."</div>";
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
                <!-- /.card-header -->
                <div class="card-header">
                  <div class="clearfix">    
                    <button type="submit" class="btn btn-primary float-right" title="Print Report" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-print"></i> Print Report</button>
                  </div> 
                </div>
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Requested Unit(s)</th>
                    <th>Status</th>
                    <th>Action</th>
                    <!-- <th>Action</th> -->
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                        $patient_id = $patient_details['id'];
                        $sql = " SELECT patient_appeal.id, patient_appeal.`app_date`, patient_appeal.`units`, patient_appeal.`app_status`, patient_appeal.`comment`,
                                blood_bank.`bank_name`, blood_bank.`address`, blood_bank.`email`, blood_bank.`phone`,
                                blood_type.`b_name`
                                FROM patient_appeal LEFT OUTER JOIN blood_bank ON patient_appeal.`bank_id` = blood_bank.`id`
                                JOIN blood_type ON patient_appeal.`blood_id` = blood_type.`id`
                                WHERE patient_appeal.`patient_id` = $patient_id";

                                // Check user was looking for specific status
                                if(isset($_GET['appeal'])){
                                  $appeal_status = $_GET['appeal'];
                                  if( $appeal_status == "approved"){
                                    $sql .= " AND (patient_appeal.`app_status` = 1 OR patient_appeal.`app_status` = 4)";
                                  }else if($appeal_status == "pending"){
                                    $sql .= " AND patient_appeal.`app_status` = 0";
                                  }else if($appeal_status == "rejected"){
                                    $sql .= " AND patient_appeal.`app_status` = 2";
                                  }else if($appeal_status == "cancelled"){
                                    $sql .= " AND patient_appeal.`app_status` = 3";
                                  }
                                }
                          $sql .= " ORDER BY patient_appeal.`app_date` DESC";
                      
                        // Prepare a select statement
                        $stmt = mysqli_prepare($conn, $sql);

                        // Execute the statement
                        mysqli_stmt_execute($stmt);

                        // Bind the result variables
                        mysqli_stmt_bind_result($stmt, $id, $appdate, $units, $appstatus, $comment, $bankname,$bankaddress, $bankmail, $bankphone, $bloodname);

                        // Loop through the results and create table rows
                        $count = 1;
                        while (mysqli_stmt_fetch($stmt)) {
                    ?>
                    <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $appdate; ?></td>
                    <td><?php echo $bankname; ?></td>
                    <td><?php echo $bankaddress; ?></td>
                    <td><b class="text-muted">mail: </b><?php echo $bankmail; ?><br><b class="text-muted">contact: </b><?php echo $bankphone; ?></td>
                    <td><b class="text-muted">Blood: </b><span class="text-danger" style="font-weight: 700;"><?php echo $bloodname; ?></span><br><b class="text-muted">units: </b><?php echo $units; ?></td>
                    <td>
                      <!-- <span class="badge badge-warning">Pending</span> -->
                      <?php
                        if($appstatus == 0){ 
                          echo "<span class='badge badge-warning'>Pending</span>";
                        }else if($appstatus == 1){
                          echo "<span class='badge badge-success'>Approved<br>Pending Transfer</span>";
                        }else if($appstatus == 2){
                          echo "<span class='badge badge-danger'>Rejected</span>";
                        }else if($appstatus == 3){
                          echo "<span class='badge badge-danger'>Cancelled</span>";
                        }else{
                          echo "<span class='badge badge-success'>Transfer Completed</span>";
                        }
                      ?>
                    </td>
                    
                    <td>
                      <?php if($appstatus == 0){ ?>
                        <a class="btn btn-danger btn-sm btn-cancel" href="#" href="#" data-toggle="modal" data-target="#modal-cancel" 
                        data-id = "<?php echo $id; ?>"
                        bank-name = "<?php echo $bankname; ?>"
                        req-date = "<?php echo $appdate; ?>">
                        <i class="fas fa-trash">
                        </i>
                        Cancel
                    </a>
                    <?php
                       }else if($appstatus == 1){
                        echo "Visit the transfusion";
                      }else if($appstatus == 2){
                        echo "$comment";
                      }else if($appstatus == 3){
                        echo "You cancelled this Request";
                      }else{
                        echo "Transfer Completed ";
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
                    <th>Date</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Requested Unit(s)</th>
                    <th>Status</th>
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
                  <button type="submit" name="cancel-request" class="btn btn-danger btn-block">Cancel Appeal Request</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Appeal And Transfusion History Reports</span></h4>
              <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <?php $url = "report.php?patient_id=". $patient_details['id']."&patient_name=".$patient_details['fname']." ".$patient_details['lname']."&action=patient-history"; ?>
            <iframe src="<?php echo $url; ?>" style='width: 100%; height: 600px';></iframe>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

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
