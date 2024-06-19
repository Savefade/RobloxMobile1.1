<?php
$underMaintenance = "";
$allowedVersions = ["1.1"];
$semiAllowedVersions = ["1.0"]; //will display recommended (1.0 - 1.1.1)
$forceLogin = true; //THIS BYPASSES THE PASSWORD VERIFICATION! Do not use on a production env
$buildersClubTabEnabled = true;
$defaultTix = 15;
$defaultRobux = 0;
$baseURL = "http://192.168.2.197";
$messageLoadLimit = 20;
$userSearchLoadLimit = 10;
$defaultFriendUsernames = "";
$defaultBestFriendUsernames = "";
$defaultFriendReqUsernames = "";

$DBURL = "127.0.0.1";
$DBName = "legacyrbxm";
$DBPassword = "";
$DBAcc = "root";
$RetrieveDBData = new mysqli($DBURL, $DBAcc, $DBPassword, $DBName);