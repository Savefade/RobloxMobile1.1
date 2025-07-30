<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

$GetFromDB = checkSession();

$friendsArray = explode(",", $GetFromDB["FriendReqUsernames"]); 
$convertedFriendsArray = array();

foreach($friendsArray as $getFriendContent){
	if(!empty($getFriendContent)){
		$convertedFriendsArray[] = array(
			'UserName' => $getFriendContent,
		);
	}
}

die(json_encode($convertedFriendsArray));

?>
