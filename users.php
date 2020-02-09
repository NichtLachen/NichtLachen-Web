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
require_once (__DIR__ . '/templates/navbar_back.php');
?>
		<center>
		<div class="profileimage" style="background-image: url('profileimages/<?php echo findProfileImage($uid); ?>');">
		</div>
		<p style="font-size: x-large; font-weight: bold;"><?php echo $user != null ? $user->getName() : ""; ?></p>
<?php
if ($uid != $myuid) {
?>
		<a class="button" href="subscribe.php?uid=<?php echo $uid; ?>&from=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"><?php echo $api->hasSubscribed($myuid, $uid) ? "Abonniert" : "Abonnieren"; ?></a>
		<br>
<?php
}
?>
		<br>
<?php
if ($user != null) {
	require_once (__DIR__ . '/templates/userinfo.php');
} else {
	$ERROR = $TITLE;
	require (__DIR__ . '/templates/error.php');
}
?>
		</center>
<?php
require_once (__DIR__ . '/templates/footer.html');
?>

