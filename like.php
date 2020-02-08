<?php
require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

if(isset($_GET['like']) && (isset($_GET['pid']) || isset($_GET['cmtid']))) {
	if(isset($_GET['pid'])) {
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
	} else if(isset($_GET['cmtid'])) {
		if($_GET['like'] == 1) {
			if($api->isCommentLikeSet($_GET['cmtid'], $uid, 1)) {
				$api->removeCommentLikes($_GET['cmtid'], $uid);
			} else {
				$api->likeComment($_GET['cmtid'], $uid);
			}
		}
	}

	$url = isset($_GET['from']) ? $_GET['from'] : "top.php";

	header("Status: 302 Found");
	header("Location: " . $url);
}
?>
