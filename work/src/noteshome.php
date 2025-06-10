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
        
        //This is the search function for the page
	    if(isset($_POST['notesearch'])){ 
	        $notesearch = $_POST['notesearch'];
	        //handling case insensitive searches
	        $notesearchlow = strtolower($notesearch); //lowercase all the values
	        $notesearchup = ucwords($notesearch); //make the first letter an upper case
	        $notesearchupper = strtoupper($notesearch); //uppercase the whole search
	        
	        //Search against the same user name or group name
	        $record = $col->find(['$or'=>[
	            ['name'=> $loginuser, 'postname'=> ['$regex'=>$notesearch]],
	            ['name'=> $loginuser, 'postname'=> ['$regex'=>$notesearchlow]],
	            ['name'=> $loginuser, 'postname'=> ['$regex'=>$notesearchup]],
	            ['name'=> $loginuser, 'postname'=> ['$regex'=>$notesearchupper]],
	            ['groups' => ['$in' => $groupsarray], 'postname'=> ['$regex'=>$notesearch]],
	            ['groups' => ['$in' => $groupsarray], 'postname'=> ['$regex'=>$notesearchlow]],
	            ['groups' => ['$in' => $groupsarray], 'postname'=> ['$regex'=>$notesearchup]],
	            ['groups' => ['$in' => $groupsarray], 'postname'=> ['$regex'=>$notesearchupper]],
	            ['groups' => ['$in' => $groupsarray, '$regex'=>$notesearch]],
	            ['groups' => ['$in' => $groupsarray, '$regex'=>$notesearchup]],
	            ['groups' => ['$in' => $groupsarray, '$regex'=>$notesearchlow]],
	            ['groups' => ['$in' => $groupsarray, '$regex'=>$notesearchupper]]
                ]]);    
	    }
	    //This returns all values if the search bar is not used or has yet to be used
	    else { $record = $col->find(['$or'=>[
	        ['name' => $loginuser],
	        ['groups' => ['$in' => $groupsarray]]
	        ]], ['sort' => ['date'=> -1]]); }



        //Search bar
        echo "<div class='search'>
        <form method='post' action='".$_SERVER['PHP_SELF']."'>    
        <input name='notesearch' type='text' class='search' placeholder='Search by group or post name'>  
        <input class='search' type='submit' value='SEARCH' ></form>
        </div>";
        foreach ($record as $note) {
            $name=$note['name'];
            $postname=$note['postname'];
            $postcolor=$note['postcolor'];
            $postdate = $note['date'];
            $postid = $note['_id'];
            $postimage = "";
            if(isset($note['postimage'])){ $postimage = $note['postimage']; }
            
            $redflag = "<a style="; //An exception when the post has a link auto copited in from Google Docs
            $redflag2 = "<img src="; // An exception for when images are posted in the note body
            //still working on getting the formatting right for this
            $content = $note['blog'];
            if (strlen($content) >= 200 && $postimage == ""){
            	//handle posts with just a link exception
            	if (strpos($content, $redflag) != false && strpos($content, $redflag) <= 200) { $content = "<p>Hyperlink in body. Click View to see details.</p>"; } 
            	if (strpos($content, $redflag2) != false && strpos($content, $redflag2) <= 200) { $content = "<p>Image in body. Click View to see details.</p>"; } 
                $content = substr($content,0,200)." ...<br>";
                $content = str_replace("< ", "", $content); //replace a bad cut if a <p> or <li> gets cut
                //$content .= "</li></ul>";  //this helps messing up other formatting if a list is used and cut  
            }
            elseif (strlen($content) >= 100 && $postimage != ""){
            	//handle posts with just a link exception
            	if (strpos($content, $redflag) != false && strpos($content, $redflag) <= 100) { $content = "<p>Hyperlink in body. Click View to see details.</p>"; }
            	if (strpos($content, $redflag2) != false && strpos($content, $redflag2) <= 200) { $content = "<p>Image in body. Click View to see details.</p>"; } 
                $content = substr($content,0,100)." ...<br>";
                $content = str_replace("< ", "", $content); //replace a bad cut if a <p> or <li> gets cut
                //$content .= "</li></ul>";  //this helps messing up other formatting if a list is used and cut  
            }

            echo "<div class='postlink overview' style='background-color: $postcolor;'>
            	<strong>Author: $name <br>Note: $postname</strong>
                <br><strong>$postdate</strong>";
            if($postimage != "none" && $postimage != null){ echo "<br><div style='text-align: center;'><img src='$postimage' style='max-height: 80px;'></div>"; }
            echo "<br>$content<br>
            	<form method='post' action='viewpost.php'>
                <input type='hidden' name='name' value='$name'>
                <input type='hidden' name='postname' value='$postname'>
                <input type='hidden' name='postcolor' value='$postcolor'>
                <input type='hidden' name='postid' value='$postid'>
                <input type='submit' value='VIEW' class='view'></form></div>";

        }
        
        //Capture tasks for the upcoming tasks alert
        $col2 = $db->tasks;
        $tasklist = $col2 -> find(['taskowner' => $loginuser]);
        $duetaskcount = 0; //this is to help trigger the javascript to show the popup
        $todaysdate = time();

        echo "<div class='groupmgmt' style='visibility: hidden;' id='dueTask'>
		<img class='closepopup' onclick='tasksdue()' src='close.png'>
		<h4>Upcoming tasks</h4><strong><p>The following tasks are coming up in the next 7 days:</p></strong><ul>";
		foreach ($tasklist as $taskitem) {
			$taskdate = strtotime($taskitem['duedate']);
			$difference = ($taskdate - $todaysdate);
			if ( $difference <= 604800 && $taskitem['taskstatus'] == "Open") {
				echo "<li>Item name: ".$taskitem['postname']." -- Due: ".$taskitem['duedate']."</li>";
				$duetaskcount++;
			}
		}
		echo "</ul><p>See more in <a href='mytasks.php'>MY TASKS</a></p>
			<input type='hidden' id='taskcount' value='$duetaskcount'>";
		if (isset($_SESSION['popupseen']) && $_SESSION['popupseen'] == "alreadyshown"){
			echo "<input type='hidden' id='alreadyshown' value='alreadyshown'>";
		}
		else { 
			$_SESSION['popupseen'] = "notyet"; 
			echo "<input type='hidden' id='alreadyshown' value='notyet'>";
		}
		echo "</div>";
    }
    else { echo "<br><br>Sorry, username and password are unknown. Please try to log in again."; }

?>

</td></tr></table>
</body>
<script>
	function tasksdue() {
		var taskcount = document.getElementById('taskcount').value;
		var tasksduepopup = document.getElementById('dueTask');
		var alreadyshown = document.getElementById('alreadyshown').value;
		console.log(taskcount+" "+alreadyshown);
		if (taskcount > 0 && alreadyshown == 'notyet') {
			if (tasksduepopup.style.visibility == 'hidden') {
					tasksduepopup.style.visibility = 'visible';
	 		} 
	 		else { tasksduepopup.style.visibility = 'hidden'; }
 		}
	}
	window.onload = tasksdue();

</script>
</html>
