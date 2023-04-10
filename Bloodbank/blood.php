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
        <h1>Blood Unit Stock</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood bank</a></li>
              <li class="breadcrumb-item active">Blood Stock</li>
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
                    <!-- <div class="clearfix">
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-add" title="Search"><i class="fas fa-plus"></i> Add Unit</button>
                        </div>
                    </div> -->
    
                    <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Pouch ID</th>
                        <th>Donor</th>
                        <th>Blood Type</th>
                        <th>Qty</th>
                        <th>Donation Date</th>
                        <th>Expiry Date</th>
                        <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>1003</td>
                            <td>Stephen Otieno</td>
                            <td>B+</td>
                            <td>20</td>
                            <td>11/02/2019</td>
                            <td>20/03/2019</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-delete">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>1034</td>
                            <td>Martin Ordeegard</td>
                            <td>O-</td>
                            <td>30</td>
                            <td>10/01/2022</td>
                            <td>20/02/2022</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-delete">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>1035</td>
                            <td>Emily Otis</td>
                            <td>A+</td>
                            <td>14</td>
                            <td>01/06/2022</td>
                            <td>27/08/2022</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-delete">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>1020</td>
                            <td>Kelvin Wanjohi</td>
                            <td>O+</td>
                            <td>11</td>
                            <td>20/02/2023</td>
                            <td>20/03/2023</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-delete">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>1060</td>
                            <td>Ezekiel Maina</td>
                            <td>AB-</td>
                            <td>42</td>
                            <td>04/04/2023</td>
                            <td>16/06/2023</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#modal-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-delete">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Pouch ID</th>
                            <th>Donor</th>
                            <th>Blood Type</th>
                            <th>Qty</th>
                            <th>Donation Date</th>
                            <th>Expiry Date</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                </div>
                <div class="card">
                  <!-- /.card-header -->
                  <div class="card-header">  
                    <h3>Expired Blood</h3>
                  <!-- <div class="clearfix">
                      <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-add" title="Search"><i class="fas fa-plus"></i> Add Unit</button>
                      </div>
                  </div> -->
  
                  <div class="card-body">
                  <table id="example3" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                      <th>#</th>
                      <th>Pouch ID</th>
                      <th>Donor</th>
                      <th>Blood Type</th>
                      <th>Qty</th>
                      <th>Donation Date</th>
                      <th>Expiry Date</th>
                      <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td>1</td>
                          <td>1003</td>
                          <td>Stephen Otieno</td>
                          <td>B+</td>
                          <td>20</td>
                          <td>11/02/2019</td>
                          <td>20/03/2019</td>
                          <td>
                              <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-delete">
                                  <i class="fas fa-times"></i>
                                  Delete
                              </a>
                          </td>
                      </tr>
                      <tr>
                          <td>2</td>
                          <td>1034</td>
                          <td>Martin Ordeegard</td>
                          <td>O-</td>
                          <td>30</td>
                          <td>10/01/2022</td>
                          <td>20/02/2022</td>
                          <td>
                              <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-delete">
                                  <i class="fas fa-times"></i>
                                  Delete
                              </a>
                          </td>
                      </tr>
                      <tr>
                          <td>3</td>
                          <td>1035</td>
                          <td>Emily Otis</td>
                          <td>A+</td>
                          <td>14</td>
                          <td>01/06/2022</td>
                          <td>27/08/2022</td>
                          <td>
                              <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-delete">
                                  <i class="fas fa-times"></i>
                                  Delete
                              </a>
                          </td>
                      </tr>
                      <tr>
                          <td>4</td>
                          <td>1020</td>
                          <td>Kelvin Wanjohi</td>
                          <td>O+</td>
                          <td>11</td>
                          <td>20/02/2023</td>
                          <td>20/03/2023</td>
                          <td>
                              <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-delete">
                                  <i class="fas fa-times"></i>
                                  Delete
                              </a>
                          </td>
                      </tr>
                      <tr>
                          <td>5</td>
                          <td>1060</td>
                          <td>Ezekiel Maina</td>
                          <td>AB-</td>
                          <td>42</td>
                          <td>04/04/2023</td>
                          <td>16/06/2023</td>
                          <td>
                              <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-delete">
                                  <i class="fas fa-times"></i>
                                  Delete
                              </a>
                          </td>
                      </tr>
                      </tbody>
                      <tfoot>
                      <tr>
                          <th>#</th>
                          <th>Pouch ID</th>
                          <th>Donor</th>
                          <th>Blood Type</th>
                          <th>Qty</th>
                          <th>Donation Date</th>
                          <th>Expiry Date</th>
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

  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Pouch</h4>
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
                <label for="">Qty</label>
                <input type="number" class="form-control" id="inputEmail3" placeholder="Quantity">
            </div>
            <div class="form-group">
                <label for="">Donation Date</label>
                <input type="Date" class="form-control" id="inputEmail3" placeholder="Donation Date">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Edit</button>
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

  <div class="modal fade" id="modal-add">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
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
                <label for="">Qty</label>
                <input type="number" class="form-control" id="inputEmail3" placeholder="Quantity">
            </div>
            <div class="form-group">
                <label for="">Donation Date</label>
                <input type="Date" class="form-control" id="inputEmail3" placeholder="Donation Date">
            </div>
            <div class="row">
                <div class="col-8">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-block">Edit</button>
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

  
  <div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Deleting Unit</h4>
          <button type="button" class="close" style="outline:none;" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Deleting....
        <h2 class="text-center">1008 - B+</h2>
        </div>
        <div class="modal-footer">
            <!-- <div class="row"> -->
                <button type="submit" class="btn btn-danger btn-block">Delete</button>
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
