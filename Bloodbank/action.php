<?php
include '../dbconfig.php';
    if ($_POST['action'] == 'endRequest') {
        // Get ID of bank to be edited
        $id = $_POST['id'];
        
        // Get data of bank to be edited
        $sql = "SELECT bank_appeals.id, app_date, blood_id, blood_type.`b_name` FROM bank_appeals LEFT OUTER JOIN blood_type ON bank_appeals.`blood_id` = blood_type.`id` WHERE bank_appeals.id = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        // Return data in JSON format
        $response = array(
            "id" => $row['id'],
            "app_date" => $row['app_date'],
            "blood_name" => $row['b_name'],
            "description" => $row['b_name']." | ".$row['app_date'],
        );
        echo json_encode($response);
    }

    if($_POST['action'] == 'bank-transfer'){
        
        // Get the quantity from the AJAX request
            $quantity = $_POST['quantity'];
            $blood_id = $_POST['blood_id'];
            $bank_id = $_POST['bank_id'];
            $pouch = $_POST['pouch'];
            $expiry = $_POST['expiry'];

            if(!empty($pouch) || $expiry < 0){
               $sql1 = "SELECT id, blood_id, units, (35 - (DATEDIFF(NOW(), fill_date))) AS num_days
               FROM pouch WHERE id = $pouch";
                $result1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($result1);
                $option_text1 = 'Pouch #' . $row1['id'] . ' (' . $row1['units'] . ' units, ' . $row1['num_days'] . ' Days to Expiry)';
                echo '<select name="pouch" id="pouch" class="form-control"><option value="'.$row1['id'] .'">'.$option_text1.'</option></select>';

            }else{

            // Connect to the database and fetch the blood pouches with the given quantity
            // ...
            $sql = "SELECT id, blood_id, units, (35 - (DATEDIFF(NOW(), fill_date))) AS num_days
                    FROM pouch
                    WHERE (units - $quantity) > 0 AND (units - $quantity) <= 10  AND blood_id = $blood_id AND DATEDIFF(NOW(), fill_date) < 35 AND pouch_status = 1 AND bank_id = $bank_id
                    ORDER BY num_days, units ASC";

            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                $options_html = '<option value="">Select Blood Pouch</option>';
                while($row = mysqli_fetch_assoc($result)){
                    $option_value = $row['id'];
                    $option_text = 'Pouch #' . $row['id'] . ' (' . $row['units'] . ' units, ' . $row['num_days'] . ' Days to Expiry)';
                    $options_html .= '<option value="' . $option_value . '">' . $option_text . '</option>';
                }

                // Return the blood pouch options as HTML
                echo '<select name="pouch" id="pouch" class="form-control">' . $options_html . '</select>';
            } else {
                echo '<select name="pouch" id="pouch" class="form-control" disabled><option value="">No available blood pouches</option></select>';
            }
                }
         }

           if($_POST['action'] == 'patient-transfer'){
            // Get the quantity from the AJAX request
            $quantity = $_POST['quantity'];
            $blood_id = $_POST['blood_id'];
            $bank_id = $_POST['bank_id'];

            // Connect to the database and fetch the blood pouches with the given quantity
            // ...
            $sql = "SELECT id, blood_id, units, (35 - (DATEDIFF(NOW(), fill_date))) AS num_days
                    FROM pouch
                    WHERE (units - $quantity) > 0 AND (units - $quantity) <= 10  AND blood_id = $blood_id AND DATEDIFF(NOW(), fill_date) < 35 AND pouch_status = 1 AND bank_id = $bank_id
                    ORDER BY num_days, units ASC";

            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                $options_html = '<option value="">Select Blood Pouch</option>';
                while($row = mysqli_fetch_assoc($result)){
                    $option_value = $row['id'];
                    $option_text = 'Pouch #' . $row['id'] . ' (' . $row['units'] . ' units, ' . $row['num_days'] . ' Days to Expiry)';
                    $options_html .= '<option value="' . $option_value . '">' . $option_text . '</option>';
                }

                // Return the blood pouch options as HTML
                echo '<select name="pouch" id="pouch" class="form-control">' . $options_html . '</select>';
            } else {
                echo '<select name="pouch" id="pouch" class="form-control" disabled><option value="">No available blood pouches</option></select>';
            }
           }
?>