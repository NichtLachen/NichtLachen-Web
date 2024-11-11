<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$user = $api->getUserByUID($uid);
$search = isset($_GET['q']) ? $_GET['q'] : "";

$TITLE = "Suchergebnisse: Beiträge";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

$checkMore = function(int $page, int $perPage) : bool {
	global $api, $search;
	return $api->moreSearchPosts($search, $page, $perPage);
};

$getPosts = function(int $page, int $perPage) : array {
	global $api, $search;
	return $api->searchPosts($search, $page, $perPage);
};

require_once (__DIR__ . '/templates/paged_post_array.php');

require_once (__DIR__ . '/templates/footer.php');
?>


