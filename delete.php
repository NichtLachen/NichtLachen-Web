<?php
require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

if (isset($_GET['pid'])) {
	if(isset($_GET['queue']) && $_GET['queue'] == 1) {
		if($api->getQueuedPostOwner($_GET['pid']) == $uid) {
			$api->postQueueDelete($_GET['pid']);
		}
	} else {
		$post = $api->getPostByPID($_GET['pid']);

		if($post != null && $post->getCreatorUID() == $uid) {
			$api->postDelete($post->getPID());
		}
	}
} else if (isset($_GET['cmtid'])) {
	$comment = $api->getCommentByCMTID($_GET['cmtid']);

	if($comment != null && $comment->getCreatorUID() == $uid) {
		$api->commentDelete($comment->getCMTID());
	}
}

$url = isset($_GET['from']) ? $_GET['from'] : "top.php";

header("Status: 302 Found");
header("Location: " . $url);
?>
