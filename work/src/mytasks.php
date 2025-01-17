<?php 
    include 'header.php'; 
    include 'titlebar.php';

    if ($validity == "valid") {
        $col = $db->tasks;
        $tasklist = $col -> find(['taskowner' => $loginuser],['sort' => ['taskstatus'=> -1, 'duedate'=> 1]]);
        $_SESSION['popupseen'] = "alreadyshown";
        
		//counter for the color fomatting. Root function in titlebar.php
        $color = 1;
        
        //Main page
        echo "<h4>Your tasks</h4>
            <table width='100%' class='postlink' align='center'>
            <tr><th width='150px'>Post Name</th><th width='45%'>Task</th>
            <th width='120px'>Due Date</th>
            <th width='120px'>Link</th><th width='120px'>Status</th>
            <th></th><th></th></tr>";

        foreach ($tasklist as $taskitem) {
            echo "<form method='post' action='viewpost.php'>";
            bgcolor($color);
            $color += 1;
            echo "<td >".$taskitem['postname']."<input type='hidden' name='postname' value='".$taskitem['postname']."'></td>";
            if(isset($taskitem['taskcomment'])){
                echo "<td >".$taskitem['taskcomment']."<input type='hidden' name='taskcomment' value='".$taskitem['taskcomment']."'></td>";
            }
            else { echo "<td></td>"; }
            echo "<input type='hidden' name='taskid' value='".$taskitem['_id']."'>
                <input type='hidden' name='postid' value='".$taskitem['postid']."'>
                <td >".$taskitem['duedate']."<input type='hidden' name='duedate' value='".$taskitem['duedate']."'></td>
                <td><input type='submit' value='VIEW'></form></td>";
            
             $taskstatus = $taskitem['taskstatus'];
            echo "<td><form id='statusupdate' method='post' action='updatetask.php'>
                		<input type='hidden' name='taskid' value='".$taskitem['_id']."'>";
             //Change the selection and color of the items based on status
            if ($taskstatus == "Open" || $taskstatus == "open") {
            	echo "<select onchange='this.form.submit()' name='taskstatus'>
                	<option value='$taskstatus' selected>$taskstatus</option>
                	<option value='Closed'>Closed</option>";
            }
            else { 
            	echo "<select onchange='this.form.submit()' name='taskstatus' style='background-color: #25B25D;'>
                	<option value='$taskstatus' selected>$taskstatus</option>
                	<option value='Open'>Open</option>"; 
        	}
            echo "</select></form></td><td></td><td></td><tr>";

        }
        echo "</table>";
        		
    }
    else { echo "Sorry, username and password are unknown. Please try to log in again."; }


?>

</td></tr></table>
</body>

</html>
