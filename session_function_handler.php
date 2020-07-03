<style type="text/css">
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
  font-family: calibri;

}

</style>

<?php



function add_new_user(){

	$firstname = $_POST['firstname'];
	$job_role  = $_POST['job_role'];
	$password  = $_POST['password'];
	$username  = $_POST['username'];

	if($firstname == "" or $job_role == "" or $password == "" or $username == ""){
		echo "<center><p>All Fields Required !</p></center>";	
	}else{

	include "config.php";
	$request = mysqli_query($conn, "SELECT * from users where username = '$username'");
	$count   = mysqli_num_rows($request);

	if($count >= 1){
		echo "<center><p>This username already exists and cannot be used. Please select a different username</p></center>";
	}else{

	include "config.php";
	mysqli_query($conn, "INSERT into `users`(`username`, `password`, `access_level`, `name` ) VALUES('$username', '$password', '$job_role', '$firstname')");

	echo "<center><p>Account has been created successfully.</p></center>";
		}
	}
}


//form for every new user registered (admin page) -- front end
if(isset($_POST['add_new_user'])){

	echo "<center><h5>Add New Employee</h5></center>
			
			<center><form method = 'post'>

				<input id = 'form_input' type = 'text' name='firstname' placeholder='Full Name' autocomplete='off'><p></p>
				<input id = 'form_input' type = 'text' name='username' placeholder='Username' autocomplete='off'><p></p>	
				<input id = 'form_input' type = 'text' name='password'	placeholder=' New Password'autocomplete='off'><p></p>

				<select name = 'job_role'>
					<option value = 'Manager'>	 Manager			</option>
					<option value = 'Supervisor'>Supervisor 		</option>
					<option value = 'Member'>	 Member 			</option>
				</select>
				<p></p>
				<input id = 'form_submit' type = 'submit' value = 'Finish Registration' name='finish_new_user_add'>
			</form></center>
	";
}

//form for every user that is being deleted (front end)
if (isset($_POST['remove_user'])) {
	echo "<center><h5>Remove Employee Account</h5><p>Please select an account from the list to remove it from the system</p></center>";

	include "config.php";
	$request = mysqli_query($conn, "SELECT * from users");
	$count   = mysqli_num_rows($request);
	for ($i=0; $i < $count ; $i++) { 
	 	$result = mysqli_fetch_array($request);
	 	echo "<center>
					<form method = 'post'>
						<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = '$result[1]' name = 'deleted_user'>
					</form>
			 </center>

			";
	 } 
}

//Adding a new item to the inventory (front end)
if (isset($_POST['new_item'])) {
	echo "<center><h5>Add new item to inventory</h5><p>Please fill in the form below to add item</p></center>";
	echo "	
		<center>
			<form method = 'post'>
				<input id = 'form_input' type = 'text' placeholder = 'Item Name' name = 'item_name' autocomplete = 'off'><p></p>
				<input id = 'form_input' type = 'text' placeholder = 'Item Type' name = 'item_type'	autocomplete = 'off'><p></p>
						
						<select name = 'item_condition'>
							<option value = 'Fully Functional'>Fully Functional</option>
							<option value = 'Needs Repair'>Needs Repair</option>
							<option value = 'Not Working'>Not Working</option>
							<option value = 'Other'>Other | Use Comments</option>
						</select><p></p>

				<input id = 'form_input' type = 'text' placeholder = 'Comments | Type NA if none' name = 'item_comments' autocomplete = 'off'><p></p>
				<input id = 'form_input' type = 'text' placeholder = 'Item location' name = 'item_location' autocomplete = 'off'><p></p>
				<input id = 'form_input' type = 'text' placeholder = 'Serial Number' name = 'serial_number' autocomplete = 'off'><p></p>


				<input id = 'form_submit' type = 'submit' value = 'Add Item' name = 'item_added'><p></p>
			</form>
		</center>
	";
}

