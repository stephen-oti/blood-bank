<?php
include '../dbconfig.php';
session_start();
// $admin_id = $_SESSION['admin_id'];
if(!isset($_SESSION['admin_id'])){
  header("Location:login.php");
}

    // Retrieve the patient details from the database using prepared statements
    $sql = "SELECT * FROM admin WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['admin_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the results and store the patient details in a variable
    if ($row = mysqli_fetch_assoc($result)) {
      $admin_details = $row;
    }
    
    // Close the statement and database connection
    mysqli_stmt_close($stmt);
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>OBBS | Administrator</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/chart.js/Chart.min.css">
    
  <style>
    .text-glow{
      color: #fff;
      letter-spacing: 0.6em;
      font-weight: 800;
      font-size: 20px;
      text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 40px #ff69b4, 0 0 70px #ff69b4, 0 0 80px #ff69b4,0 0 100px #ff69b4,0 0 150px #ff69b4 ;
    }
  </style>
  </style>
</head>