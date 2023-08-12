<?php
include('DatabaseConnection.php');
if(isset($_POST['submit']))
{
	extract($_POST);
	$checker = mysqli_query($conn, "SELECT * FROM rating WHERE Recipe_ID = '$recipeid' AND UserID = '$userid'");
	$url = "Viewer.php?id=".$recipeid;
	if(!(mysqli_num_rows($checker)>0))
	{
		$result = mysqli_query($conn, "SELECT Rating FROM recipes WHERE Recipe_ID = '$recipeid'");
		$row = mysqli_fetch_array($result);
		$new = ($row["Rating"]*0.98)+($rating*0.02);
		mysqli_query($conn, "UPDATE recipes SET Rating = '$new' WHERE Recipe_ID = '$recipeid'");
		mysqli_query($conn, "INSERT INTO rating(Recipe_ID, UserID) VALUES ('$recipeid','$userid')");
		header('Location: http://localhost/Programs/The%20Culinarian%20Main/'.$url);
	}
}
?>