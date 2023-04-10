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
            <h1>Appeal to Banks</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Patient</a></li>
              <li class="breadcrumb-item active">Make Appeals</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-hand-holding-heart"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Appeals</span>
                  <span class="info-box-number">7</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Approved</span>
                    <span class="info-box-number">4</span>
                    <a href="#" class="small-box-footer bg-danger" style="border-radius: 4px;padding:2px; text-align: center;">More info <i class="fas fa-external-link-alt"></i></a>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                  <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Pending</span>
                    <span class="info-box-number">3</span>
                    <a href="#" class="small-box-footer bg-danger" style="border-radius: 4px;padding:2px; text-align: center;">More info <i class="fas fa-external-link-alt"></i></a>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-3 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
  
                <div class="info-box-content">
                  <span class="info-box-text">Rejected</span>
                  <span class="info-box-number">0</span>
                  <a href="#" class="small-box-footer bg-danger" style="border-radius: 4px;padding:2px; text-align: center;">More info <i class="fas fa-external-link-alt"></i></a>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-12">

            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                
                <div class="clearfix">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-search" title="Search"><i class="fas fa-filter"></i> Custom filter</button>
                    </div>
                    <small style="font-size: small; color:red; font-style: italic; font-weight: 800;">(List generated based on the current location provided)</small>
                </div>
                
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Available Units <span class="text-danger">(B+)</span></th>
                    <th>Distance(KM)</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td>1</td>
                    <td>JOOTRH Kisumu national blood bank</td>
                    <td>P.O Box 333 -  40100, Kisumu</td>
                    <td><b class="text-muted">mail: </b>info@jootrh.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                    <td><span class="badge badge-danger" style="font-size: 16px;">17</span> Remaining</td>
                    <td>14</td>
                    <td>
                        <a class="btn btn-danger btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-donate">
                        <i class="fas fa-hand-holding-heart">
                        </i>
                        Appeal
                    </a>
                    </td>
                    </tr>
                    <tr>
                    <td>2</td>
                    <td>Luanda blood bank</td>
                    <td>P.O Box 4567 -  2900, Vihiga</td>
                    <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                    <td><span class="badge badge-danger" style="font-size: 16px;">14</span> Remaining</td>
                    <td>5</td>
                    <td>
                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-donate">
                        <i class="fas fa-hand-holding-heart">
                        </i>
                        Appeal
                    </a>
                    </td>
                    </tr>
                    <tr>
                    <td>3</td>
                    <td>PGH blood Bank</td>
                    <td>P.O Box 4567 -  20100, Kisumu</td>
                    <td><b class="text-muted">mail: </b>bb@pgh.co.ke<br><b class="text-muted">contact: </b>+25478288939</td>
                    <td><span class="badge badge-danger" style="font-size: 16px;">3</span> remaining</td>
                    <td>43</td>
                    <td>
                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-donate">
                        <i class="fas fa-hand-holding-heart">
                        </i>
                        Appeal
                    </a>
                    </td>
                    </tr>
                    <tr>
                    <td>4</td>
                    <td>KNH blood bank</td>
                    <td>P.O Box 0001 -  10100, Nairobi</td>
                    <td><b class="text-muted">mail: </b>blood@knh.co.ke<br><b class="text-muted">contact: </b>0200067899</td>
                    <td><span class="badge badge-danger" style="font-size: 16px;">29</span> Remaining</td>
                    <td>60</td>
                    <td>
                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-donate">
                        <i class="fas fa-hand-holding-heart">
                        </i>
                        Appeal
                    </a>
                    </td>
                    </tr>
                    <tr>
                    <td>5</td>
                    <td>MTRRH blood bank</td>
                    <td>P.O Box 46894 -  40100, Eldoret</td>
                    <td><b class="text-muted">mail: </b>bank@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                    <td><span class="badge badge-danger" style="font-size: 16px;">7</span> Remaining</td>
                    <td>20</td>
                    <td>
                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-donate">
                        <i class="fas fa-hand-holding-heart">
                        </i>
                        Appeal
                    </a>
                    </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Available units</th>
                    <th>Distance</th>
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
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-search">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Custom Filter</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form class="">
            <div class="form-group">
                <label for="">Latitude</label>
                <input type="number" class="form-control" id="inputEmail3" placeholder="eg.  6.932500">
            </div>
            <div class="form-group">
                <label for="">Longitude </label>
                <input type="number" class="form-control" id="inputEmail3" placeholder="eg. 79.857622">
            </div>
            <div class="form-group">
                <label for="">Distance (KM) </label>
                <input type="number" class="form-control" id="inputEmail3" placeholder="e.g 10km">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Update</button>
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

  <div class="modal fade" id="modal-donate">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Donation Form</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form class="">
            <div class="form-group">
                <label for="">Quantity</label>
                <input type="number" class="form-control" id="quantity" placeholder="5">
            </div>
            <div class="form-group">
                <label for="">Transfusion Center</label>
                <input type="text" class="form-control" id="quantity" placeholder="Maseno Mission Hospital">
            </div>
            <div class="form-group">
                <label for="">Transfusion Center Doctor</label>
                <input type="text" class="form-control" id="quantity" placeholder="Dr. Zagreb">
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
