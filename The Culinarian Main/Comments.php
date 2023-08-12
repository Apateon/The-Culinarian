<?php
include('DatabaseConnection.php');
if(isset($_POST['submit']))
{
	extract($_POST);
	$url = "Viewer.php?id=".$recipeid;
	mysqli_query($conn, "INSERT INTO comments VALUES ('$recipeid','$userid','$comment')");
	header('Location: http://localhost/Programs/The%20Culinarian%20Main/'.$url);
}
?>