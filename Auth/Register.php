<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Errors.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Actions.php";

if(!isset($_GET["accountName"]) || !isset($_GET["password"])){
	exit;
}

$username = strtolower($_GET["accountName"]);
if(!ctype_alnum($username)){
	die('"error"');
}

$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username = ? LIMIT 1;");
$DBReq->bind_param("s", $username); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
$DBReq->execute();
$DBResult = $DBReq->get_result();

if($DBResult->num_rows == 1){
	returnError();
}

$genSalt = rand(0, 2147000000);
$hashedPassword = password_hash($genSalt . $_GET["password"] . $genSalt, PASSWORD_BCRYPT);
	$timestamp = time();
$DBReq = $RetrieveDBData->prepare("INSERT INTO `users` (`ID`, `Username`, `AuthToken`, `Password`, `BanNote`, `Salt`, `RegisterTS`, `Robux`, `Tix`, `FriendUsernames`, `FriendReqUsernames`) VALUES (NULL, ?, '', ?, '', '$genSalt', '$timestamp', $defaultRobux, $defaultTix, '$defaultFriendUsernames', '$defaultFriendReqUsernames'); ");
$DBReq->bind_param("ss", $username, $hashedPassword); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
$DBReq->execute();

doAfterRegister($username);

die('"success"'); // successful account creation