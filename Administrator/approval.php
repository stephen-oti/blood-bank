
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
        <h1>Requests Approval</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active">Registration Requests Approval</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
      // Check if the form has been submitted
      if(isset($_POST['reject-approval'])) {
        // Get the updated values from the form
        $reqid = $_POST['rejid'];
        $rejmail = $_POST['rejmail'];
        $status = 2;
        $admin = "Admin ".$admin_details['fname'];
        $name = $_POST['rejnames'];
        $subject = "Request Denied";

        if($_POST['comment'] == Null){
          $comment = "None provided";
        }else{
          $comment = $_POST['comment'];
        }
        $message = "Your Request application For an administrative Work at <b>OBBS</b> has been <b>Disapproved</b><br><b>Reason: </b> $comment";
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE reg_request SET comments = ?, req_status = ? WHERE req_id = ?");
          mysqli_stmt_bind_param($stmt, "sii", $comment, $status, $reqid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            include_once '../mailer.php';
            sendmail("sotieno443@gmail.com",$name,$admin,$subject,$message);

            echo '<div class="alert bg-success">Request Has been dissaproved Rejected</div>';  
            echo '<meta http-equiv="refresh" content="2">';
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error while Dissaproving request: " . mysqli_error($conn)."</div>";
          }
          
          // Close the statement
          mysqli_stmt_close($stmt);
        
      }
      
    ?>
        <?php
      // Check if the form has been submitted
      if(isset($_POST['accept-approval'])) {
        // Get the updated values from the form
        $acceptid = $_POST['acceptid'];
        $admin_role = $_POST['admin_role'];
        $comments = "Request accepted";
        $status = 1;
          // Update the record in the Blood Bank table
          $stmt = mysqli_prepare($conn, "UPDATE reg_request SET comments = ?, req_status = ? WHERE req_id = ?");
          mysqli_stmt_bind_param($stmt, "sii", $comment, $status, $acceptid);
          mysqli_stmt_execute($stmt);
          // Check if the update was successful
          if(mysqli_stmt_affected_rows($stmt) > 0) {
            //Get the user data
            $sqldetails = "SELECT * FROM reg_request WHERE req_id = $acceptid";
            $result = mysqli_query($conn, $sqldetails);
            $request = mysqli_fetch_assoc($result);
            
            if($request['req_role'] == "admin"){
              $sql = "INSERT INTO admin(req_id,a_role,fname,lname,email, phone, pword, admin_status) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
              $stmnt = mysqli_prepare($conn, $sql);
              mysqli_stmt_bind_param($stmnt, 'issssssi',$acceptid, $admin_role, $request['fname'], $request['lname'], $request['email'], $request['phone'], $request['pword'], $status);

            }else{
              $sql = "INSERT INTO officer(req_id,fname,lname,email, phone, pword, o_status) VALUES(?, ?, ?, ?, ?, ?, ?)";
              $stmnt = mysqli_prepare($conn, $sql);
              mysqli_stmt_bind_param($stmnt, 'isssssi',$acceptid, $request['fname'], $request['lname'], $request['email'], $request['phone'], $request['pword'], $status);

            }
            mysqli_stmt_execute($stmnt);
            if(mysqli_stmt_error($stmt)) {
              echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error Inserting Record to Respective Table: " . mysqli_error($conn)."</div>";
            }else{
              $usermail = $request['email'];
              $username =  $request['fname']." ".$request['lname'];
              $admin_name = "Admin ".$admin_details['fname'];
              $mailsubject = "Request Approved";
              $userpassword = $request['pword'];
              $userrole = ($request['req_role'] == "admin")? "$admin_role": "Blood Bank will be assigned shortly";
              $mailbody = "Your Application was approved <br> You were assigned the role: <b>$userrole</b><br>use username:  $usermail <br> password: $userpassword";
              include_once '../mailer.php';
              sendmail("sotieno443@gmail.com",$username,$admin_name,$mailsubject,$mailbody);

              echo '<div class="alert bg-success">Request Has beenn Succesfully approved</div>';  
              echo '<meta http-equiv="refresh" content="2">';
            }
           
          } else {
            echo "<div class='alert alert-danger alert-dismissible fade show btn-delete' role='alert'>Error while Aproving request: ". mysqli_error($conn)."</div>";
          }
          
          // Close the statement
          
          mysqli_stmt_close($stmt);
        
      }
      
    ?>
    <?php
      if($admin_details['a_role'] != "approval"){
        echo "<div style='margin: auto;'>
                <h1 style='text-align: center;'>Page Strictly Restricted For Approval Managers !!!</h1>
              </div>";
      }else{
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
                        href = "report.php?action=request-approval" 
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
                        <th>Request Role</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            // Prepare a select statement
                            $stmt = mysqli_prepare($conn, "SELECT req_id, req_role,fname,lname,email, phone FROM reg_request WHERE req_status = 0");

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
                        <td><?php if($role == 'bank_officer') { echo 'Bank Officer'; } else{ echo 'Administrator';}?></td>
                        <td>
                            <a class="btn btn-primary btn-sm btn-view" href="#" data-toggle="modal" data-target="#modal-view" data-id='<?php echo $id; ?>'>
                                <i class="fas fa-eye"></i>
                              </a>
                              <a class="btn btn-success btn-sm btn-accept" href="#" data-toggle="modal" data-target="#modal-accept" data-id='<?php echo $id; ?>'>
                                <i class="fas fa-user-plus"></i>
                              </a>
                              <a class="btn btn-danger btn-sm btn-reject" href="#" data-toggle="modal" data-target="#modal-reject" data-id='<?php echo $id; ?>'  data-mail='<?php echo $email; ?>' >
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
                            <th>Request Role</th>
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
      <?php
      }
      ?>
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
                <b>Request Date</b><a class="float-right" id="reqdate"></a>
            </li>
            <li class="list-group-item">
              <b>Qualification Document</b><a href='#' id='reqdoc' data-toggle='modal' data-target='#modal-xl' class='float-right text-primary open-link' ><i class='fas fa-external-link-alt'></i><span id='req_name'></span>'s CV.pdf</a>
            </li>
          </ul>
        </div>
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
          <h4 class="modal-title">Confirm Acceptance</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Adding....
        <h2 class="text-center"><span id="confirmacceptance" style="text-transform: uppercase;"></span></h2>
        </div>
        <form method="post" name="accept-approval" id="accept-approval" role="accept-approval" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <input type="hidden" name="acceptid" id="acceptid">
          
          <div class="form-group" style="width:90%; margin:auto;padding:16px;">
          <label for="">Assign Role</label>
          <select name="admin_role" id="admin_role" class="form-control" required>
            <option value="admin">Admin</option>
            <option value="approval">Approval</option>
          </select>
          </div>

          <div class="modal-footer">
              <!-- <div class="row"> -->
                  <button type="submit" name="accept-approval" class="btn btn-success btn-block">Accept Request</button>
          </div>
        </form>
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
          <h4 class="modal-title">Confirm Rejecting Request</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form method="post" name="reject-approval" id="reject-approval" role="reject-approval" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="" class="text-danger">Rejecting... <span id="rejname" style="text-transform: uppercase;" class="text-dark"></span></label>
        <input type="hidden" name="rejid" id="rejid">
        <input type="hidden" id="rejmail" name="rejmail">
        <input type="hidden" id="rejnames" name="rejnames">
            <div class="input-group mb-3">
                
              <textarea class="form-control" placeholder="Brief Comments..." style="resize:none;" name="comment" id="" cols="30" rows=""></textarea>
            </div>
            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="reject-approval" class="btn btn-danger btn-block">Reject</button>
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
  // Attach click event listeners to the edit and delete buttons
  var view = document.querySelectorAll('.btn-view');
  var accept = document.querySelectorAll('.btn-accept');
  var reject = document.querySelectorAll('.btn-reject');

  view.forEach(function(button) {
  button.addEventListener('click', function() {
    var reqid= button.getAttribute('data-id');
    // console.log(reqid);
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: reqid,
                action: "viewRegReq"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                $('#reqdate').html(response.Date);
                $('#req_name').html(response.fullName);
                req_link = "../RegistrationReq/uploads/"+response.cv;
                const reqTag = document.querySelector("#reqdoc");
                reqTag.href = req_link;
                // $('#reqdoc').html( "");
                
            }
        });
  });
});
accept.forEach(function(button) {
  button.addEventListener('click', function() {
    var editBank_id = button.getAttribute('data-id');
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: editBank_id,
                action: "acceptRegReq"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                console.log(response);
                $('#acceptid').val(response.id);
                $('#confirmacceptance').html(response.fullName);
                
            }
        });
  });
});
reject.forEach(function(button) {
  button.addEventListener('click', function() {
    var editBank_id = button.getAttribute('data-id');
    var mail = button.getAttribute('data-mail');
    $.ajax({
            url: "action.php",
            type: "POST",
            data: {
                id: editBank_id,
                action: "rejectRegReq"
            },
            dataType: "json",
            success: function(response) {
                // Process the response here
                console.log(response);
                $('#rejid').val(response.id);
                $('#rejmail').val(mail);
                $('#rejnames').val(response.fullName);
                $('#rejname').html(response.fullName);
            }
        });
  });
});

 </script>
</body>
</html>
