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
        <h1>Donors</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Donors</li>
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
                      <h2 class="card-title">One time and infrequent donors nearby this bank</h2>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>   
                    <div class="card-body">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Total Donated</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td>1</td>
                        <td>Stephen Otieno</td>
                        <td>P.O Box 333-40100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>steph@gmail.com<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-mail">
                            <i class="fas fa-envelope"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>2</td>
                        <td>Luanda blood bank</td>
                        <td>P.O Box 4567-2900, Vihiga</td>
                        <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-mail">
                            <i class="fas fa-envelope"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>3</td>
                        <td>Emmaculate atis</td>
                        <td>P.O Box 4567-20100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>ema@gmail.com<br><b class="text-muted">contact: </b>+25478288939</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-mail">
                            <i class="fas fa-envelope"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>4</td>
                        <td>Julius Kisingu</td>
                        <td>P.O Box 0001-10100, Nairobi</td>
                        <td><b class="text-muted">mail: </b>juli@yahoo.com<br><b class="text-muted">contact: </b>0200067899</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-mail">
                            <i class="fas fa-envelope"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>5</td>
                        <td>Kinja</td>
                        <td>P.O Box 46894-40100, Eldoret</td>
                        <td><b class="text-muted">mail: </b>kinja@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                              <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-mail">
                              <i class="fas fa-envelope"></i>
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
                        <th>Total Donation</th>
                        <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="card">
                    <div class="card-header">
                      <h2 class="card-title">Top Regular Donors</h2>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>   
                    <div class="card-body">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Total Donated</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td>1</td>
                        <td>Stephen Otieno</td>
                        <td>P.O Box 333-40100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>steph@gmail.com<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>2</td>
                        <td>Luanda blood bank</td>
                        <td>P.O Box 4567-2900, Vihiga</td>
                        <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>3</td>
                        <td>Emmaculate atis</td>
                        <td>P.O Box 4567-20100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>ema@gmail.com<br><b class="text-muted">contact: </b>+25478288939</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>4</td>
                        <td>Julius Kisingu</td>
                        <td>P.O Box 0001-10100, Nairobi</td>
                        <td><b class="text-muted">mail: </b>juli@yahoo.com<br><b class="text-muted">contact: </b>0200067899</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>5</td>
                        <td>Kinja</td>
                        <td>P.O Box 46894-40100, Eldoret</td>
                        <td><b class="text-muted">mail: </b>kinja@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                              <i class="fas fa-eye"></i>
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
                        <th>Total Donation</th>
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
                <b>Next Donatiom Date</b><a class="float-right">11/06/2020</a>
            </li>
            <li class="list-group-item">
              <b>Gender</b><a class="float-right">male</a>
            </li>
            <li class="list-group-item">
              <b>Age</b> <a class="float-right">18</a>
            </li>
            <li class="list-group-item">
              <b>Medical History</b><a href="#" class="float-right text-primary"><i class="fas fa-external-link-alt"></i> Stephen medical Record.pdf</a>
            </li>
            <li class="list-group-item">
              <b>Questionnaire</b><a href="#" class="float-right text-primary"><i class="fas fa-external-link-alt"></i> Stephen-Questionnaire.pdf</a>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  
  <div class="modal fade" id="modal-mail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Mail Donor</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <!-- <div class="card-body"> -->
          <form class="">
            <div class="form-group">
                <label for="">Mail</label>
                <input type="mail" class="form-control" id="inputEmail3" placeholder="eg.Donor mail">
            </div>
            <div class="form-group">
                <label for="">Subject</label>
                <input type="text" class="form-control" id="inputEmail3" placeholder="eg.Subject Matter">
            </div>
            <div class="form-group">
                <label for="">Message</label>
                <textarea class="form-control" placeholder="Message..." style="resize:none;" name="" id="" cols="30" rows=""></textarea>
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Send</button>
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
