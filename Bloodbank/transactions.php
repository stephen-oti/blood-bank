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
        <h1>Transaction</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood Bank</a></li>
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
                        <div class="card-header">
                            <div class="clearfix">
                              <a class="btn btn-primary float-right open-link" 
                              href = "report.php?action=bank-donations" 
                              title="Print Report" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-print"></i> Print Report</a>
                            </div>
                          </div>  
                          <div class="card-body">
                          <table id="example1" class="table table-bordered table-striped">
                              <thead>
                              <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Donor</th>
                              <th>Contact</th>
                              <th>Blood</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                                  $bank_id = $bank_details['id'];
                                  $sql = "SELECT donor_donation.`don_date`, donor.`fname`, donor.`lname`, donor.`email`, donor.`phone`, blood_type.`b_name`, pouch.`id`
                                          FROM donor_donation LEFT OUTER JOIN donor ON donor_donation.`donor_id` = donor.`id`
                                          JOIN blood_type ON donor.`blood_id` = blood_type.`id`
                                          JOIN pouch ON pouch.`donation_id` = donor_donation.`id`
                                          WHERE donor_donation.`don_status` = 4 AND donor_donation.`bank_id`= $bank_id";
                                
                                  // Prepare a select statement
                                  $stmt = mysqli_prepare($conn, $sql);
          
                                  // Execute the statement
                                  mysqli_stmt_execute($stmt);
          
                                  // Bind the result variables
                                  mysqli_stmt_bind_result($stmt, $don_date, $don_fname, $don_lname, $don_mail, $don_phone, $don_blood, $don_pouch);
          
                                  // Loop through the results and create table rows
                                  $count = 1;
                                  while (mysqli_stmt_fetch($stmt)) {
                              ?>
                              <tr>
                              <td><?php echo $count; ?></td>
                              <td><?php echo $don_date; ?></td>
                              <td><?php echo "$don_fname $don_lname"; ?></td>
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
                                <th>Receipient/Donor</th>
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
                          <div class="card-header">
                            <div class="clearfix">
                              <a class="btn btn-primary float-right open-link" 
                              href = "report.php?action=patient-transfusions" 
                              title="Print Report" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-print"></i> Print Report</a>
                            </div>
                          </div>  
                        <div class="card-body">
                          <table id="example2" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Patient</th>
                              <th>Contact</th>
                              <th>Blood</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $bank_id = $bank_details['id'];
                                    $sql = "SELECT transfusion.`trans_date`, transfusion.`pouch_id`, 
                                            patient.`fname`, patient.lname, patient.`email`, patient.`phone`,
                                            blood_type.`b_name`
                                            FROM transfusion LEFT OUTER JOIN patient_appeal ON patient_appeal.`id` = transfusion.`app_id`
                                            JOIN patient ON patient.`id` = patient_appeal.`patient_id`
                                            JOIN blood_type ON blood_type.`id` = patient_appeal.`blood_id`
                                            WHERE patient_appeal.`app_status` = 4 AND transfusion.`bank_id` = $bank_id";
                                  
                                    // Prepare a select statement
                                    $stmt = mysqli_prepare($conn, $sql);
            
                                    // Execute the statement
                                    mysqli_stmt_execute($stmt);
            
                                    // Bind the result variables
                                    mysqli_stmt_bind_result($stmt, $app_date, $pat_pouch, $pat_fname, $pat_lname, $pat_mail, $pat_phone, $pat_blood);
            
                                    // Loop through the results and create table rows
                                    $count = 1;
                                    while (mysqli_stmt_fetch($stmt)) {
                                ?>
                                <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $app_date; ?></td>
                                <td><?php echo "$pat_fname $pat_lname"; ?></td>
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
                          <div class="card-header">
                            <div class="clearfix">
                              <a class="btn btn-primary float-right open-link" 
                              href = "report.php?action=bank-transfers" 
                              title="Print Report" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-print"></i> Print Report</a>
                            </div>
                          </div> 
                          <div class="card-body">
                          <table id="example3" class="table table-bordered table-striped">
                              <thead>
                              <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Type</th>
                              <th>Bank Name</th>
                              <th>Contact</th>
                              <th>Units</th>
                              <th>Blood</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php
                                    $bank_id = $bank_details['id'];
                                    $sql = "SELECT transfer.trans_date, transfer.appr_bank, transfer.req_bank, transfer.pouch_id ,pouch.units, inter_bank.quantity, blood_type.b_name,
                                    (SELECT bank_name FROM blood_bank WHERE id = transfer.appr_bank),
                                    (SELECT email FROM blood_bank WHERE id = transfer.appr_bank),
                                    (SELECT phone FROM blood_bank WHERE id = transfer.appr_bank),
                                    blood_bank.bank_name AS req_bank_name, blood_bank.email AS req_bank_mail, blood_bank.phone AS req_bank_phone
                                    FROM transfer
                                    LEFT OUTER JOIN inter_bank ON inter_bank.id = transfer.`inter_bank_id`
                                    JOIN pouch ON pouch.id = transfer.`pouch_id`
                                    JOIN blood_type ON blood_type.id = pouch.blood_id
                                    JOIN blood_bank ON blood_bank.id = transfer.`req_bank`
                                    WHERE (transfer.appr_bank = $bank_id OR transfer.req_bank = $bank_id) AND inter_bank.req_status = 1";
                                  
                                    // Prepare a select statement
                                    $stmt = mysqli_prepare($conn, $sql);
            
                                    // Execute the statement
                                    mysqli_stmt_execute($stmt);
            
                                    // Bind the result variables
                                    mysqli_stmt_bind_result($stmt, $trans_date, $appr_bank, $req_bank, $pouch_id, $units, $requested_qty, $blood_name,$appr_bank_name, $appr_bank_mail, $appr_bank_phone, $bank_name,$bank_mail, $bank_phone);
            
                                    // Loop through the results and create table rows
                                    $count = 1;
                                    while (mysqli_stmt_fetch($stmt)) {
                                ?>
                              <tr>
                              <td><?php echo $count; ?></td>
                              <td><?php echo $trans_date; ?></td>
                              <td>
                                <?php 
                                  if($req_bank == $bank_id){
                                    echo "Incoming";
                                  }else if($appr_bank == $bank_id){
                                    echo "Outgoing";
                                  }
                                ?>
                              </td>
                              <td><?php echo ($req_bank == $bank_id)?"$appr_bank_name":"$bank_name"; ?></td>
                              <!-- <td>P.O Box 333-40100, Kisumu</td> -->
                              <td><b class="text-muted">mail: </b><?php echo ($req_bank == $bank_id)?"$appr_bank_mail":"$bank_mail"; ?><br><b class="text-muted">contact: </b><?php echo ($req_bank == $bank_id)?"$appr_bank_phone":"$bank_phone"; ?></td>
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
                              <th>Type</th>
                              <th>Bank Name</th>
                              <th>Contact</th>
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

  <div class="modal fade" id="modal-view">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">View More Details</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Next Donatiom Date</b><a class="float-right">11/06/2020</a>
            </li>
            <li class="list-group-item">
              <b>Gender</b><a class="float-right">male</a>
            </li>
            <li class="list-group-item">
              <b>Age</b> <a class="float-right">18</a>
            </li>
            <li class="list-group-item">
              <b>Medical History</b><a href="#" class="float-right text-primary"><i class="fas fa-external-link-alt"></i> Stephen medical Record.pdf</a>
            </li>
            <li class="list-group-item">
              <b>Questionnaire</b><a href="#" class="float-right text-primary"><i class="fas fa-external-link-alt"></i> Stephen-Questionnaire.pdf</a>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <div class="modal fade" id="modal-mail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Mail Donor</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
          <form class="">
            <div class="form-group">
                <label for="">Mail</label>
                <input type="mail" class="form-control" id="inputEmail3" placeholder="eg.Donor mail">
            </div>
            <div class="form-group">
                <label for="">Subject</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="eg.Subject Matter">
            </div>
            <div class="form-group">
                <label for="">Mail</label>
                <textarea class="form-control" placeholder="Blood Bank Address..." style="resize:none;" name="" id="" cols="30" rows=""></textarea>
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Send</button>
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

</body>
</html>
