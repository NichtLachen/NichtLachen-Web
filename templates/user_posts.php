<?php

$checkMore = function(int $page, int $perPage) : bool {
	global $api, $uid;
	return $api->moreUserPosts($uid, $page, $perPage);
};

$getPosts = function(int $page, int $perPage) : array {
	global $api, $uid;
	return $api->getUserPosts($uid, $page, $perPage);
};

require_once (dirname(__FILE__) . '/../templates/paged_post_array.php');

require_once (dirname(__FILE__) . '/../templates/prevnext.php');

?>
