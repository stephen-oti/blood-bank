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
            <h1>Appealing Banks</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Donor</a></li>
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
                            <!-- /.card -->

                            <div class="card">
                              <!-- /.card-header -->
                              <div class="card-header">
                                <small style="font-size: small; color:red; font-style: italic; font-weight: 800;">(See Banks Requesting for Blood similar tou your blood group)</small>
                              </div>
                              <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date created</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Blood</th>
                                    <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>JOOTRH Kisumu national blood bank</td>
                                    <td>05/08/2018</td>
                                    <td>P.O Box 333 -  40100, Kisumu</td>                                    
                                    <td><b class="text-muted">mail: </b>info@jootrh.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                                    <td><b class="text-danger">10</b></td>
                                    <td>
                                      <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                                        <i class="fas fa-hand-holding-heart">
                                        </i>
                                        donate
                                    </a>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Luanda blood bank</td>
                                    <td>05/08/2018</td>
                                    <td>P.O Box 4567 -  2900, Vihiga</td>
                                    <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                                    <td><b class="text-danger">5</b></td>
                                    <td>
                                      <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                                        <i class="fas fa-hand-holding-heart">
                                        </i>
                                        donate
                                    </a>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>PGH blood Bank</td>
                                    <td>05/08/2018</td>
                                    <td>P.O Box 4567 -  20100, Kisumu</td>
                                    <td><b class="text-muted">mail: </b>bb@pgh.co.ke<br><b class="text-muted">contact: </b>+25478288939</td>
                                    <td><b class="text-danger">7</b></td>
                                    <td>
                                      <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                                        <i class="fas fa-hand-holding-heart">
                                        </i>
                                        donate
                                    </a>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>4</td>
                                    <td>KNH blood bank</td>
                                    <td>05/08/2018</td>
                                    <td>P.O Box 0001 -  10100, Nairobi</td>
                                    <td><b class="text-muted">mail: </b>blood@knh.co.ke<br><b class="text-muted">contact: </b>0200067899</td>
                                    <td><b class="text-danger">2</b></td>
                                    <td>
                                      <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                                        <i class="fas fa-hand-holding-heart">
                                        </i>
                                        donate
                                    </a>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>5</td>
                                    <td>MTRRH blood bank</td>
                                    <td>05/08/2018</td>
                                    <td>P.O Box 46894 -  40100, Eldoret</td>
                                    <td><b class="text-muted">mail: </b>bank@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                                    <td><b class="text-danger">12</b></td>
                                    <td>
                                      <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                                        <i class="fas fa-hand-holding-heart">
                                        </i>
                                        donate
                                    </a>
                                    </td>
                                  </tr>
                                  </tbody>
                                  <tfoot>
                                  <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date created</th>
                                    <th>Address</th> 
                                    <th>Contact</th>
                                    <th>Blood</th>
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
  <!-- /.modal -->

  <!-- /.modal -->

  <div class="modal fade" id="modal-pi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Donation Form</h4>
          <button type="button" class="close" style="outline:none" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="../../index.html" method="post">
            <div class="input-group mb-3">
              <!-- <input type="text" class="form-control" name="" placeholder="First name"> -->
              <select name="" id="" class="form-control" >
                <option value="">B+</option>
              </select>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-users"> Blood group</span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="number" class="form-control" name="" placeholder="Units">              
              </select>
            </div>
            <div class="input-group mb-3">
              <textarea class="form-control" placeholder="Comments..." style="resize:none;" name="" id="" cols="30" rows=""></textarea>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-clipboard-list"></span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-8">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-success btn-block">Donate</button>

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
