<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Title Search - The Culinarian</title>
		<link href="Images/Icon Image.png" rel="shortcut icon" type="image/x-icon">
		<link href="CSS Files/TitleSearchCSS.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php include("TopNav.php"); ?>
		
		<style>
			.searcher
			{
				padding: 10px;
				font-size: 17px;
				border: 1px solid grey;
				width: 89.7%;
				background: #F1F1F1;
			}
		</style>
		
		<hr class="hrwithtext" data="SEARCH USING RECIPE NAME">
		<div class="searchbar">
			<form action="" method="post">
				<input class="searcher" type="text" placeholder="Search by Title" name="searchvalue">
				<button class="searchbtn" type="submit" name="search">SEARCH</button>
			</form>
		</div>
		
	</body>
</html>
<?php
include("DatabaseConnection.php");
if(isset($_POST['search']))
{
	extract($_POST);
	$result = $conn->query("SELECT * FROM `recipes` WHERE `Recipe_Name` LIKE '%$searchvalue%' ORDER BY rating DESC");
	if(mysqli_num_rows($result)>0)
	{
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
	else
		echo "There are no Recipes with that name";
}
?>