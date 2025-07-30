<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

if(!isset($_GET["friendName"])){
	exit;
}

$GetFromDB = checkSession();

$friendsArray = explode(",", $GetFromDB["FriendUsernames"]);
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
function setFriendship($reqUsername, $friendArray, $friendArray2){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	//
	$friendUsernames = explode(",", $friendArray);
	$friendUserPlacement1 = array_search($reqUsername, $friendUsernames);
	$friendUserPlacement2 = array_search($_GET['friendName'], $friendArray2);
	unset($friendUsernames[$friendUserPlacement1]);
	$friends = implode(",", $friendUsernames);
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET FriendUsernames = ? WHERE Username = ? Limit 1;");
    $DBReq->bind_param("ss", $friends, $_GET["friendName"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	//
    unset($friendArray2[$friendUserPlacement2]);
	$friends = implode(",", $friendArray2);
	
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET FriendUsernames = ? WHERE Username = ? LIMIT 1;");
    $DBReq->bind_param("ss", $friends, $reqUsername); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	die('"success"');
}
?>
