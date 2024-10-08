<?php
include "../Config.php";

if(isset($_GET["auth_token"]) && isset($_GET["friendName"])){
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE AuthToken = ? LIMIT 1;"); // i can use query to get if the friendName exists but whateva
    $DBReq->bind_param("s", $_GET["auth_token"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0){
		returnError();
	}
	$GetFromDB = $DBResult->fetch_assoc();
	$friendsArray = explode(",", $GetFromDB["FriendReqUsernames"]);
	if(!in_array($_GET["friendName"], $friendsArray)){ 
		returnError();
	}
	$friendArray = getYourFriendsArray();
	setFriendship($GetFromDB["Username"], $friendArray, $friendsArray);
}
function getYourFriendsArray(){ //this returns the request friend's friendUsernames and other stuff
	include "../Config.php";
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username = ? LIMIT 1;"); // i can use query to get if the friendName exists but whateva
    $DBReq->bind_param("s", $_GET["friendName"]);
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0){
		returnError();
	}
	return $DBResult->fetch_assoc();
}
function setFriendship($reqUsername, $friendArray1, $friendReqArray){
	include "../Config.php";
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET FriendUsernames = CONCAT(FriendUsernames, ',', ?), MessagesCountSentToFriends = CONCAT(MessagesCountSentToFriends, ',', '0') WHERE Username = ? Limit 1;");
    $DBReq->bind_param("ss", $_GET['friendName'], $reqUsername); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	//
    unset($friendReqArray[array_search($_GET['friendName'], $friendReqArray)]);
	$friendReq = implode(",", $friendReqArray);
	
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET FriendReqUsernames = ? WHERE Username = ? LIMIT 1;");
    $DBReq->bind_param("ss", $friendReq, $reqUsername); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	die('"success"');
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}
?>
