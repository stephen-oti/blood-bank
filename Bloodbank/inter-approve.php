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
        <h1>Inter Bank Appeals</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Inter Bank</li>
              <li class="breadcrumb-item active">Approve</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php 
      if(isset($_POST['reject-request'])) {
        // Get the updated values from the form
        $interid = $_POST['delinterid'];
        $appr_date = date("Y-m-d");
        $comments = $_POST['comments'];
        $status = 2;
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE inter_bank SET req_status = ? , comments = ?, appr_date = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "issi", $status, $comments, $appr_date, $interid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Transfer Cancelling Request Successful</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Canceling Transfer Request: " . mysqli_error($conn)."</div>";
          }
          
          // Close the statement
          mysqli_stmt_close($stmt);
      }

      if(isset($_POST['bank-transfer'])) {
        // Get the updated values from the form
        $pouch_id = $_POST['pouch'];
        $inter_id = $_POST['interid'];
        $transfer_date = date("Y-m-d");
        $req_bank = $_POST['bank-id'];
        $blood_id = $_POST['blood-id'];
        $blood_qty = $_POST['blood-qty'];
        $bank_id = $bank_details['id'];
        $request_status = 1;
        $success_comment = "Transfer completed";



        $sql = "INSERT INTO transfer(trans_date, appr_bank, req_bank, pouch_id, inter_bank_id)
                VALUES(?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "siiii", $transfer_date, $bank_id, $req_bank,$pouch_id, $inter_id);
        mysqli_stmt_execute($stmt);
        // Check for errors
        if(mysqli_stmt_error($stmt)) {
          // Display the error message with the styled alert
          echo '<div class="alert bg-danger">Error while Inserting The transfer Details' . mysqli_error($conn).'</div>';
        }else{
          // $pouch_id = mysqli_insert_id($conn);
          $sql3 = "UPDATE inter_bank SET req_status = ?, pouch_id = ?, comments = ?, appr_date = ? WHERE id = ?";
          $stmnt2 = mysqli_prepare($conn, $sql3);
          mysqli_stmt_bind_param($stmnt2, "iissi", $request_status, $pouch_id, $success_comment, $transfer_date, $inter_id);
          mysqli_stmt_execute($stmnt2);
          if(mysqli_stmt_error($stmnt2)){
            echo '<div class="alert bg-danger">Error Uupdating The Transfer Status' . mysqli_error($conn).'</div>';
          }else{
            $sql4 = "UPDATE pouch SET bank_id = ? WHERE id = ?";
            $stmnt4 = mysqli_prepare($conn, $sql4);
            mysqli_stmt_bind_param($stmnt4, "ii", $req_bank, $pouch_id );
            mysqli_stmt_execute($stmnt4);
            if(mysqli_stmt_error($stmnt4)){
              '<div class="alert bg-danger">Error Updating Getting The Pouch For transfer' . mysqli_error($conn).'</div>';
            }else{
              echo '<div class="alert bg-success">Blood Transfer  to Bank Successful</div>';
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
                    <!-- /.card-header -->
                    <div class="card-header">
                    </div>
                    
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Request Date</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Requested Units</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $bank_id = $bank_details['id'];
                            $sql = "SELECT inter_bank.`id`, req_date, quantity, req_status, inter_bank.comments, inter_bank.`req_bank`,
                            blood_bank.`bank_name`, blood_bank.`address`, blood_bank.`email`, blood_bank.`phone`, blood_bank.`county`,blood_bank.`bank_status`,
                            pouch.`blood_id`,pouch.`id`, blood_type.`b_name`, pouch.`pouch_status`,(35 - DATEDIFF(NOW(), pouch.fill_date)) as days
                            FROM inter_bank 
                            LEFT OUTER JOIN blood_bank ON inter_bank.`req_bank` = blood_bank.`id`
                            JOIN pouch ON inter_bank.`pouch_id` = pouch.`id`
                            JOIN blood_type ON blood_type.`id` = pouch.`blood_id`
                            WHERE appr_bank =  $bank_id AND req_status = 0 
                            ORDER BY req_date DESC";
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
                            $count = 1;
                          
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $inter_id, $req_date, $quantity, $req_status, $comments,$bankid, $bank_name, $bank_address, $bank_mail, $bank_phone, $bank_county,$bank_status, $blood_id, $pouch_id, $blood_name,$pouch_status, $expiry);
    
                            // Loop through the results and create table rows
                            
                            while (mysqli_stmt_fetch($stmt)) {

                        ?>
                        
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $req_date; ?></td>
                        <td><?php echo $bank_name; ?></td>
                        <td><?php echo $bank_address; ?><br><?php echo $bank_county; ?></td>
                        <td><b class="text-muted"></b><?php echo $bank_mail; ?><br><b class="text-muted"> </b><?php echo $bank_phone; ?></td>
                        <td><span class="badge badge-danger" style="font-size: 16px;"><?php echo $quantity; ?></span><br><b class="text-danger"><?php echo $blood_name; ?></b></td>
                        <td>
                            <a class="btn btn-success btn-sm btn-transfer" href="#" href="#" data-toggle="modal" data-target="#modal-approve"
                            data-id='<?php echo $inter_id;?>' 
                            bank-id='<?php echo $bankid;?>' 
                            blood-id='<?php echo $blood_id;?>' 
                            bank-name = '<?php echo $bank_name;?>' 
                            req-date = '<?php echo $req_date;?>'
                            quantity = '<?php echo $quantity;?>'
                            current-bank = '<?php echo $bank_details['id'];?>'
                            pouch = '<?php echo ($pouch_status == 1) ? "$pouch_id": ""; ?>'
                            expiry = '<?php echo $expiry; ?>'>
                            <i class="fas fa-hand-holding-heart">
                            </i>
                            Transfer
                        </a>
                        <a class="btn btn-danger btn-sm btn-reject" href="#" href="#" data-toggle="modal" data-target="#modal-reject"
                            data-id='<?php echo $inter_id;?>' 
                            req-date = '<?php echo $req_date;?>' 
                            blood-name ='<?php echo $blood_name;?>' 
                            bank-name = '<?php echo $bank_name;?>' >
                              <i class="fas fa-times"></i>
                              Reject
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
                        <th>Request Date</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Requested Units</th>
                        <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="card"> 
                    <div class="card-header">
                        <h2>Processed Transfer</h2>
                    </div>  
                    <div class="card-body">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        
                        <th>Date</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Blood</th>
                        <th>Reason</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $bank_id = $bank_details['id'];
                            $sql2 = "SELECT inter_bank.`id`, appr_date, quantity, req_status, inter_bank.comments,
                                    blood_bank.`bank_name`, blood_bank.`address`, blood_bank.`email`, blood_bank.`phone`, blood_bank.`county`,
                                    pouch.`id`, pouch.`units`, blood_type.`b_name`
                                    FROM inter_bank LEFT OUTER JOIN blood_bank ON inter_bank.`req_bank` = blood_bank.`id`
                                    JOIN pouch ON inter_bank.`pouch_id` = pouch.`id`
                                    JOIN blood_type ON blood_type.`id` = pouch.`blood_id`
                                    WHERE appr_bank = $bank_id  AND (req_status = 2 OR req_status = 1)
                                    ORDER BY appr_date DESC";
                            
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql2);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt,  $inter_id, $apprdate, $quantity, $reqstatus, $comments, $bankName, $bankAddress, $bankMail, $bankPhone,$bankCounty, $pouch_id,$pouchUnits,$bloodName );
    
                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                            
                            
                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td> <?php echo $apprdate; ?></td>
                        <td><?php echo $bankName ?></td>
                        <td><?php echo $bankAddress; ?><br><?php echo $bankCounty; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $bankMail; ?><br><b class="text-muted">contact: </b><?php echo $bankPhone; ?></td>
                        <td><span class="badge badge-success" style="font-size: 16px;"><?php echo $pouchUnits; ?></span> - <span class="badge badge-danger" style="font-size: 16px;"><?php echo $quantity; ?></span><br><b class="text-danger"><?php echo $bloodName; ?></b></td>
                        <td><?php
                              if($reqstatus == 1){
                                echo "<span class='badge badge-success'>Transfer Approved</span><br>
                                <span class='badge badge-danger'>#<b>$pouch_id</b></span>";
                              }else if($reqstatus == 2){
                                echo "<span class='badge badge-danger'>Transfer Request Rejected</span><br>
                                      RE: <b>$comments</b>";
                              }
                              ?></td>
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
                          <th>Type</th>
                          <th>Date</th>
                          <th>Name</th>
                          <th>Contact</th>
                          <th>Blood</th>
                          <th>Reason</th>
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

  <!-- /.modal -->
  <div class="modal fade" id="modal-approve">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Approve Transfer</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form  method="post" name="bank-transfer" role="bank-transfer"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="">Assign Units <small class="text-danger">(sorted expiry days and units (OR +10 of appealed))</small></label>
            <div class="form-group" id="pouch-choosing">

            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" id="blood-id" name="blood-id">
                <input type="hidden" class="form-control" id="bank-id" name="bank-id">
                <input type="hidden" class="form-control" id="interid" name="interid">
                <!-- <input type="hidden" class="form-control" id="pouch-id" name="pouch-id"> -->
                <input type="hidden" class="form-control" id="blood-qty" name="blood-qty">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="bank-transfer" class="btn btn-success btn-block">Transfer</button>
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

  <div class="modal fade" id="modal-reject">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Disapproving Transfer</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Disapproving....
        <h3 class="text-center"><span id="delreqdate"></span> <span class="text-danger  fas fa-arrows-alt-h"></span><span id="delbankname" style="text-transform: uppercase;"></span></h3>
        <h3 class="text-center"><span id="delbloodname" style="text-transform: uppercase;"></span></h3>
        </div>
        <form method="post" name="reject-request" role="cancel-request" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="delinterid" id="delinterid">
        <div class="input-group mb-3" style="width:90%; margin:auto;">
          <textarea class="form-control" name="comments" id="comments" cols="10" placeholder="Add Brief Comments..." required></textarea>
        </div>
          <div class="modal-footer">
              <!-- <div class="row"> -->
            <button type="submit" name="reject-request" class="btn btn-danger btn-block">Disapproving Transfer</button>
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
  var rejectbtn = document.querySelectorAll('.btn-reject');
  var transferbtn = document.querySelectorAll('.btn-transfer');

  transferbtn.forEach(function(button) {
    button.addEventListener('click', function() {
      var interid = button.getAttribute('data-id');
      var bankid = button.getAttribute('bank-id');
      var bankname = button.getAttribute('bank-name');
      var req_date = button.getAttribute('req-date');
      var blood = button.getAttribute('blood-id');
      var qty = button.getAttribute('quantity');
      var pouch = button.getAttribute('pouch');
      var expiry = button.getAttribute('expiry');
      var current = button.getAttribute('current-bank');
      var action = "bank-transfer";

      $('#blood-id').val(blood);
      $('#interid').val(interid);
      $('#bank-id').val(bankid);
      $('#blood-qty').val(qty);
      $('#pouch-id').val(pouch);
      $('#expiry').val(expiry);
      // $('#bankname').val(patient);


        // Make an AJAX request to fetch the blood pouches with the given quantity
        $.ajax({
          url: 'action.php',
          method: 'POST',
          data: { action : action, quantity: qty, blood_id: blood, bank_id: current, pouch: pouch, expiry:expiry },
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

  rejectbtn.forEach(function(button) {
  button.addEventListener('click', function() {


    var app_id = button.getAttribute('data-id');
    var app_bank = button.getAttribute('bank-name');
    var req_date = button.getAttribute('req-date');
    var blood = button.getAttribute('blood-name');

    $('#delinterid').val(app_id);
    $('#delbankname').html(app_bank );
    $('#delreqdate').html(req_date);
    $('#delbloodname').html(blood);
  });
});
</script>
</body>
</html>
