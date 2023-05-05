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
            <h1>Appeal to Banks</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Patient</a></li>
              <li class="breadcrumb-item active">Make Appeals</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
    if(isset($_POST['make-appeal'])) {
          
          // Get the updated values from the form
          $bankid = $_POST['bank-id'];
          $bloodid = $_POST['blood-id'];
          $quantity = $_POST['quantity'];
          $appdate = date("Y-m-d");
          $patientid = $patient_details['id'];
          $appstatus = 0;
          
        
          // Update the patient record in the database
          $sql = "INSERT INTO patient_appeal(app_date, bank_id, blood_id, units, app_status, patient_id) VALUES(?, ?, ?, ?, ?,?)";
          $stmt = mysqli_prepare($conn, $sql);
          mysqli_stmt_bind_param($stmt, "siiiii", $appdate, $bankid, $bloodid, $quantity, $appstatus, $patientid);
          mysqli_stmt_execute($stmt);
          if(mysqli_stmt_error($stmt)) {
              // Display the error message with the styled alert
              echo '<div class="alert bg-danger">Error while Making an Appeal Request, Try again later. ERROR ' . mysqli_error($conn).'</div>';
          } else { 
              // Display the success message with the styled alert
              echo '<div class="alert bg-success">Blood Appeal Request Successfully Submitted</div>';
              echo '<meta http-equiv="refresh" content="2">';
  
          }
          
          // Close the statement
          mysqli_stmt_close($stmt);
        }
      ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <?php if($availability > 0){?>
                <div class="callout callout-danger">
                  <h5><i class="fas fa-hourglass-half"></i> Pending Appeal </h5>
                      You Already have a pending Application thus You can only see but may not apply for more Appeals
                </div>
              <?php } ?>

              <?php if($days > 3 || $qdate == null){ ?>
                <div class="callout callout-warning">
                  <h5><i class="fas fa-clock"></i> Questionnaire Update: <span class="badge badge-danger"><?php echo ($qdate == null)? "First Time Update":"$days Days Ago" ?></span></h5>
                      You must update The questionnaire atleast 3 days before making an appeal request
                </div>
              <?php } ?>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-trash"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Cancelled Appeals</span>
                  <span class="info-box-number">
                  <?php
                  $patient_id = $patient_details['id'];
                  $sql_appeals = "SELECT  * FROM patient_appeal WHERE patient_id = $patient_id AND app_status = 3";
                  $query_appeals = mysqli_query($conn,$sql_appeals);
                  echo mysqli_num_rows($query_appeals);
                  ?>
                  </span>
                  <a href="history.php?appeal=cancelled" class="small-box-footer bg-danger" style="border-radius: 4px;padding:2px; text-align: center;">More info <i class="fas fa-external-link-alt"></i></a>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Approved</span>
                    <span class="info-box-number"><?php
                      $sql_approved = "SELECT  * FROM patient_appeal WHERE patient_id = $patient_id AND (app_status = 1 OR app_status = 4)";
                      $query_approved = mysqli_query($conn,$sql_approved);
                      echo mysqli_num_rows($query_approved);
                      ?></span>
                    <a href="history.php?appeal=approved" class="small-box-footer bg-danger" style="border-radius: 4px;padding:2px; text-align: center;">More info <i class="fas fa-external-link-alt"></i></a>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                  <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Pending</span>
                    <span class="info-box-number"><?php echo $availability?></span>
                    <a href="history.php?appeal=pending" class="small-box-footer bg-danger" style="border-radius: 4px;padding:2px; text-align: center;">More info <i class="fas fa-external-link-alt"></i></a>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Rejected</span>
                  <span class="info-box-number"><?php
                      $sql_rej = "SELECT  * FROM patient_appeal WHERE patient_id = $patient_id AND app_status = 1";
                      $query_rej = mysqli_query($conn,$sql_rej);
                      echo mysqli_num_rows($query_rej);
                  ?></span>
                  <a href="history.php?appeal=rejected" class="small-box-footer bg-danger" style="border-radius: 4px;padding:2px; text-align: center;">More info <i class="fas fa-external-link-alt"></i></a>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-12">

            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                
                <div class="clearfix">
                    <!-- <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-search" title="Search"><i class="fas fa-filter"></i> Custom filter</button> -->
                    </div>
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
                    <th>Available Units</th>
                    <th>Distance(KM)</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $patient_status = $patient_details['p_status'];
                    $patient_rh_factor = $patient_blood['rhesus'];
                    $patient_blood_group = $patient_blood['b_group'];
                    $patient_lat = $patient_details['p_lat'];
                    $patient_lon = $patient_details['p_lon'];

                    if($patient_status != null){
                        // build the SQL query
                        $sql = "SELECT pouch.blood_id, pouch.bank_id, SUM(pouch.units) AS total_units, 
                        blood_bank.`bank_name`,blood_bank.`address`, blood_bank.`email`, blood_bank.`phone`, blood_bank.`county`, blood_bank.`lat`, blood_bank.`lon`,
                        6371 * 2* ASIN(
                            SQRT(
                                POWER(SIN((blood_bank.`lat` - $patient_lat)* PI()/180/2), 2)+
                                COS($patient_lat * PI()/180) * COS(blood_bank.`lat` * PI()/180)*
                                POWER(SIN((blood_bank.`lon` - $patient_lon) * PI()/180/2),2)
                            )
                        ) AS distance, blood_type.`b_name`
                        FROM pouch
                        LEFT OUTER JOIN  blood_bank ON blood_bank.`id` = pouch.`bank_id`
                        JOIN blood_type ON pouch.`blood_id` = blood_type.`id`
                        WHERE DATEDIFF(NOW(), pouch.fill_date) <= 35 AND pouch.pouch_status = 1 AND blood_bank.`bank_status` = 1";

                        // add conditions based on patient's blood group and rhesus factor
                        if ($user_blood == 5) {
                          // AB can receive from any blood group as long as the rhesus factor                       
                          $sql .= " AND (pouch.blood_id = 1 OR pouch.blood_id = 3  OR pouch.blood_id = 5  OR pouch.blood_id = 7)";
                          
                        }else if ($user_blood == 6) {
                          // AB can receive from any blood group as long as the rhesus factor                       
                          $sql .= " AND (pouch.blood_id = 2 OR pouch.blood_id = 4  OR pouch.blood_id = 6  OR pouch.blood_id = 8)";
                          
                        }else {
                          // other blood groups can receive from the same blood group and O, as long as the rhesus factor is compatible
                          if ($patient_rh_factor === "positive") {
                          $sql .= " AND (pouch.blood_id = $user_blood OR pouch.blood_id = 7)";
                          } else {
                          $sql .= " AND (pouch.blood_id = $user_blood OR pouch.blood_id = 8)";   
                          }
                        }

                        // order the results by distance
                        $sql .= " GROUP BY pouch.`blood_id`, pouch.`bank_id` ORDER BY distance ASC";
                        // Prepare a select statement
                        $stmt = mysqli_prepare($conn, $sql);

                        // Execute the statement
                        mysqli_stmt_execute($stmt);

                        // Bind the result variables
                        mysqli_stmt_bind_result($stmt, $blood_id, $bankid, $totalunits, $bankname, $bankaddr, $bankmail, $bankphone ,$bankcounty, $banklat, $banklon, $distance, $blood_name);
                    
                    

                        // Loop through the results and create table rows
                        $count = 1;
                        while (mysqli_stmt_fetch($stmt)) {
                    ?> 
                    <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $bankname; ?></td>
                    <td><?php echo $bankaddr; ?></td>
                    <td><b class="text-muted">mail: </b><?php echo $bankmail; ?><br><b class="text-muted">contact: </b><?php echo $bankphone; ?></td>
                    <td><span class="badge badge-danger" style="font-size: 16px;"><?php echo $blood_name; ?></span><br><b class="text-danger"><?php echo $totalunits; ?></b> Remaining</td>
                    <td><?php echo ($distance == null)? "No coordinates": round($distance, 4); ?></td>
                    <td>
                        <a class="btn btn-danger btn-sm btn-appeal  <?php echo ($availability > 0 || $days > 3 || $qdate == null)?"disabled":"";?>" href="#" href="#" data-toggle="modal" data-target="#modal-donate" 
                        blood-id = '<?php echo $blood_id; ?>'
                        bank-id = '<?php echo $bankid; ?>' >
                        <i class="fas fa-hand-holding-heart">
                        </i>
                        <?php echo ($availability > 0 || $days > 3 || $qdate == null)?"Appeal not possible":"Appeal";?>
                        
                    </a>
                    </td>
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
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Available units</th>
                    <th>Distance</th>
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

  <div class="modal fade" id="modal-search">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Custom Filter</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form class="">
            <div class="form-group">
                <label for="">Latitude</label>
                <input type="number" class="form-control" id="inputEmail3" placeholder="eg.  6.932500">
            </div>
            <div class="form-group">
                <label for="">Longitude </label>
                <input type="number" class="form-control" id="inputEmail3" placeholder="eg. 79.857622">
            </div>
            <div class="form-group">
                <label for="">Distance (KM) </label>
                <input type="number" class="form-control" id="inputEmail3" placeholder="e.g 10km">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Update</button>
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

  <div class="modal fade" id="modal-donate">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Appeal Form</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form method="post" name="make-appeal" role="make-appeal" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="">Quantity</label>
                <input type="number" class="form-control" name="quantity" id="quantity" max="20" min= "5" placeholder="5" required>
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" name="bank-id" id="bank-id">
                <input type="hidden" class="form-control" name="blood-id" id="blood-id">
            </div>
            <!-- /.col -->
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="make-appeal" class="btn btn-success btn-block">Request</button>
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
    var bank_id = button.getAttribute('bank-id');
    var blood_id = button.getAttribute('blood-id');

    $('#bank-id').val(bank_id);
    $('#blood-id').val(blood_id);
  });
});
</script>
</body>
</html>