//adding a new item to the inventory (back end)
if (isset($_POST['item_added'])) {

	$item_name 		= $_POST['item_name'];
	$item_tipe		= $_POST['item_type'];
	$item_condition = $_POST['item_condition'];
	$item_comments  = $_POST['item_comments'];
	$item_location  = $_POST['item_location'];
	$serial_number  = $_POST['serial_number'];


		if ($item_name == "" or $item_type = "" or $item_condition == "" or $item_comments == "" or $item_condition == "" or $serial_number == "" ) {
			echo "<center><p>All Fields Required</p></center>";
		}else{
			include "config.php";
			mysqli_query($conn, "INSERT into `items`(`item_name`, `item_type`, `item_condition`, `item_comments`, `item_location`, `serial_number`) VALUES('$item_name', '$item_tipe', '$item_condition', '$item_comments', '$item_location', '$serial_number')");
			$request = mysqli_query($conn, "SELECT * from items where item_name = '$item_name' ");
			$result  = mysqli_fetch_array($request);
			echo "<center><p>$item_name has been added to the inventory</p>
						  <p>Reference Code : $result[0]</p>
			</center>";
		}
}


//registering every new user (admin page) -- back end
if (isset($_POST['finish_new_user_add'])) {
add_new_user();
}

//deleting the selected user from the database
if (isset($_POST['deleted_user'])) {

	$deleted_user = $_POST['deleted_user'];
	include "config.php";
	$request = mysqli_query($conn, "DELETE from users where username = '$deleted_user'");
	echo "<center><p>$deleted_user has been removed from the system :(</p></center>";
}



//global logout function
if (isset($_POST['logout'])) {
	echo "<meta http-equiv='Refresh' content='0;url=index.php'>";
}

//editing item details (front end)
if (isset($_POST['edit_item'])) {


	include "config.php";
	$request = mysqli_query($conn, "SELECT * from items");
	$count	 = mysqli_num_rows($request);
	echo "<center><p>Please select item to be edited</p></center>";
	for ($i=0; $i < $count ; $i++) { 
	 	$result = mysqli_fetch_array($request);
	 	echo "<center>
					<form method = 'post'>
						<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = '$result[1]' name = 'edit_item_done'>
					</form>
			 </center>

			";
	 } 
}

if (isset($_POST['edit_item_done'])) {
	$edit_item = $_POST['edit_item_done'];
	include "config.php";
	$request = mysqli_query($conn, "SELECT * from items where item_name = '$edit_item'");
	$result = mysqli_fetch_array($request);
	
	$ids = $result[0];
	$item_name = $result[1];
	$item_type = $result[2];
	$item_condition = $result[3];
	$item_comments  = $result[4];
	$item_location  = $result[5];
	$serial_number  = $result[6];

	echo "<center><h5>Edit item from inventory</h5><p>Please fill in the form below to edit item</p></center>";
	echo "	
		<center>
			<form method = 'post'>
				<input type = 'hidden' value = '$ids' name = 'ids'> 
				<input id = 'form_input' type = 'text' value = '$item_name' name = 'item_name' autocomplete = 'off'><p></p>
				<input id = 'form_input' type = 'text' value = '$item_type' name = 'item_type'	autocomplete = 'off'><p></p>
						
						<select name = 'item_condition'>
							<option value = 'Fully Functional'>Fully Functional</option>
							<option value = 'Needs Repair'>Needs Repair</option>
							<option value = 'Not Working'>Not Working</option>
							<option value = 'Other'>Other | Use Comments</option>
						</select><p></p>
				<input id = 'form_input' type = 'text' value = '$item_comments' name = 'item_comments' autocomplete = 'off'><p></p>
				<input id = 'form_input' type = 'text' value = '$item_location' name = 'item_location'	autocomplete = 'off'><p></p>
				<input id = 'form_input' type = 'text' value = '$serial_number' name = 'serial_number'	autocomplete = 'off'><p></p>
				<input id = 'form_submit' type = 'submit' value = 'Update Item' name = 'item_updated'><p></p>
			</form>
		</center>
	";
}

//editing item details (back end)
if (isset($_POST['item_updated'])) {
	$ids = $_POST['ids'];
	$new_item_name = $_POST['item_name'];
	$new_item_type = $_POST['item_type'];
	$new_item_condition = $_POST['item_condition'];
	$new_item_comments  = $_POST['item_comments'];
	$new_item_location = $_POST['item_location'];
	$new_serial_number = $_POST['serial_number'];

	include "config.php";
	mysqli_query($conn, "UPDATE items SET item_name = '$new_item_name', item_type = '$new_item_type', item_condition = '$new_item_condition', item_comments = '$new_item_comments', item_location = '$new_item_location', serial_number = '$new_serial_number' where id = '$ids' ");
	echo "<center><p>$new_item_name has been updated successfully :)</p></center>";
	
}

