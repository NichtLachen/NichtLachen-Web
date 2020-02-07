<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = isset($_GET['uid']) && is_numeric($_GET['uid']) ? $_GET['uid'] : 0; // UID 0 does never exist
$user = $api->getUserByUID($uid);

$TITLE = $user != null ? "Profil von " . $user->getName() : "Benutzer nicht gefunden!";

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | <?php echo $TITLE; ?></title>
		<link rel="stylesheet" href="css/stylesheet.min.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
require_once (__DIR__ . '/templates/navbar_back.php');
?>
		<center>
		<div class="profileimage" style="background-image: url('profileimages/<?php echo $uid; ?>.jpg');">
		</div>
		<p style="font-size: x-large; font-weight: bold;"><?php echo $user != null ? $user->getName() : ""; ?></p>
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
	</body>
</html>


