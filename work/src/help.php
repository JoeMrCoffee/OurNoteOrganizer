<?php 
    include 'header.php'; 
    include 'titlebar.php';

    if ($validity == "valid") {
        
        echo "<h4>Help</h4><div class='postlink post'>
 <p>OurNoteOrganizer is a web-based note taking tool designed for small teams to use. It is built for non-Cloud, on-prem deployments and is paired with a Docker-Compose file for rapid deployment.</p>
 <p>The project first began as a proof-of-concept for exploring what can be done with PHP and MongoDB. To an extent, it still is a POC, as many features are still being developed or refined. This initial release is as much to gather community feedback as it is to share what could be a useful tool to certain teams.</p>

<h4>Run through:</h4>

<p align='center'><iframe width='560' height='315' src='https://www.youtube.com/embed/nJEJ58qsWiU' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></p>

<h4>Basic use and organization</h4>
<p>OurNoteOrganizer groups notes around the user/author and his/her associated groups or teams. All notes written are privy to the author and any associated groups he/she wishes to assign. Once multiple users are part of the same group all users are able to view and jointly edit / update the notes.</p>

<p>The initial home page displays all notes available to the user; both his/her notes or notes where he/she is a group member. The posts are displayed as small squares with their assigned colors. Unless searched for all the notes are listed in reverse chronological order (newest first) based on latest modification to the post. Clicking 'VIEW' on any note allows for viewing the full note or article.</p>

<p>The search bar at the top allows searching through the notes by associated group and post name. Search is a Regex search, so complete and partial matches will be returned.</p>

<p>New posts can be created simply by clicking the 'NEW POST' link on the top title bar. The author is bound to the logged in user. Post name, image, and highlight color can be defined, the associate group can be selected, and note content can be added.</p>

<p>To edit or update posts, authors of the post can click 'VIEW' and then 'EDIT POST'. If a color or image has been defined with the post a preview of each will be shown. When editing a post the original Author is kept as the source editor/author of the post regardless of who in the team is editing. This behavior may need to be adjusted in the future, but for now it is kept simple. Other users in the same group can read and create comments for each post.</p>

<h4>User and group management</h4>

<p>Users and their associated groups can be adjusted in the 'USERS' section. Admins can adjust the user settings including the associated groups for each user, and add or delete users. Users can adjust their own passwords using the dropdown under the user name. If a user wants to create a new Group and assign other users to it, click 'Add Group' and enter the new group name and select which users should be in it.</p>

<h4>Uploading images</h4>

<p>Each post or note can have an associated image included. All images appear in the top center of the post, and will also show at a smaller scale in the overview page (noteshome.php) and when editing a post. Changing the image will overwrite the original image association.</p>

<p>Note: All image files will continue to exist on the server under the folder images even if changed. An area for future improvement could be to create a way to identify and remove unused images overtime, but for now is out-of-scope of this project.</p>

<h4>Problems uploading images</h4>

<p>Images are uploaded using an HTML POST to PHP which then moves the file from temporary storage to a permanent location in the 'images' directory. There are a couple of potential issues that could cause the file upload to fail.<p>

<p>The directory permissions of the 'image' directory is not the correct permission level/ownership. On a production system with Apache running natively (i.e. VM or physical deployment) the best practice would be to run 'chown www-data:www-data images' for most Linux derivatives. Per the Docker containers provided, running a volume passthrough can mean that the folder is running from a host that does not have the Apache user or group. For testing what has worked is running 'chmod 777 images' to allow write and execute access to the container. This method is probably not suitable for real production, but can work for those interested in playing with the project or can ensure a strong firewalled environment.</p>

    <p>The file size may be simply too large to upload. In the Docker environment included, the default upload_max_filesize is 2 MB (this can be shown in the phpinfo.php page also included). To adjust this a user can change the config.ini files in PHP, but do so with caution and also bear in mind timeout time and other netwokring factors. This project is NOT designed to be a file upload service.</p>

<p>For more information about OurNoteOrganizer please visit the Github project page at <a href='https://github.com/JoeMrCoffee/OurNoteOrganizer' target='_blank'>HERE</a></p>
         </div>";
    }
    else { echo "Sorry, username and password are unknown. Please try to log in again."; }


?>
</table>
</td></tr></table>
</body>



</html>
