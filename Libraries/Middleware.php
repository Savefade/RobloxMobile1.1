<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Errors.php";

function checkSession(){
    include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";

    if(!isset($_GET["auth_token"])){
        exit;
    }

    $DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE AuthToken = ? LIMIT 1;");
    $DBReq->bind_param("s", $_GET["auth_token"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0)
		returnError();

    return $DBResult->fetch_assoc();
}