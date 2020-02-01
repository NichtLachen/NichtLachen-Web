<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');
require_once (dirname(__FILE__) . '/include/version.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Über</title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
$TITLE = "Über";
require_once (dirname(__FILE__) . '/templates/navbar_back.php');
?>
		<h1 style="background-color: transparent; color: orange; margin-left: 20px;">Über</h1>
<?php
if (isApp()) {
	echo "<p>App Version: " . getAppVersion() . "</p>";
}
?>
<?php

require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


