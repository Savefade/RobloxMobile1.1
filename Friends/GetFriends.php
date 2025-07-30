<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

$GetFromDB = checkSession();

$friendsArray = explode(",", $GetFromDB["FriendUsernames"]); 
$convertedFriendsArray = array();

foreach($friendsArray as $getFriendContent){
	if(!empty($getFriendContent)){
		$convertedFriendsArray[] = array(
			'Name' => $getFriendContent,
		);
	}
}

die(json_encode(array('Friends' => $convertedFriendsArray)));
//the token has to be 38 bytes in size (including "") else an error will be returned to the user
