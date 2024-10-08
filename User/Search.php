<?php
include "../Config.php";

if(isset($_GET["auth_token"]) && isset($_GET["searchKey"])){
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE AuthToken = ? LIMIT 1;"); // i can use query to get if the searchKey exists but whateva
    $DBReq->bind_param("s", $_GET["auth_token"]); //this gets the username from the get request and sends the placeholder (?) to the username. sanitised
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	if($DBResult->num_rows == 0){
		returnError();
	}
	$DBData = $DBResult->fetch_assoc();
	$addedFriends = explode(",", $DBData["FriendUsernames"]);
	$userResults = getUserResultsArray();
	$convertedResultsArray = array();
    //
	foreach($userResults as $getRequestContent){
		if(!empty($getRequestContent) && !in_array($getRequestContent["Username"], $addedFriends)){
			$convertedResultsArray[] = array(
				'UserName' => $getRequestContent["Username"],
			);
		}
	}
	die(json_encode($convertedResultsArray));
}
function getUserResultsArray(){
	include "../Config.php";
	$query = $_GET["searchKey"] . "%";
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username LIKE ? LIMIT $userSearchLoadLimit;"); // i can use query to get if the searchKey exists but whateva
    $DBReq->bind_param("s", $query);
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	$results = array();
	while($user = $DBResult->fetch_assoc()){
		$results[] = $user;
	}
	return $results;
}

function returnError(){
	die('"error"'); // this returns some json which causes the incorrect username or password to appear
}
?>
