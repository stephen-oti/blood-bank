<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

  <!-- Header -->
<?php include 'includes/header.php'?>
<!-- /Header -->

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include 'includes/navbar.php'?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'includes/sidebar.php'?>

  <!-- /Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
        <h1>Bank Officer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active">Bank Officer</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
          if(isset($_POST['delete-officer'])) {
            // Get the updated values from the form
            $offid = $_POST['delOffId'];
            $status = 2;
              // Update the record in the Blood Bank table
              $stmt = mysqli_prepare($conn, "UPDATE officer SET o_status = ? WHERE id = ?");
              mysqli_stmt_bind_param($stmt, "ii", $status, $offid);
              mysqli_stmt_execute($stmt);
              // Check if the update was successful
              if(mysqli_stmt_affected_rows($stmt) > 0) {
                echo '<div class="alert bg-success">Officer succesfully deleted</div>';  
                // echo '<meta http-equiv="refresh" content="2">';
              } else {
                echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Deleting Officer: " . mysqli_error($conn)."</div>";
              }
              
              // Close the statement
              mysqli_stmt_close($stmt);
            
          }
          
        ?>
        <?php
          if(isset($_POST['assign-officer'])) {
            // Get the updated values from the form
            $offid = $_POST['assOffId'];
            $bank_id = $_POST['assBank'];
            $status = 1;
            $current_status = 0;

                // Check if the officer is already assigned to a bank
                $stmt = mysqli_prepare($conn, "SELECT id FROM blood_bank WHERE officer_id = ?");
                mysqli_stmt_bind_param($stmt, "i", $offid);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $num_rows = mysqli_stmt_num_rows($stmt);
                if($num_rows > 0){
                    mysqli_stmt_bind_result($stmt, $current_bank_id);
                    mysqli_stmt_fetch($stmt);
                    // Update the record in the Blood Bank table to null
                    $stmt2 = mysqli_prepare($conn, "UPDATE blood_bank SET officer_id = NULL, bank_status = ? WHERE officer_id = ? AND id = ?");
                    mysqli_stmt_bind_param($stmt2, "iii", $current_status, $offid, $current_bank_id);
                    mysqli_stmt_execute($stmt2);
                    if(mysqli_stmt_affected_rows($stmt2) > 0){
                      $stmt3 = mysqli_prepare($conn, "UPDATE blood_bank SET officer_id = ?, bank_status = ? WHERE id = ?");
                      mysqli_stmt_bind_param($stmt3, "iii", $offid, $status, $bank_id);
                      mysqli_stmt_execute($stmt3);

                      if(mysqli_stmt_affected_rows($stmt3) > 0){
                        echo '<div class="alert bg-success">Bank succesfully Reassigned</div>';
                      }else{
                        echo '<div class="alert bg-danger">Reassignment Revoked</div>';
                      }

                      mysqli_stmt_close($stmt3);

                    }
                    mysqli_stmt_close($stmt2);

                
              }else{
                $stmt4 = mysqli_prepare($conn, "UPDATE blood_bank SET officer_id = ?, bank_status = ? WHERE id = ?");
                mysqli_stmt_bind_param($stmt4, "iii", $offid, $bank_status, $bank_id);
                mysqli_stmt_execute($stmt4);
                  // Check if the update was successful
                  if(mysqli_stmt_affected_rows($stmt4) > 0) {
                    echo '<div class="alert bg-success">Bank Officer Sucessfully Assigned succesfully deleted</div>';
                  } else {
                    echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Assigning Bank To this officer: " . mysqli_error($conn)."</div>";
                  }
              }

            
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
                        href = "report.php?action=officers" 
                        title="Print Report" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-print"></i> Print Report</a>
                      </div>
                    </div> 
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Blood Bank</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, "SELECT officer.id AS o_id, officer.`fname` AS o_fname, officer.`lname` AS o_lname, 
                                                  officer.`email` AS o_mail, officer.`phone` AS o_phone, blood_bank.`id` AS b_id, blood_bank.`bank_name` AS bank_name
                                                  FROM officer LEFT OUTER JOIN blood_bank ON  officer.id = blood_bank.`officer_id` WHERE o_status = 1;");

                            // Execute the statement
                            mysqli_stmt_execute($stmt);

                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $oid, $fname, $lname, $email, $phone,$bid,$bankname);

                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                              $fullname = $fname." ".$lname;
                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $fullname; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $email; ?><br><b class="text-muted">contact: </b><?php echo $phone; ?></td>
                        <td><?php echo ($bid == Null)? "Not assigned" : "$bankname"; ?></td>
                        <td>
                          <a class="btn btn-primary btn-sm btn-edit" href="#" data-toggle="modal" data-target="#modal-edit" data-id='<?php echo $oid; ?>'>
                            <i class="fas fa-edit"></i>
                          </a>
                          <a class="btn btn-info btn-sm btn-assign" href="#" data-toggle="modal" data-target="#modal-assign" data-id='<?php echo $oid; ?>'>
                            <i class="fas fa-key"></i>
                          </a>
                          <a class="btn btn-danger btn-sm btn-delete" href="#" data-toggle="modal" data-target="#modal-delete" data-id='<?php echo $oid; ?>'>
                            <i class="fas fa-times"></i>
                          </a>
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
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Blood Bank</th>
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
  <div class="modal fade" id="modal-addofficer">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Blood Bank Officer</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="../../index.html" method="post">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="fname" placeholder="First name">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control" name="lname" placeholder="Last Name">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" class="form-control" name="mail" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
                <input type="tel" class="form-control" name="phone" placeholder="Phone">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-success btn-block">Add</button>
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

  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Donor</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="post" name="edit-officer" role="edit-officer" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="eoffid" name="eoffid">
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="efname" name="fname" placeholder="First name">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control" id="elname" name="lname" placeholder="Last Name">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" class="form-control" id="email" name="mail" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
                <input type="tel" class="form-control" id="ephone" name="phone" placeholder="Phone">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="epsword" name="epsword" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="edit-officer" id="edit-officer" class="btn btn-success btn-block">Update</button>
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

  <div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Deleting Officer</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Deleting....
        <h2 class="text-center"><span id="deloffname" style="text-transform: uppercase;"></span></h2>
        </div>
        <form method="post" name="delete-officer" role="delete-officer" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="delOffId" id="delOffId">
          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="delete-officer" class="btn btn-danger btn-block">Delete Officer</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modal-assign">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Assign Blood Bank</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="post" name="assign-officer" role="assign-officer" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="number" name="assOffId" id="assOffId">
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="assfullname" name="fullname" placeholder="Full name" disabled>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <?php
              include '../dbconfig.php';
                // Retrieve the list of blood types from the database using a prepared statement
                  $sql = "SELECT id, bank_name FROM blood_bank WHERE officer_id IS NULL AND bank_status != 2;";
                  $stmt = mysqli_prepare($conn, $sql);
                  mysqli_stmt_execute($stmt);
                  mysqli_stmt_bind_result($stmt, $bankid, $bankname);
                  
                  // Fetch the results and store them in an array
                  $banks = array();
                  while (mysqli_stmt_fetch($stmt)) {
                      $banks[] = array('id' => $bankid, 'bank_name' => $bankname);
                  }
                  
                  // Close the statement
                  mysqli_stmt_close($stmt);
                ?>
                <select name="assBank" id="assBank" class="form-control" >
                  <option value="null">~Select blood Bank~</option>
                  <?php foreach ($banks as $bank): ?>
                    <option value="<?php echo $bank['id']; ?>"><?php echo $bank['bank_name']; ?></option> 
                  <?php endforeach; ?>
                </select>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-university"></span>
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit"name="assign-officer" id="assign-officer" class="btn btn-success btn-block">Assign</button>
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

  <?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->
<script>
  var editbtn = document.querySelectorAll('.btn-edit');
  var deletebtn = document.querySelectorAll('.btn-delete');
  var assignbtn = document.querySelectorAll('.btn-assign');

  editbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var off_id = button.getAttribute('data-id');
    // console.log("The Edit Id: " +off_id);
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: off_id,
                action: "returnOfficer"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                // console.log(response);
                $('#eoffid').val(response.id);
                $('#efname').val(response.firstname);
                $('#elname').val(response.lastname);
                $('#email').val(response.email);
                $('#ephone').val(response.phone);
                $('#epsword').val(response.pass); 
            }
        });
  });
});
  deletebtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var off_id = button.getAttribute('data-id');
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: off_id,
                action: "returnOfficer"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                $('#delOffId').val(response.id);
                $('#deloffname').html(response.fullName);
            }
        });
  });
});

assignbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var off_id = button.getAttribute('data-id');
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: off_id,
                action: "assignOfficer"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                console.log(response);
                $('#assOffId').val(response.id);
                $('#assfullname').val(response.fullName);
                $('#assBank').val(response.bank_id);
            }
        });
  });
});
</script>
 
</body>
</html>
