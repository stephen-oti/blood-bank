<?php
include '../dbconfig.php';
    if ($_POST['action'] == 'returnOfficer') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT * FROM officer WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        // Return data in JSON format
        $response = array(
            "id" => $row['id'],
            "firstname" => $row['fname'],
            "lastname" => $row['lname'],
            "email" => $row['email'],
            "phone" => $row['phone'],
            "pass" => $row['pword'],
            "fullName" => $row['fname']." ".$row['lname'],
        );
        echo json_encode($response);
    }
?>