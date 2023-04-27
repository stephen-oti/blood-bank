<?php 
session_start();
include '../dbconfig.php';
if(!isset($_SESSION['patient_id'])){
  header("Location:login.php");
}
// Retrieve the patient details from the database using prepared statements
$sql = "SELECT * FROM patient WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['patient_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch the results and store the patient details in a variable
if ($row = mysqli_fetch_assoc($result)) {
  $patient_details = $row;
}

// Close the statement and database connection
mysqli_stmt_close($stmt);

?>

<?php

  $user_blood = $patient_details['blood_id'];
  $stmnt = mysqli_prepare($conn, "SELECT * FROM blood_type WHERE id = ?");
  mysqli_stmt_bind_param($stmnt, 'i', $user_blood);
  mysqli_stmt_execute($stmnt);
  $results = mysqli_stmt_get_result($stmnt);
  if ($rows = mysqli_fetch_assoc($results)) {
    $patient_blood = $rows;
  }

  mysqli_stmt_close($stmnt);

?>
<?php
  $patient_status = $patient_details['p_status'];
    if($patient_status != null){
    $patient_id = $patient_details['id'];
    }
    //Checking if the donor already has a Pending donation record
    $sqlappeal = "SELECT * FROM patient_appeal WHERE patient_id = $patient_id AND app_status = 0";
    $queryappeal =  mysqli_query($conn,$sqlappeal);
    $availability = mysqli_num_rows($queryappeal);

    $sqlquest = "SELECT last_update_time FROM questionnaire WHERE user_type = 'patient' AND  p_id = $patient_id";
    $questquery = mysqli_query($conn, $sqlquest);
    $questionnaire = mysqli_fetch_array($questquery);
    $qdate = $questionnaire['last_update_time'];
    $convertedate = new DateTime($qdate);
    $today = new DateTime();
    if ($convertedate) {
      $days = $today->diff($convertedate)->days;
    } else {
      $days = null;
    }


  ?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>OBBS | Patient</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .emergencybtn {
        animation: blink 1s infinite;
    }
    @keyframes blink {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }
    .text-glow{
      color: #fff;
      letter-spacing: 0.6em;
      font-weight: 800;
      font-size: 20px;
      text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 40px #ff69b4, 0 0 70px #ff69b4, 0 0 80px #ff69b4,0 0 100px #ff69b4,0 0 150px #ff69b4 ;
    }
  </style>
</head>