//Removing an item from the inventory (front end)
if (isset($_POST['remove_item'])) {

	include "config.php";
	$request = mysqli_query($conn, "SELECT * from items");
	$count   = mysqli_num_rows($request);
	echo "<center><p>Please select item to be removed</p></center>";
	for ($i=0; $i < $count ; $i++) { 
	 	$result = mysqli_fetch_array($request);
	 	echo "<center>
					<form method = 'post'>
						<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = '$result[1]' name = 'deleted_item'>
					</form>
			 </center>

			";
	 } 

}

//Removing 
if (isset($_POST['deleted_item'])) {
	
	$deleted_item = $_POST['deleted_item'];
	include "config.php";
	$request = mysqli_query($conn, "DELETE from items where item_name = '$deleted_item'");
	echo "<center><p>$deleted_item has been removed from the system :(</p></center>";

}


//all of the inventory borrowal process
if (isset($_POST['inventory_member'])) {
	echo "<center>
					<form method = 'post'>
						<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = 'Inventory Log + / -' name = 'inventory_log_member'>
					</form>
			 </center>

			";
}

if (isset($_POST['inventory'])) {

		echo "<center>
					<form method = 'post'>
						<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = 'View Inventory Log' name = 'view_inventory_log'></br>
						<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = 'Inventory Log + / -' name = 'inventory_log'>
					</form>
			 </center>

			";
}

if (isset($_POST['view_inventory_log'])) {

	echo "
		<table style='width:100%''>
		  <caption>Inventory Log</caption>
		  <tr>
		    <th>Item Name</th>
		    <th>Item Reference Code</th>
		    <th>Item Location</th>
		    <th>Borrowed by</th>
		    <th>Authorised return date</th>
		    <th>Borrowal reason</th>
		  </tr>	

	";

	include "config.php";
	$request = mysqli_query($conn, "SELECT * from inventory order by id DESC");
	$count = mysqli_num_rows($request);

	for ($i=0; $i < $count; $i++) { 
		$result = mysqli_fetch_array($request);
echo "
	
	<tr>
	<td>$result[5]</td>
	<td>$result[1]</td>
	<td>$result[7]</td>
	<td>$result[2]</td>
	<td>$result[3]</td>
	<td>$result[6]</td>
	</tr>

	
		
";
	}
	

}

if (isset($_POST['inventory_log_member'])) {
	echo "

		<center>
			<form method = 'post'>
				<input style = 'margin-top:10px;' id = 'form_input' type = 'text' placeholder = 'Item Reference Code ' name = 'item_reference' autocomplete = 'off'><p></p>
				<input id = 'form_submit' type = 'submit' value = 'Search' name = 'item_search_member'><p></p>
			</form>
		</center>

	";
}



if (isset($_POST['inventory_log'])) {
	echo "

		<center>
			<form method = 'post'>
				<input style = 'margin-top:10px;' id = 'form_input' type = 'text' placeholder = 'Item Reference Code ' name = 'item_reference' autocomplete = 'off'><p></p>
				<input id = 'form_submit' type = 'submit' value = 'Search' name = 'item_search'><p></p>
			</form>
		</center>

	";
	
}

