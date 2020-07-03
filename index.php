<!DOCTYPE html>
<html>
<head>
	<title>ETC Portal Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div id="login_form">
	<center>
		<form method="post">

			
			<center><H3>ETC Inventory Portal</H3>

			<center><p>Welcome to the ETC Inventory Portal | Enter your details to continue</p></center>

			<img style="margin-top:10px" src="Images\logo.png"></center>


			<input style="margin-top:10px" type="text" name="username" placeholder="Username" id="detail_fields" autocomplete="off"></br><p></p>
			<input type="password" name="password" placeholder="Password" id="detail_fields"></br><p></p>
			<input type="submit" name="login" value="Login to portal   ►"   id="submit_button">
		</form>	
	</center>
</div>

</body>
<?php
include("login_handler.php");
?>
</html>