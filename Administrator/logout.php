<?php
session_start();

// Unset session variable based on module
if (isset($_SESSION['admin_id'])) {
    unset($_SESSION['admin_id']);
    header('Location: login.php');
} 

exit();
?>