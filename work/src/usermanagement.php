<?php 
    include 'header.php'; 
    include 'titlebar.php';


    if ($validity == "valid" && $adminstatus == "yes") {
        $col = $db->users;
        $userlist = $col -> find();
        
        echo "<h4>Manage users</h4>
            
            <table width='100%' class='postlink' align='center'>
            <tr><th>Username</th><th>Member groups</th><th width='120px'>Admin?</th><th width='120px'>Edit</th><th></th></tr>";
        
        foreach ($userlist as $userinfo) {
            //$usergroups = json_encode($userinfo['groups']);
            $usergroups = $userinfo['groups'];
            echo "<form method='post' action='useredit.php'><tr>
                <td width='150px'>".$userinfo['username']."<input type='hidden' name='username' value='".$userinfo['username']."'></td>
                <td width='300px'>$usergroups<input type='hidden' name='usergroups' value='$usergroups'></td>
                <input type='hidden' name='password' value='".$userinfo['password']."'>
                <td>";
            if (isset($userinfo['adminstatus']) && $userinfo['adminstatus'] == "yes") { echo "<img src='checkmark.png'>"; }
                
            echo "</td><td><input type='submit' name='edituser' value='EDIT'></td><td></td>
                </tr></form>";

        }
        
        echo "<tr><td colspan=3><form method='post' action='useredit.php'>
            <input type='submit' name='adduser' value='ADD USER'></form></td></tr></table>";
    }
    else { echo "Sorry, username and password are unknown. Please try to log in again."; }


?>
</table>
</td></tr></table>
</body>



</html>
