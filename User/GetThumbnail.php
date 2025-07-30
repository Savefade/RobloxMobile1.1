<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Config.php";
die(json_encode(array(
	"Status" => "OK",
	"ThumbnailUrl" => "$baseURL/icon.png",
)));