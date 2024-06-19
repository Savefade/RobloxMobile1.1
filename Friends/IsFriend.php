<?php
include "../Config.php";

if(isset($_GET["auth_token"]) && isset($_GET["friendName"])){
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE AuthToken = ? LIMIT 1;"); // i can use query to get if the searchKey exists but whateva
    $DBReq->bind_param("s", $_GET["auth_token"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0){
		returnError();
	}
	$GetFromDB = $DBResult->fetch_assoc();
	$friendsArray = explode(",", $GetFromDB["FriendUsernames"]); ;
	if(in_array($_GET["friendName"], $friendsArray) && doesUserExist()){ 
		die("\"true\""); //directly copies from ida xD
	}
	die("\"false\"");
	
}
function doesUserExist(){
	include "../Config.php";
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username = ? LIMIT 1;"); // i can use query to get if the searchKey exists but whateva
    $DBReq->bind_param("s", $_GET["friendName"]);
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0){
		returnError();
	}
	return true;
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}
?>
