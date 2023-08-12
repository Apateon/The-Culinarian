<?php
include("DatabaseConnection.php");
extract($_GET);
$calresult = $conn->query("SELECT * FROM ingredient_recipe WHERE Recipe_ID = '$id'");
$calorie = 0;
while($calrow = $calresult->fetch_assoc())
{
	$ingri = $calrow["Ingredient_ID"];
	$result2 = $conn->query("SELECT Calorie_Value FROM ingredients WHERE Ingredient_ID = '$ingri'");
	$cal = $result2->fetch_assoc();
	$calorie += $calrow["Quantity"]*$cal["Calorie_Value"];
}
echo $calorie;
?>