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
	//
	if(empty($GetFromDB["FriendUsernames"]))
		returnFriendJson(array());
	//
	$friendsArray = explode(",", $GetFromDB["FriendUsernames"]); 
	$convertedFriendsArray = array();
    //
	foreach($friendsArray as $getFriendContent){
		$convertedFriendsArray[] = array(
		'Name' => $getFriendContent["Username"],
		);
	}
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}

function returnFriendJson($friendsArray){
	die(json_encode(array('Friends' => $friendsArray)));
}
?>
