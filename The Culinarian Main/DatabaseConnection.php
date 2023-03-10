<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$conn = mysqli_connect($servername, $dbusername, $dbpassword);
$db = mysqli_select_db($conn, "the culinarian");
if(!$conn)
	die("Connection failed: " . mysqli_connect_error());
?>