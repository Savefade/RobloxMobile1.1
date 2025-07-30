<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Actions.php";

if(!isset($_GET["sendToUser"]) || !isset($_GET["subject"]) || !isset($_GET["message"])){
	exit;
}

$GetFromDB = checkSession();

doAfterSendMessage($GetFromDB["Username"], $_GET["sendToUser"], $_GET["subject"], $_GET["message"]);

$messagesArray = sendMessage($_GET["sendToUser"], $_GET["subject"], $_GET["message"],$GetFromDB["Username"]);
$requestedMessage2Send = array();

function sendMessage($toUsername, $subject, $message, $fromUsername){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	$timestamp = time();
	$DBReq = $RetrieveDBData->prepare("INSERT INTO `messages` (`ID`, `ToUsername`, `FromUsername`, `Subject`, `Message`, `IsRead`, `SendTS`) VALUES (NULL, ?, ?, ?, ?, '0', $timestamp); ");
    $DBReq->bind_param("ssss", $toUsername, $fromUsername, $subject, $message); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	die('"success"');
}
?>