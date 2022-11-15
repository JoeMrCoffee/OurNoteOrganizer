<?php 
    include 'header.php'; 
    include 'titlebar.php';

    
    if ($validity == "valid" && $adminstatus == "yes") {
        if (isset($_POST['edituser'])){
            $username = $_POST['username'];
            $userpwd = $_POST['password'];
            $usergroups = $_POST['usergroups'];
            
            $col = $db -> users;
            $record = $col->find( [ 'username' =>$username, 'password'=>$userpwd] );  
            foreach ($record as $user) {  
                $userid = $user['_id'];
                if(isset($user['adminstatus'])) { $adminstatus = $user['adminstatus']; }
                else { $adminstatus = 'no'; }
                //echo "$userid";
            }
                
            echo "<h4>Edit user information</h4>
                <table width='100%' class='postlink' align='center'>
                <form method='post' id='update' action='updateuserinfo.php'>
                <tr><td width='200px'>Username: </td><td width='200px'><input type='text' name='username' value='$username'></td><td></td></tr>
                <tr><td width='200px'>Password: </td><td width='200px'><input type='password' name='userpassword' value='$userpwd'></td><td></td></tr>
                <tr><td width='200px'>Member groups: </td><td width='200px'><input type='text' name='usergroups' value='$usergroups'></td><td></td></tr>
                <tr><td width='200px'>Admin status: </td><td width='200px'>";
            if ($adminstatus == 'yes') { echo "<input type='checkbox' name='adminstatus' value='yes' checked>"; }
            else { echo "<input type='checkbox' name='adminstatus' value='yes'>"; }
            echo "</td><td></td></tr>
                <input type='hidden' name='userid' value='$userid'>
                <tr><td><input type='submit' name='updateuser' value='UPDATE' form='update'></td></form>
                <form method='post' id='deleteuser' action='updateuserinfo.php'><input type='hidden' name='userid' value='$userid'>
                <td><input type='submit' form='deleteuser' name='userdel' value='DELETE' onclick='return confirmfunction()'></td><td></td></tr></form>
                </table>";
        }
        if (isset($_POST['adduser'])){
        
            echo "<h4>Add new user</h4>
                <table width='100%' class='postlink' align='center'>
                <form method='post' action='updateuserinfo.php'>
                <tr><td width='200px'>Username: </td><td width='200px'><input type='text' name='username'></td><td></td></tr>
                <tr><td width='200px'>Password: </td><td width='200px'><input type='password' name='userpassword'></td><td></td></tr>
                <tr><td width='200px'>Member groups: </td><td width='200px'><input type='text' name='usergroups'></td><td></td></tr>
                <tr><td width='200px'>Admin status: </td><td width='200px'><input type='checkbox' name='adminstatus' value='yes'></td></tr>
                <tr><td colspan='2'><input type='submit' name='adduser' value='ADD USER'></td><td></td></tr>
                </form></table>";
 
        }


    
    }
    
    
    else { echo "Sorry, username and password are unknown. Please try to log in again."; }


?>
</table>
</td></tr></table>
</body>

<script>
	function confirmfunction() { return confirm('Do you really want to delete this user?'); 	}
</script>

</html>
