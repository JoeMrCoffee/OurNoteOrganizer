<?php
    include 'header.php';
    include 'titlebar.php';

    if ($validity == "valid") {
        $col = $db -> posts;
        //get post info
	    $name = $_POST['name'];
	    $postname = $_POST['postname'];
	    $note = $_POST['notecontent'];
	    $postid = $_POST['postid'];
	    $postcolor = $_POST['postcolor'];
	    $todaydate = date("Y-m-d");
	    $postgroups = $_POST['postgroups'];

        $note = str_replace("'", "&apos;", $note);
		$postname = str_replace("'", "&apos;", $postname);
	    //Update or Edit the original post
	    if (isset($_POST['Edit'])){
	        //save file to permanent directory
	        if ( $_FILES['postimage']['tmp_name'] != null ){
	            $postimage = basename($_FILES['postimage']['name']);
				$tmpimage = $_FILES['postimage']['tmp_name'];
	            $curdir = getcwd();
                $savefile = $curdir."/images/".$postimage; //changing this a bit, may need an extra space between the " . $postimage for the basename function
                $postimgname = "images/".$postimage;
                move_uploaded_file($tmpimage, $savefile) or die("Cannot move uploaded file to working directory");
	            echo "<h3>File $savefile uploaded successfully</h3>";
	            $editimgquery = ['$set'=>['blog' => $note, "postcolor" => $postcolor, 'postimage' => $postimgname, 'date' => $todaydate, 'groups' => $postgroups]];
	            
	        }
	        else {
	            $editimgquery = ['$set'=>['blog' => $note, "postcolor" => $postcolor, 'date' => $todaydate, 'groups' => $postgroups]];
	        }

	        $updatePost = $col->updateOne(['_id' => new MongoDB\BSON\ObjectId("$postid")], $editimgquery);
	        echo "<h3>Post updated successfully: </h3>";
	        
	        $record = $col->find( ['name' => $name, 'postname' => $postname] );  
            foreach ($record as $post) {  
                echo "<div class='postlink post'>Editor name: ".$post['name'], '<br><br>Postname: ',$post['postname'],'<br><br>
                    Date: ',$post['date'],'<br><br>Groups: ',$post['groups'],'<br><br>Content:<br>', $post['blog']."</div>";
            }
        }
        
        elseif(isset($_POST['Delete'])){
            $deletePost = $col->deleteOne(['_id' => new MongoDB\BSON\ObjectId("$postid")]);
	        echo "<h3>Post deleted successfully</h3>";
        }
    }
    else { echo "Sorry, username and password are unknown. Please try to log in again."; }

?>

</td></tr></table></body></html>
