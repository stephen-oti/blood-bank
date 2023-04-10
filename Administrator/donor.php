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
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active">Donors</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
      if(isset($_POST['edit-donor'])) {
        
        // Get the updated values from the form
        $id = $_POST['edonid'];
        $fname = $_POST['efname'];
        $lname = $_POST['elname'];
        $mail = $_POST['email'];
        $phone = $_POST['ephone'];
        $dob = $_POST['ebday'];
        $address = $_POST['eaddress'];
        $county = strtoupper(trim($_POST['ecounty']));
        $psword = $_POST['epsword'];
        $gender = $_POST['egender'];
      
        // Update the patient record in the database
        $sql = "UPDATE donor SET fname = ?, lname = ?, email = ?, phone = ?, bday = ?, address = ?, county = ?, pword = ?, gender = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssssi", $fname, $lname, $mail, $phone, $dob, $address, $county, $psword, $gender, $id);
        mysqli_stmt_execute($stmt);
      
        // Check if the update was successful
        if(mysqli_stmt_affected_rows($stmt) > 0) {
          echo '<meta http-equiv="refresh" content="2">';
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Donor Updated successfully</div>';
        } else {
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Update failed. Please try again.</div>';
        }
      
        // Close the statement
        mysqli_stmt_close($stmt);
      }
    ?>
    <?php
      if(isset($_POST['delete-donor'])) {
        
        // Get the updated values from the form
        $id = $_POST['deldonId'];
        $status = 2;
        
      
        // Update the patient record in the database
        $sql = "UPDATE donor SET d_status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $status, $id);
        mysqli_stmt_execute($stmt);
      
        // Check if the update was successful
        if(mysqli_stmt_affected_rows($stmt) > 0) {
          echo '<meta http-equiv="refresh" content="2">';
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Donor Deleted successfully</div>';
        } else {
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Delete failed. Please try again.</div>';
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
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Blood Type</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, "SELECT donor.id, fname, lname, email, phone, bday, address, county, gender, blood_id, blood_type.b_name FROM donor  LEFT OUTER JOIN blood_type ON blood_type.id = donor.blood_id WHERE donor.d_status != 2");

                            // Execute the statement
                            mysqli_stmt_execute($stmt);

                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $id, $fname, $lname, $email, $phone, $bday, $address, $county, $gender, $blood_id, $blood_name);

                            // Loop through the results and create table rows
                            $count = 1;
                            $today = new DateTime();
                            while (mysqli_stmt_fetch($stmt)) {
                              $fullname = $fname." ".$lname;
                              $dob_date = new DateTime($bday);
                              $age = $today->diff($dob_date)->y;
                        ?>
                        <tr>
                          <td><?php echo $count; ?></td>
                          <td><?php echo $fullname; ?></td>
                          <td><?php echo $age; ?></td>
                          <td><?php echo $address; ?><br><?php echo $county; ?></td>
                          <td><b class="text-muted">mail: </b><?php echo $email; ?><br><b class="text-muted">contact: </b><?php echo $phone; ?></td>
                          <td><b class="text-danger"><?php echo ($blood_id == Null)? "<span class='badge badge-danger'>Pednding update</span>" : "$blood_name"; ?></b></td>
                          <td>
                            <a class="btn btn-primary btn-sm btn-edit <?php echo ($blood_id == Null)? "disabled" : ""; ?>" href="#" data-toggle="modal" data-target="#modal-edit" data-id='<?php echo $id; ?>'>
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
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Total Donation</th>
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
          <h4 class="modal-title">Update profile</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form name="edit-donor" id="edit-donor" method="post" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <input type="hidden" id="edonid" name="edonid">
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
                <select name="ebloodtype" id="ebloodtype" class="form-control" disabled>
                    <option value="">~Select blood Group~</option>
                    <?php foreach ($blood_types as $blood_type): ?>
                    <option value="<?php echo $blood_type['id']; ?>"><?php echo $blood_type['b_name']; ?></option>
                    <?php endforeach; ?>    
                </select>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-tint"></span>
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
                <select name="egender" id="egender"  class="form-control">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
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
                <input type="date" class="form-control" id="ebday" name="ebday" placeholder="DOB">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-calendar"></span>
                  </div>
                </div>
            </div>
            <div class="input-group mb-3">
              <textarea class="form-control" placeholder="Provide Your address..." style="resize:none;" name="eaddress" id="eaddress" cols="30" rows=""></textarea>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-home"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="ecounty" name="ecounty" placeholder="County">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-globe"></span>
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
                <button type="submit" name="edit-donor" class="btn btn-success btn-block">Update</button>
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
          <h4 class="modal-title">Confirm Deleting Donor</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Deleting....
        <h2 class="text-center"><span id="deldonname" style="text-transform: uppercase;"></span></h2>
        </div>
        <form method="post" name="delete-donor" role="delete-donor" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <input type="hidden" name="deldonId" id="deldonId">
          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="delete-donor" class="btn btn-danger btn-block">Delete Donor</button>
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
    $(document).ready(function () {
             showGraph();
         });
 
 
         function showGraph()
         {
             
                
                     
                     var units = [100,24,60,7,9,1,6,7];
                     var type = ["A+","A-","B+","B-","AB+","AB-","O+","O-"];
 
 
                     var chartdata = {
                         labels: type,
                         datasets: [
                             {
                                 label: 'Blood Types',
                                 backgroundColor: '#4F98C3',
                                 borderColor: '#46d5f1',
                                 hoverBackgroundColor: '#7ab1d1',
                                 hoverBorderColor: '#666666',
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
 <script>
  var editbtn = document.querySelectorAll('.btn-edit');
  var deletebtn = document.querySelectorAll('.btn-delete');


  editbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var off_id = button.getAttribute('data-id');
    // console.log("The Edit Id: " +off_id);
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: off_id,
                action: "returnDonor"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                // console.log(response);
                $('#edonid').val(response.id);
                $('#efname').val(response.firstname);
                $('#elname').val(response.lastname);
                $('#ebloodtype').val(response.bloodtype);
                $('#egender').val(response.gender);
                $('#email').val(response.email);
                $('#ephone').val(response.phone);
                $('#epsword').val(response.pass); 
                $('#eaddress').val(response.address); 
                $('#ecounty').val(response.county); 
                $('#ebday').val(response.bday); 
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
                action: "returnDonor"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                $('#deldonId').val(response.id);
                $('#deldonname').html(response.fullName);
            }
        });
  });
});
 </script>
</body>
</html>
