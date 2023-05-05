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
        <h1>Donation Requests</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Donation Requests</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
      if(isset($_POST['disapprove-donation'])) {
        // Get the updated values from the form
        $donid = $_POST['donid'];
        $comment = $_POST['comments'];
        $status = 2;
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE donor_donation SET don_status = ?, comment = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "isi", $status, $comment, $donid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Donation Request Disaaproved</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Disapproving Donation Request: " . mysqli_error($conn)."</div>";
          }
          
          // Close the statement
          mysqli_stmt_close($stmt);
        
      }
    ?>
    <?php
      if(isset($_POST['accept-donation'])) {
        // Get the updated values from the form
        $donid = $_POST['acceptdonid'];
        $status = 1;
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE donor_donation SET don_status = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "ii", $status, $donid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Donation Request Approved Successfully</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error encountered while approving Donation Request: " . mysqli_error($conn)."</div>";
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
                      <div class="clearfix">
                        <a class="btn btn-primary float-right open-link" 
                        href = "report.php?bank_id=<?php echo $bank_details['id']?>&bank_name=<?php echo $bank_details['bank_name']?>&action=donor-donations" 
                        title="Print Report" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-print"></i> Print Report</a>
                      </div>
                    </div>   
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Request date</th>
                        <th>Name</th>
                        <th>Blood</th>
                        <th>Contact</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                            $bank_id = $bank_details['id'];
                            $sql = "SELECT donor_donation.`id`, donor_donation.`bank_app_id`,donor_donation.`donor_id`, donor_donation.`req_date`, donor_donation.`blood_id`,donor_donation.`don_type`,
                                    donor.`fname`, donor.`lname`,donor.`bday`, donor.`email`, donor.`phone`,donor.`address`, donor.`county`, donor.`gender`, donor.`d_cond`, donor.`d_report`, 
                                    blood_type.`b_name`, 
                                    questionnaire.`id` AS q_id
                                    FROM donor_donation 
                                    LEFT OUTER JOIN donor ON donor_donation.`donor_id` = donor.`id`
                                    JOIN blood_type ON donor.`blood_id` = blood_type.`id`
                                    JOIN questionnaire ON questionnaire.`d_id` = donor.`id`
                                    WHERE donor_donation.`don_status` = 0 AND donor.`d_status` = 1 AND donor_donation.`bank_id` =  $bank_id";
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $donation_id, $bank_app_id, $donor_id, $req_date, $donor_blood_id, $donation_type, $don_fname,$don_lname,$don_bday, $don_email,$don_phone, $don_address,$don_county,$don_gender,$don_cond, $don_report,$don_blood_name,$don_qid);
    
                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {

                              $today = new DateTime();
                              $dob_date = new DateTime($don_bday);
                              $don_age = $today->diff($dob_date)->y;
                        ?>
                        
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo ($donation_type == 0)? "Bank Appeal":"Nearby Bank" ?></td>
                        <td><?php echo $req_date; ?></td>
                        <td><?php echo "$don_fname $don_lname"; ?></td>
                        <td><?php echo $don_blood_name; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $don_email; ?><br><b class="text-muted">contact: </b><?php echo $don_phone; ?></td>
                        <td>
                          <a class="btn btn-primary btn-sm btn-view" href="#" data-toggle="modal" data-target="#modal-view" 
                            don-address = '<?php echo "$don_address, $don_county"; ?>'
                            don-gender = '<?php echo $don_gender; ?>'
                            don-quest = '<?php echo $don_qid; ?>'
                            don-cond = '<?php echo $don_cond; ?>'
                            don-report = '<?php echo $don_report?>'
                            don-name = '<?php echo $don_fname; ?>'
                            don-age = '<?php echo $don_age; ?>'>
                            <i class="fas fa-eye"></i>
                          </a>
                          <a class="btn btn-success btn-sm btn-appr" href="#" data-toggle="modal" data-target="#modal-accept"
                          data-id = '<?php echo $donation_id; ?>'
                          don-name = '<?php echo "$don_fname $don_lname"; ?>' >
                            <i class="fas fa-check"></i>
                          </a>
                          <a class="btn btn-danger btn-sm btn-disappr" href="#" data-toggle="modal" data-target="#modal-reject"
                          data-id = '<?php echo $donation_id; ?>'
                          don-name = '<?php echo "$don_fname $don_lname"; ?>' >
                            <i class="fas fa-times"></i>
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
                        <th>Type</th>
                        <th>Request date</th>
                        <th>Name</th>
                        <th>Blood</th>
                        <th>Contact</th>
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
                        <h2>Unsuccessful requests</h2>
                    </div>  
                    <div class="card-body">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Blood</th>
                        <th>Reason</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $bank_id = $bank_details['id'];
                            $sql2 = "SELECT donor_donation.`req_date`, donor_donation.`blood_id`, donor_donation.`don_type`, donor_donation.`comment`,donor_donation.`don_status`,
                                    donor.`fname`, donor.`lname`, donor.`email`, donor.`phone`, blood_type.`b_name`
                                    FROM donor_donation 
                                    LEFT OUTER JOIN donor ON donor_donation.`donor_id` = donor.`id`
                                    JOIN blood_type ON donor.`blood_id` = blood_type.`id`
                                    WHERE (donor_donation.`don_status` = 2 OR donor_donation.`don_status` = 3)  AND donor_donation.`bank_id` = $bank_id";
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql2);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt,  $req_date, $donor_blood_id, $donation_type, $comments, $don_status, $don_fname, $don_lname, $don_email, $don_phone, $don_blood_name);
    
                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                            if($don_status == 3){
                              $comments = "User Canceled The Donation Request";
                            }
                            
                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo ($donation_type == 0)? "Bank Appeal":"Nearby Bank" ?></td>
                        <td><?php echo $req_date; ?></td>
                        <td><?php echo "$don_fname $don_lname"; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $don_email; ?><br><b class="text-muted">contact: </b><?php echo $don_phone; ?></td>
                        <td><b class="text-danger"><?php echo $don_blood_name; ?></b></td>
                        <td><?php echo ($comments == null)?" No Reason Provided":"$comments" ?></td>
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
              <b>Address</b><a class="float-right"><span id="don_addr"></span></a>
            </li>
            <li class="list-group-item">
              <b>Gender</b><a class="float-right"><span id="don_gender"></span></a>
            </li>
            <li class="list-group-item">
              <b>Age</b> <a class="float-right"><span id="don_age"></span></a>
            </li>
            <li class="list-group-item">
              <b>Recent Medical Conditions</b> <a class="float-right"><span id="don_cond"></span></a>
            </li>
            <li class="list-group-item">
              <b>Medical History</b><a id="don_report" href="#" data-toggle="modal" data-target="#modal-xl" class="float-right text-primary open-link"><span class="don_name"></span>'s medical Record.pdf <i class="fas fa-external-link-alt"></i></a>
            </li>
            <li class="list-group-item">
              <b>Questionnaire</b><a id="don_quest" href="#" data-toggle="modal" data-target="#modal-xl"  class="float-right text-primary open-link"><span class="don_name"></span>'s - Questionnaire.pdf <i class="fas fa-external-link-alt"></i></a>
            </li>
          </ul>
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
          <h4 class="modal-title">Confirm Rejecting Donation Request</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Disapproving....
        <h2 class="text-center"><span id="disapproveddonation" style="text-transform: uppercase;"></span></h2>
        </div>

        <form  method="post" name="disapprove-donation" role="disapprove-donation" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="donid" id="donid">
        <div class="input-group mb-3" style="width:90%; margin:auto;">
          <textarea class="form-control" name="comments" id="comments" cols="10" placeholder="Add Brief Comments..." required></textarea>
        </div>
          <div class="modal-footer">
              <!-- <div class="row"> -->
              <button type="submit" name="disapprove-donation" class="btn btn-danger btn-block">Disapprove Donation</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal-accept">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Approval Of donation</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Adding....
        <h2 class="text-center"><span id="accepteddonation" style="text-transform: uppercase;"></span></h2>
        </div>
        <form method="post" name="accept-donation" id="accept-donation" role="accept-donation" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="acceptdonid" id="acceptdonid">
          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="accept-donation" class="btn btn-success btn-block">Accept Donation Request</button>
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
  var viewbtn = document.querySelectorAll('.btn-view');
  var disapprovebtn = document.querySelectorAll('.btn-disappr');
  var approvebtn = document.querySelectorAll('.btn-appr');
  
  viewbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var name = button.getAttribute('don-name');
    var address = button.getAttribute('don-address');
    var gender = button.getAttribute('don-gender');
    var quest = button.getAttribute('don-quest');
    var cond = button.getAttribute('don-cond');
    var age = button.getAttribute('don-age');
    var report = button.getAttribute('don-report');

    rep_link = "../donor/uploads/"+report;
    quest_link = "questionnaire.php?question="+quest+"&action=donor-questionnaire";

    $('#appid').html(name);
    $('#don_addr').html(address);
    $('#don_gender').html(gender);
    $('#don_age').html(age);
    $('#don_cond').html(cond);
    $('.don_name').html(name);
    const repTag = document.querySelector("#don_report");
    const questTag = document.querySelector("#don_quest");
    repTag.href = rep_link;
    questTag.href = quest_link;
  });
});

disapprovebtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var name = button.getAttribute('don-name');
    var id = button.getAttribute('data-id');
    
    $('#donid').val(id);
    $('#disapproveddonation').html(name);
    
  });
});

approvebtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var name = button.getAttribute('don-name');
    var id = button.getAttribute('data-id');
    
    $('#acceptdonid').val(id);
    $('#accepteddonation').html(name);
    
  });
});

</script>
</body>
</html>
