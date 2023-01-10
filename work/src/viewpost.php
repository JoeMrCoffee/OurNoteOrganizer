<?php
    include 'header.php';
    include 'titlebar.php';

     if($validity == "valid") {
        $col = $db -> posts;   
        //Get post info
	    $postid = $_POST['postid'];
	    $content = "";
	    
	    //Search for other parameters like post content and associated image
	    $record = $col->find( [ '_id' => new MongoDB\BSON\ObjectId($postid) ] );
        foreach ($record as $post) {
        		$name = $post['name'];
	    		$postname = $post['postname'];
        		$postcolor = $post['postcolor'];
            $content = $post['blog'];
            echo "<h3>".$post['postname']."</h3>";
            if (isset($post['date'])) { echo "<h4>Most recent update: ".$post['date']; }
            if (isset($post['groups'])) { 
            		$postgroup = $post['groups'];
            		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Associated groups: $postgroup";
    			}

            //post content
            echo "</h4><div class='postlink'>";
            if ( isset($post['postimage']) && $post['postimage'] != null && $post['postimage'] != "none") { 
                $postimage = $post['postimage'];
                echo "<p style='text-align: center;'><img src='$postimage' style='max-width: 650px;'></p>"; 
            }
            else { $postimage = "none"; }

	        echo "$content </div>";
	    }
        //Content buttons - Edit if loginuser is the author of the post
        echo "<br><br><div>";
        if ($name == $loginuser) {
            echo "<form method='post' action='newpost.php' id='PostEdit' class='buttontgthr'>
                <input type='hidden' name='name' value='$name'>
                <input type='hidden' name='postname' value='$postname'>
                <input type='hidden' name='notecontent' value='$content'>
                <input type='hidden' name='postcolor' value='$postcolor'>
                <input type='hidden' name='postimage' value='$postimage'>
                <input type='hidden' name='postid' value='$postid'>
                <input type='submit' name='Edit' value='EDIT POST' form='PostEdit'></form>";
        }
        //Create a task button - anyone who can view
        echo "<button onclick='createTaskForm()' class='buttontgthr'>CREATE TASK</button> </div>";
        
        //Create task form
        echo "<div class='groupmgmt' style='visibility: hidden;' id='createTask'>
        		<img class='closepopup' onclick='createTaskForm()' src='close.png'>
        		<form method='post' action='createtask.php'>
        		<p><strong>Select task owner:&nbsp;&nbsp;&nbsp;&nbsp;</strong><select name='taskowner'>";
		$col2 = $db->users;
		$userlist2 = $col2 -> find(['groups' => ['$regex' => $postgroup]]);
		foreach ($userlist2 as $userinfo2) {
			$ownername = $userinfo2['username'];
			echo "<option value='$ownername'>$ownername</option>";
		}
		echo "</select></p><p><strong>Due date:&nbsp;&nbsp;&nbsp;&nbsp;</strong><input name='duedate' type='date'></p>
			<textarea class='giantinput' name='commentcontent' placeholder='What needs to be done?'></textarea>
			<input type='hidden' value='$postid' name='postid'>
			<input type='hidden' value='$postname' name='postname'>
			<p><input type='submit' value='CREATE TASK'></p></form></div>";
        //Create task form ends
             
        //Show comments associate with this post
        echo "<h4>Comments: </h4>";
    	
		$commentcol = $db -> comments;
		$taskcol = $db -> tasks;
		try { $commentrec = $commentcol->find([ 'postid' => $postid ]); }
		finally { $commentrec = $commentcol->find([ 'postname' => $postname ]); }
		foreach ( $commentrec as $commentinfo) {
			$comcontent = $commentinfo['comment'];			
			$comauthor = $commentinfo['author'];
        		if ( str_contains($comcontent, "Task assigned to")){
        			$taskvalue = explode("</h4>", $comcontent)[1];
        			$taskrec = $taskcol -> find(['postid' => $postid, 'taskcomment' => $taskvalue]);
        			foreach ($taskrec as $taskitem) {
        				$statusvalue = $taskitem['taskstatus'];
		    			if($statusvalue == "Closed") {
		    				echo "<p><div class='postlink post'><img class='closepopup' src='checkmark.png'><p>$comcontent -- CLOSED</p>
		    				- Author: $comauthor</div></p>";
		    			}
		    			else {echo "<p><div class='postlink post'><p>$comcontent</p>- Author: $comauthor</div></p>"; }
	    			}
        		}			
    			else {echo "<p><div class='postlink post'><p>$comcontent</p>- Author: $comauthor</div></p>"; }
        }
        
        
        echo "<button onclick='addcomment()'>ADD COMMENT</button><br><br>
		    <div id='AddComment' style='visibility: hidden;'>
		    	<form method='post' action='submitcomment.php' id='insertComment'>
		    	<textarea class='giantinput' name='commentcontent' placeholder='Add a comment'></textarea>
		    	<input type='hidden' name='author' value='$loginuser'>
		    	<input type='hidden' name='postname' value='$postname'>
            <input type='hidden' name='postid' value='$postid'>
		    	<br><br><input type='submit' form='insertComment' value='Submit'></form>
			</div>";
    }
    else { echo "Sorry, username and password are unknown. Please try to log in again."; }

?>
	</td></tr></table>
	</body>
	<script>
	function addcomment() {
		var commentform = document.getElementById('AddComment');
		if (commentform.style.visibility === 'hidden') {
    		commentform.style.visibility = 'visible';
 		} 
 		else { commentform.style.visibility = 'hidden'; }
	}
	
	function createTaskForm() {
		var groupform = document.getElementById('createTask');
		if (groupform.style.visibility == 'hidden') {
    			groupform.style.visibility = 'visible';
    			scroll(0,0); //moves to top of page in case of tall images
 		} 
 		else { groupform.style.visibility = 'hidden'; }
	}
	
	</script>
</html>
	
