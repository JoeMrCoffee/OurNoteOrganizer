<?php 
    include 'header.php'; 
    include 'titlebar.php';

    if ($validity == "valid") {
        $username = $loginuser;
        $userpwd = $loginpassword;

        $usercol = $db -> users;
        $record = $usercol->find( [ 'username' =>$username, 'password'=>$userpwd] );  
        foreach ($record as $user) {  
            $userid = $user['_id'];
            $usergroups = $user['groups'];
            if(isset($user['adminstatus'])) { $adminstatus = $user['adminstatus']; }
            else { $adminstatus = 'no'; }
        }
        
        echo "<h4>Edit user information</h4>
            <table width='100%' class='postlink' align='center'>
            <form method='post' id='update' action='updateuserinfo.php'>
            <tr><td width='200px'>Username: </td><td width='200px'><input type='text' name='username' value='$username'></td><td></td></tr>
            <tr><td width='200px'>Password: </td><td width='200px'><input type='password' name='userpassword' value='$userpwd'></td><td></td></tr>
            <tr><td width='200px'>Member groups: </td><td width='200px'><input type='text' name='usergroups' value='$usergroups'></td><td></td></tr>
            <td></td></tr>
            <input type='hidden' name='userid' value='$userid'>
            <input type='hidden' name='adminstatus' value='$adminstatus'>
            <tr><td><input type='submit' name='updateuser' value='UPDATE' form='update'></td></table></form>";
                    
                    
    }
    else { echo "<br><br><br><br>Error retrieving data for you. Please try to log in again.</td></tr></table>"; }
    
?>
</table>
</td></tr></table>
</body>


</html>
