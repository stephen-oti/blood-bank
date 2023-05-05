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
                  <div class="card-header">
                      <div class="clearfix">
                        <a class="btn btn-primary float-right open-link" 
                        href = "report.php?action=total-blood" 
                        title="Print Report" data-toggle="modal" data-target="#modal-xl"><i class="fas fa-print"></i> Print Report</a>
                      </div>
                    </div>    
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
                        <?php
                            // Prepare a select statement
                            $sql = "SELECT bb.id AS bank_id, bb.bank_name,
                                            COALESCE(A_pos_total, 0) AS A_pos_total,
                                            COALESCE(A_neg_total, 0) AS A_neg_total,
                                            COALESCE(B_pos_total, 0) AS B_pos_total,
                                            COALESCE(B_neg_total, 0) AS B_neg_total,
                                            COALESCE(AB_pos_total, 0) AS AB_pos_total,
                                            COALESCE(AB_neg_total, 0) AS AB_neg_total,
                                            COALESCE(O_pos_total, 0) AS O_pos_total,
                                            COALESCE(O_neg_total, 0) AS O_neg_total
                                    FROM blood_bank bb 
                                    LEFT JOIN (
                                      SELECT pouch.bank_id,
                                              SUM(CASE WHEN blood_type.`id` = 1 THEN pouch.units ELSE 0 END) AS A_pos_total,
                                              SUM(CASE WHEN blood_type.`id` = 2 THEN pouch.units ELSE 0 END) AS A_neg_total,
                                              SUM(CASE WHEN blood_type.`id` = 3 THEN pouch.units ELSE 0 END) AS B_pos_total,
                                              SUM(CASE WHEN blood_type.`id` = 4 THEN pouch.units ELSE 0 END) AS B_neg_total,
                                              SUM(CASE WHEN blood_type.`id` = 5 THEN pouch.units ELSE 0 END) AS AB_pos_total,
                                              SUM(CASE WHEN blood_type.`id` = 6 THEN pouch.units ELSE 0 END) AS AB_neg_total,
                                              SUM(CASE WHEN blood_type.`id` = 7 THEN pouch.units ELSE 0 END) AS O_pos_total,
                                              SUM(CASE WHEN blood_type.`id` = 8 THEN pouch.units ELSE 0 END) AS O_neg_total
                                      FROM pouch
                                      LEFT JOIN blood_type ON pouch.blood_id = blood_type.id
                                      WHERE DATEDIFF(NOW(), fill_date) <= 35 AND pouch_status = 1 
                                      GROUP BY pouch.bank_id
                                    ) blood_totals ON bb.id = blood_totals.bank_id WHERE bb.bank_status != 2";
                            $stmt = mysqli_prepare($conn, $sql);

                            // Execute the statement
                            mysqli_stmt_execute($stmt);

                            // Bind the result variables
                            mysqli_stmt_bind_result($stmt, $bank_id, $bank_name,$A_pos, $A_neg, $B_pos, $B_neg, $AB_pos, $AB_neg,$O_pos, $O_neg);

                            // Loop through the results and create table rows
                            $count = 1;
                            while (mysqli_stmt_fetch($stmt)) {
                              $total = $A_pos + $A_neg + $B_pos + $B_neg + $AB_pos + $AB_neg + $O_pos + $O_neg;
                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $bank_name; ?></td>
                        <td><?php echo $A_pos; ?></td>
                        <td><?php echo $A_neg; ?></td>
                        <td><?php echo $B_pos; ?></td>
                        <td><?php echo $B_neg; ?></td>
                        <td><?php echo $AB_pos; ?></td>
                        <td><?php echo $AB_neg; ?></td>
                        <td><?php echo $O_pos; ?></td>
                        <td><?php echo $O_neg; ?></td>
                        <td><b class="text-danger"><?php echo $total; ?></b></td>
                        </tr>
                        <tr>
                        <?php
                           $count++;
                            }
                            // Close the statement and database connection
                            mysqli_stmt_close($stmt);
                            // mysqli_close($conn);
                        ?>
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
<?php
// Assume $conn is the database connection variable

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
        WHERE DATEDIFF(NOW(), fill_date) <= 35 AND pouch_status = 1 AND blood_bank.`bank_status` != 2 ";

// Bind the parameter and execute the statement
$stmt = mysqli_prepare($conn, $sql); // Assuming $bank_id is the value you want to bind
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
