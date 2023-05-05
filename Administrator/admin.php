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
        <h1>Admins</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active">Admins</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
          if(isset($_POST['delete-admin'])) {
            // Get the updated values from the form
            $admid = $_POST['delAdmId'];
            $status = 2;
              // Update the record in the Blood Bank table
              $stmt = mysqli_prepare($conn, "UPDATE admin SET admin_status = ? WHERE id = ?");
              mysqli_stmt_bind_param($stmt, "ii", $status, $admid);
              mysqli_stmt_execute($stmt);
              // Check if the update was successful
              if(mysqli_stmt_affected_rows($stmt) > 0) {
                echo '<div class="alert bg-success">Administrator succesfully deleted</div>';  
                echo '<meta http-equiv="refresh" content="2">';
              } else {
                echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Deleting Administrator: " . mysqli_error($conn)."</div>";
              }
              
              // Close the statement
              mysqli_stmt_close($stmt);
            
          }
          
        ?>
        <?php
        // Check if the form has been submitted
        if(isset($_POST['edit-admin'])) {
          // Get the updated values from the form
          $adminid = $_POST['eadminid'];
          $fname = $_POST['efname'];
          $lname = $_POST['elname'];
          $mail = $_POST['email'];
          $phone = $_POST['ephone'];
          $pword = $_POST['epsword'];
          $role = $_POST['eadminrole'];
          
            // Update the record in the Blood bank table
            $stmt = mysqli_prepare($conn, "UPDATE admin SET a_role = ?, fname = ?, lname = ?, email = ?, phone = ?, pword = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssssssi", $role, $fname, $lname, $mail, $phone, $pword, $adminid);
            mysqli_stmt_execute($stmt);
            // Check if the update was successful
            if(mysqli_stmt_affected_rows($stmt) > 0) {
              echo '<div class="alert bg-success" style="margin:8px auto; width: 95%;">Administrator Updated Successfully</div>';  
              // echo '<meta http-equiv="refresh" content="2">';
            } else {
              echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert' style='margin:8px auto; width: 95%;'>Error updating ADMINISTRATOR: " . mysqli_error($conn)."</div>";
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
                        href = "report.php?action=admins" 
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
                        <th>Role</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, "SELECT id, a_role, fname, lname, email, phone FROM admin WHERE admin_status = 1");

                            // Execute the statement
                            mysqli_stmt_execute($stmt);

                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $id, $role, $fname, $lname, $email, $phone);

                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                              $fullname = $fname." ".$lname;
                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $fullname; ?></td>
                        <td><b class="text-muted">mail: </b><?php echo $email; ?><br><b class="text-muted">contact: </b><?php echo $phone; ?></td>
                        <td><?php if($role == 'admin') { echo 'Administrator'; } else if($role == 'approval'){ echo 'Approval';}else{ echo 'Not Assigned'; } ?></td>
                        <td>
                          <a class="btn btn-primary btn-sm btn-edit" href="#" data-toggle="modal" data-target="#modal-edit" data-id='<?php echo $id; ?>'>
                            <i class="fas fa-edit"></i>
                          </a>
                          <a class="btn btn-danger btn-sm btn-delete" href="#" data-toggle="modal" data-target="#modal-delete" data-id='<?php echo $id; ?>'>
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
                            <th>Role</th>
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


  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Administrator</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="post" name="edit-admin" id="edit-admin" role="edit-admin" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="eadminid" name="eadminid">
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="efname" name="efname" placeholder="First name">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="elname" name="elname" placeholder="Last Name">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
                <input type="tel" class="form-control" id="ephone" name="ephone" placeholder="Phone">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="epsword" id="epsword" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <select name="eadminrole" id="eadminrole" class="form-control">
                <option value="">~Update Role~</option>
                <option value="approval">Approval</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="edit-admin" class="btn btn-success btn-block">Update</button>
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
          <h4 class="modal-title">Confirm Deleting Administrator</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Deleting....
        <h2 class="text-center"><span id="deladmname" style="text-transform: uppercase;"></span></h2>
        </div>
        <form method="post" name="delete-admin" id="delete-admin" role="delete-admin" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="delAdmId" id="delAdmId">
          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="delete-admin" class="btn btn-danger btn-block">Delete Admin</button>
          </div>
        </form>
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

  editbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var adm_id = button.getAttribute('data-id');
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: adm_id,
                action: "editAdmin"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                console.log(response);
                $('#eadminid').val(response.id);
                $('#efname').val(response.firstname);
                $('#elname').val(response.lastname);
                $('#email').val(response.email);
                $('#ephone').val(response.phone);
                $('#epsword').val(response.pass);
                $('#eadminrole').val(response.role);
                
            }
        });
  });
});
  deletebtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var adm_id = button.getAttribute('data-id');
    // console.log(adm_id);
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: adm_id,
                action: "deleteAdmin"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                console.log(response);
                $('#delAdmId').val(response.id);
                $('#deladmname').html(response.fullName);
            }
        });
  });
});

</script>
 
</body>
</html>
