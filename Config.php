<?php
$underMaintenance = false;
$allowedVersions = ["1.1"];
$semiAllowedVersions = ["1.0"]; //will display the recommended update nag
$forceLogin = false; //THIS BYPASSES THE PASSWORD CHECK! Do not use on a production env
$buildersClubTabEnabled = true;
$defaultTix = 15;
$defaultRobux = 0;
$baseURL = "http://localhost";
$messageLoadLimit = 20;
$userSearchLoadLimit = 10;
$messagesSentBeforeBestFriends = 10; //
$defaultFriendUsernames = "";
$defaultFriendReqUsernames = "";

//Discord Config
$webhooksEnabled = false;
$webhookURL = ""; 

$DBURL = "127.0.0.1";
$DBName = "legacyrbxm";
$DBPassword = "";
$DBAcc = "root";
$RetrieveDBData = new mysqli($DBURL, $DBAcc, $DBPassword, $DBName);

if($underMaintenance){
	exit('"Require"');
}
