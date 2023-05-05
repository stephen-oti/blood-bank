<?php
session_start();

// Unset session variable based on module
if (isset( $_SESSION['officer_id']) && isset( $_SESSION['bank_id'])) {
    unset($_SESSION['officer_id']);
    unset($_SESSION['bank_id']);
    header('Location: login.php');
} 

exit();
?>