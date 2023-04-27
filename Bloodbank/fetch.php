<?php
include '../dbconfig.php';

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

?>