if(isset($_POST['item_search_member'])){
	
	//capturing the item reference and splitting it into different values
	$item_reference = $_POST['item_reference'];
	$item_references = explode(",", $item_reference);
	$array_size = count($item_references);
	$_SESSION['item_references'] = $item_references;


	//Checking how many items there are in the array (single item selection or multiple)
	if ($array_size > 1) {
			for ($i=0; $i < $array_size ; $i++) { 
					include "config.php";
					$request = mysqli_query($conn, "SELECT * from items where id = '$item_references[$i]'");
					$count = mysqli_num_rows($request);
					//Checking if the given codes exist in the system or not
					if($count < 1){
						
						$item_references = array_diff($item_references,['$item_references[$i]'] );
						

						echo "<center><p>Sorry, item with code: $item_references[$i] doesn't exist in the system. Please try again</p></center> ";
					}
					else{
						$result = mysqli_fetch_array($request);
						$ids = $result[0];
						$item_name = $result[1];
						$item_condition = $result[3];
						$item_location = $result[5];
						$serial_number = $result[6];
						//$item_references = $_SESSION['item_references'];
						$item_referencess = implode(",", $item_references);
						echo "	
							<center>
								<form method = 'post'>
									<input  type = 'hidden' value = '$item_referencess' name = 'ids'> 
									<input  type = 'hidden' value = '$item_name' name = 'item_name1'> 
									<input style = 'margin-top:10px;' id = 'form_input' value = '$item_name' name = 'item_name' autocomplete = 'off' disabled><p></p>
									<input id = 'form_input' type = 'text' value = '$item_condition' name = 'item_condition'autocomplete = 'off' disabled><p></p>
									<input id = 'form_input' type = 'text' value = '$item_location' name = 'item_location' autocomplete = 'off' disabled><p></p>
									<input id = 'form_input' type = 'text' value = '$serial_number' name = 'serial_number' autocomplete = 'off' disabled><p></p>
									
								
							</center>
						"; 
					}
				
			}//End of for loop
			//This part of the form (submit button ((return/ borrow has been put here so it doesn't repeat)))
			echo "
			
			<center><select name = 'status'>
						<option value = 'Borrow'>Borrow</option>
					
			</select><p></p>
			<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = 'Done' name = 'status_done_member'>

				</center></form>";

	//Only one item exists in the list so the normal operation can be carried on
	}else{
		include "config.php";
	
	$request = mysqli_query($conn, "SELECT * from items where id = '$item_reference'");
	$count = mysqli_num_rows($request);
	if($count < 1){
		echo "<center><p>Sorry, the given reference code doesnt exist in the system :(</p></center> ";
	}
	else{
	$result = mysqli_fetch_array($request);
	$ids = $result[0];
	$item_name = $result[1];
	$item_type = $result[2];
	$item_condition = $result[3];
	$item_comments  = $result[4];
	$item_location = $result[5];
	$serial_number = $result[6];

	echo "	
		<center>
			<form method = 'post'>
				<input  type = 'hidden' value = '$ids' name = 'ids'> 
				<input  type = 'hidden' value = '$item_name' name = 'item_name1'> 
				<input style = 'margin-top:10px;' id = 'form_input' value = '$item_name' name = 'item_name' autocomplete = 'off' disabled><p></p>
				<input id = 'form_input' type = 'text' value = '$item_type' name = 'item_type'	autocomplete = 'off' disabled><p></p>
				<input id = 'form_input' type = 'text' value = '$item_condition' name = 'item_condition'autocomplete = 'off' disabled><p></p>
				<input id = 'form_input' type = 'text' value = '$item_comments' name = 'item_comments' autocomplete = 'off' disabled><p></p>
				<input id = 'form_input' type = 'text' value = '$item_location' name = 'item_location' autocomplete = 'off' disabled><p></p>
				<input id = 'form_input' type = 'text' value = '$serial_number' name = 'serial_number' autocomplete = 'off' disabled><p></p>
				
				<select name = 'status'>
							<option value = 'Borrow'>Borrow</option>
							
				</select><p></p>
				<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = 'Done' name = 'status_done_member'>
			</form>
		</center>
	"; 
	}


	}
}

