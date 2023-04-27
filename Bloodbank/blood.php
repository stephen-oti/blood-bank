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
        <h1>Blood Unit Stock</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Blood Stock</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
      if(isset($_POST['del-pouch'])) {
        // Get the updated values from the form
        $pouch_id = $_POST['del-id'];
        $status = 2;
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE pouch SET pouch_status = ? WHERE id = ?");
          mysqli_stmt_bind_param($stmt, "ii", $status, $pouch_id );
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo '<div class="alert bg-success">Pouch Units Successfully Deleted</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Deleting pouch: " . mysqli_error($conn)."</div>";
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
                    <!-- <div class="clearfix">
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-add" title="Search"><i class="fas fa-plus"></i> Add Unit</button>
                        </div>
                    </div> -->
    
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Pouch Code</th>
                        <th>Donor</th>
                        <th>Blood Type</th>
                        <th>Qty</th>
                        <th>Donation Date</th>
                        <th>Expiry Date</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Prepare a select statement
                            $bank_id = $bank_details['id'];
                            $sql = "SELECT pouch.`id`, pouch.`fill_date`, DATEDIFF(NOW(), fill_date) AS rem_days, pouch.`units`, pouch.`pouch_status`, donor.`fname`, donor.`lname`, blood_type.`b_name` 
                                    FROM  pouch
                                    LEFT OUTER JOIN donor ON pouch.`donor_id` = donor.`id`
                                    JOIN blood_type ON pouch.`blood_id` = blood_type.`id`
                                    WHERE pouch_status = 1 AND pouch.`bank_id` = $bank_id
                                    HAVING rem_days <= 35
                                    ORDER BY fill_date ASC";
                            $stmt = mysqli_prepare($conn, $sql);

                            // Execute the statement
                            mysqli_stmt_execute($stmt);

                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $pouch_id, $filldate,$remaining_days, $quantity, $pouch_status, $donor_fname, $donor_lname, $donor_blood_name);

                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                              $expdate = date('Y-m-d', strtotime($filldate.'+ 35 days'));
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $pouch_id; ?></td>
                            <td><?php echo "$donor_fname $donor_lname"; ?></td>
                            <td><?php echo $donor_blood_name; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo $filldate; ?></td>
                            <td><?php echo $expdate ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm btn-edit" href="#" data-toggle="modal" data-target="#modal-edit"
                                data-id = '<?php echo $pouch_id; ?>'
                                data-qty = '<?php echo $quantity; ?>'
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-danger btn-sm btn-delete" href="#" data-toggle="modal" data-target="#modal-delete"
                                data-id = '<?php echo $pouch_id; ?>'
                                data-blood = '<?php echo $donor_blood_name; ?>'
                                >
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
                            <th>Pouch Code</th>
                            <th>Donor</th>
                            <th>Blood Type</th>
                            <th>Qty</th>
                            <th>Donation Date</th>
                            <th>Expiry Date</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                </div>
                <div class="card">
                  <!-- /.card-header -->
                  <div class="card-header">  
                    <h3>Blood Tray out</h3>
  
                  <div class="card-body">
                  <table id="example3" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                        <th>#</th>
                        <th>Pouch ID</th>
                        <th>Donor</th>
                        <th>Blood Type</th>
                        <th>Qty</th>
                        <th>Donation Date</th>
                        <th>Expiry Date</th>
                        <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            // Prepare a select statement
                            $bank_id = $bank_details['id'];
                            $sql = "SELECT pouch.`id`, pouch.`fill_date`, DATEDIFF(NOW(), fill_date) AS rem_days, pouch.`units`, pouch.`pouch_status`, donor.`fname`, donor.`lname`, blood_type.`b_name` 
                                    FROM  pouch
                                    LEFT OUTER JOIN donor ON pouch.`donor_id` = donor.`id`
                                    JOIN blood_type ON pouch.`blood_id` = blood_type.`id`
                                    WHERE (pouch_status = 2 OR pouch_status = 3 OR DATEDIFF(NOW(), fill_date) > 35) AND pouch.`bank_id` = $bank_id
                                    ORDER BY fill_date ASC";
                            $stmt = mysqli_prepare($conn, $sql);

                            // Execute the statement
                            mysqli_stmt_execute($stmt);

                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $pouch_id, $filldate,$remaining_days, $quantity, $pouch_status, $donor_fname, $donor_lname, $donor_blood_name);

                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                              $expdate = date('Y-m-d', strtotime($filldate.'+ 35 days'));
                        ?>
                      <tr>
                          <td><?php echo $count; ?></td>
                          <td><?php echo $pouch_id; ?></td>
                          <td><?php echo "$donor_fname $donor_lname"; ?></td>
                          <td><?php echo $donor_blood_name; ?></td>
                          <td><?php echo $quantity; ?></td>
                          <td><?php echo $filldate; ?></td>
                          <td><?php echo $expdate ?></td>
                          <td>
                            <?php if ($pouch_status == 2 ){
                              echo "<span class='badge badge-danger'>Removed from stock</span>";
                            }else if($pouch_status == 3){
                              echo "<span class='badge badge-success'>Transfered to Patient</span>";
                            }else{ ?>
                              <a class="btn btn-danger btn-sm btn-delete" href="#" data-toggle="modal" data-target="#modal-delete"
                                data-id = '<?php echo $pouch_id; ?>'
                                data-blood = '<?php echo $donor_blood_name; ?>'
                                >
                                  <i class="fas fa-times"></i>
                                  Delete Expired Blood
                              </a>
                              <?php } ?>
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
                          <th>Pouch ID</th>
                          <th>Donor</th>
                          <th>Blood Type</th>
                          <th>Qty</th>
                          <th>Donation Date</th>
                          <th>Expiry Date</th>
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
          <h4 class="modal-title">Edit Pouch</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form  method="post" name="edit-pouch" role="edit-pouch" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="pouch-id" id="edit-pouch-id">
            <div class="form-group">
                <label for="">Qty</label>
                <input type="number" class="form-control" id="edit-qty" name="edit-qty" placeholder="Quantity">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="edit-pouch" class="btn btn-success btn-block">Edit</button>
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
          <h4 class="modal-title">Confirm Deleting Unit</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Deleting....
        <h2 class="text-center"><span id="del-id-disp"></span> - <span id="del-blood-name" style="text-transform: uppercase;"></span></h2>
        </div>
        <form method="post" name="del-pouch" role="del-pouch" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="del-id" id="del-id">
          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="del-pouch" class="btn btn-danger btn-block">Delete Blood Unit</button>
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
  var editbtn = document.querySelectorAll('.btn-edit');
  var deletebtn = document.querySelectorAll('.btn-delete');

  editbtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var id = button.getAttribute('data-id');
    var qty = button.getAttribute('data-qty');

    $('#edit-pouch-id').val(id);
    $('#edit-qty').val(qty);
  });
});

deletebtn.forEach(function(button) {
  button.addEventListener('click', function() {
    var id = button.getAttribute('data-id');
    var blood = button.getAttribute('data-blood');

    $('#del-id').val(id);
    $('#del-id-disp').html(id);
    $('#del-blood-name').html(blood);

  });
});
</script>
</body>
</html>
