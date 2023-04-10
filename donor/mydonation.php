<!DOCTYPE html>
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
            <h1>My donation History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Donor</a></li>
              <li class="breadcrumb-item active">My donation</li>
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
                              <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>Code</th>
                                    <th>Blood bank</th>
                                    <th>Date</th>
                                    <th>Blood</th>
                                    <th>Contact</th>
                                    <!-- <th>Action</th> -->
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>JOOTRH Kisumu national blood bank</td>
                                    <td>10/11/2022</td>
                                    <td><b class="text-danger">5</b></td>
                                    <td><b class="text-muted">mail: </b>info@jootrh.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                                    <!-- <td>
                                      <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                                        <i class="fas fa-credit-card">
                                        </i>
                                         Track
                                    </a>
                                    </td> -->
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Luanda blood bank</td>
                                    <td>28/09/2000</td>
                                    <td><b class="text-danger">5</b></td>
                                    <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                                    <!-- <td>
                                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                                          <i class="fas fa-credit-card">
                                          </i>
                                           Track
                                      </a>
                                      </td> -->
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>PGH blood Bank</td>
                                    <td>05/08/2018</td>
                                    <td><b class="text-danger">7</b></td>
                                    <td><b class="text-muted">mail: </b>bb@pgh.co.ke<br><b class="text-muted">contact: </b>+25478288939</td>
                                    <!-- <td>
                                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                                          <i class="fas fa-credit-card">
                                          </i>
                                           Track
                                      </a>
                                      </td> -->
                                  </tr>
                                  <tr>
                                    <td>4</td>
                                    <td>KNH blood bank</td>
                                    <td>12/10/2018</td>
                                    <td><b class="text-danger">2</b></td>
                                    <td><b class="text-muted">mail: </b>blood@knh.co.ke<br><b class="text-muted">contact: </b>0200067899</td>
                                    <!-- <td>
                                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                                          <i class="fas fa-credit-card">
                                          </i>
                                           Track
                                      </a>
                                      </td> -->
                                  </tr>

                                  <tr>
                                    <td>5</td>
                                    <td>MTRRH blood bank</td>
                                    <td>22/12/2018</td>
                                    <td><b class="text-danger">12</b></td>
                                    <td><b class="text-muted">mail: </b>bank@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                                    <!-- <td>
                                        <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-pi">
                                            <i class="fas fa-credit-card">
                                            </i>
                                            Track
                                        </a>
                                    </td> -->
                                    </tr>

                                  </tbody>
                                  <tfoot>
                                  <tr>
                                    <th>Code</th>
                                    <th>Blood bank</th>
                                    <th>Date</th>
                                    <th>Blood</th>
                                    <th>Contact</th>
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

    <div class="modal fade" id="modal-pi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Track Your donation</h4>
          <button type="button" class="close" style="outline:none" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Blood track</p>
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
