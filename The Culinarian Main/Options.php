<option value="" disabled selected>Select the Ingredient</option><?php
$ingris = $conn->query("SELECT Ingredient_Name, Ingredient_ID FROM ingredients");
while($ingrirow = $ingris->fetch_assoc())
{
	$option = $ingrirow["Ingredient_ID"];?>
	<option value="<?php echo $option; ?>"><?php echo $ingrirow["Ingredient_Name"]; ?></option><?php
}
?>