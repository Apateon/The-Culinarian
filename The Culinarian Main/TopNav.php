<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="CSS Files/TopNavCSS.css" rel="stylesheet" type="text/css">
		<link href="CSS Files/LoginModalCSS.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src=""></script>
	</head>
	<body>
		<div class="topnav">
			<a class="headerimg" href="HomePage.php"><img src="Images/Header Image.png"></a>
			<div class="menus">
				<?php
					if(isset($_SESSION["UserID"]))
					{
						?>
							<div class="dropdown">
								<button class="dropbtn" style="font-weight: bold; padding: 32px 30px 32px 20px"><?php echo $_SESSION["Name"] ?> <i class="fa fa-caret-down"></i></button>
								<div class="dropdowncontent">
									<a href="AddRecipePage.php">Add Recipe</a>
									<a href="LogOut.php">Log Out</a>
								</div>
							</div>
						<?php
					}
					else
					{
						?><a href="SignUpPage.php" class="creator">Create an Account</a><?php
						?><a onclick="document.getElementById('loginmodal').style.display='block'">Login</a><?php
					}
				?>
				<a href="AboutUs.php">About Us</a>
				<div class="dropdown">
					<button class="dropbtn"><i class="fa fa-search"></i> Search</button>
					<div class="dropdowncontent">
						<a href="TitleSearchPage.php">Search by Title</a>
						<a href="IngredientSearchPage.php">Search by Ingredient</a>
					</div>
				</div>
				
				<div class="loginmodal" id="loginmodal">
					<form class="loginmodalcontent animate" action="" method="post">				
						<div class="logincontainer">
							<div class="headings" style="padding-bottom: 20px;"><center>Login to Avail all Services!</center></div>
							<label for="username"><b>USERNAME</b></label>
							<input type="text" placeholder="ENTER USERNAME" name="email" required>
						
							<label for="password"><b>PASSWORD</b></label>
							<input type="password" placeholder="ENTER PASSWORD" name="password" required>
							
							<button type="submit" name="submit">Login</button>
							<button type="button" onClick="document.getElementById('loginmodal').style.display='none'" style="color: white; 
	background-color: #F44336;">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
include('DatabaseConnection.php');
if(isset($_POST['submit']))
{
	extract($_POST);
	$result = mysqli_query($conn, "SELECT * FROM `user` WHERE EmailID = '$email' AND Password = '$password'");
	$row = mysqli_fetch_array($result);
	if(mysqli_num_rows($result)>0)
	{
		$_SESSION["UserID"] = $row['UserID'];
		$_SESSION["Name"] = $row['Name'];
		$_SESSION["EmailID"] = $row['EmailID'];
		$_SESSION["Verification"] = $row['Verification'];
		header("Refresh:0");
	}
	else
	{
		?><script>alert("INVALID USERNAME OR PASSWORD.");</script><?php
	}
}
?>