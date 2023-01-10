<?php
    include 'header.php';
    include 'titlebar.php';

    if ($validity == "valid") {
        
        $col = $db -> tasks;
        $taskowner = $_POST['taskowner'];
        $postid = $_POST['postid'];
        $duedate = $_POST['duedate'];
        $postname = $_POST['postname'];
        $comment = $_POST['commentcontent'];
        
        if ($duedate == null) { $duedate = "undefined"; } 
        
       
        //clean the bad apostrophes 
		$postname = str_replace("'", "&apos;", $postname);
		$comment = str_replace("'", "&apos;", $comment);
        $taskcomment = "<h4>Task assigned to: $taskowner</h4>".$comment; //concatenate the owner and comment
       
        $task = ['taskowner' => $taskowner, 'duedate' => $duedate, 'postname' => $postname, 'postid' => $postid, 'taskstatus' => 'Open', 'taskcomment' => $comment];
        if ($submittask = $col->insertOne($task)){
                echo "<h3>Task for $postname given to $taskowner. </h3>";
        }
        else { echo "<h3>Error occured while creating that task. Please contact your IT administrator.</h3>"; }
        
         $col2 = $db -> comments;
        
        $insertcomment = ['author' => $loginuser, 'comment' => $taskcomment, 'postname' => $postname, 'postid' => $postid];
        if ($postcomment = $col2->insertOne($insertcomment)){
                echo "<h3>Comment added to $postname. </h3>";
        }
        else { echo "<h3>Error occured while copying to the comments section. Please contact your IT administrator.</h3>"; }
        
    }

    else { echo "<p>Sorry, username and password are unknown. Please try to log in again.</p>"; }
    
?>

</td></tr></table></body></html>
