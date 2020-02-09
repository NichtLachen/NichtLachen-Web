<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/include/version.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);

$TITLE = "Über";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');
?>
		<div class="about">
			<h1>Über</h1>
			<hr/>
			<p>App Version: <?php echo isApp() ? getAppVersion() : "App wird nicht verwendet"; ?></p>
			<hr/>
			<p>Web Version: <?php echo getWebVersionTag() . "-" . getWebVersion(); ?></p>
			<hr/>
		</div>
<?php

require_once (__DIR__ . '/templates/footer.html');
?>


