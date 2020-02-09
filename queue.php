<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();

$uid = $api->getUIDBySessionID(session_id());

$TITLE = "Warteschlange";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

$checkMore = function(int $page, int $perPage) : bool {
	global $api, $uid;
	return $api->moreQueuePosts($uid, $page, $perPage);
};

$getPosts = function(int $page, int $perPage) : array {
	global $api, $uid;
	return $api->getQueuePosts($uid, $page, $perPage);
};

$queue = true;

require_once (__DIR__ . '/templates/paged_post_array.php');

require_once (__DIR__ . '/templates/footer.html');
?>


