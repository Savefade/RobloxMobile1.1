<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

if(!isset($_GET["friendName"])){
	exit;
}

$GetFromDB = checkSession();

$friendsArray = explode(",", $GetFromDB["FriendReqUsernames"]);
if(!in_array($_GET["friendName"], $friendsArray)){ 
	returnError();
}
$friendArray = getYourFriendsArray()["FriendUsernames"];
setFriendship($GetFromDB["Username"], $friendArray, $friendsArray);

function getYourFriendsArray(){ //this returns the request friend's friendUsernames and other stuff
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username = ? LIMIT 1;"); // i can use query to get if the friendName exists but whateva
    $DBReq->bind_param("s", $_GET["friendName"]);
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0){
		returnError();
	}
	return $DBResult->fetch_assoc();
}
function setFriendship($reqUsername, $friendArray, $friendReqArray){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	//
	$friendUsernames = explode(",", $friendArray);
	unset($friendUsernames[array_search($reqUsername, $friendUsernames)]);
	$friends = implode(",", $friendUsernames);
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET FriendUsernames = ? WHERE Username = ? Limit 1;");
    $DBReq->bind_param("ss", $friends, $_GET["friendName"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	//
    unset($friendReqArray[array_search($_GET['friendName'], $friendReqArray)]);
	$friendReq = implode(",", $friendReqArray);
	
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET FriendReqUsernames = ? WHERE Username = ? LIMIT 1;");
    $DBReq->bind_param("ss", $friendReq, $reqUsername); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	die('"success"');
}
?>
