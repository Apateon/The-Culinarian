<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ingredient Search - The Culinarian</title>
		<link href="Images/Icon Image.png" rel="shortcut icon" type="image/x-icon">
		<link href="CSS Files/IngredientSearchCSS.css" rel="stylesheet" type="text/css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body>
		<?php include("TopNav.php"); ?>
		
		<hr class="hrwithtext" data="SEARCH USING AVAILABLE INGREDIENTS">
		
		<button class="collapsible">Select Your Ingredients</button>
		<form class="container1" method="post">
			<div class="items">
				<h2 class="ingredients">Ingredients</h2>
				<h2 class="basket">My Basket</h2>
				<span class="mess">Add Ingredients to your Basket</span>
				<?php
				$ingri = $conn->query("SELECT Ingredient_ID, Ingredient_Name from ingredients ORDER BY Ingredient_Name");
				while($ingris = $ingri->fetch_assoc())
				{
					$checkid = $ingris["Ingredient_ID"];?>
					<input id="<?php echo $checkid; ?>" type="checkbox" onclick="anyCheckbox()" value="<?php echo $checkid; ?>" name="ingris[]">
					<label for="<?php echo $checkid; ?>"><?php echo $ingris["Ingredient_Name"]; ?></label><?php
				}
				?>
				
				<input id="id" type="checkbox" onclick="anyCheckbox()" value="id" name="ingris[]">
				<label for="id">This is for ingri</label>
				
				<input class="search" type="submit" value="Search" name="checkboxer" disabled>
			</div>
		</form>
		<script src="Scripts/Checkbox Script.js"></script>
	</body>
</html>
<?php
error_reporting(0);
include("DatabaseConnection.php");
if(isset($_POST['checkboxer']))
{
	$sugge = array();
	extract($_POST);
	foreach($_POST['ingris'] as $ingid)
	{
		$receps = $conn->query("SELECT * FROM ingredient_recipe WHERE Ingredient_ID = '$ingid'");
		if(mysqli_num_rows($receps)>0)
		{
			while($rec = $receps->fetch_assoc())
			{
				$recid = $rec["Recipe_ID"];
				$temp = $conn->query("SELECT * FROM ingredient_recipe WHERE Recipe_ID = '$recid'");
				$value = round(1/mysqli_num_rows($temp),2);
				$sugge["$recid"] = $sugge["$recid"] + $value;
			}
		}
	}
	arsort($sugge);
	foreach($sugge as $k=>$v)
	{
		$result = $conn->query("SELECT * FROM recipes WHERE Recipe_ID = '$k'");
		while($row = $result->fetch_assoc())
		{
			$person = $row["Recipe_By"];
			$result2 = $conn->query("SELECT * FROM user WHERE UserID = '$person'");
			$byperson = $result2->fetch_assoc();
			?><a class="links" href='Viewer.php?id=<?php echo $row["Recipe_ID"] ?>'><div class="comments">
				<span><?php echo $row["Recipe_Name"]; ?></span>
				<div class="rate"><?php echo $row["Rating"]; ?>%</div>
				<p>By <?php echo $byperson["Name"]; ?></p>
			</div></a><?php
		}
	}
}
?>