<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');
require_once (dirname(__FILE__) . '/config.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);

$TITLE = $user != null ? "Beiträge von " . $user->getName() : "Benutzer nicht gefunden!";

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | <?php echo $TITLE; ?></title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
require_once (dirname(__FILE__) . '/templates/profilenavbar.php');
?>
<?php
if ($user != null) {
	require_once (dirname(__FILE__) . '/templates/user_posts.php');
}
?>
		</center>
<?php
require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


