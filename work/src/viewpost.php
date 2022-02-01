<?php
    include 'header.php';
    include 'titlebar.php';

    
     if($validity == "valid") {
        $col = $db -> posts;   
        //Get post info
	    $name = $_POST['name'];
	    $postname = $_POST['postname'];
	    $content = "";
	    $postcolor = $_POST['postcolor'];
	    
	    //Search for other parameters like post content and associated image
	    $record = $col->find( [ 'name'=> $name, 'postname'=> $postname ] );
        foreach ($record as $post) {
            $content = $post['blog'];   
            echo "<h3>".$post['postname']."</h3>";
            if (isset($post['date'])) { echo "<h4>Most recent update: ".$post['date']; }
            if (isset($post['groups'])) { echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Associated groups: ".$post['groups']; }
            
            echo "</h4><div class='postlink post'>";
            if ( isset($post['postimage']) && $post['postimage'] != null && $post['postimage'] != "none") { 
                $postimage = $post['postimage'];
                echo "<p style='text-align: center;'><img src='$postimage' style='max-width: 650px;'></p>"; 
            }
            else { $postimage = "none"; }

	        echo "$content";
	    }
        
        echo "<br><br><form method='post' action='newpost.php'>
            <input type='hidden' name='name' value='$name'>
            <input type='hidden' name='postname' value='$postname'>
            <input type='hidden' name='notecontent' value='$content'>
            <input type='hidden' name='postcolor' value='$postcolor'>
            <input type='hidden' name='postimage' value='$postimage'>
            <input type='submit' name='Edit' value='EDIT POST'></div>";
            
    }
    else { echo "Sorry, username and password are unknown. Please try to log in again."; }
?>

</td></tr></table></body></html>
	
