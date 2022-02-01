# OurNoteOrganizer

OurNoteOrganizer is a web-based note taking tool designed for small teams to use. It is built for non-Cloud, on-prem deployments and is paired with a Docker-Compose file for rapid deployment. 

The project first began as a proof-of-concept for exploring what can be done with PHP and MongoDB. To an extent, it still is as many features are still being developed or refined. This initial release is as much to gather community feedback as it is to share what could be a useful tool to certain teams. 

### Structure
OurNoteOrganizer is an interactive website that uses primarily HTML/PHP with a MongoDB backend to store data. A sample environment is provided using Docker and Docker Compose.

### Installation

The easiest way to begin using OurNoteOrganizer is to run a git clone, then using Docker and Docker Compose run 'docker-compose up' in the main directory. This will auto install and run an Apache + PHP web environment along with another MongoDB environment. Parameters such as the DB password can be adjusted in the docker-compose.yml file as desired.

NOTE: If the DB password is adjusted, the login parameters in the web environment also need to be adjusted. This can be done by editing the mongologin.ini file:

    ip = mongo
    user = root
    pwd = mongopwd

Alternatively, for users looking to run in a more permenant environment using physical or virtual machines rather than containers, a LAMP stack with a MongoDB server can also be built. Just ensure that the MongoDB login parameters match those of the web environment's connection. 

Once running the containers without errors, navigate to the localhost or address/domain name of the host system. The home screen should appear. Default username is 'admin', password is also 'admin'. The password can be changed once logged in.

#### Sercurity

To better harden the security the MongoDB access should not be as I have in the reference code. 

Currently the login credentials are separated in mongologin.ini which gets read in header.php and applied to all the sub-pages. Ideally, the .ini file can be placed outside of the web server source (/var/www/html - Apache default), and on the server in a secure location with read-only access to the apache service user. Something like 'chown apache:apache mongologin.ini' would probably work in most Linux environments. Always be careful with access credentials.

### Basic use and organization

OurNoteOrganizer groups notes around the user/author and his/her associated groups or teams. All notes written are privy to the author and any associated groups he/she wishes to assign. Once multiple users are part of the same group all users are able to view and jointly edit / update the notes. 

The initial home page displays all notes available to the user; both his/her notes or notes where he/she is a group member. The posts are displayed as small squares with their assigned colors. Clicking 'VIEW' on any note allows for viewing the full note or article. 

The search bar at the top allows searching through the notes by associated group and post name.

New posts can be created simply by clicking the 'NEW POST' link on the top title bar. The author is bound to the logged in user, post name, image, and highlight color can be defined, the associate group can be selected, and note content can be added.

To edit or update posts, users can click 'VIEW' and then 'EDIT POST'. If a color or image has been defined with the post a preview of each will be shown.

### User and group management
<div align='center'><img src='ournoteorganizer.png' width='500px'></div>

Users and their associated groups can be adjusted in the 'USERS' section. Currently, only users who are labeled as Admins can adjust the user settings including the associated groups for each user, and add or delete users. Users can adjust their own passwords, however using the dropdown under the user name.
<div align='center'><img src='OurNoteOrganizer-edituser.png' width='500px'></div>

To create a new group, simply edit a user and add another group. <strong>Each group needs to be separated by a comma.</strong>

### A word on TinyMCE

TinyMCE is an external text editor which is used to help enhance the ease for writing and editing posts. It is an external tool that requires connectivity to external networks in order to function. For environments that do not have external Internet connectivity a standard textarea that does not offer rich formatting is employed. 

As this project is made to be hosted on any on-prem environment, there is no TinyMCE API key provided or registered. Users can create their own keys based on their domains and needs. To remove the notification about getting started, users can follow the quick steps, create their own API key, and add it to line 8 of the newpost.php file.

More information on TinyMCE and getting started: 
https://www.tiny.cloud/
https://www.tiny.cloud/docs/quick-start/
