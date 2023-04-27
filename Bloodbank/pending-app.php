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
        <h1>Pending Appeal Requests</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Approved Appeal Requests</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
      if(isset($_POST['transfer-appeal'])) {
        // Get the updated values from the form
        $pouch_id = $_POST['pouch'];
        $appeal_id = $_POST['appeal-id'];
        $transfer_date = date("Y-m-d");
        $patient_id = $_POST['patient-id'];
        $blood_id = $_POST['blood-id'];
        $blood_qty = $_POST['blood-qty'];
        $bank_id = $bank_details['id'];
        $pouch_status = 3;
        $appeal_status = 4;



        $sql = "INSERT INTO transfusion(app_id, trans_date, pouch_id, bank_id)
                VALUES(?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isii", $appeal_id, $transfer_date, $pouch_id, $bank_id);
        mysqli_stmt_execute($stmt);
        // Check for errors
        if(mysqli_stmt_error($stmt)) {
          // Display the error message with the styled alert
          echo '<div class="alert bg-danger">Error while Inserting The transfer Details' . mysqli_error($conn).'</div>';
        }else{
          // $pouch_id = mysqli_insert_id($conn);
          $sql3 = "UPDATE patient_appeal SET app_status = ? WHERE id = ?";
          $stmnt2 = mysqli_prepare($conn, $sql3);
          mysqli_stmt_bind_param($stmnt2, "ii", $appeal_status, $appeal_id);
          mysqli_stmt_execute($stmnt2);
          if(mysqli_stmt_error($stmnt2)){
            echo '<div class="alert bg-danger">Error Uupdating The Appeal Status' . mysqli_error($conn).'</div>';
          }else{
            $sql4 = "UPDATE pouch SET pouch_status = ? WHERE id = ?";
            $stmnt4 = mysqli_prepare($conn, $sql4);
            mysqli_stmt_bind_param($stmnt4, "ii", $pouch_status, $pouch_id );
            mysqli_stmt_execute($stmnt4);
            if(mysqli_stmt_error($stmnt4)){
              '<div class="alert bg-danger">Error Updating Getting The Pouch For transfer' . mysqli_error($conn).'</div>';
            }else{
              echo '<div class="alert bg-success">Blood Transfer Successful</div>';
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
                        <h3>Approved Appeal Requests</h3>
                    </div> 
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Blood</th>
                        <th>Amount(units)</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $bank_id = $bank_details['id'];
                            $sql = "SELECT patient_appeal.`id`, patient_appeal.`app_date`, patient_appeal.`patient_id`, patient_appeal.`blood_id`,patient_appeal.`units`, patient_appeal.`app_status`,
                                    patient.`fname`, patient.`lname`, patient.`email`, patient.`address`, patient.`phone`, blood_type.`b_name`
                                    FROM patient_appeal
                                    LEFT OUTER JOIN patient ON patient_appeal.`patient_id` = patient.`id`
                                    JOIN blood_type ON patient_appeal.`blood_id` = blood_type.`id`
                                    WHERE patient_appeal.`app_status` = 1 AND patient.`p_status` = 1  AND patient_appeal.`bank_id` = $bank_id";
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $appeal_id, $app_date, $patient_id, $appeal_blood_id,$appeal_units,$appeal_status,  $pat_fname, $pat_lname, $pat_email, $pat_address, $pat_phone, $appeal_blood_name);
    
                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo "$pat_fname $pat_lname"; ?></td>
                        <td><?php echo $pat_address; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $pat_email; ?><br><b class="text-muted">contact: </b><?php echo $pat_phone; ?></td>
                        <td><b class="text-danger"><?php echo $appeal_blood_name; ?></b></td>
                        <td><?php echo $appeal_units; ?></td>
                        <td>
                          <a class="btn btn-primary btn-sm btn-appeal" href="#" data-toggle="modal" data-target="#modal-complete" 
                            blood-id = '<?php echo $appeal_blood_id;?>'
                            appeal-id = '<?php echo $appeal_id; ?>'
                            patient-id = '<?php echo $patient_id; ?>'
                            blood-qty = '<?php echo $appeal_units; ?>'
                            bank-id = '<?php echo $bank_id; ?>' >
                            <i class="fas fa-check"></i>
                            Transfer
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
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Blood</th>
                        <th>Amount</th>
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
          <h4 class="modal-title">Complete Transfer</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form  method="post" name="transfer-appeal" role="transfer-appeal"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="">Assign Units <small class="text-danger">(sorted expiry days and units (OR +10 of appealed))</small></label>
            <div class="form-group" id="pouch-choosing">

            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="blood-id" name="blood-id">
                <input type="hidden" class="form-control" id="appeal-id" name="appeal-id">
                <input type="hidden" class="form-control" id="patient-id" name="patient-id">
                <input type="hidden" class="form-control" id="blood-qty" name="blood-qty">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="transfer-appeal" class="btn btn-success btn-block">Transfer</button>
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
  var appealbtn = document.querySelectorAll('.btn-appeal');

  appealbtn.forEach(function(button) {
    button.addEventListener('click', function() {
      var blood = button.getAttribute('blood-id');
      var appeal = button.getAttribute('appeal-id');
      var patient = button.getAttribute('patient-id');
      var qty = button.getAttribute('blood-qty');
      var bank = button.getAttribute('bank-id');
      var action = "patient-transfer";

      $('#blood-id').val(blood);
      $('#appeal-id').val(appeal);
      $('#patient-id').val(patient);
      $('#blood-qty').val(qty);

        // Make an AJAX request to fetch the blood pouches with the given quantity
        $.ajax({
          url: 'action.php',
          method: 'POST',
          data: {action : action, quantity: qty, blood_id: blood, bank_id: bank },
          success: function(data) {
            // Replace the content of the #pouch-choosing div with the select options
            $('#pouch-choosing').html(data);
          },
          error: function() {
            console.log('Failed to fetch blood pouches');
          }
        });
      
    });
  });
</script>
</body>
</html>
