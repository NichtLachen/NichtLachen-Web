<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();

$from = isset($_GET['from']) ? $_GET['from'] : "./";

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Witz hinzufügen</title>
		<link rel="stylesheet" href="/css/stylesheet.min.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
$TITLE = "Witz hinzufügen";
require_once (__DIR__ . '/templates/navbar_back.php');

if (isset($_GET['cid'])) {
	$name = $api->getCategoryName($_GET['cid']);

	if ($name != null && !$api->isSuperCategory($_GET['cid'])) {
		
	} else {
		$ERROR = "Kategorie nicht gefunden!";
		require (__DIR__ . '/templates/error.php');
	}
} else if (isset($_POST['cid'])) {
} else {
	$ERROR = "Ungültige Anfrage";
	require (__DIR__ . '/templates/error.php');
}


require_once (__DIR__ . '/templates/footer.html');
?>
	</body>
</html>


