<?php session_start()  ?>
<?php

if (isset($_POST['login'])) {
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		include "config.php";
		$check  = mysqli_query($conn, "SELECT * from users where username = '$username' and password = '$password'");
		$result = mysqli_num_rows($check);
		$level = mysqli_fetch_array($check);
		$level = $level[3];
		$check  = mysqli_query($conn, "SELECT * from users where username = '$username' and password = '$password'");
		$name  = mysqli_fetch_array($check);
		$name  = $name[4];
	

		if ($result==1) {
			echo "<meta http-equiv='Refresh' content='0;url=session.php'>";

			
			$_SESSION['username'] 	  = $username;
			$_SESSION['access_level'] = $level;
			$_SESSION['name']		  = $name;
		}
		else{
			if($username == $admin_username && $password == $admin_password){
				echo "<meta http-equiv='Refresh' content='0;url=session.php'>";
				
				$_SESSION['username'] 	  = $admin_username;
				$_SESSION['access_level'] = "admin";
				$_SESSION['name']		  = $admin_name;
				return;
			}
			echo "<center><p style = 'color:red; font-size:18px;'>Account could not be found :(</p></center>";		
		}
}
?>