if(isset($_POST['item_search'])){
	//capturing the item reference and splitting it into different values
	$item_reference = $_POST['item_reference'];
	$item_references = explode(",", $item_reference);
	$array_size = count($item_references);
	$_SESSION['item_references'] = $item_references;


	//Checking how many items there are in the array (single item selection or multiple)
	if ($array_size > 1) {
			for ($i=0; $i < $array_size ; $i++) { 
					include "config.php";
					$request = mysqli_query($conn, "SELECT * from items where id = '$item_references[$i]'");
					$count = mysqli_num_rows($request);
					//Checking if the given codes exist in the system or not
					if($count < 1){
						
						$item_references = array_diff($item_references,['$item_references[$i]'] );
						

						echo "<center><p>Sorry, item with code: $item_references[$i] doesn't exist in the system. Please try again</p></center> ";
					}
					else{
						$result = mysqli_fetch_array($request);
						$ids = $result[0];
						$item_name = $result[1];
						$item_condition = $result[3];
						$item_location = $result[5];
						$serial_number = $result[6];
						//$item_references = $_SESSION['item_references'];
						$item_referencess = implode(",", $item_references);
						echo "	
							<center>
								<form method = 'post'>
									<input  type = 'hidden' value = '$item_referencess' name = 'ids'> 
									<input  type = 'hidden' value = '$item_name' name = 'item_name1'> 
									<input style = 'margin-top:10px;' id = 'form_input' value = '$item_name' name = 'item_name' autocomplete = 'off' disabled><p></p>
									<input id = 'form_input' type = 'text' value = '$item_condition' name = 'item_condition'autocomplete = 'off' disabled><p></p>
									<input id = 'form_input' type = 'text' value = '$item_location' name = 'item_location' autocomplete = 'off' disabled><p></p>
									<input id = 'form_input' type = 'text' value = '$serial_number' name = 'serial_number' autocomplete = 'off' disabled><p></p>
									
								
							</center>
						"; 
					}
				
			}//End of for loop
			//This part of the form (submit button ((return/ borrow has been put here so it doesn't repeat)))
			echo "
			
			<center><select name = 'status'>
						<option value = 'Borrow'>Borrow</option>
						<option value = 'Return'>Return</option>
			</select><p></p>
			<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = 'Done' name = 'status_done'>

				</center></form>";

	//Only one item exists in the list so the normal operation can be carried on
	}else{
		include "config.php";
	
	$request = mysqli_query($conn, "SELECT * from items where id = '$item_reference'");
	$count = mysqli_num_rows($request);
	if($count < 1){
		echo "<center><p>Sorry, the given reference code doesnt exist in the system :(</p></center> ";
	}
	else{
	$result = mysqli_fetch_array($request);
	$ids = $result[0];
	$item_name = $result[1];
	$item_type = $result[2];
	$item_condition = $result[3];
	$item_comments  = $result[4];
	$item_location = $result[5];
	$serial_number = $result[6];

	echo "	
		<center>
			<form method = 'post'>
				<input  type = 'hidden' value = '$ids' name = 'ids'> 
				<input  type = 'hidden' value = '$item_name' name = 'item_name1'> 
				<input style = 'margin-top:10px;' id = 'form_input' value = '$item_name' name = 'item_name' autocomplete = 'off' disabled><p></p>
				<input id = 'form_input' type = 'text' value = '$item_type' name = 'item_type'	autocomplete = 'off' disabled><p></p>
				<input id = 'form_input' type = 'text' value = '$item_condition' name = 'item_condition'autocomplete = 'off' disabled><p></p>
				<input id = 'form_input' type = 'text' value = '$item_comments' name = 'item_comments' autocomplete = 'off' disabled><p></p>
				<input id = 'form_input' type = 'text' value = '$item_location' name = 'item_location' autocomplete = 'off' disabled><p></p>
				<input id = 'form_input' type = 'text' value = '$serial_number' name = 'serial_number' autocomplete = 'off' disabled><p></p>
				
				<select name = 'status'>
							<option value = 'Borrow'>Borrow</option>
							<option value = 'Return'>Return</option>
				</select><p></p>
				<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = 'Done' name = 'status_done'>
			</form>
		</center>
	"; 
	}


	}


	
}

