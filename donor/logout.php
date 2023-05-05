<?php
session_start();

// Unset session variable based on module
if (isset($_SESSION['donor_id'])) {
    unset($_SESSION['donor_id']);
    header('Location: login.php');
} 

exit();
?>