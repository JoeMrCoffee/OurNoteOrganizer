<?php 
    include 'header.php'; 
    include 'titlebar.php';

    if ($validity == "valid") {
        
        echo "<h4>Edit user information</h4>
            <table width='100%' class='postlink' align='center'>
            <form method='post' id='update' action='updateuserinfo.php'>
            <tr><td width='200px'>Username: </td><td width='200px'><input type='text' name='username' value='$loginuser'></td><td></td></tr>
            <tr><td width='200px'>Password: </td><td width='200px'><input type='password' name='userpassword' value='$loginpassword'></td><td></td></tr>
            <tr><td width='200px'>Member groups: </td><td width='200px'><input type='text' name='usergroups' value='$loginusergroups'></td><td></td></tr>
            <td></td></tr>
            <input type='hidden' name='userid' value='$loginuserid'>
            <input type='hidden' name='adminstatus' value='$adminstatus'>
            <tr><td><input type='submit' name='updateuser' value='UPDATE' form='update'></td></table></form>";
                    
                    
    }
    else { echo "<br><br><br><br>Error retrieving data for you. Please try to log in again.</td></tr></table>"; }
    
?>
</table>
</td></tr></table>
</body>


</html>
