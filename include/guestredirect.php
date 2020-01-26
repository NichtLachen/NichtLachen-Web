<?php

require_once (dirname(__FILE__) . '/../classes/db/DatabaseAPI.php');

session_name("NL_SID");
session_set_cookie_params(pow(2, 32) - 1);
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
	header("Location: ./");
	return;
}

?>
