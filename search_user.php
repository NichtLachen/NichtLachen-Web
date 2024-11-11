<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$search = isset($_GET['q']) ? $_GET['q'] : "";

$TITLE = "Suchergebnisse: Benutzer";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

$checkMore = function(int $page, int $perPage) : bool {
	global $api, $search;
	return $api->moreSearchUsers($search, $page, $perPage);
};

$getUsers = function(int $page, int $perPage) : array {
	global $api, $search;
	return $api->searchUsers($search, $page, $perPage);
};

require_once (__DIR__ . '/templates/paged_user_array.php');

require_once (__DIR__ . '/templates/footer.php');
?>


