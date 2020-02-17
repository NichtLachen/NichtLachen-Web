<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/include/profileimageutils.php');

$api = new DatabaseAPI();
$myuid = $api->getUIDBySessionID(session_id());
$uid = isset($_GET['uid']) && is_numeric($_GET['uid']) ? $_GET['uid'] : 0; // UID 0 does never exist
$user = $api->getUserByUID($uid);

$TITLE = $user != null ? "Profil von " . $user->getName() : "Benutzer nicht gefunden!";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/profilenavbar.php');

if ($user != null) {
	require_once (__DIR__ . '/templates/userinfo.php');
} else {
	$ERROR = $TITLE;
	require (__DIR__ . '/templates/error.php');
}

require_once (__DIR__ . '/templates/footer.html');
?>

