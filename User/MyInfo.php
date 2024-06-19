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
    //
	die(json_encode(array("Robux" => $GetFromDB["Robux"], "Tickets" => $GetFromDB["Tix"]))); //sending the raw gentoken var crashes the app!!
	//the token has to be 38 bytes in size (including "")
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}