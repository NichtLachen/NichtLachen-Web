<?php
require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

if(isset($_GET['like']) && isset($_GET['pid'])) {
	if($_GET['like'] == -1) {
		if($api->isLikeSet($_GET['pid'], $uid, -1)) {
			$api->removeLikes($_GET['pid'], $uid);
		} else {
			$api->dislikePost($_GET['pid'], $uid);
		}
	} else {
		if($api->isLikeSet($_GET['pid'], $uid, 1)) {
			$api->removeLikes($_GET['pid'], $uid);
		} else {
			$api->likePost($_GET['pid'], $uid);
		}
	}

	$url = isset($_GET['from']) ? urldecode($_GET['from']) : "top.php";

	header("Status: 302 Found");
	header("Location: " . $url);
}
?>
