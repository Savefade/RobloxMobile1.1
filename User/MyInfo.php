<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Libraries/Middleware.php";

$GetFromDB = checkSession();

die(json_encode(array("Robux" => $GetFromDB["Robux"], "Tickets" => $GetFromDB["Tix"], "BCType" => "BC"))); //sending the raw gentoken var crashes the app!!