<?php 
    include 'header.php'; 
    include 'titlebar.php';

?>


<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({ selector:'textarea#notepost', height: 500, plugins: 'lists',
    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncentre alignright alignjustify | indent outdent | bullist'
     });</script>

<!-- Reference for the TinyCE https://www.tiny.cloud/ -->


<?php
    if ($validity == "valid"){
        $col = $db -> posts;
        //Are we editing?
        if (isset($_POST['Edit'])) {
        
            $name = $_POST['name'];
            $postname = $_POST['postname'];
            $content = $_POST['notecontent'];
            $postid = $_POST['postid'];
            $postcolor = $_POST['postcolor'];
            $postimage = ""; //define first but only assign if the image is set during DB find.
            
            if ($postcolor == ""){
                $postcolor = "#ffffff";
            }

            $record = $col->find( [ '_id' => new MongoDB\BSON\ObjectId($postid) ] );  
            foreach ($record as $post) {
                if(isset($post['postimage'])){ $postimage = $post['postimage']; }
                if(isset($post['groups'])){ $postgroups = $post['groups']; }
                else { $postgroups = ""; } 
            }
            
            //get the available groups
            //07252022 - update to only search the groups the user is a member of
            //10122022 - cleaned up the code, working off unique IDs instead of values
            $groupsSTR = "";
            $usercol = $db -> users;
            $groupsrch = $usercol -> find([ 'username' =>$loginuser ]);
           
            foreach ($groupsrch as $usrgrp) {
                $usergroups = $usrgrp['groups'];
	            $usergroups = str_replace(" ", "", $usergroups);
            }
            $usrgrparray = explode(",", $usergroups);

            echo "<h3>Edit post</h3>
                <div class='postlink post'>
                <table width='100%'><tr><td colspan='14'>
                <form method='post' action='updatepost.php' id='updatepost' enctype='multipart/form-data'>
                <h4>Name: $name<input type='hidden' name='name' value='$name'><br><br>
                Note title: $postname<input type='hidden' name='postname' value='$postname'></h4>
                <h4>Associated Group: <select name='postgroups'><option value='$postgroups' selected>$postgroups</option>";
            foreach($usrgrparray as $groupoption) { //Originally $groupsarray, not $usergroups
                echo "<option value='$groupoption'>$groupoption</option>";
            }            
            echo "</select></h4><h4>
                <input type='hidden' name='postid' value='$postid'>
                Note highlight color: <input type='color' name='postcolor' value='$postcolor'></h4>";
            
            if($postimage != "none" && $postimage != null){ echo "Current image: <img src='$postimage' style='max-height: 100px;'><br><br>"; }
                
            echo "
                Insert a new image with post? <input type='file' name='postimage'><br><br>
                <input type='hidden' name='postimageexists' value='$postimage'>
                Note post: <br><textarea class='giantinput' id='notepost' type='text' name='notecontent'>$content</textarea></td></tr>
                <tr><td style='max-width: 80px;'><input type='submit' name='Edit' value='SUBMIT' form='updatepost'></form></td>
                
                <td style='max-width: 80px;'>
                <form method='post' action='updatepost.php' id='deletepost' enctype='multipart/form-data'>
                <input type='hidden' name='postid' value='$postid'>
                <input type='hidden' name='postname' value='$postname'>
                <input type='hidden' name='postcolor' value='$postcolor'>
                <input type='hidden' name='postgroups' value='$postgroups'>
                <input type='hidden' name='notecontent'>
                <input type='hidden' name='postimage' value='none'>
                <input type='hidden' name='name' value='$name'>
                <input type='submit' name='Delete' value='DELETE' form='deletepost' onclick='return confirmfunction()'></form></td>
                <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>
                </div>";

        }
        //It's a brand new post
        else {
            //get the available groups
            //07252022 - update to only search the groups the user is a member of
            $groupsSTR = "";
            $usercol = $db -> users;
            $groupsrch = $usercol -> find([ 'username' =>$loginuser ]);
           
            foreach ($groupsrch as $usrgrp) {
                $usergroups = $usrgrp['groups'];
	            $usergroups = str_replace(" ", "", $usergroups);

            }
            $usrgrparray = explode(",", $usergroups);
        
            echo "<h3>New post</h3>
                <div class='postlink post'>
                <form method='post' action='insertnewpost.php' enctype='multipart/form-data'>
                <h4>Name: $loginuser<input type='hidden' name='name' value='$loginuser'><br><br>
                Note title: <input type='text' name='postname'><br><br></h4>
                Associated Group: <select name='postgroups' ><option value='$loginuser' selected>$loginuser</option>";
            foreach($usrgrparray as $groupoption) {
                echo "<option value='$groupoption'>$groupoption</option>";
            }
           
            echo "</select><p>
                Note highlight color: <input type='color' name='postcolor' value='#ffffff'><br><br>
                Insert image with post? <input type='file' name='postimage'><br><br>
                Note post: </p><textarea class='giantinput' id='notepost' type='text' name='notecontent'></textarea><br><br>
                <input type='submit' name='Enter' value='SUBMIT'></form>
                </div>";
        
        }
    }
    else { echo "Sorry, username and password are unknown. Please try to log in again."; }
        
        
        
?>    
</td></tr></table>
</body>

<script>
	function confirmfunction() { return confirm('Do you really want to delete this post?'); 	}
</script>

</html>
