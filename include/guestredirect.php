<?php

require_once (dirname(__FILE__) . '/../classes/db/DatabaseAPI.php');

if(session_status() == PHP_SESSION_NONE) {
	session_start();
}

$sid = session_id();
$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID($sid);
if($uid != null) {
	$api->refreshSession($sid);
} else {
	header("Status: 302 Found");
	header("Location: /");
	return;
}

?>
