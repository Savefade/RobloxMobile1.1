<?php
include "../Config.php";

if(isset($_GET["auth_token"]) && isset($_GET["sendToUser"]) && isset($_GET["subject"]) && isset($_GET["message"])){
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE AuthToken = ? LIMIT 1;");
    $DBReq->bind_param("s", $_GET["auth_token"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0)
		returnError();
	
	$GetFromDB = $DBResult->fetch_assoc();
	$messagesArray = sendMessage($_GET["sendToUser"], $_GET["subject"], $_GET["message"],$GetFromDB["Username"]);
	$requestedMessage2Send = array();
    //
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}

function sendMessage($toUsername, $subject, $message, $fromUsername){
	include "../Config.php";
	$timestamp = time();
	$DBReq = $RetrieveDBData->prepare("INSERT INTO `messages` (`ID`, `ToUsername`, `FromUsername`, `Subject`, `Message`, `IsRead`, `SendTS`) VALUES (NULL, ?, ?, ?, ?, '0', $timestamp); ");
    $DBReq->bind_param("ssss", $toUsername, $fromUsername, $subject, $message); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	die('"success"');
}
?>