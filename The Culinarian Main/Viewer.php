<!doctype html>
<html>
	<?php
	extract($_GET);
	include("DatabaseConnection.php");
	$result = $conn->query("SELECT * FROM `recipes` WHERE Recipe_ID = '$id'");
	$row = $result->fetch_assoc();
	$person = $row["Recipe_By"];
	$result2 = $conn->query("SELECT * FROM user WHERE UserID = '$person'");
	$byperson = $result2->fetch_assoc();
	?>
	<head>
		<meta charset="utf-8">
		<title><?php echo $row["Recipe_Name"]; ?> - The Culinarian</title>
		<link href="Images/Icon Image.png" rel="shortcut icon" type="image/x-icon">
		<link href="CSS Files/RecipeViewerCSS.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		
		<?php include("TopNav.php"); ?>
		
		<div class="displayheader">
			<div id="title">
				<h1 class="title shadow"><?php echo $row["Recipe_Name"]; ?></h1>
			</div>
			<div class="byperson">
				By <?php echo $byperson["Name"]; ?>
			</div>
		</div>
		<div class="row">
			<div class="column1">
				<img src="data:image/jpeg;base64,<?php echo base64_encode($row['Image'] ); ?> " onerror="this.src='Images/No Image.png';" class="image">
			</div>
			<div class="column2">
				<div>
					<div class="headings"><center>Tasty-Meter</center></div>
					<div class="scorebox">
						<div class="score"><?php echo $row["Rating"]; ?>%</div>
					</div>
					<div style="padding: 10px;">
						<div class="tastybar">
							<div class="meter value" style="--score: <?php echo $row["Rating"]; ?>%;"></div>
						</div>
					</div>
					
					<?php
					if(isset($_SESSION["UserID"]))
					{
						?><button class="blockbtn" onclick="document.getElementById('ratee').style.display='block'"><span>Rate This Recipe</span></button><?php
					}
					else
					{
						?><button class="blockbtn" onclick="document.getElementById('loginmodal').style.display='block'"><span>Rate This Recipe</span></button><?php
					}
					?>
					
					<div id="ratee" class="ratemodal">
						<div class="ratemodalcontent">
							<form action="Rating.php" method="post">
								<div class="slidecontainer">
									
									<?php 
									$ratter = $_SESSION["UserID"];
									$checker = mysqli_query($conn, "SELECT * FROM rating WHERE Recipe_ID = '$id' AND UserID = '$ratter'");
									if(mysqli_num_rows($checker)>0)
									{
										?>
										<center><img src="Images/Rating Done.png"></center>
										<?php
									}
									else
									{
										?>
										<div class="headings"><center>Rate It!</center></div>
										<span id="printer" class="rangelabel">0</span>
										<input type="hidden" name="recipeid" value="<?php echo $id; ?>">
										<input type="hidden" name="userid" value="<?php echo $_SESSION["UserID"]; ?>">
										<center><input id="slider" class="slider" type="range" value="0" min="0" max="100" name="rating"></center>
										<button type="submit" id="ratesub" name="submit">Submit</button>
										<?php
									}
									?>
									
									<button type="button" onClick="document.getElementById('ratee').style.display='none'" style="color: white; background-color: #F44336;">Cancel</button>
									
									<script>
										var slider = document.getElementById("slider");
										var printer = document.getElementById("printer");
										
										showSliderValue();
										
										slider.addEventListener("input", showSliderValue, false);
										
										function showSliderValue()
										{
											printer.innerHTML = slider.value;
											printer.style.left = (slider.value * 11) + "px";
										}
									</script>
									
								</div>
							</form>
						</div>
					</div>
				</div>
				<hr class="horizon">
				<div class="headings"><center>Calories</center></div>
				<div class="score" style="font-size: 90px;"><center><?php include("CalorieCalculator.php"); ?></center></div>
			</div>
		</div>
		<div class="row">
			<div class="column1" style="width: 40%;height: auto;">
				<div class="headings" style="padding: 16px;font-size: 40px">Ingredients</div>
				<table>
					<?php
						$ingriresult = $conn->query("SELECT * FROM ingredient_recipe WHERE Recipe_ID = '$id'");
						while($ingrirow = $ingriresult->fetch_assoc())
						{
							$ingri = $ingrirow["Ingredient_ID"];
							$result2 = $conn->query("SELECT Ingredient_Name FROM ingredients WHERE Ingredient_ID = '$ingri'");
							$ingriname = $result2->fetch_assoc();?><tr>
							<td><?php echo $ingriname["Ingredient_Name"]; ?></td>
							<td><?php echo $ingrirow["Quantity"]." ".$ingrirow["Measurer"]; ?></td></tr><?php
						}
					?>
				</table>
			</div>
			<div class="column2" style="width: 60%;">
				<div class="headings" style="padding: 16px;font-size: 40px">Steps:</div>
				<div class="steps">
					<?php echo $row["Instructions"]; ?>
				</div>
			</div>
		</div>
		<div class="headings" style="padding: 16px;font-size: 40px">Comments</div>
		<?php
		if(isset($_SESSION["UserID"]))
		{
			?><div class="comments" style="margin-bottom: -40px;">
			<form action="Comments.php" method="post">
				<input type="hidden" name="recipeid" value="<?php echo $id; ?>">
				<input type="hidden" name="userid" value="<?php echo $_SESSION["UserID"]; ?>">
				<textarea onkeyup="textAreaAdjust(this)" name="comment" placeholder="Add a comment..."></textarea>
				<input type="submit" name="submit" value="Submit">
			</form>
			<script>
				function textAreaAdjust(element) 
				{
					element.style.height = "1px";
					element.style.height = (25+element.scrollHeight)+"px";
				}
			</script>
			</div><?php
		}
		$comments = $conn->query("SELECT Comment, UserID FROM comments WHERE Recipe_ID = '$id'");
		while($commentrow = $comments->fetch_assoc())
		{
			$commenter = $commentrow["UserID"];
			$commenter = $conn->query("SELECT Name FROM user WHERE UserID = '$commenter'");
			$commenter = $commenter->fetch_assoc();
			?><div class="comments">
			<p style="font-weight: bold"><?php echo $commenter["Name"]; ?></p>
			<span><?php echo $commentrow["Comment"]; ?></span>
			</div><?php
		}
		?>
	</body>
</html>