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
            <h1>My History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Patient</a></li>
              <li class="breadcrumb-item active">My History</li>
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
                    <button type="button" class="btn btn-primary float-right" title="Print Report"><i class="fas fa-print"></i> Print Report</button>
                    </div>
                </div>
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Requested Unit(s)</th>
                    <th>Status</th>
                    <!-- <th>Action</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td>1</td>
                    <td>11/07/2022</td>
                    <td>JOOTRH Kisumu national blood bank</td>
                    <td>P.O Box 333 -  40100, Kisumu</td>
                    <td><b class="text-muted">mail: </b>info@jootrh.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                    <td><b class="text-muted">Blood: </b><span class="text-danger" style="font-weight: 700;">B+</span><br><b class="text-muted">units: </b>6</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <!-- <td>
                        <a class="btn btn-danger btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-view">
                        <i class="fas fa-trash">
                        </i>
                        Cancel
                    </a>
                    </td> -->
                    </tr>
                    <tr>
                    <td>2</td>
                    <td>07/10/2022</td>
                    <td>Luanda blood bank</td>
                    <td>P.O Box 4567 -  2900, Vihiga</td>
                    <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                    <td><b class="text-muted">Blood: </b><span class="text-danger" style="font-weight: 700;">B+</span><br><b class="text-muted">units: </b>12</td>
                   
                    <td><span class="badge badge-success">Success</span></td>
                    <!-- <td>
                        <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                          <i class="fas fa-eye">
                          </i>
                          View
                        </a>
                    </td> -->
                    </tr>
                    <tr>
                    <td>3</td>
                    <td>01/11/2023</td>
                    <td>PGH blood Bank</td>
                    <td>P.O Box 4567 -  20100, Kisumu</td>
                    <td><b class="text-muted">mail: </b>bb@pgh.co.ke<br><b class="text-muted">contact: </b>+25478288939</td>
                    <td><b class="text-muted">Blood: </b><span class="text-danger" style="font-weight: 700;">B+</span><br><b class="text-muted">units: </b>6</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <!-- <td>
                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                        <i class="fas fa-trash">
                        </i>
                        cancel
                    </a>
                    </td> -->
                    </tr>
                    <tr>
                    <td>4</td>
                    <td>07/10/2022</td>
                    <td>KNH blood bank</td>
                    <td>P.O Box 0001 -  10100, Nairobi</td>
                    <td><b class="text-muted">mail: </b>blood@knh.co.ke<br><b class="text-muted">contact: </b>0200067899</td>
                    <td><b class="text-muted">Blood: </b><span class="text-danger" style="font-weight: 700;">B+</span><br><b class="text-muted">units: </b>6</td>
                    <td><span class="badge badge-success">Success</span></td>
                    <!-- <td>
                      <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                        <i class="fas fa-eye">
                        </i>
                        View
                      </a>
                    </td> -->
                    </tr>
                    <tr>
                    <td>5</td>
                    <td>07/02/2023</td>
                    <td>MTRRH blood bank</td>
                    <td>P.O Box 46894 -  40100, Eldoret</td>
                    <td><b class="text-muted">mail: </b>bank@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                    <td><b class="text-muted">Blood: </b><span class="text-danger" style="font-weight: 700;">B+</span><br><b class="text-muted">units: </b>6</td>
                    <td><span class="badge badge-danger">Rejected</span></td>
                    <!-- <td>
                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                        <i class="fas fa-eye">
                        </i>
                        View
                    </a>
                    </td> -->
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Available units</th>
                    <th>Distance</th>
                    <!-- <th>Action</th> -->
                    </tr>
                    </tfoot>
                </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-view">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Track Application</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form class="">
            <div class="form-group">
              <label for="">Application</label>
              <p class="text-muted">11/02/2022: 10:43pm - Application and processing </p>
            </div>
            <div class="form-group">
                <label for="">Request Approval</label>
                <p class="text-muted">12/02/2023 - Request Processing</p>
            </div>
            <div class="form-group">
              <label for="">Pouch ID</label>
              <p class="text-muted">12/02/2023 - #3HM08 assigned</p>
            </div>
            <div class="form-group">
              <label for="">Transfusion</label>
              <p class="text-muted">12/02/2023 - Done at Maseno Mission hospital by DR. Zagreb</p>
            </div>
            <!-- /.col -->
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Request</button>
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


  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- /.Footer -->

</div>
<!-- ./wrapper -->

</body>
</html>
