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
        <h1>Donors</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Donors</li>
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
                    <div class="card-header">
                      <h2 class="card-title">Top Donors To this Blood Bank</h2>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>   
                    <div class="card-body">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Total Donated</th>
                        <th>Next Donation</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $today = new DateTime();
                            $bank_id = $bank_details['id'];
                            $sql = "SELECT donor_donation.`id`, donor_donation.`bank_id`, donor_donation.`donor_id`, SUM(donor_donation.`quantity`) AS collective, donor_donation.`blood_id`,
                                    donor.`fname`, donor.`lname`, donor.`address`, donor.`email`, donor.`phone`,donor.`d_status`, DATEDIFF(NOW(), donor.`d_next`), blood_type.`b_name`
                                    FROM donor_donation LEFT OUTER JOIN donor ON donor_donation.`donor_id` = donor.`id`
                                    JOIN blood_type ON blood_type.`id` = donor_donation.`blood_id`
                                    WHERE donor_donation.`don_status` = 4 AND donor_donation.`bank_id` = $bank_id
                                    GROUP BY donor_donation.`donor_id`";
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $donation_id, $bank_id, $donor_id, $collective, $donor_blood_id, $don_fname, $don_lname,$don_address, $don_email,$don_phone,$don_status,$donor_next_date,$don_blood_name);
    
                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {

                              // $last_donation_date = new DateTime($donor_next_date);
                              // $donation_days = $today->diff($last_donation_date)->days;
                              // $days_left = $donation_days - 56;
                              
                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo "$don_fname $don_lname"; ?></td>
                        <td><?php echo $don_address; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $don_email; ?><br><b class="text-muted">contact: </b><?php echo $don_phone; ?></td>
                        <td><span class="badge badge-danger" style="font-size: 16px;"><?php echo $collective; ?></span><br><b class="text-danger"><?php echo $don_blood_name; ?></b></td>
                        <td><?php echo ($donor_next_date < 0)?"<b>".abs($donor_next_date)." Days to Go</b>" :"<b class='text-danger'> $donor_next_date Days Past</b>";?></td>
                        <td>
                          <!-- <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a> -->
                          <a class="btn btn-success btn-sm btn-mail <?php echo ($don_status == 2)? "disabled":""?>" href="#" data-toggle="modal" data-target="#modal-mail"
                          data-id = '<?php echo $don_email; ?>'>
                          <?php echo ($don_status == 2)? "Donor Deleted/Suspended":"<i class='fas fa-envelope'></i>"?>
                            
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
                        <th>Total Donation</th>
                        <th>Next Donation</th>
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
        <form  method="post" name="mail-donor" role="mail-donor" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="">Mail</label>
                <input type="mail" class="form-control" name="donor-mail" id="donor-mail" placeholder="eg.Donor mail" disabled>
            </div>
            <div class="form-group">
                <label for="">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="eg.Subject Matter">
            </div>
            <div class="form-group">
                <label for="">Message</label>
                <textarea class="form-control" placeholder="Message..." name = "message" style="resize:none;" name="" id="" cols="30" rows=""></textarea>
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="mail-donor" class="btn btn-success btn-block">Send</button>
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
  var mailbtn = document.querySelectorAll('.btn-mail');
  mailbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var mail = button.getAttribute('data-id');
    
    $('#donor-mail').val(mail);
  });
});
</script>
</body>
</html>
