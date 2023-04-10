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
            <h1>Donation Application Requests</h1>
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
                                    <th>#</th>
                                    <th>Blood bank</th>
                                    <th>Date</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Comments</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>JOOTRH Kisumu national blood bank</td>
                                    <td>10/11/2022</td>
                                    <td><b class="text-muted">mail: </b>info@jootrh.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                                    <td class="project-state">
                                      <span class="badge badge-danger">Donation Denied</span>
                                    </td>
                                    <td>
                                      <!-- <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-eye">
                                        </i> 
                                        View     
                                    </a> -->
                                    Took too long
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>2</td>
                                    <td>Luanda blood bank</td>
                                    <td>28/09/2000</td>                                    
                                    <td><b class="text-muted">mail: </b>damu@vihiga.co.ke<br><b class="text-muted">contact: </b>0799699300</td>
                                    <td class="project-state">
                                      <span class="badge badge-success">Pending Donation</span>
                                    </td>
                                    <td>
                                      <!-- <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-eye">
                                        </i> 
                                        View     
                                      </a> -->
                                      Make your donation
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>3</td>
                                    <td>PGH blood Bank</td>
                                    <td>095/12/2018</td>
                                    <td><b class="text-muted">mail: </b>bb@pgh.co.ke<br><b class="text-muted">contact: </b>+25478288939</td>
                                    <td class="project-state">
                                      <span class="badge badge-warning">Pending Approval</span>
                                    </td>
                                    <td>
                                      <!-- <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-eye">
                                        </i> 
                                        View     
                                      </a> -->
                                      Not yet processed
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>4</td>
                                    <td>KNH blood bank</td>
                                    <td>095/12/2018</td>
                                    <td><b class="text-muted">mail: </b>blood@knh.co.ke<br><b class="text-muted">contact: </b>0200067899</td>
                                    <td class="project-state">
                                      <span class="badge badge-success">Pending Donation</span>
                                    </td>
                                    <td>
                                    <!-- 
                                      <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-eye">
                                        </i> 
                                        View     
                                      </a>-->
                                    Visit the donation center
                                    </td>
                                  </tr>

                                  <tr>
                                    <td>5</td>
                                    <td>MTRRH blood bank</td>
                                    <td>095/12/2018</td>
                                    <td><b class="text-muted">mail: </b>bank@mtrh.co.ke<br><b class="text-muted">contact: </b>+25477888908</td>
                                    <td class="project-state">
                                      <span class="badge badge-warning">Pending Approval</span>
                                    </td>
                                    <td>
                                      <!-- <a class="btn btn-info btn-sm" href="#">
                                          <i class="fas fa-eye">
                                          </i> 
                                          View     
                                      </a> -->
                                      Not yet processed
                                    </td>
                                    </tr>

                                  </tbody>
                                  <tfoot>
                                  <tr>
                                    <th>#</th>
                                    <th>Blood bank</th>
                                    <th>Date</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>View</th>
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
