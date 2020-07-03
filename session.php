<?php session_start()  ?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashoard</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


</body>

<?php

$username     = $_SESSION['username'];
$access_level = $_SESSION['access_level'];
$name		  = $_SESSION['name'];

require("session_handler.php");
?>