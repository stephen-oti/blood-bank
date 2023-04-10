<?php 
session_start();
include '../dbconfig.php';

// Retrieve the user details from the database using prepared statements
$sql = "SELECT id, fname, lname FROM patient WHERE email = ? AND pword = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ss', $_SESSION['mail'], $_SESSION['pword']);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $id, $fname,$lname);

// Fetch the results and store the user details in session variables
if (mysqli_stmt_fetch($stmt)) {
  $_SESSION['id'] = $id;
  $_SESSION['fname'] = $fname;
  $_SESSION['lname'] = $lname;
}

// Close the statement
mysqli_stmt_close($stmt);
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