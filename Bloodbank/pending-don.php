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
        <h1>Pending Requests</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Donation Requests</li>
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
                    <div class="card-header">
                        <h3>Approved Donation Requests</h3>
                    </div> 
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Blood</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td>1</td>
                        <td>Stephen Otieno</td>
                        <td>P.O Box 333-40100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>steph@gmail.com<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><b class="text-danger">AB-</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-complete">
                            <i class="fas fa-check"></i>
                            Donation Complete
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>2</td>
                        <td>Luanda blood bank</td>
                        <td>P.O Box 4567-2900, Vihiga</td>
                        <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><b class="text-danger">A+</b></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-complete">
                                <i class="fas fa-check"></i>
                                Donation Complete
                            </a>
                        </td>
                        </tr>
                        <tr>
                        <td>3</td>
                        <td>Emmaculate atis</td>
                        <td>P.O Box 4567-20100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>ema@gmail.com<br><b class="text-muted">contact: </b>+25478288939</td>
                        <td><b class="text-danger">A-</b></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-complete">
                                <i class="fas fa-check"></i>
                                Donation Complete
                              </a>
                        </td>
                        </tr>
                        <tr>
                        <td>4</td>
                        <td>Julius Kisingu</td>
                        <td>P.O Box 0001-10100, Nairobi</td>
                        <td><b class="text-muted">mail: </b>juli@yahoo.com<br><b class="text-muted">contact: </b>0200067899</td>
                        <td><b class="text-danger">O-</b></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-complete">
                                <i class="fas fa-check"></i>
                                Donation Complete
                            </a>
                        </td>
                        </tr>
                        <tr>
                        <td>5</td>
                        <td>Kinja</td>
                        <td>P.O Box 46894-40100, Eldoret</td>
                        <td><b class="text-muted">mail: </b>kinja@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                        <td><b class="text-danger">B+</b></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-complete">
                                <i class="fas fa-check"></i>
                                Donation Complete
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
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-complete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Accept Donation</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
          <form class="">
            <div class="form-group">
                <label for="">Collected Units</label>
                <input type="number" class="form-control" id="inputEmail3" placeholder="eg. 10 units">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Add To bank</button>
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
