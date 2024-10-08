<?php
include "../Config.php";

if(isset($_GET["auth_token"])){
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE AuthToken = ? LIMIT 1;");
    $DBReq->bind_param("s", $_GET["auth_token"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0)
		returnError();
	
	$GetFromDB = $DBResult->fetch_assoc();
	$messagesArray = getAccountMessagesArray($GetFromDB["Username"]);
	
	die(json_encode(array('Unread' => count($messagesArray))));
	//the token has to be 38 bytes in size (including "") else an error will be returned to the user
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}

function getAccountMessagesArray($toUsername){
	include "../Config.php";
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