<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

$GetFromDB = checkSession();

$friendsArray = explode(",", $GetFromDB["FriendReqUsernames"]); 
$pendingRequestsCount = (count($friendsArray) - 1 > 0)? count($friendsArray) - 1 : 0;
	
	
die(json_encode(array("Pending Friend Requests" => $pendingRequestsCount,)));
	//the token has to be 38 bytes in size (including "") else an error will be returned to the user
?>