<?php
include "../Config.php";
die(json_encode(array(
	"Status" => "OK",
	"ThumbnailUrl" => "$baseURL/icon.png",
)));