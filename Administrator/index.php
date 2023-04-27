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
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrator</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
// Assume $conn is the database connection variable

    // Prepare the SQL statement
    $sql = "SELECT 
                SUM(CASE WHEN blood_type.`b_group` = 'A' THEN pouch.units ELSE 0 END) AS A,
                SUM(CASE WHEN blood_type.`b_group` = 'B' THEN pouch.units ELSE 0 END) AS B,
                SUM(CASE WHEN blood_type.`b_group` = 'AB' THEN pouch.units ELSE 0 END) AS AB,
                SUM(CASE WHEN blood_type.`b_group` = 'O' THEN pouch.units ELSE 0 END) AS O
            FROM pouch
            LEFT OUTER JOIN blood_bank ON blood_bank.id = pouch.bank_id
            JOIN blood_type ON pouch.blood_id = blood_type.id
            WHERE DATEDIFF(NOW(), fill_date) <= 35 AND pouch_status = 1";

    // Bind the parameter and execute the statement
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);

    // Fetch the result and store in variables
    mysqli_stmt_bind_result($stmt, $A, $B, $AB, $O);
    mysqli_stmt_fetch($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
                  <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>A</h3>

                <p><?php echo $A; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>B</h3>

                <p><?php echo $B; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>AB</h3>

                <p><?php echo $AB; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>O</h3>

                <p><?php echo $O; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          
          
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> System Users</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              
              <div class="card-body">
              <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg"><?php 
                      $sql_totunits = "SELECT SUM(units) FROM pouch";
                      $stmt = mysqli_prepare($conn, $sql_totunits);
                      mysqli_stmt_execute($stmt);
                      mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $total_units);
                        mysqli_stmt_fetch($stmt);
                        
                        if($total_units  == null){
                          echo "0 Units";
                        }else{
                          echo $total_units." Units";
                        }

                        // Close the statement and database connection
                        mysqli_stmt_close($stmt);
                    ?></span>
                    <span>Blood In</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <?php 
                       $sql_totunits = "SELECT AVG(total_donations/donor_count)AS average_donation_rate
                       FROM(SELECT COUNT(*) AS donor_count, SUM(quantity) AS total_donations
                       FROM donor_donation
                       GROUP BY donor_id
                       ) AS summary";
                        $stmt = mysqli_prepare($conn, $sql_totunits);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $total_units);
                        mysqli_stmt_fetch($stmt);
                    ?>
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> <?php 
                       
                          
                          if($total_units  == null){
                            echo "0 %";
                          }elseif($total_units < 0){

                          }else{
                            echo $total_units."%";
                          }
  
                          // Close the statement and database connection
                          mysqli_stmt_close($stmt);
                      ?>
                    </span>
                    <span class="text-muted">Donation Rate</span>
                  </p>
                </div>
                <canvas id="graphCanvas" style="width:100%;max-width:600px"></canvas>
              </div>      
            </div>
          </div>

          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-hand-holding-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Requests</span>
                <span class="info-box-number"><?php
                  $sql_appeals = "SELECT  * FROM patient_appeal";
                  $query_appeals = mysqli_query($conn,$sql_appeals);
                  $appeals = mysqli_num_rows($query_appeals);

                  $sql_donations = "SELECT  * FROM donor_donation";
                  $query_donations = mysqli_query($conn,$sql_donations);
                  $donations = mysqli_num_rows($query_donations);

                  echo $donations+$appeals;
                  ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="fas fa-university"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Blood Banks</span>
                <span class="info-box-number"><?php
                $sql_banks = "SELECT  * FROM blood_bank WHERE bank_status != 2";
                $query_banks = mysqli_query($conn,$sql_banks);
                echo mysqli_num_rows($query_banks);
                ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number"><?php
                  $sql_patient = "SELECT  * FROM patient WHERE p_status != 2";
                  $query_patient = mysqli_query($conn,$sql_patient);
                  $patient = mysqli_num_rows($query_patient);

                  $sql_donor = "SELECT  * FROM donor WHERE d_status != 2";
                  $query_donor = mysqli_query($conn,$sql_donor);
                  $donor = mysqli_num_rows($query_donor);

                  $sql_officer = "SELECT  * FROM officer WHERE o_status != 2";
                  $query_officer = mysqli_query($conn,$sql_officer);
                  $officer = mysqli_num_rows($query_officer);

                  $sql_admin = "SELECT  * FROM admin WHERE admin_status != 2";
                  $query_admin = mysqli_query($conn,$sql_admin);
                  $admin = mysqli_num_rows($query_admin);

                  echo $patient+ $donor + $officer + $admin;
                  ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="fas fa-tint"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Blood Units</span>
                <span class="info-box-number"><?php
                $sql_units = "SELECT SUM(units) FROM pouch WHERE pouch_status = 1";
                $stmt = mysqli_prepare($conn, $sql_units);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                  mysqli_stmt_bind_result($stmt, $total_units);
                  mysqli_stmt_fetch($stmt);
                  
                  if($total_units  == null){
                    echo "0 Units";
                  }else{
                    echo $total_units." Units";
                  }
                ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-dark">
              <span class="info-box-icon"><i class="fas fa-pen"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Approval Requests</span>
                <span class="info-box-number"><?php
                $sql_units = "SELECT * FROM reg_request";
                $stmt = mysqli_prepare($conn, $sql_units);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                echo mysqli_stmt_num_rows($stmt);
                ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
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
  <script>
    $(document).ready(function () {
             showGraph();
         });
 
 
         function showGraph()
         {
             
                
                     
                      var month = [];
                     var units = [<?php echo $donor; ?>,<?php echo $patient; ?>,<?php echo $officer; ?>,<?php echo $admin; ?>];

                     var year = ["Donors","Patients","Bank Officers","Administrators"];
                    //  var barColors = [  "#b91d47",  "#00aba9",  "#2b5797",  "#e8c3b9",  "#8b008b",  "#ffd700",  "#ff7f50",  "#4169e1"];
                    var myColors = ["#8b008b",  "#ffd700",  "#ff7f50",  "#4169e1"];

 
 
                     var chartdata = {
                         labels: year,
                         datasets: [
                             {
                                 label: 'Users',
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
                         type: 'pie',
                         data: chartdata,
                     });
             
             
         }
 </script>
 
</body>
</html>
