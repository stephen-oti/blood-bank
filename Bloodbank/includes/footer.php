<?php
  if(isset($_POST['update-officer-profile'])) {
    // Get the updated values from the form
    $offid = $_POST['offid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mail = $_POST['mail'];
    $phone = $_POST['phone'];
    $pword = $_POST['psword'];

      // Update the record in the Blood Bank table
      $stmt = mysqli_prepare($conn, "UPDATE officer SET fname = ?, lname = ?, email = ?, phone = ?, pword = ? WHERE id = ?");
      mysqli_stmt_bind_param($stmt, "sssssi", $fname, $lname, $mail, $phone, $pword, $offid);
      mysqli_stmt_execute($stmt);
      // Check if the update was successful
      if(mysqli_stmt_affected_rows($stmt) > 0) {
        echo '<div class="alert bg-success">Officer Profile updated</div>';  
        echo '<meta http-equiv="refresh" content="2">';
      } else {
        echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error updating profile: " . mysqli_error($conn)."</div>";
      }
      
      // Close the statement
      mysqli_stmt_close($stmt);
    
  }
?>
<!-- Updating Modal -->
<div class="modal fade" id="modal-acc">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Account</h4>
          <button type="button" class="close" style="outline:none" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="post" name="update-officer-profile" role="update-officer-profile" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden"  name="offid" value="<?php echo $officer_details['id'] ? $officer_details['id'] : '' ?>">
            <div class="input-group mb-3">
              <input type="text" class="form-control"  name="fname" placeholder="First name" value="<?php echo $officer_details['fname'] ? $officer_details['fname'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control"  name="lname" placeholder="Last Name" value="<?php echo $officer_details['lname'] ? $officer_details['lname'] : '' ?>">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" class="form-control" name="mail" placeholder="Email" value="<?php echo $officer_details['email'] ? $officer_details['email'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
                <input type="tel" class="form-control" name="phone" placeholder="Phone" value="<?php echo $officer_details['phone'] ? $officer_details['phone'] : '' ?>">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-phone"></span>
                  </div>
                </div>
            </div>
            <div class="input-group">
              <input type="password" class="form-control" name="psword" placeholder="Password" value="<?php echo $officer_details['pword'] ? $officer_details['pword'] : '' ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <div class="row" style="padding-top:10px;">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="update-officer-profile" id="update-officer-profile" class="btn btn-success btn-block">Update</button>
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

  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Donate Life-Save Lives: Give Blood at Your Local Blood Bank!
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 <a href="#">OBBS.co.ke</a>.</strong> All rights reserved.
  </footer>
  <!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- ChartJs -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
  </script>
  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        
      });
      $("#example3").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        
      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>