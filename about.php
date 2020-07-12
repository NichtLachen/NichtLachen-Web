<?php

require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/include/version.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
if ($uid != null) {
	$user = $api->getUserByUID($uid);
}

$TITLE = "Über";

$rules = "rules.php?from=" . urlencode($_SERVER['REQUEST_URI']);

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
			<p style="visibility: hidden;">placeholder</p>
			<hr/>
			<div class="onclick" onclick="goto('<?php echo $rules; ?>');">
				<a href="<?php echo $rules; ?>">Regeln</a>
			</div>
			<hr/>
		</div>
<?php

require_once (__DIR__ . '/templates/footer.html');
?>
