<?php
    include 'header.php';
    include 'titlebar.php';


    if ($validity == "valid") {
        
        $col = $db -> users;
        
        if (isset($_POST['updateuser'])){
            $username = $_POST['username'];
            $userpwd = $_POST['userpassword'];
            $usergroups = $_POST['usergroups'];
            $userid = $_POST['userid'];
            if (isset($_POST['adminstatus'])) { $adminstatus = $_POST['adminstatus']; }
            else { $adminstatus = 'no'; }
            
            if (str_contains($usergroups, $username)){ }
            else { $usergroups = "".$usergroups.", ".$username.""; }
        
            $usereditquery = ['$set'=>['username' => $username, "password" => $userpwd, 'groups' => $usergroups, 'adminstatus' => $adminstatus]];
            if ($updateUser = $col->updateOne(['_id' => new MongoDB\BSON\ObjectId("$userid")], $usereditquery)){
                if ($username == $loginuser && $userpwd != $loginpassword) {
                    $_SESSION['password'] = $userpwd;         
                }
                echo "<h3>User info updated successfully. </h3>";
            }      
        }
        else if (isset($_POST['adduser'])){
            $username = $_POST['username'];
            $userpwd = $_POST['userpassword'];
            $usergroups = $_POST['usergroups'];
            if (isset($_POST['adminstatus'])) { $adminstatus = $_POST['adminstatus']; }
            else { $adminstatus = 'no'; }
            
            if ($usergroups == "") { $usergroups = "".$username.""; }
            
            if (str_contains($usergroups, $username)){ }
            else { $usergroups = "".$usergroups.", ".$username.""; }

            $adduserquery = ['username' => $username, "password" => $userpwd, 'groups' => $usergroups, 'adminstatus' => $adminstatus];
            if ($updateUser = $col->insertOne($adduserquery)){
                echo "<h3>User created successfully.</h3>";
            }
        }
        else if (isset($_POST['userdel'])){
            $userid = $_POST['userid'];
            if ($col->deleteOne(['_id' => new MongoDB\BSON\ObjectId("$userid")])){
                echo "<h3>User deleted successfully. </h3>";
            }
        }

    }

    else { echo "Sorry, username and password are unknown. Please try to log in again."; }
    
?>

</td></tr></table></body></html>
