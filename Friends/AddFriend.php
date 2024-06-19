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
	$friendsArray = explode(",", $GetFromDB["FriendUsernames"]); ;
	if(in_array($_GET["friendName"], $friendsArray) || !doesUserExist($GetFromDB["Username"]) || $_GET["friendName"] ==  $GetFromDB["Username"]){ 
		returnError();
	}
	
	setFriendship($GetFromDB["Username"]);
}
function doesUserExist($reqUsername){
	include "../Config.php";
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username = ? LIMIT 1;"); // i can use query to get if the friendName exists but whateva
    $DBReq->bind_param("s", $_GET["friendName"]);
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if(in_array($reqUsername, explode(",", $DBResult->fetch_assoc()["FriendReqUsernames"])))
		return false;
	if($DBResult->num_rows > 0)
	return true;
}
function setFriendship($reqUsername){
	include "../Config.php";
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET FriendUsernames = CONCAT(FriendUsernames, ',', ?), MessagesCountSentToFriends = CONCAT(MessagesCountSentToFriends, ',', '0') WHERE Username = ? LIMIT 1;");
    $DBReq->bind_param("ss", $_GET['friendName'], $reqUsername); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	//
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET FriendReqUsernames = CONCAT(FriendReqUsernames, ',', ?) WHERE Username = ? LIMIT 1;");
    $DBReq->bind_param("ss", $reqUsername, $_GET['friendName']); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	die('"success"');
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}
?>
