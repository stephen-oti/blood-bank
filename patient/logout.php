
<?php
session_start();

// Unset session variable based on module
if (isset($_SESSION['patient_id'])) {
    unset($_SESSION['patient_id']);
    header('Location: login.php');
} 

exit();
?>