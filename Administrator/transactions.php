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
        <h1>Transactions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active">Transactions</li>
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
                  

                  <div class="row">
                          <div class="col-md-4 col-sm-6 col-12">
                            <div class="info-box">
                              <span class="info-box-icon bg-success"><i class="fas fa-arrow-down"></i></span>
                
                              <div class="info-box-content">
                                <span class="info-box-text">Blood In</span>
                                <span class="info-box-number"><?php 
                                  $sql_totunits = "SELECT SUM(units) FROM pouch";
                                  $stmt = mysqli_prepare($conn, $sql_totunits);
                                  mysqli_stmt_execute($stmt);
                                  mysqli_stmt_store_result($stmt);
                                    mysqli_stmt_bind_result($stmt, $total_units);
                                    mysqli_stmt_fetch($stmt);
                                    
                                    if($total_units  == null){
                                      echo "0 Units";
                                    }else{
                                      echo $total_units." Units";
                                    }

                                    // Close the statement and database connection
                                    mysqli_stmt_close($stmt);
                                ?></span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                          </div>
                          <!-- /.col -->
                          <div class="col-md-4 col-sm-6 col-12">
                              <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-arrow-up"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">Blood Out</span>
                                  <span class="info-box-number"><?php 
                                  $sql_totunits = "SELECT SUM(units) FROM pouch WHERE pouch_status = 3";
                                  $stmt = mysqli_prepare($conn, $sql_totunits);
                                  mysqli_stmt_execute($stmt);
                                  mysqli_stmt_store_result($stmt);
                                    mysqli_stmt_bind_result($stmt, $total_units);
                                    mysqli_stmt_fetch($stmt);
                                    
                                    if($total_units  == null){
                                      echo "0 Units";
                                    }else{
                                      echo $total_units." Units";
                                    }

                                    // Close the statement and database connection
                                    mysqli_stmt_close($stmt);
                                ?></span>
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                              <!-- /.info-box -->
                            </div>
                          <div class="col-md-4 col-sm-6 col-12">
                            <div class="info-box">
                              <span class="info-box-icon bg-warning"><i class="fas fa-times"></i></span>
                
                              <div class="info-box-content">
                                <span class="info-box-text">Expired Blood</span>
                                <span class="info-box-number"><?php 
                                  $sql_totunits = "SELECT SUM(units) FROM pouch WHERE DATEDIFF(NOW(), fill_date) > 35 OR pouch_status = 2";
                                  $stmt = mysqli_prepare($conn, $sql_totunits);
                                  mysqli_stmt_execute($stmt);
                                  mysqli_stmt_store_result($stmt);
                                    mysqli_stmt_bind_result($stmt, $total_units);
                                    mysqli_stmt_fetch($stmt);
                                    
                                    if($total_units  == null){
                                      echo "0 Units";
                                    }else{
                                      echo $total_units." Units";
                                    }

                                    // Close the statement and database connection
                                    mysqli_stmt_close($stmt);
                                ?></span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                          </div>
                          <!-- /.col -->
                      </div>
                        <!-- /.row -->
                        <div class="card">
                          <div class="card-header">
                            <h3 class="card-title">Transaction Type</h3>
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <canvas id="graphCanvas" style="width:100%;max-width:600px"></canvas>
                          </div>      
                        </div>

                <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Donations</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Transfusions</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Inter-Bank Appeals</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                    <div class="card">   
                          <div class="card-body">
                          <table id="example1" class="table table-bordered table-striped">
                              <thead>
                              <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Donor</th>
                              <th>Blood Bank</th>
                              <th>Contact</th>
                              <th>Blood</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                                  
                                  $sql = "SELECT donor_donation.`don_date`, donor.`fname`, donor.`lname`, donor.`email`, donor.`phone`, blood_type.`b_name`, pouch.`id`, blood_bank.bank_name
                                          FROM donor_donation LEFT OUTER JOIN donor ON donor_donation.`donor_id` = donor.`id`
                                          JOIN blood_type ON donor.`blood_id` = blood_type.`id`
                                          JOIN blood_bank on blood_bank.id = donor_donation.bank_id
                                          JOIN pouch ON pouch.`donation_id` = donor_donation.`id`
                                          WHERE donor_donation.`don_status` = 4";
                                
                                  // Prepare a select statement
                                  $stmt = mysqli_prepare($conn, $sql);
          
                                  // Execute the statement
                                  mysqli_stmt_execute($stmt);
          
                                  // Bind the result variables
                                  mysqli_stmt_bind_result($stmt, $don_date, $don_fname, $don_lname, $don_mail, $don_phone, $don_blood, $don_pouch, $bankName);
          
                                  // Loop through the results and create table rows
                                  $count = 1;
                                  while (mysqli_stmt_fetch($stmt)) {
                              ?>
                              <tr>
                              <td><?php echo $count; ?></td>
                              <td><?php echo $don_date; ?></td>
                              <td><?php echo "$don_fname $don_lname"; ?></td>
                              <td><?php echo $bankName; ?></td>
                              <td><b class="text-muted">mail: </b><?php echo $don_mail; ?><br><b class="text-muted">contact: </b><?php echo $don_phone; ?></td>
                              <td><span class="badge badge-danger" style="font-size: 16px;"><?php echo $don_blood; ?></span><br><b class="text-muted">Pouch: </b><?php echo $don_pouch; ?></td>
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
                                <th>Date</th>
                                <th>Type</th>
                                <th>Donor</th>
                                <th>Blood Bank</th>
                                <th>Contact</th>
                                <th>Blood</th>
                              </tr>
                              </tfoot>
                          </table>
                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="card">   
                        <div class="card-body">
                          <table id="example2" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Patient</th>
                              <th>Blood Bank</th>
                              <th>Contact</th>
                              <th>Blood</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                   
                                    $sql = "SELECT transfusion.`trans_date`, transfusion.`pouch_id`,blood_bank.bank_name,
                                            patient.`fname`, patient.lname, patient.`email`, patient.`phone`,
                                            blood_type.`b_name`
                                            FROM transfusion LEFT OUTER JOIN patient_appeal ON patient_appeal.`id` = transfusion.`app_id`
                                            JOIN patient ON patient.`id` = patient_appeal.`patient_id`
                                            JOIN blood_bank ON blood_bank.id = patient_appeal.bank_id
                                            JOIN blood_type ON blood_type.`id` = patient_appeal.`blood_id`
                                            WHERE patient_appeal.`app_status` = 4";
                                  
                                    // Prepare a select statement
                                    $stmt = mysqli_prepare($conn, $sql);
            
                                    // Execute the statement
                                    mysqli_stmt_execute($stmt);
            
                                    // Bind the result variables
                                    mysqli_stmt_bind_result($stmt, $app_date, $pat_pouch,$bank_name, $pat_fname, $pat_lname, $pat_mail, $pat_phone, $pat_blood);
            
                                    // Loop through the results and create table rows
                                    $count = 1;
                                    while (mysqli_stmt_fetch($stmt)) {
                                ?>
                                <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $app_date; ?></td>
                                <td><?php echo "$pat_fname $pat_lname"; ?></td>
                                <td><?php echo $bank_name; ?></td>
                                <td><b class="text-muted">mail: </b><?php echo $pat_mail; ?><br><b class="text-muted">contact: </b><?php echo $pat_phone; ?></td>
                                <td><span class="badge badge-danger" style="font-size: 16px;"><?php echo $pat_blood; ?></span><br><b class="text-muted">Pouch: </b><?php echo $pat_pouch; ?></td>
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
                                  <th>Date</th>
                                  <th>Patient</th>
                                  <th>Blood Bank</th>
                                  <th>Contact</th>
                                  <th>Blood</th>
                                </tr>
                              </tfoot>
                          </table>
                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <!-- /.tab-pane -->
  
                    <div class="tab-pane" id="settings">
                    <div class="card">   
                          <div class="card-body">
                          <table id="example3" class="table table-bordered table-striped">
                              <thead>
                              <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Source Bank</th>
                              <th>Destination Bank</th>
                              <th>Units</th>
                              <th>Blood</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                                    
                                    $sql = "SELECT transfer.trans_date, (SELECT bank_name FROM blood_bank WHERE id = transfer.appr_bank) AS approving_bank,  transfer.req_bank, transfer.pouch_id ,pouch.units, inter_bank.quantity, blood_type.b_name,
                                            blood_bank.bank_name, blood_bank.email, blood_bank.phone
                                            FROM transfer
                                            LEFT OUTER JOIN inter_bank ON inter_bank.id = transfer.`inter_bank_id`
                                            JOIN pouch ON pouch.id = transfer.`pouch_id`
                                            JOIN blood_type ON blood_type.id = pouch.blood_id
                                            JOIN blood_bank ON blood_bank.id = transfer.`req_bank`
                                            WHERE inter_bank.req_status = 1";
                                  
                                    // Prepare a select statement
                                    $stmt = mysqli_prepare($conn, $sql);
            
                                    // Execute the statement
                                    mysqli_stmt_execute($stmt);
            
                                    // Bind the result variables
                                    mysqli_stmt_bind_result($stmt, $trans_date, $appr_bank, $req_bank, $pouch_id, $units, $requested_qty, $blood_name, $bank_name,$bank_mail, $bank_phone);
            
                                    // Loop through the results and create table rows
                                    $count = 1;
                                   
                                     
                                    while (mysqli_stmt_fetch($stmt)) {
                                ?>
                              <tr>
                              <td><?php echo $count; ?></td>
                              <td><?php echo $trans_date; ?></td>
                              <td><?php echo $appr_bank; ?></td>
                              <td><?php echo $bank_name; ?></td>
                              <td><span class="badge badge-success" style="font-size: 16px;"><?php echo $units; ?></span> - <span class="badge badge-danger" style="font-size: 16px;"><?php echo $requested_qty; ?></span></td>
                              <td><span class="badge badge-danger" style="font-size: 16px;"><?php echo $blood_name; ?></span><br><b class="text-muted">Pouch: </b><?php echo $pouch_id; ?></td>
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
                              <th>Date</th>
                              <th>Source Bank</th>
                              <th>Destination Bank</th>
                              <th>Units</th>
                              <th>Blood</th>
                              </tr>
                              </tfoot>
                          </table>
                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.nav-tabs-custom -->
                </div>
              </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- /.Footer -->

</div>
<!-- ./wrapper -->
  <script>
    $(document).ready(function () {
             showGraph();
         });
 
 
         function showGraph()
         {
            var units = [100,49];
            var type = ["Donations","Appeals"];
            var myColors = ["#8b008b",  "#ffd700"];



            var chartdata = {
                labels: type,
                datasets: [
                    {
                        label: 'Transactions Type',
                        backgroundColor: myColors,
                      //  borderColor: '#46d5f1',
                        hoverBackgroundColor: '#ff4d4d',
                      //  hoverBorderColor: '#666666',
                        data: units
                    }
                ]
              };


            var graphTarget = $("#graphCanvas");

            var barGraph = new Chart(graphTarget, {
                type: 'bar',
                data: chartdata,
                options: {
                indexAxis: 'y',
                }

              });
             
             
         }
 </script>

 
</body>
</html>
