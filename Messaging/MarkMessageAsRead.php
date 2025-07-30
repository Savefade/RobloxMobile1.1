<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

if(!isset($_GET["id"])){
	exit;
}

$GetFromDB = checkSession();

markAsRead($GetFromDB["Username"]);

function markAsRead($toUsername){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	$DBReq = $RetrieveDBData->prepare("UPDATE messages SET IsRead = 1 WHERE ToUsername = ? && ID = ?");
    $DBReq->bind_param("ss", $toUsername, $_GET["id"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	die('"success"');
}
?>