<?php

require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');

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
	header("Status: 302 Found");
	header("Location: top.php");
	die();
}

?>
