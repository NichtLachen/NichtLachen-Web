<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();

$TITLE = "Top";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar.php');

$checkMore = function(int $page, int $perPage) : bool {
	global $api;
	return $api->moreTopPosts($page, $perPage);
};

$getPosts = function(int $page, int $perPage) : array {
	global $api;
	return $api->getTopPosts($page, $perPage);
};

require_once (__DIR__ . '/templates/paged_post_array.php');

require_once (__DIR__ . '/templates/footer.html');
?>


