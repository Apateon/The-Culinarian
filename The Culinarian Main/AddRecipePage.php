<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Add New Recipe - The Culinarian</title>
		<link href="Images/Icon Image.png" rel="shortcut icon" type="image/x-icon">
		<link href="CSS Files/AddRecipeCSS.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php include("TopNav.php"); ?>
		
		<hr class="hrwithtext" data="ADD A NEW RECIPE">
		
		<div class="container">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="row">
					<label for="rtitle">Recipe Title</label>
					<input type="text" name="rtitle" placeholder="Title of the Dish.." required>
				</div>
				<div class="row">
					<label for="category">Category</label>
					<input type="text" list="categories" name="category" required>
					<datalist id="categories">
						<?php
						$category = $conn->query("SELECT DISTINCT Category FROM recipes");
						while($categoryrow = $category->fetch_assoc())
						{
							$option = $categoryrow["Category"];?>
							<option value="<?php echo $option; ?>"><?php
						}?>
					</datalist>
				</div>
				<div class="row">
					<label for="ingredients">Ingredients</label>
					<div id="newingri">
					</div>
					
					<button type="button" onclick="ingriBoxCreate()">Add Ingredient</button>
					<script>
						var i = 1;
						function ingriBoxCreate() 
						{
							var y = document.createElement("div");
							y.setAttribute("Class", "ingrirow");
							y.innerHTML = '<select id="ingredients" name="ingredient'+i+'"><?php include("Options.php"); ?></select>Quantity: <input name="quantity'+i+'" style="width: 20%;" type="number" min="0">';
							document.getElementById("newingri").appendChild(y);
							i++;
						}
					</script>
				</div>
				<div class="row">
					<label for="instructions">Instructions</label>
					<textarea name="instructions" placeholder="Write the steps here...." style="height:200px" required></textarea>
				</div>
				<div class="row">
					<label for="image">Image</label>:
					<input type="file" name="image" required>
				</div>
				<div class="row">
					<input name="addrecipe" type="submit" value="Submit">
				</div>
			</form>
		</div>
	</body>
</html>
<?php
include('DatabaseConnection.php');
if(isset($_POST['addrecipe']))
{
	$uploadimage = addslashes(file_get_contents($_FILES['image']['tmp_name']));
	extract($_POST);
	$userid = $_SESSION["UserID"];
	if(mysqli_query($conn, "INSERT INTO recipes(`Recipe_Name`, `Category`, `Instructions`, `Rating`, `Recipe_By`, `Image`) VALUES ('$rtitle','$category','$instructions','50','$userid','$uploadimage')"))
		?><script>alert("Recipe Added Successfully");</script><?php
	$newrec = mysqli_query($conn, "SELECT MAX(Recipe_ID) FROM recipes");
	$newrec = mysqli_fetch_array($newrec);
	$newrec = $newrec["MAX(Recipe_ID)"];
	$ingridi = array();
	$quanti = array();
	$searchi = "ingredient";
	$searchq = "quantity";
	$searchilength = strlen($searchi);
	$searchqlength = strlen($searchq);
	foreach ($_POST as $key => $value) 
	{
    	if (substr($key, 0, $searchilength) == $searchi) 
		{ 
			$ingridi = array_merge($ingridi, array($key=>$value));
		}
		if (substr($key, 0, $searchqlength) == $searchq) 
		{ 
			$quanti = array_merge($quanti, array($key=>$value));
		}
    }
	$length = count($ingridi);
	for($lop=1;$lop<=$length;$lop++)
	{
		$icounter = "ingredient".$lop;
		$qcounter = "quantity".$lop;
		mysqli_query($conn, "INSERT INTO ingredient_recipe(`Recipe_ID`, `Ingredient_ID`, `Quantity`, `Measurer`) VALUES ('$newrec','$ingridi[$icounter]','$quanti[$qcounter]','Nos')");
	}
}
?>