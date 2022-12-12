<?php 
    include 'header.php';
    include 'titlebar.php';
    
	if ($validity == "valid") {
	    $col = $db -> posts;
	    $usercol = $db -> users;
	    
	    $userresult = $usercol -> find(['username' => $loginuser]);
	    $usergroups = "";
	    foreach ($userresult as $userinfo){
	        $usergroups = $userinfo['groups'];
	        $usergroups = str_replace(" ", "", $usergroups);
	        $groupsarray = explode(",", $usergroups);
	    }
        
        
	    if(isset($_POST['notesearch'])){ 
	        $notesearch = $_POST['notesearch'];
	        //handling case insensitive searches
	        $notesearchlow = strtolower($notesearch); //lowercase all the values
	        $notesearchup = ucwords($notesearch); //make the first letter an upper case
	        
	        //Search against the same user name or group name
	        $record = $col->find(['$or'=>[
	            ['name'=> $loginuser, 'postname'=> ['$regex'=>$notesearch]],
	            ['name'=> $loginuser, 'postname'=> ['$regex'=>$notesearchlow]],
	            ['name'=> $loginuser, 'postname'=> ['$regex'=>$notesearchup]],
	            ['groups' => ['$in' => $groupsarray], 'postname'=> ['$regex'=>$notesearch]],
	            ['groups' => ['$in' => $groupsarray], 'postname'=> ['$regex'=>$notesearchlow]],
	            ['groups' => ['$in' => $groupsarray], 'postname'=> ['$regex'=>$notesearchup]],
	            ['groups' => ['$in' => $groupsarray], 'groups'=> ['$regex'=>$notesearch]],
		    ['groups' => ['$in' => $groupsarray], 'groups'=> ['$regex'=>$notesearchup]],
	            ['groups' => ['$in' => $groupsarray], 'groups'=> ['$regex'=>$notesearchlow]]
                ]]);    
	    }
	     
	    else { $record = $col->find(['$or'=>[
	        ['name' => $loginuser],
	        ['groups' => ['$in' => $groupsarray]]
	        ]], ['sort' => ['date'=> -1]]); }

	    $item=0;

        //Search bar
        echo "<tr><td class='search' colspan='4'>
        <form method='post' action='".$_SERVER['PHP_SELF']."'>    
        <input name='notesearch' type='text' class='search' placeholder='Search by group or post name'>  
        <input class='search' type='submit' value='SEARCH' ></form>
        </td></tr>
        <tr>";
        foreach ($record as $note) {
            $name=$note['name'];
            $postname=$note['postname'];
            $postcolor=$note['postcolor'];
            $postdate = $note['date'];
            $postid = $note['_id'];
            $postimage = "";
            if(isset($note['postimage'])){ $postimage = $note['postimage']; }
            
            //still working on getting the formatting right for this
            $content = $note['blog'];
            if (strlen($content) >= 200 && $postimage == ""){
                $content = substr($content,0,200)." ...<br>";
                $content = str_replace("< ", "", $content); //replace a bad cut if a <p> or <li> gets cut
                $content .= "</li></ul>";  //this helps messing up other formatting if a list is used and cut  
            }
            elseif (strlen($content) >= 100 && $postimage != ""){
                $content = substr($content,0,100)." ...<br>";
                $content = str_replace("< ", "", $content); //replace a bad cut if a <p> or <li> gets cut
                $content .= "</li></ul>";  //this helps messing up other formatting if a list is used and cut  
            }

            if ($item < 4){
                echo "<td>
                    <form method='post' action='viewpost.php'>       
                    <div class='postlink overview' style='background-color: $postcolor;'><strong>Author: $name <br>Note: $postname</strong>
                    <br><strong>$postdate</strong>";
                if($postimage != "none" && $postimage != null){ echo "<br><div style='text-align: center;'><img src='$postimage' style='max-height: 80px;'></div>"; }
                echo "$content<br>
                    <input type='hidden' name='name' value='$name'>
                    <input type='hidden' name='postname' value='$postname'>
                    <input type='hidden' name='postcolor' value='$postcolor'>
                    <input type='hidden' name='postid' value='$postid'>
                    <input type='submit' value='VIEW' class='view'></div></form></td>";
            
                $item++;
            
            }
            
            elseif($item >= 4){
                $item=1;
                echo "</tr><tr>";
                echo "<td><form method='post' action='viewpost.php'>       
                    <div class='postlink overview' style='background-color: $postcolor;'><strong>Author: $name <br>Note: $postname</strong>
                    <br><strong>$postdate</strong>";
                if($postimage != "none" && $postimage != null){ echo "<br><div style='text-align: center;'><img src='$postimage' style='max-height: 80px;'></div>"; }
                echo "<br>$content<br>
                    <input type='hidden' name='name' value='$name'>
                    <input type='hidden' name='postname' value='$postname'>
                    <input type='hidden' name='postcolor' value='$postcolor'>
                    <input type='hidden' name='postid' value='$postid'>
                    <input type='submit' value='VIEW' class='view'></div></form></td>";
            
            }
        }
        echo "</tr>";
    }
    else { echo "<br><br>Sorry, username and password are unknown. Please try to log in again."; }

?>
</table>
</td></tr></table>
</body>



</html>
