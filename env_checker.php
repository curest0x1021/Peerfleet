<?php
$minPHPVersion = '8.1';

$message = "";
$response = "success";

if (version_compare(PHP_VERSION, $minPHPVersion, '<')) {
	$response = "acknowledgement_required";
	$message = "Before start, you must backup your database first. After upgrading RISE to 3.5, you must upgrade your php to 8.1.";
}

return array("response_type"=>$response, "message"=>$message);