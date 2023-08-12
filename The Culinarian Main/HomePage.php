<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>The Culinarian</title>
        <link href="Images/Icon Image.png" rel="shortcut icon" type="image/x-icon">
		<link href="CSS Files/HomePageCSS.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php include("TopNav.php"); ?>
		
		<?php
		include("DatabaseConnection.php");
		$result = $conn->query("SELECT * FROM `recipes` ORDER BY Rating DESC LIMIT 3");
		?>
		
		<div class="headings" style="padding: 30px 0 0 0;"><center>Popular Recipes</center></div>
		<div class="allholder">
			<div class="slideshowcontainer">
				
				<?php
					while($row = $result->fetch_assoc())
					{?>
						<div class="slide fade">
							<a href>
								<img src="data:image/jpeg;base64,<?php echo base64_encode($row['Image'] ); ?> " onerror="this.src='Images/No Image.png';" style="width: 100%">
								<div class="overlay">
									<?php
					 				$person = $row["Recipe_By"];
									$result2 = $conn->query("SELECT * FROM user WHERE UserID = '$person'");
									$byperson = $result2->fetch_assoc();
					 				?>
									<a href='Viewer.php?id=<?php echo $row["Recipe_ID"] ?>'><div class="overlaytext"><?php echo $row["Recipe_Name"]; ?> by <?php echo $byperson["Name"]; ?></div></a>
								</div>
							</a>
						</div><?php
					}
				?>
				
				<a class="prev" onClick="plusSlide(-1)"><i class="fa fa-chevron-left"></i></a>
				<a class="next" onClick="plusSlide(1)"><i class="fa fa-chevron-right"></i></a>
			</div>
			<script src="Scripts/Slideshow Script.js"></script>
		</div>
		
		
	</body>
</html>