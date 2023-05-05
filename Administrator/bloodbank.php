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
        <h1>Blood Banks</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active">Blood Bank</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
      if(isset($_POST['addBank'])){
        $bankname = $_POST['bankname'];
        $mail = $_POST['bankmail'];
        $phone = $_POST['bankphone'];
        $address = $_POST['bankaddress'];
        $county = strtoupper(trim($_POST['bankcounty']));
        $bank_status = 0;
          
        // Update the patient record in the database
        $sql = "INSERT INTO blood_bank(bank_name,email, phone, address, county, bank_status) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssi',$bankname,$mail, $phone, $address, $county,$bank_status);
        if(!empty($bankname) && !empty($mail)&& !empty($phone)&& !empty($address)&& !empty($county)){
          // Execute the statement
            mysqli_stmt_execute($stmt);
            // Check for errors
            if(mysqli_stmt_error($stmt)) {
                // Display the error message with the styled alert
                echo '<div class="alert bg-danger">Error while adding record, Try again later</div>';
            } else { 
                // Display the success message with the styled alert
                echo '<div class="alert bg-success">Blood Bank Successfully added</div>';  
                echo '<meta http-equiv="refresh" content="3">'; 
            }
        } else {
            // // Display the error message with the styled alert
            echo '<div class="alert bg-danger">Make Sure all fields are filled in</div>';
        }

      }
    ?>
    <?php
      // Check if the form has been submitted
      if(isset($_POST['editBank'])) {
        // Get the updated values from the form
        $bankname = $_POST['ebankname'];
        $mail = $_POST['ebankmail'];
        $phone = $_POST['ebankphone'];
        $address = $_POST['ebankaddress'];
        $county = strtoupper(trim($_POST['ebankcounty']));
        $bankid = $_POST['bankid'];
          // Update the record in the Blood bank table
          $stmt = mysqli_prepare($conn, "UPDATE blood_bank SET bank_name = ?, email = ?, phone = ?, address = ?, county = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "sssssi", $bankname, $mail, $phone, $address, $county, $bankid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Blood Bank Updated Successfully</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error updating Blood Bank: " . mysqli_error($conn)."</div>";
          }
          
          // Close the statement
          mysqli_stmt_close($stmt);
        
      }
      
    ?>
        <?php
      // Check if the form has been submitted
      if(isset($_POST['deleteBank'])) {
        // Get the updated values from the form
        $bankid = $_POST['delbankid'];
        $status = 2;
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE blood_bank SET bank_status = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "ii", $status, $bankid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Blood Bank Deleted Successfully</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Deleting Blood Bank: " . mysqli_error($conn)."</div>";
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
                            <div class="clearfix float-right">
                                <button type="button" class="btn btn-info " data-toggle="modal" data-target="#modal-addbank" title="Search"><i class="fas fa-plus"></i> Add Bank</button>
                                <a class="btn btn-primary  open-link" 
                                  href = "report.php?action=banks" 
                                  title="Print Report" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-print"></i> Print Report</a>
                            </div>
                        </div>
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Bank Name</th>
                        <th>Bank Address</th>
                        <th>Contact</th>
                        <th>Location</th>
                        <th>Bank Officer</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php
                            // Prepare a select statement
                            $sql = "SELECT blood_bank.`id`, blood_bank.`bank_name`, blood_bank.`email`, blood_bank.`phone`, blood_bank.`address`, 
                                    blood_bank.`county`, blood_bank.`lat`, blood_bank.`lon`, blood_bank.`officer_id`, CONCAT(officer.`fname`,' ',officer.`lname`) AS full_name
                                    FROM blood_bank LEFT OUTER JOIN officer ON officer.`id` = blood_bank.`officer_id` WHERE blood_bank.`bank_status` != 2";

                            $stmt = mysqli_prepare($conn, $sql);

                            // Execute the statement
                            mysqli_stmt_execute($stmt);

                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $id, $bank_name, $email, $phone, $address, $county, $lat, $lon, $officerid, $officername);

                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                              ?>
                            <tr>
                              <td><?php echo $count; ?></td>
                              <td><?php echo $bank_name; ?></td>
                              <td><?php echo $address; ?></td>
                              <td><b class='text-muted'>mail: </b><?php echo $email; ?><br><b class='text-muted'>contact: </b><?php echo $phone; ?></td>
                              <td><b class='text-muted'>Lon: </b><?php echo $lon; ?><br><b class='text-muted'>Lat: </b><?php echo $lat ?></td>
                              <td><?php echo ($officerid == Null)? "Not assigned" : "$officerid - $officername" ?></td>
                              <td>
                              <a class='btn btn-primary btn-sm btn-edit' href='#' data-toggle='modal' data-target='#modal-edit' data-id='<?php echo $id; ?>'>
                                  <i class='fas fa-edit'></i>
                              </a>
                              <a class='btn btn-danger btn-sm btn-delete' href='#' data-toggle='modal' data-target='#modal-delete' data-id='<?php echo $id; ?>'>
                                  <i class='fas fa-times'></i>
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
                            <th>Bank Name</th>
                            <th>Bank Address</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Bank Officer</th>
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

  <div class="modal fade" id="modal-addbank">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Bank</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" name="add-bank" id="add-bank" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <span class="response" data-input="bankname"></span>
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="bankname" placeholder="Bank name" onkeyup="validateInput('bankname')">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <span class="response" data-input="bankmail"></span>
            <div class="input-group mb-3">
              <input type="email" class="form-control" name="bankmail" placeholder="Email" onkeyup="validateInput('bankmail')">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <span class="response" data-input="bankaddress"></span>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="bankaddress" placeholder="Provide Your address..." cols="30" onkeyup="validateInput('bankaddress')">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-home"></span>
                  </div>
                </div>
              </div>
            <span class="response" data-input="bankphone"></span>
            <div class="input-group mb-3">
                <input type="tel" class="form-control" name="bankphone" placeholder="Phone" onkeyup="validateInput('bankphone')">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
            </div>
            <span class="response" data-input="bankcounty"></span>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="bankcounty" placeholder="County" onkeyup="validateInput('bankcounty')">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-globe"></span>
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="addBank" id="addBank" class="btn btn-success btn-block">Add Bank</button>
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
  <div id="myresponse"></div>

  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Bank</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="post" name="edit-bank" id="edit-bank" role="edit-bank" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" class="form-control" id="bankid" name="bankid" >
            <span class="response" data-input="bankname"></span>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="ebankname" name="ebankname" placeholder="Bank name" onkeyup="validateInput('ebankname')" >
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <span class="response" data-input="ebankmail"></span>
            <div class="input-group mb-3">
              <input type="email" class="form-control" id="ebankmail" name="ebankmail" placeholder="Email" onkeyup="validateInput('ebankmail')" >
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <span class="response" data-input="ebankaddress"></span>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="ebankaddress" name="ebankaddress" placeholder="Provide Your address..." onkeyup="validateInput('ebankaddress')" >
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-home"></span>
                  </div>
                </div>
              </div>
            <span class="response" data-input="ebankphone"></span>
            <div class="input-group mb-3">
                <input type="tel" class="form-control" id="ebankphone" name="ebankphone" placeholder="Phone" onkeyup="validateInput('ebankphone')" >
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
            </div>
            <span class="response" data-input="ebankcounty"></span>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="ebankcounty" name="ebankcounty" placeholder="County" onkeyup="validateInput('ebankcounty')" >
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-globe"></span>
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="editBank" id="editBank" class="btn btn-success btn-block">EditBank</button>
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
          <h4 class="modal-title">Confirm Deleting Blood Bank</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Deleting....
        <h2 class="text-center"><span id="confirmBank" style="text-transform: uppercase;"></span></h2>
        </div>
        <div class="modal-footer">
            <!-- <div class="row"> -->
            <form method="post" name="delete-bank" id="delete-bank" role="delete-bank" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" class="form-control" id="delbankid" name="delbankid" >
                <button type="submit" name = "deleteBank" class="btn btn-danger btn-block">Delete</button>
            </form>
            <!-- </div> -->

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
  // Attach click event listeners to the edit and delete buttons
var editButtons = document.querySelectorAll('.btn-edit');
var deleteButtons = document.querySelectorAll('.btn-delete');

editButtons.forEach(function(button) {
  button.addEventListener('click', function() {
    var editBank_id = button.getAttribute('data-id');
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: editBank_id,
                action: "editBank"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                $('#bankid').val(response.id);
                $('#ebankname').val(response.bank_name);
                $('#ebankmail').val(response.email);
                $('#ebankphone').val(response.phone);
                $('#ebankaddress').val(response.address);
                $('#ebankcounty').val(response.county);
                $('#ebanklat').val(response.lat);
                $('#ebanklon').val(response.lon);
            }
        });
  });
});

deleteButtons.forEach(function(button) {
  button.addEventListener('click', function() {
    var deleteBank_id = button.getAttribute('data-id');
    // console.log(id);
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: deleteBank_id,
                action: "deleteBank"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                console.log("Delete response:", response);
                $('#delbankid').val(response.id);
                $('#confirmBank').html(response.bank_name)
            }
        });
  });
});
</script>
</body>
</html>
