<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

$TITLE = "Beitrag hinzufügen";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

if (isset($_GET['cid']) && !isset($_POST['cid'])) {
	$name = $api->getCategoryName($_GET['cid']);

	if ($name != null && !$api->isSuperCategory($_GET['cid'])) {
?>
		<div class="center">
			<form class="default-form" method="POST" id="post">
				<div class="post-category"><?php echo $name; ?></div><br>
				<input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>">
				<textarea style="width: 95%; height: 15em;" form="post" name="text"></textarea><br>
				<br>
				<input type="submit" class="button">
			</form>
		</div>
<?php
	} else {
		$ERROR = "Kategorie nicht gefunden!";
		require (__DIR__ . '/templates/error.php');
	}
} else if (isset($_POST['cid']) && isset($_POST['text'])) {
	$cid = $_GET['cid'];
	$text = $_POST['text'];
	if (strlen($text) > 0 && $api->getCategoryName($cid) != null && !$api->isSuperCategory($cid)) {
		$api->postQueue($cid, $uid, $text);
	}
?>
	<script language="javascript">back();</script>
	<noscript><meta http-equiv="refresh" content="0; url=<?php echo $_GET['from']; ?>" /></noscript>
<?php
} else {
	$ERROR = "Ungültige Anfrage";
	require (__DIR__ . '/templates/error.php');
}


require_once (__DIR__ . '/templates/footer.html');
?>
