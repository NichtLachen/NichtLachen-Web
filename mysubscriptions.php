<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

$TITLE = "Meine Abos";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

$checkMore = function(int $page, int $perPage) : bool {
	global $api, $uid;
	return $api->moreFollows($uid, $page, $perPage);
};

$getUsers = function(int $page, int $perPage) : array {
	global $api, $uid;
	return $api->getFollows($uid, $page, $perPage);
};

require_once (__DIR__ . '/templates/paged_user_array.php');

require_once (__DIR__ . '/templates/footer.php');
?>


