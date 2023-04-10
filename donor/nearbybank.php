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
            <h1>Search Nearby Banks</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Donor</a></li>
              <li class="breadcrumb-item active">NearBy Banks</li>
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
                            <!-- /.card -->
                            <div class="card">
                              <!-- <div class="card-body"> -->
                                <form class="form-horizontal">
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-3">
                                            <label for="">Latitude </label>
                                            <input type="number" class="form-control" id="inputEmail3" placeholder="eg. 40°44′55″N">
                                      </div>
                                      <div class="col-3">
                                        <label for="">Longitude </label>
                                        <input type="number" class="form-control" id="inputEmail3" placeholder="eg. 73 59 11W">
                                      </div>
                                      <div class="col-3">
                                            <label for="">Distance (KM) </label>
                                            <input type="number" class="form-control" id="inputEmail3" placeholder="e.g 10km">
                                      </div>
                                      <div class="col-3">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-danger form-control">Search</button>
                                      </div>
                                    </div>

                                  </div>
                                  <!-- /.card-body -->
                                </form>
                              <!-- </div> -->
                            </div>

                            <div class="card">
                              <!-- /.card-header -->
                              <div class="card-header">
                                <small style="font-size: small; color:red; font-style: italic; font-weight: 800;">(List generated based on the current location provided)</small>
                              </div>
                              <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Distance(KM)</th>
                                    <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr>
                                    <td>JOOTRH Kisumu national blood bank</td>
                                    <td>P.O Box 333 -  40100, Kisumu</td>
                                    <td><b class="text-muted">mail: </b>info@jootrh.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                                    <td>14</td>
                                    <td>
                                      <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-hand-holding-heart">
                                        </i>
                                        donate
                                    </a>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Luanda blood bank</td>
                                    <td>P.O Box 4567 -  2900, Vihiga</td>
                                    <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                                    <td>5</td>
                                    <td>
                                      <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-hand-holding-heart">
                                        </i>
                                        donate
                                    </a>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>PGH blood Bank</td>
                                    <td>P.O Box 4567 -  20100, Kisumu</td>
                                    <td><b class="text-muted">mail: </b>bb@pgh.co.ke<br><b class="text-muted">contact: </b>+25478288939</td>
                                    <td>43</td>
                                    <td>
                                      <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-hand-holding-heart">
                                        </i>
                                        donate
                                    </a>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>KNH blood bank</td>
                                    <td>P.O Box 0001 -  10100, Nairobi</td>
                                    <td><b class="text-muted">mail: </b>blood@knh.co.ke<br><b class="text-muted">contact: </b>0200067899</td>
                                    <td>60</td>
                                    <td>
                                      <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-hand-holding-heart">
                                        </i>
                                        donate
                                    </a>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>MTRRH blood bank</td>
                                    <td>P.O Box 46894 -  40100, Eldoret</td>
                                    <td><b class="text-muted">mail: </b>bank@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                                    <td>20</td>
                                    <td>
                                      <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-hand-holding-heart">
                                        </i>
                                        donate
                                    </a>
                                    </td>
                                  </tr>
                                  </tbody>
                                  <tfoot>
                                  <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
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


  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- /.Footer -->

</div>
<!-- ./wrapper -->

</body>
</html>
