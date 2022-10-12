<?php
    include 'header.php';
    include 'titlebar.php';


    if ($validity == "valid") {
        
        $col = $db -> comments;
            
        $username = $_POST['author'];
        $comment = $_POST['commentcontent'];
        $postname = $_POST['postname'];
        $postid = $_POST['postid'];

        $insertcomment = ['author' => $username, 'comment' => $comment, 'postname' => $postname, 'postid' => $postid];
        if ($postcomment = $col->insertOne($insertcomment)){
                echo "<h3>Comment added to $postname. </h3>";
        }
        else { echo "<h3>Error occured while adding that comment. Please contact your IT administrator.</h3>"; }

    }

    else { echo "Sorry, username and password are unknown. Please try to log in again."; }
    
?>

</td></tr></table></body></html>
