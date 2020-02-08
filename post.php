<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

$from = isset($_GET['from']) ? $_GET['from'] : "./";

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Witz hinzufügen</title>
		<link rel="stylesheet" href="css/stylesheet.min.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
$TITLE = "Witz hinzufügen";
require_once (__DIR__ . '/templates/navbar_back.php');

if (isset($_GET['cid']) && !isset($_POST['cid'])) {
	$name = $api->getCategoryName($_GET['cid']);

	if ($name != null && !$api->isSuperCategory($_GET['cid'])) {
		
?>
		<form class="newpost" method="POST" action="" id="post">
			<input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>">
			<textarea form="post" name="text"></textarea><br>
			<br>
			<input type="submit" class="button">
		</form>
<?php
	} else {
		$ERROR = "Kategorie nicht gefunden!";
		require (__DIR__ . '/templates/error.php');
	}
} else if (isset($_POST['cid']) && isset($_POST['text'])) {
	$text = $_POST['text'];
	if (!empty($text)) {
		$api->postVerify($_POST['cid'], $uid, $text);
	}

	header("302 Found");
	header("Location: " . $from);
} else {
	$ERROR = "Ungültige Anfrage";
	require (__DIR__ . '/templates/error.php');
}


require_once (__DIR__ . '/templates/footer.html');
?>
	</body>
</html>

