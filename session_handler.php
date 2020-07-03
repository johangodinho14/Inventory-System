<?php
//This file will check what access rights the user has and redirect him/her to the correct page with appropriate options

if($access_level == "admin"){
	echo "
		
		<center><h3>Welcome $name</h3></center>
		
		<center><div id='header'>
			<form method = 'post'>
				<input id = 'menu_buttons' type = 'submit' name = 'add_new_user' value = 'New Employee'>	
				<input id = 'menu_buttons' type = 'submit' name = 'remove_user' value = 'Remove Employee'>	
				<input id = 'menu_buttons' type = 'submit' name = 'new_item' value = 'Add new item'>
				<input id = 'menu_buttons' type = 'submit' name = 'edit_item' value = 'Edit Item'>
				<input id = 'menu_buttons' type = 'submit' name = 'remove_item' value = 'Remove Item'>	
				<input id = 'menu_buttons' type = 'submit' name = 'inventory' value = 'Inventory'>
				<input id = 'menu_buttons' type = 'submit' name = 'all_items' value = 'View all items'>		
				<input id = 'menu_buttons' type = 'submit' name = 'sort_all_items' value = 'Sort all items'>	
				<input id = 'menu_buttons' type = 'submit' name = 'logout' value = 'Logout'>	
			</form>
			
		</div></center>

	";
}
elseif ($access_level == "Manager") {
	echo "
		
		<center><h3>Welcome $name</h3></center>
		
		<center><div id='header'>
			<form method = 'post'>
				<input id = 'menu_buttons' type = 'submit' name = 'add_new_user' value = 'New Employee'>		
				<input id = 'menu_buttons' type = 'submit' name = 'new_item' value = 'Add new item'>
				<input id = 'menu_buttons' type = 'submit' name = 'inventory' value = 'Inventory'>	
				<input id = 'menu_buttons' type = 'submit' name = 'all_items' value = 'View all items'>
				<input id = 'menu_buttons' type = 'submit' name = 'sort_all_items' value = 'Sort all items'>	
				<input id = 'menu_buttons' type = 'submit' name = 'logout' value = 'Logout'>	
			</form>
			
		</div></center>

	";
}

elseif ($access_level == "Supervisor") {
	echo "
		
		<center><h3>Welcome $name</h3></center>
		
		<center><div id='header'>
			<form method = 'post'>		
				<input id = 'menu_buttons' type = 'submit' name = 'inventory' value = 'Inventory'>	
				<input id = 'menu_buttons' type = 'submit' name = 'logout' value = 'Logout'>	
			</form>
			
		</div></center>

	";

}

else{
	echo "
		
		<center><h3>Welcome $name</h3></center>
		
		<center><div id='header'>
			<form method = 'post'>		
				<input id = 'menu_buttons' type = 'submit' name = 'inventory_member' value = 'Inventory'>	
				<input id = 'menu_buttons' type = 'submit' name = 'logout' value = 'Logout'>	
			</form>
			
		</div></center>

	";
}


require("session_function_handler.php"); //This will allow the function for appropriate buttons to be triggered.

?>