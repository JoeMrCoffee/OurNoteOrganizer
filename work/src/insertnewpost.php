<?php
    include 'header.php';
    include 'titlebar.php';
    
    if ($validity == "valid"){
        $col = $db -> posts;
	    $name = $_POST['name'];
	    $postname = $_POST['postname'];
	    $note = $_POST['notecontent'];
	    $postcolor = $_POST['postcolor'];
	    $postgroups = $_POST['postgroups'];
	    $postimage = basename($_FILES['postimage']['name']);
	    $tmpimage = $_FILES['postimage']['tmp_name'];
	    $todaydate = date("Y-m-d");
	    
	    //save file to permanent directory
	    if ( $postimage != null ){
	        $curdir = getcwd();
            $savefile = $curdir."/images/".$postimage;
            //echo "save file : $savefile<br>"; //debug
            $postimgname = "images/".$postimage;
            move_uploaded_file($tmpimage, $savefile) or die("Cannot move uploaded file to working directory");
	        
	    }
	    else { $postimgname = "none"; }
	    
	    $note = str_replace("'", "&apos;", $note);
	    $postname = str_replace("'", "&apos;", $postname);
	    
	    $doc = ["name" => $name,"postname" => $postname,"blog" => $note, "postcolor" => $postcolor, 'postimage' => $postimgname, 'date' => $todaydate, 'groups'=> $postgroups];
	    
	    $col->insertOne($doc);
	    echo "<h3>Post inserted successfully: </h3>";
	    
	    
	    $record = $col->find( [ 'name' => $name, 'postname' => $postname] );  
        foreach ($record as $post) {  
            echo "<div class='postlink post'>Original author: ".$post['name'], '<br><br>Postname: ',$post['postname'],'<br><br>Groups: ',$post['groups'],'
            <br><br>Date: ',$post['date'],'<br><br>Content:<br>', $post['blog']."</div>";  
        }
    }
    else { echo "Sorry, username and password are unknown. Please try to log in again."; }

?>

</td></tr></table></body></html>
