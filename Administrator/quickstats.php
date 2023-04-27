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
      
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Patients</h3>
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
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                   
                                   // Prepare a select statement
                                   $sql = "SELECT  
                                                CASE 
                                                    WHEN TIMESTAMPDIFF(YEAR, patient.bday, NOW()) BETWEEN 18 AND 25 THEN '18-25'
                                                    WHEN TIMESTAMPDIFF(YEAR, patient.bday, NOW()) BETWEEN 26 AND 35 THEN '26-35'
                                                    WHEN TIMESTAMPDIFF(YEAR, patient.bday, NOW()) BETWEEN 36 AND 45 THEN '36-45'
                                                    WHEN TIMESTAMPDIFF(YEAR, patient.bday, NOW()) BETWEEN 46 AND 55 THEN '46-55'
                                                    WHEN TIMESTAMPDIFF(YEAR, patient.bday, NOW()) >= 56 THEN '56+'
                                                END AS age_group,
                                                SUM(CASE WHEN blood_type.`id` = 1  OR blood_type.`id` = 1 THEN 1 ELSE 0 END) AS A,
                                                SUM(CASE WHEN blood_type.`id` = 3 OR blood_type.`id` = 4 THEN 1 ELSE 0 END) AS B,
                                                SUM(CASE WHEN blood_type.`id` = 5 OR blood_type.`id` = 6 THEN 1 ELSE 0 END) AS AB,
                                                SUM(CASE WHEN blood_type.`id` = 7 OR blood_type.`id` = 8 THEN 1 ELSE 0 END) AS O
                                            FROM patient
                                            LEFT JOIN blood_type ON patient.blood_id = blood_type.id
                                            GROUP BY age_group;";
                                   $stmt = mysqli_prepare($conn, $sql);
       
                                   // Execute the statement
                                   mysqli_stmt_execute($stmt);
       
                                   // Bind the result variables
                                   mysqli_stmt_bind_result($stmt, $age_group, $A,$B, $AB, $O);
       
                                   // Loop through the results and create table rows
                                   $count = 1;
                                   $totalA = 0;
                                   $totalB = 0;
                                   $totalAB = 0;
                                   $totalO = 0;
                                   $overall = 0;
                                   while (mysqli_stmt_fetch($stmt)) {
                                     $total = $A + $B + $AB + $O;
                               
                                     
                                 ?>
                                <tr>
                                <!-- <td>1</td> -->
                                <td class="text-bold"><?php echo ($age_group == null)? "Not Provided": $age_group; ?></td>
                                <td><?php echo $A; ?></td>
                                <td><?php echo $B; ?></td>
                                <td><?php echo $AB; ?></td>
                                <td><?php echo $O; ?></td>
                                <td><?php echo $total; ?></td>
                                
                                </tr>
                                <?php
                                $totalA += $A;
                                $totalB += $B;
                                $totalAB += $AB;
                                $totalO += $O;
                                $overall += $total;
                                  $count++;
                                    }
                                    // Close the statement and database connection
                                    mysqli_stmt_close($stmt);
                                    // mysqli_close($conn);
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                <th>Total</th>
                                <th><?php echo $totalA; ?></th>
                                <th><?php echo $totalB; ?></th>
                                <th><?php echo $totalAB; ?></th>
                                <th><?php echo $totalO; ?></th>
                                <th><?php echo $overall; ?></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>      
                      </div>
                <!-- /.card -->

                <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Donors</h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table">
                                <thead>
                                <tr>
                                <!-- <th>#</th> -->
                                <th>Age Group</th>
                                <th>Blood Group A</th>
                                <th>Blood Group B</th>
                                <th>Blood Group AB</th>
                                <th>Blood Group O</th>
                                <th>Total Donors</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                  // print the age group counts
                                  // Prepare a select statement
                                  $sql = "SELECT  
                                                CASE 
                                                    WHEN TIMESTAMPDIFF(YEAR, donor.bday, NOW()) BETWEEN 18 AND 25 THEN '18-25'
                                                    WHEN TIMESTAMPDIFF(YEAR, donor.bday, NOW()) BETWEEN 26 AND 35 THEN '26-35'
                                                    WHEN TIMESTAMPDIFF(YEAR, donor.bday, NOW()) BETWEEN 36 AND 45 THEN '36-45'
                                                    WHEN TIMESTAMPDIFF(YEAR, donor.bday, NOW()) BETWEEN 46 AND 55 THEN '46-55'
                                                    WHEN TIMESTAMPDIFF(YEAR, donor.bday, NOW()) >= 56 THEN '56+'
                                                END AS age_group,
                                                SUM(CASE WHEN blood_type.`id` = 1  OR blood_type.`id` = 1 THEN 1 ELSE 0 END) AS A,
                                                SUM(CASE WHEN blood_type.`id` = 3 OR blood_type.`id` = 4 THEN 1 ELSE 0 END) AS B,
                                                SUM(CASE WHEN blood_type.`id` = 5 OR blood_type.`id` = 6 THEN 1 ELSE 0 END) AS AB,
                                                SUM(CASE WHEN blood_type.`id` = 7 OR blood_type.`id` = 8 THEN 1 ELSE 0 END) AS O
                                            FROM donor
                                            LEFT JOIN blood_type ON donor.blood_id = blood_type.id
                                            GROUP BY age_group";

                                  $stmt = mysqli_prepare($conn, $sql);

                                  // Execute the statement
                                  mysqli_stmt_execute($stmt);

                                  // Bind the result variables
                                  mysqli_stmt_bind_result($stmt, $age_group_don, $A_don,$B_don, $AB_don, $O_don);

                                  // Loop through the results and create table rows
                                  $count = 1;
                                  $totalA_don = 0;
                                  $totalB_don = 0;
                                  $totalAB_don = 0;
                                  $totalO_don = 0;
                                  $overall_don = 0;
                                  while (mysqli_stmt_fetch($stmt)) {
                                    $total_don = $A_don + $B_don + $AB_don + $O_don;
                                                  
                                 ?>
                                <tr>
                                <!-- <td>1</td> -->
                               <td class="text-bold"><?php echo ($age_group_don == null)? "Not Provided": $age_group_don; ?></td>
                                <td><?php echo $A_don; ?></td>
                                <td><?php echo $B_don; ?></td>
                                <td><?php echo $AB_don; ?></td>
                                <td><?php echo $O_don; ?></td>
                                <td><?php echo $total_don; ?></td>
                                </tr>
                                <?php 
                                 $totalA_don += $A_don;
                                 $totalB_don += $B_don;
                                 $totalAB_don += $AB_don;
                                 $totalO_don += $O_don;
                                 $overall_don += $total_don;
                                   $count++;
                                     }
                                     // Close the statement and database connection
                                     mysqli_stmt_close($stmt);
                                     // mysqli_close($conn); 
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                <th>Total</th>
                                <th><?php echo $totalA_don; ?></th>
                                <th><?php echo $totalB_don; ?></th>
                                <th><?php echo $totalAB_don; ?></th>
                                <th><?php echo $totalO_don; ?></th>
                                <th><?php echo $overall_don; ?></th>
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
