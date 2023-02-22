<?php 
    include 'header.php'; 
    include 'titlebar.php';

    if ($validity == "valid") {
        $col = $db->tasks;
        $tasklist = $col -> find(['taskowner' => $loginuser]);
        
        //Status update listener
        if(isset($_POST['taskstatus'])) {
        		$upttaskstatus = $_POST['taskstatus'];
        		$upttaskid = $_POST['taskid']; 
        		$upttask = ['$set'=>['taskstatus' => $upttaskstatus]];
        		if ( $updateTask = $col->updateOne(['_id' => new MongoDB\BSON\ObjectId("$upttaskid")], $upttask) ) {
        			echo "<h3>Success</h3><p class='postlink'><br>Task updated successfully.<br><br></p>";
        		}
        		else {  echo "<h3>Sorry an error occurred, please contact your admin. </h3>"; }
        		echo "<a href='mytasks.php'><button>< BACK</button></a>";
        		
        }
   }
   else { echo "Sorry, username and password are unknown. Please try to log in again."; }
        
        
?>

</td></tr></table>
</body>

</html>
