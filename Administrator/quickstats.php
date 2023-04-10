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
        <h1>Quick statistics</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active">Quick Statistics</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
    // select all users with their birthdate from the database
      $sql = "SELECT id, bday FROM patient";
      $result = $conn->query($sql);

      $sql2 = "SELECT id, bday FROM donor";
      $result2 = $conn->query($sql);
      // initialize age group arrays
      $patient = array(
          "18-25" => 0,
          "26-35" => 0,
          "36-45" => 0,
          "46-55" => 0,
          "56-65" => 0,
          "65+" => 0
      );


      // loop through the users
      while ($row = $result->fetch_assoc()) {
          // calculate the age from the birthdate
          $birthdate = new DateTime($row["bday"]);
          $today = new DateTime();
          $age = $birthdate->diff($today)->y;
          
          // increment the appropriate age group
          if ($age >= 18 && $age <= 25) {
              $patient["18-25"]++;
          } elseif ($age >= 26 && $age <= 35) {
              $patient["26-35"]++;
          } elseif ($age >= 36 && $age <= 45) {
              $patient["36-45"]++;
          } elseif ($age >= 46 && $age <= 55) {
              $patient["46-55"]++;
          } elseif ($age >= 56 && $age <= 65) {
              $patient["56-65"]++;
          } elseif ($age >= 65) {
              $patient["65+"]++;
          }
      }
      ?>
      
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Quick Statistics</h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table">
                                <thead>
                                <tr>
                                <!-- <th>#</th> -->
                                <th>Age Group</th>
                                <th>Blood Group A</th>
                                <th>Blood Group B</th>
                                <th>Blood Group AB</th>
                                <th>Blood Group O</th>
                                <th>Total Patients</th>
                                <th>Total Donors</th>
                                <th>Donation Rate</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                  // print the age group counts
                                  foreach ($patient as $patient_group => $patient_count) {
                                     
                                 ?>
                                <tr>
                                <!-- <td>1</td> -->
                                <td class="text-bold"><?php echo $patient_group; ?></td>
                                <td><b class="text-success">Donors: </b>6<br><b class="text-danger">Patients: </b>1</td>
                                <td><b class="text-success">Donors: </b>6<br><b class="text-danger">Patients: </b>1</td>
                                <td><b class="text-success">Donors: </b>6<br><b class="text-danger">Patients: </b>1</td>
                                <td><b class="text-success">Donors: </b>6<br><b class="text-danger">Patients: </b>1</td>
                                <td><?php echo $patient_count; ?></td>
                                <td>12</td>
                                <td>20%</td>
                                </tr>
                                <?php 
                                  }
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                <th>Total</th>
                                <th>134</th>
                                <th>302</th>
                                <th>200</th>
                                <th>432</th>
                                <th>212</th>
                                <th>200</th>
                                <th>48%</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>      
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
