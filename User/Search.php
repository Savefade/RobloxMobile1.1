<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

if(!isset($_GET["searchKey"])){
	exit;
}

$DBData = checkSession();

$addedFriends = explode(",", $DBData["FriendUsernames"]);
$userResults = getUserResultsArray();
$convertedResultsArray = array();

foreach($userResults as $getRequestContent){
	if(!empty($getRequestContent) && !in_array($getRequestContent["Username"], $addedFriends)){
		$convertedResultsArray[] = array(
			'UserName' => $getRequestContent["Username"],
		);
	}
}
die(json_encode($convertedResultsArray));

function getUserResultsArray(){
	include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
	$query = $_GET["searchKey"] . "%";
	$DBReq = $RetrieveDBData->prepare("SELECT * FROM users WHERE Username LIKE ? && BanNote = '' LIMIT $userSearchLoadLimit;"); // i can use query to get if the searchKey exists but whateva
    $DBReq->bind_param("s", $query);
    $DBReq->execute();
	$DBResult = $DBReq->get_result();
	$results = array();
	while($user = $DBResult->fetch_assoc()){
		$results[] = $user;
	}
	return $results;
}
?>
