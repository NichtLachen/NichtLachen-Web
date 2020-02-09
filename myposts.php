<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);

$TITLE = $user != null ? "Beiträge von " . $user->getName() : "Benutzer nicht gefunden!";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/profilenavbar.php');

if ($user != null) {
	require_once (__DIR__ . '/templates/user_posts.php');
}

require_once (__DIR__ . '/templates/footer.html');
?>


