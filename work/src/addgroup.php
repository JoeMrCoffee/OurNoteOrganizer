<?php
	include 'header.php';
	include 'titlebar.php';

	if ($validity == "valid") {
		//var_dump($_POST); //debug
		
		$groupname = $_POST['groupname'];
		$usernames = $_POST['users'];
		$col = $db -> users;
		
		echo "<h4>Group created</h4><div class='postlink'>";
		
		foreach($usernames as $username){
			//echo "$username<br>";
			//get the existing groups
			$result = $col -> find(['username' => $username]);
			foreach ($result as $existinggroupsqry) { 
				$existinggroups = $existinggroupsqry['groups'];
				//add the new group name value to the user list
				$groupvalue = $existinggroups.", ".$groupname;
			}
			//create the update value
			$updategroupqry = ['$set' => ['groups' => $groupvalue]];
			//push the update to the MongoDB object
			if ($updateUser = $col->updateOne(['username' => $username], $updategroupqry)){
                echo "<p>$username added to group $groupname.</p>";
            }
            else { echo "<p>Sorry there was an error</p>"; }
		}
		echo "</div>";
	}
	else { echo "Sorry, username and password are unknown. Please try to log in again."; }

?>

</td></tr></table></body></html>
