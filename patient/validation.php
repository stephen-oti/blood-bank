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
            echo"<script>$('#submit').prop('disabled',true );</script>";
        }else{  
            echo"<script>$('#submit').prop('disabled',false );</script>";
        }
      break;
    case 'mail':
        // Validate the email
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            echo "<span class='text-danger'>Invalid Email Formart</span>";
            echo"<script>$('#submit').prop('disabled',true );</script>";
        } else {
            $sql = "SELECT * FROM patient WHERE email='$value'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<span class='text-danger'>Email already exists in the database.</span>";
                echo"<script>$('#submit').prop('disabled',true );</script>";
            }else{
                echo "<span class='text-success'>Email Available for registration</span>";
                echo"<script>$('#submit').prop('disabled',false );</script>";
            }
           
        }
      break;
    case 'phone':
        // Validate phone
        if (!preg_match('/^(?:\+2547|\+2541|0?7)\d{8}$/', $value)) {
            echo "<span class='text-danger'>Phone number should be either in the format +254xxxxxxxxx or 07xxxxxxxx.</span>";
            echo"<script>$('#submit').prop('disabled',true );</script>";
        } else {
            $sqlphone = "SELECT * FROM patient WHERE phone='$value'";
            $resultphone = mysqli_query($conn, $sqlphone);
            if (mysqli_num_rows($resultphone) > 0) {
                echo "<span class='text-danger'>Phone already in use by another user.</span>";
                echo"<script>$('#submit').prop('disabled',true );</script>";
            }else{
                echo "<span class='text-success'>Phone Available for registration</span>";
                echo"<script>$('#submit').prop('disabled',false );</script>";
            }
        }
      break;
    case 'dob':
        $today = new DateTime();
        $dob_date = new DateTime($value);
        $age = $today->diff($dob_date)->y;
        if ($age < 18) {
            echo "<span class='text-danger'>You must be at least 18 years old to register.</span>";
            echo"<script>$('#submit').prop('disabled',true );</script>";
        }else{
            echo"<script>$('#submit').prop('disabled',false );</script>";
        }
      break;
    case 'address':
        // Validate address
        if (!preg_match('/^\d{3,4}\s?\-\s?\d{4,5},\s?[a-zA-Z]+\s?[a-zA-Z]*$/i', $value)) {
            echo "<span class='text-danger'>Address should be in the format XXXX-XXXXX, Town Name.</span>";
            echo "<script>$('#submit').prop('disabled', true);</script>";
        } else {
            echo "<script>$('#submit').prop('disabled', false);</script>";
        }
        break;
    case 'county':
        // Validate county
        if (preg_match('/\d/', $value)) {
            echo "<span class='text-danger'>County name should not contain digits..</span>";
            echo"<script>$('#submit').prop('disabled',true );</script>";
        }
      break;
    case 'psword':
        // Validate password
        if (strlen($value) < 8 || strlen($value) > 10) {
            echo "<span class='text-danger'> Password is &ge; 8 OR Password &le; 10.</span>";
            echo"<script>$('#submit').prop('disabled',true );</script>";
        }else{
            echo"<script>$('#submit').prop('disabled',false );</script>";
        }
      break;
    case 'lat':
        if (!is_numeric($value)) {
            echo "<span class='text-danger'> Integer values only allowed</span>";
            echo "<script>$('#update-pi').prop('disabled',true );</script>";
        } else {
            if ($value < -90 || $value > 90) {
                echo "<span class='text-danger'>Latitude ranges between -90 to 90</span>";
                echo "<script>$('#update-pi').prop('disabled',true );</script>";
            } else {
                $pattern = "/^-?((1[0-7][0-9]|[1-9]?[0-9])\.\d+|90\.0+)$/i";
                if (!preg_match($pattern, $value)) {
                    echo "<span class='text-danger'>Invalid decimal format</span>";
                } else {
                    echo"<script>$('#update-pi').prop('disabled',false );</script>";
                }
            }
        }
        break;
    case 'long':
        if (!is_numeric($value)) {
            echo "<span class='text-danger'> Integer values only allowed</span>";
            echo "<script>$('#update-pi').prop('disabled',true );</script>";
        } else {
            if ($value < -180 || $value > 180) {
                echo "<span class='text-danger'>Longitude ranges between -180 to 180</span>";
                echo "<script>$('#update-pi').prop('disabled',true );</script>";
            } else {
                $pattern = "/^-?([1-8]?[0-9]\.\d+|90\.0+)$/i";
                if (!preg_match($pattern, $value)) {
                    echo "<span class='text-danger'>Invalid decimal format for longitude</span>";
                } else {
                    echo"<script>$('#update-pi').prop('disabled',false );</script>";
                }
            }
        }
        break;
    

    default:
      $response['error'] = 'Invalid field name.';
      break;
  }
  

?>
