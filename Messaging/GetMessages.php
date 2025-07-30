<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

if(!isset($_GET["startRowIndex"])){
	exit;
}

$GetFromDB = checkSession();

$messagesArray = getAccountMessagesArray($GetFromDB["Username"]);
$convertedMessagesArray = array();

foreach($messagesArray as $getMessageContent){
$convertedMessagesArray[] = array(
	'From' => $getMessageContent["FromUsername"],
	'Subject' => $getMessageContent["Subject"],
	'Body' => $getMessageContent["Message"],
	'ID' => $getMessageContent["ID"],
	'Date' => $getMessageContent["SendTS"],
	'IsRead' => $getMessageContent["IsRead"] == 1 ? true : false);
}
	
die(json_encode(array('MessageCount' => count($convertedMessagesArray), 'Messages' => $convertedMessagesArray)));
	//the token has to be 38 bytes in size (including "") else an error will be returned to the user

function getAccountMessagesArray($toUsername){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM messages WHERE ToUsername = ? ORDER BY `messages`.`SendTS` DESC LIMIT $messageLoadLimit;");
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