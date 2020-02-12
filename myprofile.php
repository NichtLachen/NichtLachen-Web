<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/include/profileimageutils.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);

$TITLE = "Mein Profil";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/profilenavbar.php');

require_once (__DIR__ . '/templates/userinfo.php');

require_once (__DIR__ . '/templates/footer.html');
?>


