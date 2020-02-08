<?php
require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

if(isset($_GET['accept']) && isset($_GET['pid'])) {
	$pid = $_GET['pid'];
	if (!$api->hasPostAcceptedOrRejected($uid, $pid) && $api->getQueuedPostOwner($pid) != $uid) {
		if($_GET['accept'] == -1) {
			$api->postQueueReject($uid, $pid);
		} else {
			$api->postQueueAccept($uid, $pid);
		}
	}

	if ($api->getPostQueueAccepts($pid) > 5) { // post accepted!
		$api->postDeQueue($pid);
	}

	$url = isset($_GET['from']) ? urldecode($_GET['from']) : "top.php";

	header("Status: 302 Found");
	header("Location: " . $url);
}
?>
