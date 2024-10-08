<?php
include "../Config.php";

if(isset($_GET["auth_token"])){
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE AuthToken = ? LIMIT 1;");
    $DBReq->bind_param("s", $_GET["auth_token"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0)
		returnError();
	
	$GetFromDB = $DBResult->fetch_assoc();
	$friendsArray = explode(",", $GetFromDB["FriendUsernames"]); 
	$convertedFriendsArray = array();
    //
	foreach($friendsArray as $getFriendContent){
		if(!empty($getFriendContent)){
			$convertedFriendsArray[] = array(
				'Name' => $getFriendContent,
			);
		}
	}
	
	die(json_encode(array('Friends' => $convertedFriendsArray)));
	//the token has to be 38 bytes in size (including "") else an error will be returned to the user
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}
?>
