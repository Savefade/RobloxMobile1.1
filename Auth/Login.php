<?php
include "../Config.php";

if(isset($_GET["username"]) && isset($_GET["password"])){
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username = ? LIMIT 1;");
    $DBReq->bind_param("s", $_GET["username"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	//
	if($DBResult->num_rows == 0)
		returnError();
	//
	$GetFromDB = $DBResult->fetch_assoc();
	$salt = $GetFromDB["Salt"];
	//
	if(!password_verify($salt . $_GET["password"] . $salt, $GetFromDB["Password"]) || !$forceLogin)
		returnError();
	//
    $genToken = bin2hex(random_bytes(18));
	updateToken($genToken);
	die('"' . $genToken .'"'); //sending the raw gentoken var crashes the app!!
	//the token has to be 38 bytes in size (including "")
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}

function updateToken($token){
	include "../Config.php";
	$DBReq = $RetrieveDBData->prepare("UPDATE users SET AuthToken = ? WHERE Username = ? LIMIT 1;");
    $DBReq->bind_param("ss", $token, $_GET["username"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	return;
}