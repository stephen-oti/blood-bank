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
                              $percentage = ($collected/$target)*100;
                        ?>

                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $appdate; ?></td>
                        <td><?php echo $blood_name ?></td>
                        <td><?php echo $target ?></td>
                        <td class="project_progress">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-green" role="progressbar" aria-volumenow="<?php echo $percentage ?>" aria-volumemin="<?php echo $percentage ?>" aria-volumemax="100" style="width: 87%">
                                </div>
                            </div>
                            <small>
                            <?php echo $percentage ?>
                            </small>
                        </td>
                        <td>
                        <?php  if ($app_status == 0) { ?>
                            <a class="btn btn-danger btn-sm btn-end" href="#" href="#" data-toggle="modal" data-target="#modal-end" data-id='<?php echo $id; ?>'>
                                <i class="fas fa-square">
                                </i>
                                End Request
                            </a> 
                        <?php } 
                        else if($app_status == 1){
                          echo "<span class='badge badge-success'>Completed</span>";
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
                                                <tr>
                        <td>1</td>
                        <td>19/11/2019</td>
                        <td>B+</td>
                        <td>80</td>
                        <td class="project_progress">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-green" role="progressbar" aria-volumenow="87" aria-volumemin="0" aria-volumemax="100" style="width: 87%">
                                </div>
                            </div>
                            <small>
                                87% Complete
                            </small>
                        </td>
                        <td>
                            <a class="btn btn-danger btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-end">
                                <i class="fas fa-square">
                                </i>
                                End Request
                            </a>
                        </td>
                        </tr>
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
        <form class="">
            <div class="form-group">
                <label for="">Blood Type</label>
                <select name="" id="" class="form-control" >
                    <option value="">~Select blood Group~</option>
                    <option value="">A+</option>
                    <option value="">B+</option>
                    <option value="">AB+</option>
                    <option value="">O+</option>
                    <option value="">A-</option>
                    <option value="">B-</option>
                    <option value="">AB-</option>
                    <option value="">O-</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Units</label>
                <input type="number" class="form-control" id="inputEmail3" placeholder="eg. 10 units">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Appeal</button>
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
        <h2 class="text-center">11/2/2019 - B+</h2>
        </div>
        <div class="modal-footer">
            <!-- <div class="row"> -->
                <button type="submit" class="btn btn-danger btn-block">End</button>
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
</body>
</html>
