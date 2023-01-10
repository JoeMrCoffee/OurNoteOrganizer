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
        			echo "<h4>Task update successful</h4>";
        		}
        		else {  echo "<h4>Sorry an error occured, please contact your admin. </h4>"; }
        		echo "<a href='mytasks.php'><button>< BACK</button></a>";
        		
        }
   }
   else { echo "Sorry, username and password are unknown. Please try to log in again."; }
        
        
?>

</td></tr></table>
</body>

</html>
