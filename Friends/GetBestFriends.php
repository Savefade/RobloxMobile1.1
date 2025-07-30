<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

$GetFromDB = checkSession();

$bestFriendsArray = getBestFriendsArray($GetFromDB["Username"]);
$convertedBestFriendsArray = array();
foreach($bestFriendsArray as $getFriendContent){
	if(!empty($getFriendContent)){
		$convertedBestFriendsArray[] = array(
			'Name' => $getFriendContent["ToUsername"],
		);
	}
}
die(json_encode(array('Friends' => $convertedBestFriendsArray,)));

function getBestFriendsArray($fromUsername){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	$DBReq = $RetrieveDBData->prepare("SELECT ToUsername, COUNT(*) c FROM messages WHERE FromUsername = ? GROUP BY ToUsername HAVING c >= $messagesSentBeforeBestFriends;");
    $DBReq->bind_param("s", $fromUsername); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	$bestFriendsArray = array();
	while($bestfriend = $DBResult->fetch_assoc()){
		$bestFriendsArray[] = $bestfriend;
	}
	return $bestFriendsArray;
}
?>