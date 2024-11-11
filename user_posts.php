<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = isset($_GET['uid']) && is_numeric($_GET['uid']) ? $_GET['uid'] : 0; // UID 0 does never exist
$user = $api->getUserByUID($uid);
$myuid = $api->getUIDBySessionID(session_id());

$TITLE = $user != null ? "Beiträge von " . $user->getName() : "Benutzer nicht gefunden!";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_profile.php');

if ($user != null) {
	$checkMore = function(int $page, int $perPage) : bool {
		global $api, $uid, $myuid;
		return $api->moreUserPosts($uid, $myuid == $uid, $page, $perPage);
	};

	$getPosts = function(int $page, int $perPage) : array {
		global $api, $uid, $myuid;
		return $api->getUserPosts($uid, $myuid == $uid, $page, $perPage);
	};

	require_once (__DIR__ . '/templates/paged_post_array.php');
} else {
	$ERROR = $TITLE;
	require (__DIR__ . '/templates/error.php');
}

require_once (__DIR__ . '/templates/footer.php');
?>


