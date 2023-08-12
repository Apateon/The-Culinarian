<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sign Up - The Culinarian</title>
        <link href="Images/Icon Image.png" rel="shortcut icon" type="image/x-icon">
		<link href="CSS Files/SignUpCSS.css" rel="stylesheet" type="text/css">
		<script>
			function checker()
			{
				if(document.getElementById('psw1').value==document.getElementById('psw2').value)
				{
					document.getElementById('message').innerHTML = '';
					document.getElementById('submitbtn').disabled = false;
				}
				else
				{
					document.getElementById('message').style.color = 'red';
					document.getElementById('message').innerHTML = '*The Passwords Do Not Match';
					document.getElementById('submitbtn').disabled = true;
				}
			}
		</script>
    </head>
	<body>
		<?php
			include("TopNav.php");
		?>
		<form action="" method="post" style="border: 3px solid #71A400; margin: 50px 0 0 0;">
			<div class="signupcontainer">
				<div class="headings"><center>Welcome Aboard!</center></div>
				<h3 class="label">Fill up the form below and Join our Community. It's as easy as 1,2,3...</h3>
				<hr>
				
				<label class="label" for="name"><b>Name</b></label>
				<input type="text" placeholder="Enter your Full Name" name="name" required>
				
				<label class="label" for="email"><b>E-Mail</b></label>
				<input type="text" placeholder="Enter your E-Mail" name="email" required>
				
				<label class="label" for="psw1"><b>Password</b></label>
				<input type="password" placeholder="Choose a Password" name="psw1" value="" id="psw1" onkeyup="checker()" required>
				
				<label class="label" for="psw2"><b>Repeat Password</b></label>
				<input type="password" placeholder="Repeat your Password" name="psw2" value="" id="psw2" onkeyup="checker()" required>
			
				<span class="label" id="message" style="font-size: 20px;padding: 10px;"></span>
				
				<center><button type="submit" name="submit" id="submitbtn" class="signupbtn">Sign Up</button></center>
			</div>
		</form>
	</body>
</html>
<?php
include('DatabaseConnection.php');
if(isset($_POST['submit']))
{
	extract($_POST);
	$result = mysqli_query($conn, "SELECT * FROM `user` WHERE EmailID = '$email'");
	if(mysqli_num_rows($result)>0)
	{
		?><script>alert("Another account with the same E-mail Address already exists. Continue to Login or use another E-mail Address");</script><?php
	}
	else
	{
		$result = mysqli_query($conn, "INSERT INTO `user`(`Password`, `Name`, `EmailID`) VALUES ('$psw1','$name','$email')");
		if($result)
		{
			mail($email,"CONGRATULATIONS ON JOINING OUR COMUNITY","Thank you for signing up to culinarian. We would love to work very closely with you to connect world wide famous chefs to the little chefs at home.");
			?><script>alert("YOUR ACCOUNT WAS CREATED SUCCESSFULLY. YOU MAY NOW PROCEED TO LOGIN.");</script><?php
			header('Location: http://localhost/Programs/The%20Culinarian%20Main/HomePage.php');
		}
		else
		{
			?><script>alert("Something went wrong. Please try registering again.");</script><?php
		}
	}
}
?>