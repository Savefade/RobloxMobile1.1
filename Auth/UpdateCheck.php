<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
if(!isset($_GET["version"]))
	die("No version detected!");
if(!empty($allowedVersions)){
	if(in_array($_GET["version"], $semiAllowedVersions)){
	    sendOlderRobloxErrorMessage("Recommend");	// if the client's ver is partially allowed it would return the recommended update message
	}
	if(!in_array($_GET["version"], $allowedVersions)){
        sendOlderRobloxErrorMessage("Require");	// if the client's ver is not allowed it will display the out of date error
	}
	sendOlderRobloxErrorMessage("No need");
}

function sendOlderRobloxErrorMessage($message){
	die('"' . $message . '"');
}