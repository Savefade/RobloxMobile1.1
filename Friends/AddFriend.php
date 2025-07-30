<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

if(!isset($_GET["friendName"])){
	exit;
}

$GetFromDB = checkSession();

$friendsArray = explode(",", $GetFromDB["FriendUsernames"]); ;
if(in_array($_GET["friendName"], $friendsArray) || !doesUserExist($GetFromDB["Username"]) || $_GET["friendName"] ==  $GetFromDB["Username"]){ 
	returnError();
}
	
setFriendship($GetFromDB["Username"]);

function doesUserExist($reqUsername){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username = ? && BanNote = '' LIMIT 1;"); // i can use query to get if the friendName exists but whateva
    $DBReq->bind_param("s", $_GET["friendName"]);
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if(in_array($reqUsername, explode(",", $DBResult->fetch_assoc()["FriendReqUsernames"])))
		return false;
	if($DBResult->num_rows > 0)
	return true;
}
function setFriendship($reqUsername){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET FriendUsernames = CONCAT(FriendUsernames, ',', ?) WHERE Username = ? LIMIT 1;");
    $DBReq->bind_param("ss", $_GET['friendName'], $reqUsername); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	//
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET FriendReqUsernames = CONCAT(FriendReqUsernames, ',', ?) WHERE Username = ? LIMIT 1;");
    $DBReq->bind_param("ss", $reqUsername, $_GET['friendName']); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	die('"success"');
}

?>
