<?php
include "../Config.php";

if(isset($_GET["accountName"]) && isset($_GET["password"]) && isset($_GET["under13"])){
	$username = strtolower($_GET["accountName"]);
	if(!ctype_alnum($username))
		die('"error"');
	//
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username = ? LIMIT 1;");
    $DBReq->bind_param("s", $username); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	//
	if($DBResult->num_rows == 1)
		returnError();
	//
	$genSalt = rand(0, 2147000000);
	$hashedPassword = password_hash($genSalt . $_GET["password"] . $genSalt, PASSWORD_BCRYPT);
	$timestamp = time();
    $DBReq = $RetrieveDBData->prepare("INSERT INTO `users` (`ID`, `Username`, `AuthToken`, `Password`, `Salt`, `RegisterTS`, `Robux`, `Tix`, `FriendUsernames`, `MessagesCountSentToFriends`, `FriendReqUsernames`) VALUES (NULL, ?, '', ?, '$genSalt', '$timestamp', $defaultRobux, $defaultTix, '$defaultFriendUsernames', '$defaultBestFriendUsernames', '$defaultFriendReqUsernames'); ");
    $DBReq->bind_param("ss", $username, $hashedPassword); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	die('"success"'); // successful account creation
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}