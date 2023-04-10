<?php 

$servername = "localhost";
$username = "root";
$password = "stephen";
$dbname = "obbs";


$conn = new mysqli($servername, $username,$password, $dbname);
if($conn->connect_error) {
	echo "<script> alert('Mysql Connection Error')</script>";
	die("Connection Failed : " . $conn->connect_error);
}
?>