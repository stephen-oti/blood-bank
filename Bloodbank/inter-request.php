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
              <li class="breadcrumb-item active">Request</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
      if(isset($_POST['inter-request'])) {
        // Get the updated values from the form
        $apprbank = $_POST['apprbank'];
        $qty = $_POST['quantity'];
        $pouch = $_POST['pouch'];
        $request_date = date("Y-m-d");
        $req_bank = $bank_details['id'];
        $status = 0;

          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "INSERT into inter_bank(req_bank, appr_bank, req_date, req_status, quantity, pouch_id) VALUES(?, ?, ?, ?, ?, ?)");
          mysqli_stmt_bind_param($stmt, "iisiii",  $req_bank, $apprbank, $request_date, $status,$qty, $pouch);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Request Successfully Submitted</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Making the Inter Bank Request: " . mysqli_error($conn)."</div>";
          }
          
          // Close the statement
          mysqli_stmt_close($stmt);
        
      }
      if(isset($_POST['cancel-request'])) {
        // Get the updated values from the form
        $interid = $_POST['interid'];
        $status = 3;
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE inter_bank SET req_status = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "ii", $status, $interid);
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
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-search" title="Search"><i class="fas fa-filter"></i> Custom filter</button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Available Units</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $bank_id = $bank_details['id'];
                            if(isset($_POST['search-blood'])) {
                              $blood_id = $_POST['bloodtype'];
                              $quantity = $_POST['units'];
                            
                            $sql = "SELECT pouch.`id`, pouch.`blood_id`, pouch.units, blood_bank.`id`, blood_bank.`bank_name`, blood_bank.`address`, blood_bank.`email`, blood_bank.`phone`, blood_bank.`county`, blood_type.`b_name`
                                    FROM pouch LEFT OUTER JOIN blood_bank ON pouch.`bank_id` = blood_bank.`id`
                                    JOIN blood_type ON blood_type.`id` = pouch.`blood_id`
                                    WHERE pouch.`pouch_status` = 1 AND blood_bank.`bank_status` = 1 AND pouch.`blood_id` = $blood_id AND (pouch.units - $quantity) > 0 AND (pouch.units - $quantity) < ((1/2)*$quantity) AND pouch.`bank_id` != $bank_id
                                    AND pouch.`id` NOT IN (
                                          SELECT pouch_id
                                          FROM inter_bank
                                          WHERE req_bank = $bank_id AND pouch_id IS NOT NULL
                                      )
                                    GROUP BY pouch.blood_id, pouch.bank_id
                                    HAVING DATEDIFF(NOW(), MAX(pouch.fill_date)) <= 35 
                                    ORDER BY (pouch.units - $quantity) ASC";
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $pouchid, $bloodid, $units, $apprbankid, $bank_name, $bank_address, $bank_mail, $bank_phone, $bank_county, $blood_name);
    
                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {

                        ?>
                        
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $bank_name; ?></td>
                        <td><?php echo $bank_address; ?><br><?php echo $bank_county; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $bank_mail; ?><br><b class="text-muted">contact: </b><?php echo $bank_phone; ?></td>
                        <td><span class="badge badge-danger" style="font-size: 16px;"><?php echo $units; ?></span> Remaining <br class="text-danger"><b class="text-danger"><?php echo $blood_name; ?></b></td>
                        <td>
                            <a class="btn btn-danger btn-sm btn-req" href="#" href="#" data-toggle="modal" data-target="#modal-appeal"
                            data-id = '<?php echo $apprbankid; ?>'
                            blood-qty = '<?php echo $quantity; ?>'
                            pouch = '<?php echo $pouchid; ?>'
                            bank-blood = '<?php echo "$bank_name | $blood_name | $quantity"; ?>'>
                            <i class="fas fa-hand-holding-heart">
                            </i>
                            Request
                        </a>
                        </td>
                        </tr>
                        <?php
                          $count++;
                            }
                            // Close the statement and database connection
                            mysqli_stmt_close($stmt);
                            // mysqli_close($conn);
                          }else{
                            echo "<h2 class = 'badge badge-danger'>You've Not made the Custom Search Yet</h2>";
                          }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Available units</th>
                        <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                  <div class="card">
                    <!-- /.card-header -->
                    <div class="card-header">
                    <h3 class="card-title">Previous Requests</h3>
                    </div>
                    
                    <div class="card-body">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Request Date</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Requested Units</th>
                        <th>Action / Comments</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                             $bank_id = $bank_details['id'];
                          
                            
                            $sql = "SELECT inter_bank.`id`, req_date, quantity, req_status, inter_bank.comments,
                                    blood_bank.`bank_name`, blood_bank.`address`, blood_bank.`email`, blood_bank.`phone`, blood_bank.`county`, blood_bank.`bank_status`,
                                    pouch.`blood_id`, pouch.`id`, blood_type.`b_name`, pouch.`pouch_status`, (35 - DATEDIFF(NOW(), pouch.fill_date))
                                    FROM inter_bank LEFT OUTER JOIN blood_bank ON inter_bank.`appr_bank` = blood_bank.`id`
                                    JOIN pouch ON inter_bank.`pouch_id` = pouch.`id`
                                    JOIN blood_type ON blood_type.`id` = pouch.`blood_id`
                                    WHERE req_bank = $bank_id
                                    ORDER BY req_date DESC";
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $inter_id, $req_date, $quantity, $req_status, $comments, $bank_name, $bank_address, $bank_mail, $bank_phone, $bank_county,$bank_status, $blood_id, $pouch_id, $blood_name,$pouch_status, $expiry);
    
                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {

                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $req_date; ?></td>
                        <td><?php echo $bank_name; ?></td>
                        <td><?php echo $bank_address; ?><br><?php echo $bank_county; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $bank_mail; ?><br><b class="text-muted">contact: </b><?php echo $bank_phone; ?></td>
                        <td><span class="badge badge-danger" style="font-size: 16px;"><?php echo $quantity; ?></span><br><b class="text-danger"><?php echo $blood_name; ?></b></td>
                        <td>
                          <?php if($req_status == 0) {
                            if($bank_status == 2){
                              echo "<span class='badge badge-danger'>Pending Processing</span><br>
                              RE: <b>Bank suspended/Deleted before Transfer</b>";
                            }else if($expiry < 0){
                              echo "<span class='badge badge-warning'>Pending Processing</span><br>
                              RE: <b>Pouch Expired before Transfer</b>";
                            }else if($pouch_status != 1){
                              if($pouch_status == 2){
                                echo "<span class='badge badge-warning'>Pending Processing</span><br>
                                RE: <b>Pouch Removed from Blood Bank before Transfer</b>";
                              }else if($pouch_status == 3){
                                echo "<span class='badge badge-warning'>Pending Processing</span><br>
                                RE: <b>Pouch Already Transfered to Patient</b>";
                              }
                            }else{  
                          ?>
                            <a class="btn btn-danger btn-sm btn-cancel" href="#" href="#" data-toggle="modal" data-target="#modal-reject"
                            data-id='<?php echo $inter_id;?>' 
                            bank-name = '<?php echo $bank_name;?>' 
                            req-date = '<?php echo $req_date;?>'>
                              <i class="fas fa-times"></i> Cancel Request
                            </a>
                            <?php
                             } 
                            }else if($req_status == 1){
                              echo "<span class='badge badge-success'>Transfer was a success</span><br>
                                    <span class='badge badge-danger'>#<b>$pouch_id</b></span>";
                            } else if($req_status == 2){
                              echo "<span class='badge badge-danger'>Transfer Request Rejected</span><br>
                                    RE: <b>$comments</b>";
                            }else{
                                echo "<span class='badge badge-danger'>Request Cancelled</span><br>
                                      RE: <b>You Cancelled The Transfer Request</b>";
                            }
                          ?>
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
                        <th>Requested  units</th>
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

  <div class="modal fade" id="modal-search">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Custom Search</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form name="search-blood" id="search-blood" method="POST" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <div class="form-group">
                  <label for="">Blood Type</label>
                <?php
                    include '../dbconfig.php';
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
                <select name="bloodtype" id="bloodtype" class="form-control">
                    <option value="">~Select blood Group~</option>
                    <?php foreach ($blood_types as $blood_type): ?>
                    <option value="<?php echo $blood_type['id']; ?>"><?php echo $blood_type['b_name']; ?></option>
                    <?php endforeach; ?>    
                </select>
            </div>
            <div class="form-group">
                <label for="">Units</label>
                <input type="number" name = "units" class="form-control" id="inputEmail3" placeholder="eg. 10 units">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="search-blood" class="btn btn-success btn-block">Search</button>
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

  <div class="modal fade" id="modal-appeal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Inter Bank Appeal</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Appealing to Bank....
        <h2 class="text-center"><span id="bank-blood" style="text-transform: uppercase;"></span></h2>
        </div>
        <form method="post" name="inter-request" role="inter-request" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="apprbank" id="apprbank">
        <input type="hidden" name="quantity" id="quantity">
        <input type="hidden" name="pouch" id="pouch">
          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="inter-request" class="btn btn-danger btn-block">Make Request</button>
          </div>
        </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  <!-- </div> -->
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
          <form class="">
            <div class="form-group">
                <label for="">Assign Units <small class="text-danger">(sorted according to days before expiry and units)</small></label>
                <select name="" id="" class="form-control" >
                    <option value="">Pouch:1008 - 12 units, 07 days remaining</option>
                    <option value="">1025 - 12 - 20 days remaining</option>
                    <option value="">1103 - 20 - 23 days remaining</option>
                    <option value="">1228 - 12 - 23 days remaining</option>
                    <option value="">1608 - 14 - 30 days remaining</option>
                </select>
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Transfer</button>
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
          <h4 class="modal-title">Confirm cancelling Transfer</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Cancelling....
        <h3 class="text-center"><span id="reqdate"></span> <span class="text-danger  fas fa-arrows-alt-h"></span> <span id="bankname" style="text-transform: uppercase;"></span></h3>
        </div>
        <form method="post" name="cancel-request" role="cancel-request" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="interid" id="interid">
          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="cancel-request" class="btn btn-danger btn-block">Cancelling Transfer</button>
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
  var reqbtn = document.querySelectorAll('.btn-req');
  var cancelbtn = document.querySelectorAll('.btn-cancel');

  reqbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var id = button.getAttribute('data-id');
    var qty = button.getAttribute('bank-blood');
    var quantity = button.getAttribute('blood-qty');
    var pouch = button.getAttribute('pouch');

    $('#apprbank').val(id);
    $('#quantity').val(quantity);
    $('#bank-blood').html(qty);
    $('#pouch').val(pouch);
  });
});

cancelbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var app_id = button.getAttribute('data-id');
    var app_bank = button.getAttribute('bank-name');
    var req_date = button.getAttribute('req-date');
    $('#interid').val(app_id);
    $('#bankname').html(app_bank );
    $('#reqdate').html(req_date);
  });
});
</script>
</body>
</html>
