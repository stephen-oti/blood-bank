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
        <h1>Inter Bank Appeals</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Inter Bank Appelas</li>
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
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-search" title="Search"><i class="fas fa-filter"></i> Custom filter</button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Available Units</th>
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
                        <td>
                            <a class="btn btn-danger btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-appeal">
                            <i class="fas fa-hand-holding-heart">
                            </i>
                            Request
                        </a>
                        </td>
                        </tr>
                        <tr>
                        <td>2</td>
                        <td>Luanda blood bank</td>
                        <td>P.O Box 4567 -  2900, Vihiga</td>
                        <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">14</span> Remaining</td>
                        <td>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-appeal">
                            <i class="fas fa-hand-holding-heart">
                            </i>
                            Request
                        </a>
                        </td>
                        </tr>
                        <tr>
                        <td>3</td>
                        <td>PGH blood Bank</td>
                        <td>P.O Box 4567 -  20100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>bb@pgh.co.ke<br><b class="text-muted">contact: </b>+25478288939</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">3</span> remaining</td>
                        <td>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-appeal">
                            <i class="fas fa-hand-holding-heart">
                            </i>
                            Request
                        </a>
                        </td>
                        </tr>
                        <tr>
                        <td>4</td>
                        <td>KNH blood bank</td>
                        <td>P.O Box 0001 -  10100, Nairobi</td>
                        <td><b class="text-muted">mail: </b>blood@knh.co.ke<br><b class="text-muted">contact: </b>0200067899</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">29</span> Remaining</td>
                        <td>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-appeal">
                            <i class="fas fa-hand-holding-heart">
                            </i>
                            Request
                        </a>
                        </td>
                        </tr>
                        <tr>
                        <td>5</td>
                        <td>MTRRH blood bank</td>
                        <td>P.O Box 46894 -  40100, Eldoret</td>
                        <td><b class="text-muted">mail: </b>bank@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">7</span> Remaining</td>
                        <td>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-appeal">
                            <i class="fas fa-hand-holding-heart">
                            </i>
                            Request
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
                        <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                  <div class="card">
                    <!-- /.card-header -->
                    <div class="card-header">
                    <h3 class="card-title">Approve Inter-Bank Request</h3>
                    </div>
                    
                    <div class="card-body">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Requested Units</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td>1</td>
                        <td>JOOTRH Kisumu national blood bank</td>
                        <td>P.O Box 333 -  40100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>info@jootrh.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">3</span><br><b class="text-danger">O+</b></td>
                        <td>
                            <a class="btn btn-info btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-approve">
                              <i class="fas fa-check"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-reject">
                              <i class="fas fa-times"></i>
                            </a>
                        </td>
                        </tr>
                        <tr>
                        <td>2</td>
                        <td>Luanda blood bank</td>
                        <td>P.O Box 4567 -  2900, Vihiga</td>
                        <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">3</span><br><b class="text-danger">O+</b></td>
                        <td>
                            <a class="btn btn-info btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-approve">
                              <i class="fas fa-check"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-reject">
                              <i class="fas fa-times"></i>
                            </a>
                        </td>
                        </tr>
                        <tr>
                        <td>3</td>
                        <td>PGH blood Bank</td>
                        <td>P.O Box 4567 -  20100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>bb@pgh.co.ke<br><b class="text-muted">contact: </b>+25478288939</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">3</span><br><b class="text-danger">O+</b></td>
                        <td>
                            <a class="btn btn-info btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-approve">
                              <i class="fas fa-check"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-reject">
                              <i class="fas fa-times"></i>
                            </a>
                        </td>
                        </tr>
                        <tr>
                        <td>4</td>
                        <td>KNH blood bank</td>
                        <td>P.O Box 0001 -  10100, Nairobi</td>
                        <td><b class="text-muted">mail: </b>blood@knh.co.ke<br><b class="text-muted">contact: </b>0200067899</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">3</span><br><b class="text-danger">O+</b></td>
                        <td>
                            <a class="btn btn-info btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-approve">
                              <i class="fas fa-check"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-reject">
                              <i class="fas fa-times"></i>
                            </a>
                        </td>
                        </tr>
                        <tr>
                        <td>5</td>
                        <td>MTRRH blood bank</td>
                        <td>P.O Box 46894 -  40100, Eldoret</td>
                        <td><b class="text-muted">mail: </b>bank@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">3</span><br><b class="text-danger">O+</b></td>
                        <td>
                            <a class="btn btn-info btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-approve">
                              <i class="fas fa-check"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" href="#" data-toggle="modal" data-target="#modal-reject">
                              <i class="fas fa-times"></i>
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
                        <th>Requested  units</th>
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
          <h4 class="modal-title">Custom Search</h4>
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
                  <button type="submit" class="btn btn-success btn-block">Search</button>
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

  <div class="modal fade" id="modal-appeal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Inter Bank Appeal</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
        <form class="">
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
  <div class="modal fade" id="modal-approve">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Approve Transfer</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
          <form class="">
            <div class="form-group">
                <label for="">Assign Units <small class="text-danger">(sorted according to days before expiry and units)</small></label>
                <select name="" id="" class="form-control" >
                    <option value="">Pouch:1008 - 12 units, 07 days remaining</option>
                    <option value="">1025 - 12 - 20 days remaining</option>
                    <option value="">1103 - 20 - 23 days remaining</option>
                    <option value="">1228 - 12 - 23 days remaining</option>
                    <option value="">1608 - 14 - 30 days remaining</option>
                </select>
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Transfer</button>
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

  <div class="modal fade" id="modal-reject">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Disapproving Transfer</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Disapproving....
        <h2 class="text-center">STEPHEN OTIENO</h2>
        </div>
        <div class="modal-footer">
            <!-- <div class="row"> -->
                <button type="submit" class="btn btn-danger btn-block">Disapprove</button>
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
