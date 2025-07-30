<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

$GetFromDB = checkSession();

$messagesArray = getAccountMessagesArray($GetFromDB["Username"]);
	
die(json_encode(array('Unread' => count($messagesArray))));

function getAccountMessagesArray($toUsername){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM messages WHERE ToUsername = ? && IsRead = 0;");
    $DBReq->bind_param("s", $toUsername); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	$messagesArray = array();
	while($message = $DBResult->fetch_assoc()){
		$messagesArray[] = $message;
	}
	return $messagesArray;
}
?>