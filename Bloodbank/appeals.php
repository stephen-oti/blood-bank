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
        <h1>Appeal Requests</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Appeal Requests</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
      if(isset($_POST['disapprove-appeal'])) {
        // Get the updated values from the form
        $appid = $_POST['appid'];
        $comment = $_POST['comments'];
        $status = 2;
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE patient_appeal SET app_status = ?, comment = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "isi", $status, $comment, $appid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Appeal Request Disaaproved</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Disapproving Appeal Request: " . mysqli_error($conn)."</div>";
          }
          
          // Close the statement
          mysqli_stmt_close($stmt);
        
      }
    ?>
    <?php
      if(isset($_POST['accept-appeal'])) {
        // Get the updated values from the form
        $appid = $_POST['acceptappid'];
        $status = 1;
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE patient_appeal SET app_status = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "ii", $status, $appid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Appeal Request Approved Successfully</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error encountered while approving Appeal Request: " . mysqli_error($conn)."</div>";
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
                        href = "report.php?bank_id=<?php echo $bank_details['id']?>&bank_name=<?php echo $bank_details['bank_name']?>&action=patient-appeals" 
                        title="Print Report" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-print"></i> Print Report</a>
                      </div>
                    </div>  
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Appeal Date</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Blood</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $bank_id = $bank_details['id'];
                            $sql = "SELECT patient_appeal.`id`, patient_appeal.`app_date`, patient_appeal.`blood_id`, patient_appeal.`units`,patient_appeal.`patient_id`,
                                    patient.`fname`, patient.`lname`,patient.`blood_id`, patient.`address`,patient.`email`, patient.`phone`, patient.`bday`, patient.`county`, patient.`gender`,
                                    patient.`p_cond`, patient.`p_report`,blood_type.`b_name`, questionnaire.`id` AS q_id
                                    FROM patient_appeal LEFT OUTER JOIN patient ON patient_appeal.`patient_id` = patient.`id`
                                    JOIN blood_type ON blood_type.`id` = patient_appeal.`blood_id`
                                    JOIN questionnaire ON questionnaire.`p_id` = patient.`id`
                                    WHERE patient_appeal.`app_status` = 0 AND patient.`p_status` = 1 AND questionnaire.`user_type` = 'patient' AND patient_appeal.`bank_id` = $bank_id
                                    ORDER BY patient_appeal.`app_date` DESC";
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $appealid, $appdate, $appbloodid, $appunits, $pat_id, $pat_fname, $pat_lname,$pat_bloodid, $pat_address, $pat_mail,$pat_phone,$pat_bday, $pat_county,$pat_gender,$pat_cond, $pat_report,$app_blood_name,$pat_qid);
    
                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {

                              $today = new DateTime();
                              $dob_date = new DateTime($pat_bday);
                              $pat_age = $today->diff($dob_date)->y;
                        ?>
                        <tr>
                          <td><?php echo $count; ?></td>
                          <td><?php echo $appdate; ?></td>
                          <td><?php echo "$pat_fname $pat_lname"; ?></td>
                          <td><?php echo $pat_address; ?><br><?php echo $pat_county; ?></td>
                          <td><b class="text-muted">mail: </b><?php echo $pat_mail; ?><br><b class="text-muted">contact: </b><?php echo $pat_phone; ?></td>
                          <td><span class="badge badge-danger" style="font-size: 16px;"><?php echo $appunits; ?></span><br><b class="text-danger"><?php echo $app_blood_name; ?></b></td>
                          <td>
                            <a class="btn btn-primary btn-sm btn-view" href="#" data-toggle="modal" data-target="#modal-view"
                              pat-gender = '<?php echo $pat_gender; ?>'
                              pat-quest = '<?php echo $pat_qid; ?>'
                              pat-cond = '<?php echo $pat_cond; ?>'
                              pat-report = '<?php echo $pat_report?>'
                              pat-name = '<?php echo $pat_lname; ?>'
                              full-name = '<?php echo "$pat_fname $pat_lname"; ?>'
                              pat-age = '<?php echo $pat_age; ?>'>
                              <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-success btn-sm btn-appr" href="#" data-toggle="modal" data-target="#modal-accept"
                            data-id = '<?php echo $appealid; ?>'
                            blood-data = '<?php echo "$app_blood_name , $appunits"; ?>'
                            pat-name = '<?php echo "$pat_fname $pat_lname"; ?>' >
                              <i class="fas fa-check"></i>
                            </a>
                            <a class="btn btn-danger btn-sm btn-disappr" href="#" data-toggle="modal" data-target="#modal-reject"
                            data-id = '<?php echo $appealid; ?>'
                            blood-data = '<?php echo "$app_blood_name , $appunits"; ?>'
                            pat-name = '<?php echo "$pat_fname $pat_lname"; ?>' >
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
                        <th>Date</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Blood</th>
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
                            $sql2 = "SELECT patient_appeal.`app_date`, patient_appeal.`units`, patient_appeal.`comment`, patient_appeal.`app_status`,
                                    patient.`fname`, patient.`lname`, patient.`address`,patient.`email`, patient.`phone`, patient.`county`,
                                    blood_type.`b_name`
                                    FROM patient_appeal LEFT OUTER JOIN patient ON patient_appeal.`patient_id` = patient.`id`
                                    JOIN blood_type ON blood_type.`id` = patient_appeal.`blood_id`
                                    WHERE (patient_appeal.`app_status` = 2 OR patient_appeal.`app_status` = 3 ) AND patient_appeal.`bank_id` = $bank_id
                                    ORDER BY patient_appeal.`app_date` DESC";
                          
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, $sql2);
    
                            // Execute the statement
                            mysqli_stmt_execute($stmt);
    
                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt,  $app_date,$app_units, $comments, $app_status, $pat_fname, $pat_lname, $pat_address, $pat_mail, $pat_phone, $pat_county, $pat_blood_name);
    
                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                            if($app_status == 3){
                              $comments = "User Canceled the Appeal Request";
                            }
                            
                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $app_date; ?></td>
                        <td><?php echo "$pat_fname $pat_lname" ?></td>
                        <td><?php echo $pat_address; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $pat_mail; ?><br><b class="text-muted">contact: </b><?php echo $pat_phone; ?></td>
                        <td><b class="text-danger"><?php echo $pat_blood_name; ?></b><br><?php echo $app_units; ?></td>
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
                        <th>Date</th>
                        <th>Name</th>
                        <th>Address</th>
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
              <b>Name</b><a class="float-right"><span id ="patient_name"></span></a>
            </li>
            <li class="list-group-item">
              <b>Gender</b><a class="float-right"><span id="pat_gender"></span></a>
            </li>
            <li class="list-group-item">
              <b>Age</b> <a class="float-right"><span id="pat_age"></span></a>
            </li>
            <li class="list-group-item">
              <b>Recent Medical Conditions</b> <a class="float-right"><span id="pat_cond"></span></a>
            </li>
            <li class="list-group-item">
              <b>Medical History</b><a id="pat_report" href="#"  data-toggle="modal" data-target="#modal-xl" class="float-right text-primary open-link"><span class="pat_name"></span>'s medical Record.pdf <i class="fas fa-external-link-alt"></i></a>
            </li>
            <li class="list-group-item">
              <b>Questionnaire</b><a id="pat_quest" href="#"  data-toggle="modal" data-target="#modal-xl" class="float-right text-primary open-link"><span class="pat_name"></span>'s - Questionnaire.pdf <i class="fas fa-external-link-alt"></i></a>
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
          <h4 class="modal-title">Confirm Disapproving Appeal</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Disapproving....
        <h2 class="text-center"><span id="disapprovedappeal" style="text-transform: uppercase;"></span> - <span id="disapproveblood" class="text-danger"></span></h2>
        </div>
        <form  method="post" name="disapprove-appeal" role="disapprove-appeal" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="appid" id="appid">
        <div class="input-group mb-3" style="width:90%; margin:auto;">
          <textarea class="form-control" name="comments" id="comments" cols="10" placeholder="Add Brief Comments..." required></textarea>
        </div>
          <div class="modal-footer">
              <!-- <div class="row"> -->
              <button type="submit" name="disapprove-appeal" class="btn btn-danger btn-block">Disapprove Appeal</button>
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
          <h4 class="modal-title">Confirm Approval Of Appeal</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Approving....
        <h2 class="text-center"><span id="acceptedappeal" style="text-transform: uppercase;"></span> - <span id="acceptbloodname" class="text-success"></span></h2>
        
        </div>
        <form method="post" name="accept-appeal" id="accept-appeal" role="accept-donation" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="acceptappid" id="acceptappid">
          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="accept-appeal" class="btn btn-success btn-block">Accept Appeal Request</button>
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
    var name = button.getAttribute('pat-name');
    var gender = button.getAttribute('pat-gender');
    var quest = button.getAttribute('pat-quest');
    var cond = button.getAttribute('pat-cond');
    var age = button.getAttribute('pat-age');
    var report = button.getAttribute('pat-report');
    var full_name = button.getAttribute('full-name');

    rep_link = "../patient/uploads/"+report;
    quest_link = "questionnaire.php?question="+quest+"&action=patient-questionnaire";

    $('#patient_name').html(full_name);
    $('#pat_gender').html(gender);
    $('#pat_age').html(age);
    $('#pat_cond').html(cond);
    $('.pat_name').html(name);
    const repTag = document.querySelector("#pat_report");
    const questTag = document.querySelector("#pat_quest");
    repTag.href = rep_link;
    questTag.href = quest_link;
  });
});

disapprovebtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var name = button.getAttribute('pat-name');
    var id = button.getAttribute('data-id');
    var blood = button.getAttribute('blood-data');
    
    $('#appid').val(id);
    $('#disapprovedappeal').html(name);
    $('#disapproveblood').html(blood);
    
  });
});

approvebtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var name = button.getAttribute('pat-name');
    var id = button.getAttribute('data-id');
    var blood = button.getAttribute('blood-data');
    
    $('#acceptappid').val(id);
    $('#acceptedappeal').html(name);
    $('#acceptbloodname').html(blood);
    
  });
});

</script>
</body>
</html>
