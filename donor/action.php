<?php
include '../dbconfig.php';
    if ($_POST['action'] == 'returnAppeal') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        // Get data of bank to be edited
        $sql = "SELECT bank_appeals.id, app_date, blood_id, blood_type.`b_name` FROM bank_appeals LEFT OUTER JOIN blood_type ON bank_appeals.`blood_id` = blood_type.`id` WHERE bank_appeals.id = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        // Return data in JSON format
        $response = array(
            "id" => $row['id']
            
        );
        echo json_encode($response);
    }
?>