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
        <h1>Bank Appeals</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Bank Appeals</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
        if(isset($_POST['make-appeal'])) {
        
        // Get the updated values from the form
        $bloodid = $_POST['bloodtype'];
        $target = $_POST['target'];
        $date = date("Y-m-d");
        $bank_id = $bank_details['id'];
        $status = 0;
        
      
        // Update the patient record in the database
        $sql = "INSERT INTO bank_appeals(bank_id, app_date, tgt_units, app_status, blood_id) VALUES(?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isiii", $bank_id, $date, $target, $status, $bloodid);
        if(!empty($bloodid) && !empty($target)){
          mysqli_stmt_execute($stmt);
          if(mysqli_stmt_error($stmt)) {
            // Display the error message with the styled alert
            echo '<div class="alert bg-danger">Error while inserting record, Try again later. ERROR ' . mysqli_error($conn).'</div>';
        } else { 
            // Display the success message with the styled alert
            echo '<div class="alert bg-success">Blood Appeal successful submitted</div>';   
        }
        }else{
          echo '<div class="alert bg-danger">Make Sure all fields are filled in</div>';
            
        }
        // Close the statement
        mysqli_stmt_close($stmt);
      }
    ?>
    <?php
      if(isset($_POST['end-request'])) {
        // Get the updated values from the form
        $appid = $_POST['appid'];
        $status = 2;
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE bank_appeals SET app_status = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "ii", $status, $appid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Appeal Request succesfully Terminated</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Terminatiing  Appeal: " . mysqli_error($conn)."</div>";
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
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-search" title="Search"><i class="fas fa-plus"></i> Appeal</button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Blood Type</th>
                        <th>Units</th>
                        <th>Status</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn,  "SELECT bank_appeals.id, app_date, tgt_units, coll_units, app_status, blood_id, blood_type.`b_name` FROM bank_appeals LEFT OUTER JOIN blood_type ON bank_appeals.`blood_id` = blood_type.`id` WHERE bank_id = $bank_id");

                            // Execute the statement
                            mysqli_stmt_execute($stmt);

                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $id, $appdate, $target, $collected, $app_status, $blood_id, $blood_name );

                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                              $percentage = round(($collected/$target)*100);
                              $percent = round(($collected/$target)*100, 2);
                              $percentage_diff = $percent - 100;
                        ?>

                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $appdate; ?></td>
                        <td><?php echo $blood_name ?></td>
                        <td><?php echo $target ?></td>
                        <td class="project_progress">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-green" role="progressbar" aria-volumenow="<?php echo $percentage ?>" aria-volumemin="<?php echo $percentage ?>" aria-volumemax="100" style="width: <?php echo ($percentage > 100)?" 100% ": $percentage."%" ?>">
                                </div>
                            </div>
                            <!-- <small> -->
                            <?php echo ($percentage_diff > 0)? " 100% Complete <span class= 'text-success fas fa-plus'> $percentage_diff%</span>":"$percentage % Complete"; ?>
                            <!-- </small> -->
                        </td>
                        <td>
                        <?php  if ($app_status == 0 && $percentage < 100) { ?>
                            <a class="btn btn-danger btn-sm btn-end" href="#" href="#" data-toggle="modal" data-target="#modal-end" data-id='<?php echo $id; ?>'>
                                <i class="fas fa-square">
                                </i>
                                End Request
                            </a> 
                        <?php } 
                        else if($app_status == 1 || $percentage >= 100){
                          echo "<span class='badge badge-success'>Target achieved Completed</span>";
                        }
                        else {
                          echo "<span class='badge badge-danger'>Expired/Suspended</span>";
                        }
                        ?>

                        </td>
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
                        <th>Blood Type</th>
                        <th>Units</th>
                        <th>Status</th>
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
          <h4 class="modal-title">Custom Appeal</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form method="post" name="make-appeal" role="make-appeal" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
                <input type="number" class="form-control" id="target" name="target" placeholder="eg. 10 units">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="make-appeal" class="btn btn-success btn-block">Appeal</button>
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
  
  <div class="modal fade" id="modal-end">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Ending Appeal</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Terminating....
        <h2 class="text-center"><span id="endappeal" style="text-transform: uppercase;"></span></h2>
        </div>
        <form method="post" name="end-request" role="end-request" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="appid" id="appid">
          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="end-request" class="btn btn-danger btn-block">End Appeal Request</button>
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
</body>
</html>
<script>
    var endbtn = document.querySelectorAll('.btn-end');

  endbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var app_id = button.getAttribute('data-id');
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: app_id,
                action: "endRequest"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                $('#appid').val(response.id);
                $('#endappeal').html(response.description);
                
            }
        });
  });
});
</script>