<?php
require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

if(isset($_GET['pid'])) {
	$pid = $_GET['pid'];

	if ($api->isFavSet($pid, $uid)) {
		$api->removeFav($pid, $uid);
	} else {
		$api->favPost($pid, $uid);
	}

	if(isset($_GET['from'])) {
		header("Status: 302 Found");
		header("Location: " . $_GET['from']);
	} else {
		header("Status: 204 No Content");
	}
}
?>
