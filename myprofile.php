<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Mein Profil</title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
	</head>
	<body>
<?php
require_once (dirname(__FILE__) . '/templates/navbar.php');
?>
		<center>
		<div class="profileimage" style="background-image: url('profileimages/<?php echo $uid; ?>.jpg');">
		</div>
		<p style="font-size: x-large; font-weight: bold;"><?php echo $user->getName(); ?></p>
		<br>
<?php
require_once (dirname(__FILE__) . '/templates/userinfo.php');
?>
		</center>
<?php
require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


