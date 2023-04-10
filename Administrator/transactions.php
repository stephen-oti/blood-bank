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
        <h1>Transactions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active">Transactions</li>
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
                      <h3 class="card-title">Transaction Type</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <canvas id="graphCanvas" style="width:100%;max-width:600px"></canvas>
                    </div>      
                  </div>
                <div class="card">   
                    <div class="card-body">
                    
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Blood</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td>1</td>
                        <td>11/02/2022</td>
                        <td>Donation</td>
                        <td>Stephen Otieno</td>
                        <!-- <td>P.O Box 333-40100, Kisumu</td> -->
                        <td>Maseno Bank</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">B+</span><br><b class="text-muted">Pouch: </b>1008</td>
                        </tr>
                        <tr>
                        <td>2</td>
                        <td>13/02/2022</td>
                        <td>Donation</td>
                        <td>Luanda blood bank</td>
                        <!-- <td>P.O Box 4567-2900, Vihiga</td> -->
                        <td>Kisumu Bank</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">AB-</span><br><b class="text-muted">Pouch: </b>1908</td>
                        </tr>
                        <tr>
                        <td>3</td>
                        <td>15/02/2022</td>
                        <td>Donation</td>
                        <td>Emmaculate atis</td>
                        <!-- <td>P.O Box 4567-20100, Kisumu</td> -->
                        <td>KNH Bank</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">O-</span><br><b class="text-muted">Pouch: </b>2038</td>
                        </tr>
                        <tr>
                        <td>4</td>
                        <td>20/02/2022</td>
                        <td>Appeal</td>
                        <td>Julius Kisingu</td>
                        <!-- <td>P.O Box 0001-10100, Nairobi</td> -->
                        <td>Luanda Bank</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">A+</span><br><b class="text-muted">Pouch: </b>1028</td>
                        </tr>
                        <tr>
                        <td>5</td>
                        <td>23/02/2022</td>
                        <td>Appeal</td>
                        <td>Kinja</td>
                        <!-- <td>P.O Box 46894-40100, Eldoret</td> -->
                        <td>Kisumu Bank</td>
                        <td><span class="badge badge-danger" style="font-size: 16px;">A-</span><br><b class="text-muted">Pouch: </b>1018</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Source</th>
                            <th>Destination</th>
                            <th>Blood</th>
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

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- /.Footer -->

</div>
<!-- ./wrapper -->
  <script>
    $(document).ready(function () {
             showGraph();
         });
 
 
         function showGraph()
         {
            var units = [100,49];
            var type = ["Donations","Appeals"];
            var myColors = ["#8b008b",  "#ffd700"];



            var chartdata = {
                labels: type,
                datasets: [
                    {
                        label: 'Transactions Type',
                        backgroundColor: myColors,
                      //  borderColor: '#46d5f1',
                        hoverBackgroundColor: '#ff4d4d',
                      //  hoverBorderColor: '#666666',
                        data: units
                    }
                ]
              };


            var graphTarget = $("#graphCanvas");

            var barGraph = new Chart(graphTarget, {
                type: 'bar',
                data: chartdata,
                options: {
                indexAxis: 'y',
                }

              });
             
             
         }
 </script>

 
</body>
</html>
