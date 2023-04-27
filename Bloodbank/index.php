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
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Blood Bank</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
  $bank_id = $bank_details['id'];
  // Retrieve the patient details from the database using prepared statements
  $sql = "SELECT 
          SUM(CASE WHEN blood_type.`id` = 1 THEN pouch.units ELSE 0 END) AS A_pos,
          SUM(CASE WHEN blood_type.`id` = 2 THEN pouch.units ELSE 0 END) AS A_neg,
          SUM(CASE WHEN blood_type.`id` = 3 THEN pouch.units ELSE 0 END) AS B_pos,
          SUM(CASE WHEN blood_type.`id` = 4 THEN pouch.units ELSE 0 END) AS B_neg,
          SUM(CASE WHEN blood_type.`id` = 5 THEN pouch.units ELSE 0 END) AS AB_pos,
          SUM(CASE WHEN blood_type.`id` = 6 THEN pouch.units ELSE 0 END) AS AB_neg,
          SUM(CASE WHEN blood_type.`id` = 7 THEN pouch.units ELSE 0 END) AS O_pos,
          SUM(CASE WHEN blood_type.`id` = 8 THEN pouch.units ELSE 0 END) AS O_neg
          FROM pouch
          LEFT OUTER JOIN blood_bank ON blood_bank.id = pouch.bank_id
          JOIN blood_type ON pouch.blood_id = blood_type.id
          WHERE DATEDIFF(NOW(), fill_date) <= 35 AND pouch_status = 1 AND pouch.bank_id = ?
          GROUP BY pouch.bank_id ";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $bank_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
    // Fetch the results and store the patient details in a variable
    if ($row = mysqli_fetch_assoc($result)) {
      $bank_blood = $row;
    }
  $validity = mysqli_num_rows($result);

  // Close the statement and database connection
  mysqli_stmt_close($stmt);

?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
                  <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>A+</h3>

                <p><?php echo ($validity == 0)? "0": $bank_blood['A_pos']; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>B+</h3>

                <p><?php echo ($validity == 0)? "0": $bank_blood['B_pos']; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>AB+</h3>

                <p><?php echo ($validity == 0)? "0": $bank_blood['AB_pos']; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>O+</h3>

                <p><?php echo ($validity == 0)? "0": $bank_blood['O_pos']; ?> Units</p>
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
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>A-</h3>

                <p><?php echo ($validity == 0)? "0": $bank_blood['A_neg']; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>B -</h3>

                <p><?php echo ($validity == 0)? "0": $bank_blood['B_neg']; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>AB-</h3>

                <p><?php echo ($validity == 0)? "0": $bank_blood['AB_neg']; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>O-</h3>

                <p><?php echo ($validity == 0)? "0": $bank_blood['O_neg']; ?> Units</p>
              </div>
              <div class="icon">
                <i class="fas fa-tint"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->


        <!-- <div class="row"> -->

        <!-- </div>           -->
        <div class="row">
          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-hand-holding-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Appeals</span>
                <span class="info-box-number"><?php
                $sql_appeals = "SELECT  * FROM patient_appeal WHERE bank_id = $bank_id";
                $query_appeals = mysqli_query($conn,$sql_appeals);
                echo mysqli_num_rows($query_appeals);
                ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Donations</span>
                <span class="info-box-number"><?php
                $sql_donations = "SELECT  * FROM donor_donation WHERE bank_id = $bank_id AND don_status = 4";
                $query_donations = mysqli_query($conn,$sql_donations);
                echo mysqli_num_rows($query_donations);
                ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total units</span>
                <span class="info-box-number"><?php
                $sql_units = "SELECT SUM(units) FROM pouch WHERE bank_id =  $bank_id AND pouch_status = 1";
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
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="fas fa-exchange-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Transfers</span>
                <span class="info-box-number"><?php
                $sql_transfers = "SELECT * FROM transfer WHERE appr_bank = $bank_id OR req_bank = $bank_id";
                $query_transfers = mysqli_query($conn, $sql_transfers);
                echo mysqli_num_rows($query_transfers);
                ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-pie"></i> Blood Statistics</h3>
              </div>
              <div class="card-body">
                <canvas id="graphCanvas" style="width:100%;max-width:600px"></canvas>
              </div>      
            </div>
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
 <?php
// Assume $conn is the database connection variable

// Prepare the SQL statement
$bank_id = $bank_details['id'];
$sql = "SELECT 
            SUM(CASE WHEN blood_type.`id` = 1 THEN pouch.units ELSE 0 END) AS A_pos,
            SUM(CASE WHEN blood_type.`id` = 2 THEN pouch.units ELSE 0 END) AS A_neg,
            SUM(CASE WHEN blood_type.`id` = 3 THEN pouch.units ELSE 0 END) AS B_pos,
            SUM(CASE WHEN blood_type.`id` = 4 THEN pouch.units ELSE 0 END) AS B_neg,
            SUM(CASE WHEN blood_type.`id` = 5 THEN pouch.units ELSE 0 END) AS AB_pos,
            SUM(CASE WHEN blood_type.`id` = 6 THEN pouch.units ELSE 0 END) AS AB_neg,
            SUM(CASE WHEN blood_type.`id` = 7 THEN pouch.units ELSE 0 END) AS O_pos,
            SUM(CASE WHEN blood_type.`id` = 8 THEN pouch.units ELSE 0 END) AS O_neg
        FROM pouch
        LEFT OUTER JOIN blood_bank ON blood_bank.id = pouch.bank_id
        JOIN blood_type ON pouch.blood_id = blood_type.id
        WHERE DATEDIFF(NOW(), fill_date) <= 35 AND pouch_status = 1 AND pouch.bank_id = ?
        GROUP BY pouch.bank_id";

// Bind the parameter and execute the statement
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $bank_id); // Assuming $bank_id is the value you want to bind
mysqli_stmt_execute($stmt);

// Fetch the result and store in variables
mysqli_stmt_bind_result($stmt, $A_pos, $A_neg, $B_pos, $B_neg, $AB_pos, $AB_neg, $O_pos, $O_neg);
mysqli_stmt_fetch($stmt);

// Close the statement
mysqli_stmt_close($stmt);
?>
<script>
$(document).ready(function() {
    showGraph();
});

function showGraph() {
    var bloodTypes = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];
    var units = [<?php echo $A_pos; ?>, <?php echo $A_neg; ?>, <?php echo $B_pos; ?>, <?php echo $B_neg; ?>, <?php echo $AB_pos; ?>, <?php echo $AB_neg; ?>, <?php echo $O_pos; ?>, <?php echo $O_neg; ?>];

    var chartdata = {
        labels: bloodTypes,
        datasets: [{
            label: 'Blood Types',
            backgroundColor: '#4F98C3',
            borderColor: '#46d5f1',
            hoverBackgroundColor: '#7ab1d1',
            hoverBorderColor: '#666666',
            data: units
        }]
    };

    var graphTarget = $("#graphCanvas");

    var barGraph = new Chart(graphTarget, {
        type: 'bar',
        data: chartdata
    });
}
</script>
</body>
</html>
