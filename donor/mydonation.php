<!DOCTYPE html>
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
            <h1>My donation History</h1>
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
                      <th>Code</th>
                      <th>Blood bank</th>
                      <th>Date</th>
                      <th>Blood</th>
                      <th>Contact</th>
                      <!-- <th>Action</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $donor_id = $donor_details['id'];
                        $sql = "SELECT donor_donation.`id`, donor_donation.`don_date`,donor_donation.`quantity`,
                                blood_bank.`bank_name`, blood_bank.`email`, blood_bank.`phone` 
                                FROM donor_donation LEFT OUTER JOIN blood_bank ON donor_donation.`bank_id` = blood_bank.`id`
                                JOIN donor ON donor_donation.`donor_id` = donor.`id` 
                                WHERE donor_donation.`donor_id` = $donor_id AND don_status = 4 
                                ORDER BY don_date DESC;";
                      
                        // Prepare a select statement
                        $stmt = mysqli_prepare($conn, $sql);

                        // Execute the statement
                        mysqli_stmt_execute($stmt);

                        // Bind the result variables
                        mysqli_stmt_bind_result($stmt, $id, $dondate, $quantity, $bankname, $bankmail, $bankphone);

                        // Loop through the results and create table rows
                        $count = 1;
                        while (mysqli_stmt_fetch($stmt)) {
                    ?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $bankname; ?></td>
                      <td><?php echo $dondate; ?></td>
                      <td><b class="text-danger"><?php echo $quantity; ?></b><br><span class="badge badge-danger"><?php echo $donor_blood['b_name']; ?></span></td>
                      <td><b class="text-muted">mail: </b><?php echo $bankmail; ?><br><b class="text-muted">contact: </b><?php echo $bankphone; ?></td>
                      <!-- <td>
                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                          <i class="fas fa-credit-card">
                          </i>
                            Track
                      </a>
                      </td> -->
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
                      <th>Code</th>
                      <th>Blood bank</th>
                      <th>Date</th>
                      <th>Blood</th>
                      <th>Contact</th>
                      <!-- <th>Action</th> -->
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

    <div class="modal fade" id="modal-pi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Track Your donation</h4>
          <button type="button" class="close" style="outline:none" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Blood track</p>
        </div>
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
              <h4 class="modal-title">My Donation Reports</span></h4>
              <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <?php $url = "report.php?donor_id=". $donor_details['id']."&donor_name=".$donor_details['fname']." ".$donor_details['lname']."&action=donor-donations"; ?>
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

</body>
</html>