if(isset($_POST['status_done_member'])){
		$status = $_POST['status'];
		$ids	= $_POST['ids'];
		$item_name = $_POST['item_name1'];

		$item_references = explode(",", $ids);
		$count1 = count($item_references);



			if ($status == "Borrow") {
			for ($i=0; $i < $count1; $i++) { 
				include "config.php";
			
				$request = mysqli_query($conn, "SELECT * from inventory where item_id = '$item_references[$i]' ");
				$count4	 = mysqli_num_rows($request);
				$result  = mysqli_fetch_array($request);

			if ($count4 >=1) {
				$item_references = array_diff($item_references, ['$item_references[$i]']);
		
				echo "<center><p>Sorry, but the item with reference : $item_references[$i] item has been borrowed by $result[2] until $result[3]</p></center>";

			}}
			if ($count4 < 1) {
				$ids = implode(",", $item_references);
				$username     = $_SESSION['username'];
				
				echo "
				<center><form method = 'post'>
				<input style = 'margin-top:10px;' id = 'form_input' type = 'hidden' value = '$username@etc.co.uk' name = 'b_username' autocomplete='off'><p></p>
				<input  type = 'hidden' value = '$ids' name = 'ids'>
				<input  type = 'hidden' value = '$item_name' name = 'item_name'>  
				<input style = 'margin-top:10px;' id = 'form_input' type = 'text' name = 'date_deadline' placeholder = 'Deadline: YY/MM/DD' autocomplete = 'off' ><p></p>
				<input style = 'margin-top:10px;' id = 'form_input' type = 'text' name = 'penalty' placeholder = 'Penalty £ | NA if none' autocomplete = 'off' ><p></p>
				<input style = 'margin-top:10px;' id = 'form_input' type = 'text' name = 'b_reason' placeholder = 'Reason for borrowing' autocomplete = 'off' ><p></p>
				<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = 'Done' name = 'deadline_ready_borrow'>
			</form>
		</center>";
			}
			
				}
			else{

				for ($i=0; $i < $count1; $i++) { 
					include "config.php";
				$request = mysqli_query($conn, "DELETE FROM inventory WHERE item_id='$item_references[$i]'");
				echo "<center><p>Item with code : $item_references[$i] has been returned successfully</p></center>";
				}
				

	
			}
		}


if(isset($_POST['status_done'])){
		$status = $_POST['status'];
		$ids	= $_POST['ids'];
		$item_name = $_POST['item_name1'];

		$item_references = explode(",", $ids);
		$count1 = count($item_references);



			if ($status == "Borrow") {
			for ($i=0; $i < $count1; $i++) { 
				include "config.php";
			
				$request = mysqli_query($conn, "SELECT * from inventory where item_id = '$item_references[$i]' ");
				$count4	 = mysqli_num_rows($request);
				$result  = mysqli_fetch_array($request);

			if ($count4 >=1) {
				$item_references = array_diff($item_references, ['$item_references[$i]']);
		
				echo "<center><p>Sorry, but the item with reference : $item_references[$i] item has been borrowed by $result[2] until $result[3]</p></center>";

			}}
			if ($count4 < 1) {
				$ids = implode(",", $item_references);
				
				echo "
				<center><form method = 'post'>
				<input style = 'margin-top:10px;' id = 'form_input' type = 'text' placeholder = 'Borrowers username / email' name = 'b_username' autocomplete='off'><p></p>
				<input  type = 'hidden' value = '$ids' name = 'ids'>
				<input  type = 'hidden' value = '$item_name' name = 'item_name'>  
				<input style = 'margin-top:10px;' id = 'form_input' type = 'text' name = 'date_deadline' placeholder = 'Deadline: YY/MM/DD' autocomplete = 'off' ><p></p>
				<input style = 'margin-top:10px;' id = 'form_input' type = 'text' name = 'penalty' placeholder = 'Penalty £ | NA if none' autocomplete = 'off' ><p></p>
				<input style = 'margin-top:10px;' id = 'form_input' type = 'text' name = 'b_reason' placeholder = 'Reason for borrowing' autocomplete = 'off' ><p></p>
				<input style = 'margin-top:5px;' id = 'form_submit' type = 'submit' value = 'Done' name = 'deadline_ready_borrow_member'>
			</form>
		</center>";
			}
			
				}
			else{

				for ($i=0; $i < $count1; $i++) { 
					include "config.php";
				$request = mysqli_query($conn, "DELETE FROM inventory WHERE item_id='$item_references[$i]'");
				echo "<center><p>Item with code : $item_references[$i] has been returned successfully</p></center>";
				}
				

	
			}
		}

