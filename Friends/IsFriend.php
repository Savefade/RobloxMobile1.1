<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

if(!isset($_GET["friendName"])){
	exit;
}

$GetFromDB = checkSession();

$friendsArray = explode(",", $GetFromDB["FriendUsernames"]); ;
if(in_array($_GET["friendName"], $friendsArray) && doesUserExist()){ 
	die("\"true\""); //directly copies from ida xD
}
die("\"false\"");
	
function doesUserExist(){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username = ? LIMIT 1;"); // i can use query to get if the searchKey exists but whateva
    $DBReq->bind_param("s", $_GET["friendName"]);
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0){
		returnError();
	}
	return true;
}
?>
