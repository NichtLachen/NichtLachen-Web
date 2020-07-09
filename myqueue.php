<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

$TITLE = "Eingereicht";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_profile.php');

$checkMore = function(int $page, int $perPage) : bool {
	global $api, $uid;
	return $api->moreUserQueuePosts($uid, $page, $perPage);
};

$getPosts = function(int $page, int $perPage) : array {
	global $api, $uid;
	return $api->getUserQueuePosts($uid, $page, $perPage);
};

$queue = true;

require_once (__DIR__ . '/templates/paged_post_array.php');

require_once (__DIR__ . '/templates/footer.html');
?>