if (isset($_POST['deadline_ready_borrow'])) {
	$ids =  $_POST['ids'];
	$deadline = $_POST['date_deadline'];
	$penalty  = $_POST['penalty'];
	$b_username = $_POST['b_username'];
	$b_reason = $_POST['b_reason'];
	
	$_SESSION['b_username'] = $b_username;
	

	$item_references = explode(",", $ids);
	$count1 = count($item_references);

	include "config.php";
	$request = mysqli_query($conn, "SELECT * from users where username = '$b_username' ");
	$count	 = mysqli_num_rows($request);

	if ($count >= 1) {
			if ($deadline == "" or $penalty == "" or $b_username = "") {
		echo "<center><p>All Fields Required</p></center>";
	}else{
		
		$b_username = $_SESSION['b_username'];

	for ($i=0; $i < $count1 ; $i++) { 
		include "config.php";
		$request2 = mysqli_query($conn, "SELECT * from items where id = '$item_references[$i]'");
		$check = mysqli_num_rows($request2);
		$result = mysqli_fetch_array($request2);
		$item_name = $result[1];
		$item_location = $result[5];
		$serial_number = $result[6];
		if ($check >= 1) {
			mysqli_query($conn, "INSERT into `inventory`(`item_id`, `item_name`, `user_id`, `deadline`, `penalty`, `b_reason`,`item_location`,`serial_number`) values ('$item_references[$i]', '$item_name', '$b_username', '$deadline', '$penalty', '$b_reason', '$item_location', '$serial_number')");
		echo "<center><p>$b_username has successfully borrowed  the item with reference code : $item_references[$i] until $deadline where the penalty has been set to $penalty</p></center>";
			
			
		}
		else{
			$item_references = array_diff($item_references, ['$item_references[$i]']);
	
			echo "<center><p>One or more items entered have already been borrowed or do not exist</p></center>
			";}
		
	}
		
	}

	}else{
		echo "<center><p>$b_username isn't a valid username, please try again</p></center>";
	}


	
}

if (isset($_POST['all_items'])) {
	include "config.php";
	$request = mysqli_query($conn, "SELECT * from items order by id desc ");
	$count = mysqli_num_rows($request);
	echo "
		<table style='width:100%''>
		  <center><p>Inventory Log</p></center>
		  <tr>
		    <th>Item ID</th>
		    <th>Item name</th>
		    <th>Item type</th>
		    <th>Item Condition</th>
		    <th>Item Comments</th>
		    <th>Item Location</th>
		    <th>Serial Number</th>
		  </tr>	

	";
	
	for ($i=0; $i < $count; $i++) { 
		$result = mysqli_fetch_array($request);
			echo "
			<tr>
				<td>$result[0]</td>
				<td>$result[1]</td>
				<td>$result[2]</td>
				<td>$result[3]</td>
				<td>$result[4]</td>
				<td>$result[5]</td>
				<td>$result[6]</td>
			</tr>
	";
	}
}



if (isset($_POST['deadline_ready_borrow_member'])) {
	$ids =  $_POST['ids'];
	$deadline = $_POST['date_deadline'];
	$penalty  = $_POST['penalty'];
	$b_username = $_POST['b_username'];
	$b_reason = $_POST['b_reason'];
	
	$_SESSION['b_username'] = $b_username;
	

	$item_references = explode(",", $ids);
	$count1 = count($item_references);

	include "config.php";
	$request = mysqli_query($conn, "SELECT * from users where username = '$b_username' ");
	$count	 = mysqli_num_rows($request);

	if ($count >= 1) {
			if ($deadline == "" or $penalty == "" or $b_username = "") {
		echo "<center><p>All Fields Required</p></center>";
	}else{
		
		$b_username = $_SESSION['b_username'];

	for ($i=0; $i < $count1 ; $i++) { 
		include "config.php";
		$request2 = mysqli_query($conn, "SELECT * from items where id = '$item_references[$i]'");
		$check = mysqli_num_rows($request2);
		$result = mysqli_fetch_array($request2);
		$item_name = $result[1];
		$item_location = $result[5];
		$serial_number = $result[6];
		if ($check >= 1) {
			mysqli_query($conn, "INSERT into `inventory`(`item_id`, `item_name`, `user_id`, `deadline`, `penalty`, `b_reason`,`item_location`,`serial_number`) values ('$item_references[$i]', '$item_name', '$b_username', '$deadline', '$penalty', '$b_reason', '$item_location', '$serial_number')");
		echo "<center><p>$b_username has successfully borrowed  the item with reference code : $item_references[$i] until $deadline where the penalty has been set to $penalty</p></center>";
			
			
		}
		else{
			$item_references = array_diff($item_references, ['$item_references[$i]']);
	
			echo "<center><p>One or more items entered have already been borrowed or do not exist</p></center>
			";}
		
	}
		
	}

	}else{
		echo "<center><p>$b_username isn't a valid username, please try again</p></center>";
	}


	

	
}

//sorting all items
if (isset($_POST['sort_all_items'])) {
	
	echo "
		<center>
			<form method='post'>
				<input id='submit_button' type='submit' value = 'Sort by item type' name='sort_by_item'>
				<input id='submit_button' type='submit' value = 'Sort by location' name='sort_by_location'>
			</form>
		</center>
	";
}

if (isset($_POST['sort_by_item'])) {
	$item_type = $_POST['sort_by_item'];

	include "config.php";
	$request  = mysqli_query($conn, "SELECT DISTINCT item_type from items order by id desc");
	$count    = mysqli_num_rows($request);

	
	for ($i=0; $i < $count; $i++) { 

		$result   = mysqli_fetch_array($request);
		
		echo "
		<center>
				<form method = 'post'>
					<input id='submit_button' style='margin-top:5px;' type='submit' name='item_type_sort' value='$result[0]'>
				</form>
		</center>
		";
			  
	}
}

if(isset($_POST['sort_by_location'])){

	include "config.php";
	$request  = mysqli_query($conn, "SELECT DISTINCT item_location from items order by id desc");
	$count    = mysqli_num_rows($request);

	
	for ($i=0; $i < $count; $i++) { 

		$result   = mysqli_fetch_array($request);
		
		echo "
		<center>
				<form method = 'post'>
					<input id='submit_button' style='margin-top:5px;' type='submit' name='item_location_sort' value='$result[0]'>
				</form>
		</center>
		";
			  
	}
}



if (isset($_POST['item_location_sort'])) {
	
	$selected_item = $_POST['item_location_sort'];
	include "config.php";
	$request  = mysqli_query($conn, "SELECT * from items where item_location = '$selected_item' ");
	$count    = mysqli_num_rows($request);	

	//table headings
	echo "
		<table style='width:100%''>
		  <caption style='font-family:calibri;'>Displaying $count items from $selected_item</caption>
		  <tr>
		    <th>Item Name</th>
		    <th>Item Reference Code</th>
		    <th>Item Location</th>
		    <th>Item Condition</th>
		    <th>Item Comments</th>
		    <th>Serial Number</th>
		  </tr>	

			";

	for ($i=0; $i < $count ; $i++) { 
		$result = mysqli_fetch_array($request);
			
			echo "
				
				<tr>
				<td>$result[1]</td>
				<td>$result[0]</td>
				<td>$result[5]</td>
				<td>$result[3]</td>
				<td>$result[4]</td>
				<td>$result[6]</td>
				</tr>
		
			";		
	}	
}


if (isset($_POST['item_type_sort'])) {
	
	$item_type = $_POST['item_type_sort'];
	include "config.php";
	$request  = mysqli_query($conn, "SELECT * from items where item_type = '$item_type' ");
	$count    = mysqli_num_rows($request);	

	//table headings
	echo "
		<table style='width:100%''>
		  <caption style='font-family:calibri;'>Displaying $count item/ items type $item_type</caption>
		  <tr>
		    <th>Item Name</th>
		    <th>Item Reference Code</th>
		    <th>Item Location</th>
		    <th>Item Condition</th>
		    <th>Item Comments</th>
		    <th>Serial Number</th>
		  </tr>	

			";

	for ($i=0; $i < $count ; $i++) { 
		$result = mysqli_fetch_array($request);
			
			echo "
				
				<tr>
				<td>$result[1]</td>
				<td>$result[0]</td>
				<td>$result[5]</td>
				<td>$result[3]</td>
				<td>$result[4]</td>
				<td>$result[6]</td>
				</tr>
		
			";		
	}	
}

?>

