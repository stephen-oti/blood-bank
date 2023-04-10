<?php
include '../dbconfig.php';
    if ($_POST['action'] == 'editBank') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT * FROM blood_bank WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        // Return data in JSON format
        $response = array(
            "id" => $row['id'],
            "bank_name" => $row['bank_name'],
            "email" => $row['email'],
            "phone" => $row['phone'],
            "address" => $row['address'],
            "county" => $row['county'],
            "lat" => $row['lat'],
            "lon" => $row['lon']
        );
        echo json_encode($response);
    }
    if ($_POST['action'] == 'deleteBank') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT * FROM blood_bank WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        // Return data in JSON format
        $response = array(
            "id" => $row['id'],
            "bank_name" => $row['bank_name'],
        );
        echo json_encode($response);
    }

    if ($_POST['action'] == 'viewRegReq') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT * FROM reg_request WHERE req_id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        // Return data in JSON format
        $response = array(
            "id" => $row['req_id'],
            "Date" => $row['reg_date'],
            "cv" => $row['req_doc'],
            "fullName" => $row['fname']." ".$row['lname'],
           
        );
        echo json_encode($response);
    }
    if ($_POST['action'] == 'acceptRegReq') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT * FROM reg_request WHERE req_id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        // Return data in JSON format
        $response = array(
            "id" => $row['req_id'],
            "fullName" => $row['fname']." ".$row['lname'],    
        );
        echo json_encode($response);
    }
    if ($_POST['action'] == 'rejectRegReq') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT * FROM reg_request WHERE req_id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        // Return data in JSON format
        $response = array(
            "id" => $row['req_id'], 
            "fullName" => $row['fname']." ".$row['lname'],
        );
        echo json_encode($response);
    }
    if ($_POST['action'] == 'editAdmin') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT * FROM admin WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        // Return data in JSON format
        $response = array(
            "id" => $row['id'],
            "firstname" => $row['fname'],
            "lastname" => $row['lname'],
            "email" => $row['email'],
            "phone" => $row['phone'],
            "role" => $row['a_role'],
            "pass" => $row['pword']
        );
        echo json_encode($response);
    }
    if ($_POST['action'] == 'deleteAdmin') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT * FROM admin WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        // Return data in JSON format
        $response = array(
            "id" => $row['id'],
            "fullName" => $row['fname']." ".$row['lname'], 
        );
        echo json_encode($response);
    }
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
    if ($_POST['action'] == 'assignOfficer') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT officer.`id`, officer.fname,officer.lname, officer.email,officer.phone, officer.pword, blood_bank.`id` AS bank_id  
        FROM officer LEFT OUTER JOIN blood_bank ON officer.`id` = blood_bank.`officer_id` WHERE officer.id = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        // Return data in JSON format
        // ech 
        $response = array(
            "id" => $row['id'],
            "firstname" => $row['fname'],
            "lastname" => $row['lname'],
            "email" => $row['email'],
            "phone" => $row['phone'],
            "pass" => $row['pword'],
            "fullName" => $row['fname']." ".$row['lname'],
            "bank_id" => $row['bank_id'],
        );
        echo json_encode($response);
    }
    if ($_POST['action'] == 'returnDonor') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT * FROM donor WHERE id = $id";
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
            "county" => $row['county'],
            "address" => $row['address'],
            "bday" => $row['bday'],
            "gender" => $row['gender'],
            "bloodtype" => $row['blood_id'],

            "fullName" => $row['fname']." ".$row['lname'],
        );
        echo json_encode($response);
    }
    if ($_POST['action'] == 'returnPatient') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT * FROM patient WHERE id = $id";
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
            "county" => $row['county'],
            "address" => $row['address'],
            "bday" => $row['bday'],
            "gender" => $row['gender'],
            "bloodtype" => $row['blood_id'],

            "fullName" => $row['fname']." ".$row['lname'],
        );
        echo json_encode($response);
    }

?>