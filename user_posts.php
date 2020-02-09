<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = isset($_GET['uid']) && is_numeric($_GET['uid']) ? $_GET['uid'] : 0; // UID 0 does never exist
$user = $api->getUserByUID($uid);

$TITLE = $user != null ? "Beiträge von " . $user->getName() : "Benutzer nicht gefunden!";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

if ($user != null) {
	require_once (__DIR__ . '/templates/user_posts.php');
} else {
	$ERROR = $TITLE;
	require (__DIR__ . '/templates/error.php');
}

require_once (__DIR__ . '/templates/footer.html');
?>


