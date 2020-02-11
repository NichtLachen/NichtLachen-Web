<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

$TITLE = "Witz hinzufügen";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

if (isset($_GET['cid']) && !isset($_POST['cid'])) {
	$name = $api->getCategoryName($_GET['cid']);

	if ($name != null && !$api->isSuperCategory($_GET['cid'])) {
?>
		<form onsubmit="return sendForm('post', function() { back(); });" class="newpost" method="POST" action="" id="post">
			<div class="post-category"><?php echo $name; ?></div><br>
			<input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>">
			<textarea form="post" name="text" autofocus></textarea><br>
			<br>
			<input type="submit" class="button">
		</form>
<?php
	} else {
		$ERROR = "Kategorie nicht gefunden!";
		require (__DIR__ . '/templates/error.php');
	}
} else if (isset($_POST['cid']) && isset($_POST['text'])) {
	$cid = $_GET['cid'];
	$text = $_POST['text'];
	if (!empty($text) && $api->getCategoryName($cid) != null && !$api->isSuperCategory($cid)) {
		$api->postQueue($cid, $uid, $text);
	}

	if(isset($_GET['from'])) {
		header("Status: 302 Found");
		header("Location: " . $_GET['from']);
	} else {
		header("Status: 204 No Content");
	}
} else {
	$ERROR = "Ungültige Anfrage";
	require (__DIR__ . '/templates/error.php');
}


require_once (__DIR__ . '/templates/footer.html');
?>


