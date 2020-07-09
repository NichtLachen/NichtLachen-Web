<?php

require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/user/Rank.php');

if(!isset($uid) || !$api->getUserByUID($uid)->hasRank(Rank::MODERATOR) && !$api->getUserByUID($uid)->hasRank(Rank::ADMINISTRATOR)) {
	$ERROR = "Sie haben nicht die Berechtigung diese Seite aufzurufen!";
	require (__DIR__ . '/templates/error.php');

	die();
}

?>
