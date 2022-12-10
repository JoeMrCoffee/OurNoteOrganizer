<?php 
    include 'header.php'; 
    include 'titlebar.php';

    if ($validity == "valid") {
        $col = $db->users;
        $userlist = $col -> find();
        
        echo "<h4>Manage users</h4>
            <table width='100%' class='postlink' align='center'>
            <tr><th>Username</th><th width='60%'>Member groups</th><th width='120px'>Admin?</th>";
            
        if($adminstatus == "yes"){ echo "<th width='120px'>Edit</th><th></th></tr>"; }
		else { "<th width='120px'></th><th></th></tr>"; }

        foreach ($userlist as $userinfo) {
            //$usergroups = json_encode($userinfo['groups']);
            $usergroups = $userinfo['groups'];
            echo "<form method='post' action='useredit.php'><tr>
                <td width='150px'>".$userinfo['username']."<input type='hidden' name='username' value='".$userinfo['username']."'></td>
                <td>$usergroups<input type='hidden' name='usergroups' value='$usergroups'></td>
                <input type='hidden' name='password' value='".$userinfo['password']."'>
                <td>";
            if (isset($userinfo['adminstatus']) && $userinfo['adminstatus'] == "yes") { echo "<img src='checkmark.png'>"; }
            
            //Change 11152022 - update logic so users can create new groups, but only admin edit user info
            if($adminstatus == "yes") { echo "</td><td><input type='submit' name='edituser' value='EDIT'></td><td></td></tr></form>"; }
            else { echo "</td><td></td><td></td></tr></form>"; }

        }
        echo "</table><br><div><button onclick='addgroupform()' class='buttontgthr'>ADD GROUP</button>";
        if ($adminstatus == "yes"){
		    echo "<form method='post' action='useredit.php' class='buttontgthr'>
		        <input type='submit' name='adduser' value='ADD USER'></form>";
        }
        echo "</div>";
        
        //Group management pop-up
        echo "<div class='groupmgmt' style='visibility: hidden;' id='groupEdit'><img class='closepopup' onclick='addgroupform()' src='close.png'>
		<form method='post' action='addgroup.php'>
        	<p><strong>Group name: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='groupname'></p>
        	<p><strong>Select users:</strong></p>";
		$col2 = $db->users;
		$userlist2 = $col2 -> find();
		foreach ($userlist2 as $userinfo2) {
			echo "<p><input type='checkbox' name='users[]' value=".$userinfo2['username'].">&nbsp;&nbsp;&nbsp;&nbsp;".$userinfo2['username']."</p>
				<input type='hidden' name='userid[]' value='".$userid = $userinfo2['_id']."'>";
		}
		echo "<input type='submit' value='ADD GROUP'></form></div>";
        		
    }
    else { echo "Sorry, username and password are unknown. Please try to log in again."; }


?>

</td></tr></table>
</body>
<script>
	function addgroupform() {
		var groupform = document.getElementById('groupEdit');
	
		if (groupform.style.visibility == 'hidden') {
    			groupform.style.visibility = 'visible';
 		} 
 		else { groupform.style.visibility = 'hidden'; }
		
	}
</script>
</html>
