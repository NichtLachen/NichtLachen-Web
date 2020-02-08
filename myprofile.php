<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/include/profileimageutils.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Mein Profil</title>
		<link rel="stylesheet" href="css/stylesheet.min.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
require_once (__DIR__ . '/templates/profilenavbar.php');
?>
		<center>
		<div class="profileimage" style="background-image: url('profileimages/<?php echo findProfileImage($uid); ?>');">
		</div>
		<p style="font-size: x-large; font-weight: bold;"><?php echo $user->getName(); ?></p>
		<br>
<?php
require_once (__DIR__ . '/templates/userinfo.php');
?>
		</center>
<?php
require_once (__DIR__ . '/templates/footer.html');
?>
	</body>
</html>


