<?php
include "../Config.php";

if(isset($_GET["auth_token"]) && isset($_GET["id"])){
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE AuthToken = ? LIMIT 1;");
    $DBReq->bind_param("s", $_GET["auth_token"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0)
		returnError();
	
	$GetFromDB = $DBResult->fetch_assoc();
	markAsRead($GetFromDB["Username"]);
	
	//the token has to be 38 bytes in size (including "") else an error will be returned to the user
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}

function markAsRead($toUsername){
	include "../Config.php";
	$DBReq = $RetrieveDBData->prepare("UPDATE messages SET IsRead = 1 WHERE ToUsername = ? && ID = ?");
    $DBReq->bind_param("ss", $toUsername, $_GET["id"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	die('"success"');
}
?>