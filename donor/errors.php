<?php
session_start();
include '../dbconfig.php';
  // Check if the form has been submitted
  
  if(isset($_POST['update-pi'])) {
    $donor_id = $_SESSION['id'];
    // Get the updated values from the form
    $blood_group = intval($_POST['blood_group']);
    $latitude = $_POST['lat'];
    $longitude = $_POST['long'];
    $d_status = 1;
    // echo "Medical condition:$medical_condition, lon: $longitude, file: $file_name, lat: $latitude,  blood: $blood_group";
    // Check if a medical condition was selected
    if($_POST['condition-select'] == 'yes') {
      // $has_condition = 1;
      $medical_condition = $_POST['condition'];
    } else {
      // $has_condition = 0;
      $medical_condition = "None";
    }

    // echo "$medical_condition, $longitude,$file_name, $latitude,  $blood_group";
  if ($_FILES['customFile']['size'] > 0) {
    $file_name = 'donor_' . str_pad($_SESSION['id'], 7, '0', STR_PAD_LEFT) . '_' . time() . '.pdf';
    // Search for existing files with the same name pattern
    $existing_files = glob("uploads/donor_" . str_pad($_SESSION['id'], 7, '0', STR_PAD_LEFT) . '_*.pdf');


    // Delete any existing files
    foreach($existing_files as $existing_file) {
      unlink($existing_file);
    }
        // Upload the file to the server
        $target_dir = "uploads/";
        $target_file = $target_dir . $file_name;
        move_uploaded_file($_FILES['customFile']['tmp_name'], $target_file);
    
        // Update the patient record in the database
        $sql = "UPDATE donor SET blood_id = ?, d_cond = ?, d_lat = ?, d_lon = ?, d_report = ? ,d_status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isddsii", $blood_group, $medical_condition, $latitude, $longitude, $file_name,$d_status, $donor_id);
  }else{
    $sql = "UPDATE patient SET blood_id = ?, d_cond = ?, d_lat = ?, d_lon = ?, d_status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isddii", $blood_group, $medical_condition, $latitude, $longitude, $d_status, $donor_id);
  }
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if(mysqli_stmt_affected_rows($stmt) > 0) {
      echo 'update successful';
    } else {
       $myfile = $_FILES['customFile'];
      echo "Medical condition:$medical_condition, lon: $longitude, file: $myfile, lat: $latitude,  blood: $blood_group";
      ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Update failed. Please try again.'. mysqli_error($conn).'</div>';
    }

    // Close the statement
    mysqli_stmt_close($stmt);
  }