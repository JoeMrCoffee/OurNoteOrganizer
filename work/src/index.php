<?php 
    include 'header.php'; 
    session_destroy();
    //create a default user: admin if doesn't exist
    $usercheck = "";
    $usercol = $db -> users;
    $userresult = $usercol -> find(['username' => 'admin']);
    foreach( $userresult as $uname){
        $usercheck = $uname['username'];
    }
    if ($usercheck != "") {
        //print_r($userresult);
        //echo "user exists $usercheck";
    }
    else {
        //echo "user check fails";
        $adduserquery = ['username' => 'admin', "password" => 'admin', 'groups' => 'admin', 'adminstatus' => 'yes'];
        if ($updateUser = $usercol->insertOne($adduserquery)){ }
        else { 
            echo "<p style = 'color: white;'>Error connecting to the MongoDB server, 
                please ensure the connection is correct in the header.php file or contact your system administrator."; 
        }
    }
?>
<body style='background-color: #27252E;'>

<div class='center'>
<h4><img src='ournoteorganizericon.png' height='80px'><br><br>Welcome to OurNoteOrganizer!
<form action='noteshome.php' method='post'>
<table align='center'>
<tr><td>Username: </td><td><input type='text' name='username' style='min-height: 22px;'></td></tr><br>
<tr><td>Password: </td><td><input type='password' name='password' style='min-height: 22px;'></td></tr><br>
<tr ><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='submit' value='LOG IN'></td></tr></table>
</form></h4>


</div>

</body>

<script>

window.onload = function() {
    if (!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
</script>

</html>
