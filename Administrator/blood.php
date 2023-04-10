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
        <h1>Blood</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active">Blood</li>
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
                      <h3 class="card-title"><i class="fas fa-chart-bar"></i> Blood Type Statistics</h3>
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
                        <th>Bank</th>
                        <th>A+</th>
                        <th>A-</th>
                        <th>B+</th>
                        <th>B-</th>
                        <th>AB+</th>
                        <th>AB-</th>
                        <th>O+</th>
                        <th>O-</th>
                        <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td>1</td>
                        <td>Maseno Bank</td>
                        <td>13</td>
                        <td>14</td>
                        <td>09</td>
                        <td>12</td>
                        <td>9</td>
                        <td>52</td>
                        <td>56</td>
                        <td>42</td>
                        <td>340</td>
                        </tr>
                        <tr>
                        <td>2</td>
                        <td>Luanda blood bank</td>
                        <td>70</td>
                        <td>12</td>
                        <td>8</td>
                        <td>56</td>
                        <td>9</td>
                        <td>89</td>
                        <td>25</td>
                        <td>76</td>
                        <td>358</td>
                        </tr>
                        <tr>
                        <td>3</td>
                        <td>KNH Bank</td>
                        <td>13</td>
                        <td>14</td>
                        <td>09</td>
                        <td>12</td>
                        <td>9</td>
                        <td>52</td>
                        <td>30</td>
                        <td>13</td>
                        <td>440</td>
                        </tr>
                        <tr>
                        <td>4</td>
                        <td>Luanda Bank</td>
                        <td>13</td>
                        <td>14</td>
                        <td>09</td>
                        <td>12</td>
                        <td>9</td>
                        <td>52</td>
                        <td>49</td>
                        <td>42</td>
                        <td>170</td>
                        </tr>
                        <tr>
                        <td>5</td>
                        <td>Kisumu Bank</td>
                        <td>13</td>
                        <td>14</td>
                        <td>09</td>
                        <td>12</td>
                        <td>9</td>
                        <td>52</td>
                        <td>28</td>
                        <td>42</td>
                        <td>200</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Bank</th>
                            <th>A+</th>
                            <th>A-</th>
                            <th>B+</th>
                            <th>B-</th>
                            <th>AB+</th>
                            <th>AB-</th>
                            <th>O+</th>
                            <th>O-</th>
                            <th>Total</th>
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
             
                
                     
                     var units = [100,24,60,7,9,1,6,7];
                     var type = ["A+","A-","B+","B-","AB+","AB-","O+","O-"];
 
 
                     var chartdata = {
                         labels: type,
                         datasets: [
                             {
                                 label: 'Blood Types',
                                 backgroundColor: '#4F98C3',
                                 borderColor: '#46d5f1',
                                 hoverBackgroundColor: '#7ab1d1',
                                 hoverBorderColor: '#666666',
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
