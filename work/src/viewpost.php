<?php
    include 'header.php';
    include 'titlebar.php';

    
     if($validity == "valid") {
        $col = $db -> posts;   
        //Get post info
	    $name = $_POST['name'];
	    $postname = $_POST['postname'];
	    $postid = $_POST['postid'];
	    $content = "";
	    $postcolor = $_POST['postcolor'];
	    
	    //Search for other parameters like post content and associated image
	    $record = $col->find( [ '_id' => new MongoDB\BSON\ObjectId($postid) ] );
        foreach ($record as $post) {
            $content = $post['blog'];
            echo "<h3>".$post['postname']."</h3>";
            if (isset($post['date'])) { echo "<h4>Most recent update: ".$post['date']; }
            if (isset($post['groups'])) { echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Associated groups: ".$post['groups']; }
            
            //post content
            echo "</h4><div class='postlink post'>";
            if ( isset($post['postimage']) && $post['postimage'] != null && $post['postimage'] != "none") { 
                $postimage = $post['postimage'];
                echo "<p style='text-align: center;'><img src='$postimage' style='max-width: 650px;'></p>"; 
            }
            else { $postimage = "none"; }

	        echo "$content </div>";
	    }
        
        if ($name == $loginuser) {
            echo "<p><form method='post' action='newpost.php' id='PostEdit'>
                <input type='hidden' name='name' value='$name'>
                <input type='hidden' name='postname' value='$postname'>
                <input type='hidden' name='notecontent' value='$content'>
                <input type='hidden' name='postcolor' value='$postcolor'>
                <input type='hidden' name='postimage' value='$postimage'>
                <input type='hidden' name='postid' value='$postid'>
                <input type='submit' name='Edit' value='EDIT POST' form='PostEdit'></form></p>";
        }
        //Show comments associate with this post
        echo "<h4>Comments: </h4>";
    	
    	$commentcol = $db -> comments;
        try { $commentrec = $commentcol->find([ 'postid' => $postid ]); }
        finally { $commentrec = $commentcol->find([ 'postname' => $postname ]); }
        foreach ( $commentrec as $commentinfo) {
        	$comcontent = $commentinfo['comment'];
        	$comauthor = $commentinfo['author'];
        	
        	echo "<p><div class='postlink post'><p>$comcontent</p>- Author: $comauthor</div></p>";
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
	</script>
</html>
	
