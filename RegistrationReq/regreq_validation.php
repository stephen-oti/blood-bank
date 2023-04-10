<?php
include '../dbconfig.php';
$field = $_POST['field'];
$value = $_POST['value'];

// Validate the input field value based on the field name
switch ($field) {
    case 'fname':
    case 'lname':
        if (preg_match('/\d/', $value) || strpos($value, ' ') !== false) {
            echo "<span class = 'text-danger'>Name should not contain spaces or digits.</span>";
            echo"<script>$('#regreqbtn').prop('disabled',true );</script>";
        }else{  
            echo"<script>$('#regreqbtn').prop('disabled',false );</script>";
        }
      break;
    case 'mail':
        // Validate the email
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            echo "<span class='text-danger'>Invalid Email Formart</span>";
            echo"<script>$('#regreqbtn').prop('disabled',true );</script>";
        } else {
            $sql = "SELECT * FROM reg_request WHERE email='$value'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<span class='text-danger'>Email already exists in the database.</span>";
                echo"<script>$('#regreqbtn').prop('disabled',true );</script>";
            }else{
                echo "<span class='text-success'>Email Available for registration</span>";
                echo"<script>$('#regreqbtn').prop('disabled',false );</script>";
            }
           
        }
      break;
    case 'phone':
        // Validate phone
        if (!preg_match('/^(?:\+2547|\+2541|0?7)\d{8}$/', $value)) {
            echo "<span class='text-danger'>Phone number should be either in the format +254xxxxxxxxx or 07xxxxxxxx.</span>";
            echo"<script>$('#regreqbtn').prop('disabled',true );</script>";
        } else {
            $sqlphone = "SELECT * FROM reg_request WHERE phone='$value'";
            $resultphone = mysqli_query($conn, $sqlphone);
            if (mysqli_num_rows($resultphone) > 0) {
                echo "<span class='text-danger'>Phone already in use by another user.</span>";
                echo"<script>$('#regreqbtn').prop('disabled',true );</script>";
            }else{
                echo "<span class='text-success'>Phone Available for registration</span>";
                echo"<script>$('#regreqbtn').prop('disabled',false );</script>";
            }
        }
      break;
    case 'psword':
        // Validate password
        if (strlen($value) < 8 || strlen($value) > 10) {
            echo "<span class='text-danger'> Password is &ge; 8 OR Password &le; 10.</span>";
            echo"<script>$('#regreqbtn').prop('disabled',true );</script>";
        }else{
            echo"<script>$('#regreqbtn').prop('disabled',false );</script>";
        }
      break;
    default:
      $response['error'] = 'Invalid field name.';
      break;
  }
  

?>
