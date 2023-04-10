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
        <h1>Appeal Requests</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Appeal Requests</li>
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
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Type</th>
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
                        <td>Patient</td>
                        <td>Stephen Otieno</td>
                        <td>P.O Box 333-40100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>steph@gmail.com<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">17</span><br><b class="text-danger">B+</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-accept">
                            <i class="fas fa-check"></i>
                          </a>
                          <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-reject">
                            <i class="fas fa-times"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>2</td>
                        <td>Bank</td>
                        <td>Luanda blood bank</td>
                        <td>P.O Box 4567-2900, Vihiga</td>
                        <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">14</span><br><b class="text-danger">AB-</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-accept">
                            <i class="fas fa-check"></i>
                          </a>
                          <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-reject">
                            <i class="fas fa-times"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>3</td>
                        <td>Patient</td>
                        <td>Emmaculate atis</td>
                        <td>P.O Box 4567-20100, Kisumu</td>
                        <td><b class="text-muted">mail: </b>ema@gmail.com<br><b class="text-muted">contact: </b>+25478288939</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">3</span><br><b class="text-danger">O+</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-accept">
                            <i class="fas fa-check"></i>
                          </a>
                          <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-reject">
                            <i class="fas fa-times"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>4</td>
                        <td>patient</td>
                        <td>Julius Kisingu</td>
                        <td>P.O Box 0001-10100, Nairobi</td>
                        <td><b class="text-muted">mail: </b>juli@yahoo.com<br><b class="text-muted">contact: </b>0200067899</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">29</span><br><b class="text-danger">AB-</b></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-accept">
                            <i class="fas fa-check"></i>
                          </a>
                          <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-reject">
                            <i class="fas fa-times"></i>
                          </a>
                        </td>
                        </tr>
                        <tr>
                        <td>5</td>
                        <td>bank</td>
                        <td>MTRRH blood bank</td>
                        <td>P.O Box 46894-40100, Eldoret</td>
                        <td><b class="text-muted">mail: </b>bank@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">7</span><br><b class="text-danger">A+</b></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-view">
                              <i class="fas fa-eye"></i>
                            </a>
                            <a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#modal-accept">
                              <i class="fas fa-check"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-reject">
                              <i class="fas fa-times"></i>
                            </a>
                        </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                        <th>#</th>
                        <th>Type</th>
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
              <b>Appeal Date</b><a class="float-right">11/02/2023</a>
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

  
  <div class="modal fade" id="modal-reject">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Disapproving Appeal</h4>
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
