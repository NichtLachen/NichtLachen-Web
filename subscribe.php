<?php
require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$myuid = $api->getUIDBySessionID(session_id());

if(isset($_GET['uid'])) {
	$uid = $_GET['uid'];

	if ($api->hasSubscribed($myuid, $uid)) {
		$api->unsubscribe($myuid, $uid);
	} else if($api->canSubscribe($myuid, $uid)) {
		$api->subscribe($myuid, $uid);
	}

	$url = isset($_GET['from']) ? $_GET['from'] : "top.php";

	header("Status: 302 Found");
	header("Location: " . $url);
}
?>
